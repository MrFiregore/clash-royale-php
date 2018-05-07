<?php
/**************************************************************************************************************************************************************************************************************************************************************
 *                                                                                                                                                                                                                                                            *
 * Copyright (c) 2018 by Firegore (https://firegore.es) (git:firegore2).                                                                                                                                                                                      *
 * This file is part of clash-royale-php.                                                                                                                                                                                                                     *
 *                                                                                                                                                                                                                                                            *
 * clash-royale-php is free software: you can redistribute it and/or modify it under the terms of the GNU Affero General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version. *
 * clash-royale-php is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                                                                    *
 * See the GNU Affero General Public License for more details.                                                                                                                                                                                                *
 * You should have received a copy of the GNU General Public License along with clash-royale-php.                                                                                                                                                             *
 * If not, see <http://www.gnu.org/licenses/>.                                                                                                                                                                                                                *
 *                                                                                                                                                                                                                                                            *
 **************************************************************************************************************************************************************************************************************************************************************/

namespace CR\Console;



/**
 * Class BaseConsole.
 */
class BaseConsole
{
  // foreground color control codes
  const FG_BLACK = 30;
  const FG_RED = 31;
  const FG_GREEN = 32;
  const FG_YELLOW = 33;
  const FG_BLUE = 34;
  const FG_PURPLE = 35;
  const FG_CYAN = 36;
  const FG_GREY = 37;
  // background color control codes
  const BG_BLACK = 40;
  const BG_RED = 41;
  const BG_GREEN = 42;
  const BG_YELLOW = 43;
  const BG_BLUE = 44;
  const BG_PURPLE = 45;
  const BG_CYAN = 46;
  const BG_GREY = 47;
  // fonts style control codes
  const RESET = 0;
  const NORMAL = 0;
  const BOLD = 1;
  const ITALIC = 3;
  const UNDERLINE = 4;
  const BLINK = 5;
  const NEGATIVE = 7;
  const CONCEALED = 8;
  const CROSSED_OUT = 9;
  const FRAMED = 51;
  const ENCIRCLED = 52;
  const OVERLINED = 53;
  /**
   * Will return a string formatted with the given ANSI style.
   *
   * @param string $string the string to be formatted
   * @param array $format An array containing formatting values.
   * You can pass any of the `FG_*`, `BG_*` and `TEXT_*` constants
   * and also [[xtermFgColor]] and [[xtermBgColor]] to specify a format.
   * @return string
   */
  public static function ansiFormat($string, $format = [])
  {
      $code = implode(';', $format);

      return "\033[0m" . ($code !== '' ? "\033[" . $code . 'm' : '') . $string . "\033[0m";
  }


}
