<?php
    /*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
 ~                                                                                                                                                                                                                                                          ~
 ~ Copyright (c) 2018 by firegore (https://firegore.es) (git:firegore2)                                                                                                                                                                                     ~
 ~ This file is part of clash-royale-php.                                                                                                                                                                                                                   ~
 ~                                                                                                                                                                                                                                                          ~
 ~ clash-royale-php is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
 ~ clash-royale-php is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                                                                  ~
 ~ See the GNU Affero General Public License for more details.                                                                                                                                                                                              ~
 ~ You should have received a copy of the GNU General Public License along with clash-royale-php.                                                                                                                                                           ~
 ~ If not, see <http://www.gnu.org/licenses/> 2018.06.13                                                                                                                                                                                                    ~
 ~                                                                                                                                                                                                                                                          ~
 ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/

    namespace CR;

    use CR\Exceptions\CRSDKException;

    class CommentParser
    {
        public static $types = [
            'method' => ['return', 'type', 'name', 'desc', 'implement'],
            'param'  => ['type', 'var', 'desc'],
            'return' => ['type', 'desc'],
        ];
        /**
         * The description of the class
         *
         * @type String
         */
        public $desc;
        /**
         * @var string $_object The class name
         */
        protected $_object;
        /**
         * @var \ReflectionClass $_reflection
         */
        protected $_reflection;
        /**
         * @var bool $_abstarct Define if the class is abstract or not.
         */
        protected $_abstarct;
        /**
         * @var array $_tags An array with the tags (method,package,deprecated,...) matched in the top comment of the
         *      class
         */
        protected $_tags = [];

        function __construct (string $object)
        {
            $this->_object = $object;
            $this->_parse();
        }

        protected function _parse ()
        {
            collect(
                preg_split(
                    '/\r?\n\r?/', substr(
                                    $this->_getReflection()
                                         ->getDocComment(), 3, -2
                                )
                )
            )->each(
                function ($val, $index) {
                    $body = ltrim(rtrim($val), "* \t\n\r\0\x0B");
                    if (isset($body[1]) && !self::isTagged($body) && !$this->desc) {
                        $this->desc = $body;
                    } elseif (isset($body[1])) {
                        $tag  = substr(self::strTag($body), 1);
                        $body = ltrim(substr($body, strlen($tag) + 2));
                        if (isset(self::$types[$tag])) {

                            $count = count(self::$types[$tag]);
                            if ($tag == "method") $count -= 2;

                            $parts = preg_split('/\s+/', $body, $count);
                            $parts = array_pad($parts, $count, null);

                            if ($tag == "method") {
                                $implemented_method =
                                    $this->_getReflection()
                                         ->hasMethod(substr($parts[1], 0, -2));
                                preg_match('#(get|set|has|is)?(\w+)#', $parts[1], $matches);
                                if (!isset($matches[1])) {
                                    d($body, $parts);
                                }
                                $parts = [
                                    $parts[0],
                                    strtolower($matches[1]),
                                    snake_case($matches[2]),
                                    $parts[2],
                                    $implemented_method,
                                ];
                            }
                            $this->_addTag($tag, $parts);
                        } else {
                            // The tagged block is only text
                            $this->_addTag($tag, $body);
                        }
                        return $val;
                    }
                    return null;
                }
            );
            d($this, $this->desc, $this->_tags);

        }

        /**
         * @return \ReflectionClass
         * @throws \CR\Exceptions\CRSDKException
         * @throws \ReflectionException
         */
        protected function _getReflection ()
        {
            if (!class_exists($this->_object)) {
                throw new CRSDKException("The given class '" . $this->_object . "' not exists", 0);
            }
            if (!$this->_reflection) {
                $this->_reflection = new \ReflectionClass($this->_object);
            }
            return $this->_reflection;
        }

        /**
         * Whether or not a string begins with a @tag
         *
         * @param  String $str
         *
         * @return bool
         */
        public static function isTagged ($str)
        {
            return isset($str[1]) && $str[0] == '@' && ctype_alpha($str[1]);
        }

        /**
         * The tag at the beginning of a string
         *
         * @param  String $str
         *
         * @return String|null
         */
        public static function strTag ($str)
        {
            if (preg_match('/^@[a-z0-9_]+/', $str, $matches)) return $matches[0];
            return null;
        }

        /**
         * Add a tag to the collection
         *
         * @param string $tag
         * @param mixed  $parts
         */
        protected function _addTag (string $tag, $parts)
        {
            if (is_array($parts)) {
                $this->_tags[$tag][] = array_combine(self::$types[$tag], $parts);
            } else {
                $this->_tags[$tag][] = $parts;
            }
        }

        public function isAbstract ()
        {
            return $this->_getReflection()
                        ->isAbstract();
        }

    }
