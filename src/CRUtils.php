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
    
    use cebe\markdown\GithubMarkdown;
    use CR\Console\ConsoleMarkdown;

    class CRUtils
    {
        protected static $composer;
        protected static $root;
        /** @var GithubMarkdown $parsedown */
        protected static $parsedown;
        
        /**
         * [isCli description].
         *
         * @return bool [description]
         */
        public static function isCli ()
        {
            return 'cli' == php_sapi_name();
        }
        
        /**
         * [markdownToHTML description].
         *
         * @param string $markdown [description]
         *
         * @return string [description]
         */
        public static function markdownToHTML (string $markdown)
        {
            return self::getParsedown()
                       ->parse($markdown);
        }
        
        /**
         * @return \Composer\Autoload\ClassLoader|false
         */
        public static function getComposer ()
        {
            if (false !== self::$composer) {
                $composer_path  = self::getRoot() . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
                self::$composer = (file_exists($composer_path)) ? require $composer_path : false;
            }
            
            return self::$composer;
        }
        
        /**
         * @return string
         */
        public static function getRoot ()
        {
            if (!self::$root) {
                self::$root = substr(__DIR__, 0, strpos(__DIR__, 'vendor') ?: strpos(__DIR__, 'src'));
            }
            
            return self::$root;
        }
        
        public static function delTree ($dir)
        {
            if (is_dir($dir)) {
                $objects = scandir($dir);
                foreach ($objects as $object) {
                    if ('.' != $object && '..' != $object) {
                        if (is_dir($dir . '/' . $object)) {
                            self::delTree($dir . '/' . $object);
                        }
                        else {
                            unlink($dir . '/' . $object);
                        }
                    }
                }
                rmdir($dir);
            }
        }
        
        /**
         * Check if the given string is a HTML page.
         *
         * @method isHTMLPage
         *
         * @param string $string The string to check
         *
         * @return bool Returns true if is a HTML page, otherwise returns false
         */
        public static function isHTMLPage ($string)
        {
            return 0 != preg_match('/<html.*>/', $string);
        }
        
        public static function getFunctionDefaultValues ()
        {
            $values          = [];
            $debug_backtrace = debug_backtrace();
            
            if (!isset($debug_backtrace[1])) {
                return $values;
            }
            
            $caller    = $debug_backtrace[1];
            $type      = (isset($caller['class']) ? 'Method' : 'Function');
            $func_name = ('Method' === $type) ? $caller['class'] . '::' . $caller['function'] : $caller['function'];
            
            $reflection_type = 'Reflection' . $type;
            $reflection      = new $reflection_type($func_name);
            
            foreach ($reflection->getParameters() as $param) {
                $arg_sent =
                    isset($caller['args'][$param->getPosition()]) && !is_null($caller['args'][$param->getPosition()])
                        ?
                        $caller['args'][$param->getPosition()]
                        :
                        (($param->isOptional() && $param->isDefaultValueAvailable())
                            ? $param->getDefaultValue()
                            :
                            null);
                
                $values[$param->getName()] = $arg_sent;
            }
            
            return $values;
        }
        
        public static function isAssoc (array $arr)
        {
            if ([] === $arr) {
                return false;
            }
            
            return array_keys($arr) !== range(0, count($arr) - 1);
        }
        
        /**
         * [getParsedown description].
         *
         * @return GithubMarkdown
         */
        protected static function getParsedown ()
        {
            if (is_null(self::$parsedown)) {
                self::$parsedown = self::isCli() ? new ConsoleMarkdown() : new GithubMarkdown();
            }
            
            return self::$parsedown;
        }
    }
