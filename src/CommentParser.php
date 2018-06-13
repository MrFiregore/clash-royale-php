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
        protected $_object;
        protected $_reflection;
        function __construct (string $object)
        {
            $this->_object = $object;
            $this->_parse();
        }

        /**
         * @return \ReflectionClass
         * @throws \CR\Exceptions\CRSDKException
         * @throws \ReflectionException
         */
        protected function _getReflection(){
            if (!class_exists($this->_object)){
                throw new CRSDKException("The given class not exists",0);
            }
            if (!$this->_reflection){
                $this->_reflection = new \ReflectionClass($this->_object);
            }
            return $this->_reflection;
        }

        protected function _parse()
        {
         $reflection = $this->_getReflection();
         $relations = [];
         if (!$reflection->isAbstract()){
             $relations = call_user_func([$this->_object,"__getRelations"]);
         }
         d($reflection,$relations);
            $comment =
                collect(preg_split('/\r?\n\r?/', substr($reflection->getDocComment(), 3, -2)))
                    ->map(
                        function ($val, $index) use ($reflection) {
                            $val = ltrim(rtrim($val), "* \t\n\r\0\x0B");
                            if (isset($val[1]) && $val[0] == '@' && ctype_alpha($val[1])) {
                                preg_match('/^@[a-z0-9_]+/', $val, $matches);
                                $tag   = substr($matches[0], 1);
                                $body  = ltrim(substr($val, strlen($tag) + 2));
                                $parts = preg_split('/\s+/', $body, 3);
                                $parts = array_pad($parts, 3, null);
                                if ($reflection->hasMethod($parts[1]) || $tag !== "method") {
                                    return null;
                                }
                                preg_match('#(get?|set?)(\w+)#', $parts[1], $matches);
//                                d($parts,$tag,$matches);

                                $val = [
                                    'return' => $parts[0],
                                    'type'   => strtolower($matches[1]),
                                    'name'   => snake_case($matches[2]),
                                    'desc'   => $parts[2],
                                ];
//                                d($val);
                                return $val;
                            }
                        }
                    )
                    ->reject(
                        function ($name) {
//                            d($name);
                            return is_null($name);
                        }
                    );
            d($comment);

        }

    }
