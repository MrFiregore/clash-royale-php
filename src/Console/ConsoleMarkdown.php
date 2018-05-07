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

use cebe\markdown\block\ListTrait;
use cebe\markdown\block\QuoteTrait;
use cebe\markdown\block\FencedCodeTrait;
use cebe\markdown\inline\CodeTrait;
use cebe\markdown\inline\EmphStrongTrait;
use cebe\markdown\inline\StrikeoutTrait;

/**
 * Class ConsoleMarkdown.
 */
class ConsoleMarkdown extends \cebe\markdown\Parser
{
  use FencedCodeTrait;
  use ListTrait {
    // Check Ul List before headline
    identifyUl as protected identifyBUl;
    consumeUl as protected consumeBUl;
  }
  use CodeTrait;
  use EmphStrongTrait;
  use StrikeoutTrait;
  use QuoteTrait;


    /**
     * @var array these are "escapeable" characters. When using one of these prefixed with a
     * backslash, the character will be outputted without the backslash and is not interpreted
     * as markdown.
     */
    protected $escapeCharacters = [
        '\\', // backslash
        '`', // backtick
        '<', '>',
        '*', // asterisk
        '_', // underscore
        '~', // tilde
    ];
    /**
  	 * Renders a blockquote
     * @param array $block
  	 */
  	protected function renderQuote($block)
  	{
      return Console::ansiFormat( $this->renderAbsy($block['content']), [Console::BLINK]) . "\n\n";
  	}
    /**
     * Renders a code block
     *
     * @param array $block
     * @return string
     */
    protected function renderCode($block)
    {
        return Console::ansiFormat($block['content'], [Console::NEGATIVE]) . "\n\n";
    }

    /**
     * Render a paragraph block
     *
     * @param string $block
     * @return string
     */
    protected function renderParagraph($block)
    {
        return rtrim($this->renderAbsy($block['content'])) . "\n\n";
    }

    /**
     * Renders an inline code span `` ` ``.
     * @param array $element
     * @return string
     */
    protected function renderInlineCode($element)
    {
        return Console::ansiFormat($element[1], [Console::UNDERLINE]);
    }

    /**
     * Renders empathized elements.
     * @param array $element
     * @return string
     */
    protected function renderEmph($element)
    {
        return Console::ansiFormat($this->renderAbsy($element[1]), [Console::ITALIC]);
    }

    /**
     * Renders strong elements.
     * @param array $element
     * @return string
     */
    protected function renderStrong($element)
    {
        return Console::ansiFormat($this->renderAbsy($element[1]), [Console::BOLD]);
    }
    /**
    * Renders a list
    * @param array $block
    * @return string
    */
    protected function renderList($block)
    {
      $type = $block['list'];

      $output = "";

      foreach ($block['items'] as $item => $itemLines) {
        $output .= "\t ".Console::ansiFormat("•",[Console::FG_RED]) . $this->renderAbsy($itemLines). "\n";
      }
      return $output . "\n";
    }
    /**
     * Consume lines for a paragraph
     *
     * Allow headlines, lists and code to break paragraphs
     *
     * @param array $lines
     * @param int   $current
     * @return string
     */
    protected function consumeParagraph($lines, $current)
    {
      // consume until newline
      $content = [];
      for ($i = $current, $count = count($lines); $i < $count; $i++) {
        $line = $lines[$i];
        if ($line === ''
          || ltrim($line) === ''
          || !ctype_alpha($line[0]) && (
            $this->identifyQuote($line, $lines, $i) ||
            $this->identifyUl($line, $lines, $i) ||
            $this->identifyOl($line, $lines, $i)
          ))
        {
          break;
        } elseif ($this->identifyCode($line, $lines, $i)) {
          if (preg_match('~<\w+([^>]+)$~s', implode("\n", $content))) {
            $content[] = $line;
          } else {
            break;
          }
        } else {
          $content[] = $line;
        }
      }
      $block = [
        'paragraph',
        'content' => $this->parseInline(implode("\n", $content)),
      ];
      return [$block, --$i];
    }
    /**
     * Consume lines for a blockquote element
     * @param array $lines
     * @param int   $current
     */
    protected function consumeQuote($lines, $current)
    {
      // consume until newline
      $content = [];
      for ($i = $current, $count = count($lines); $i < $count; $i++) {
        $line = $lines[$i];
        if (ltrim($line) !== '') {
          if ($line[0] == '>' && !isset($line[1])) {
            $line = '';
          } elseif (strncmp($line, '> ', 2) === 0) {
            $line = "  ".substr($line, 2);
          }
          $content[] = $line;
        } else {
          break;
        }
      }

      $block = [
        'quote',
        'content' => $this->parseBlocks($content),
        'simple' => true,
      ];
      return [$block, $i];
    }


    /**
     * Renders the strike through feature.
     * @param array $element
     * @return string
     */
    protected function renderStrike($element)
    {
        return Console::ansiFormat($this->parseInline($this->renderAbsy($element[1])), [Console::CROSSED_OUT]);
    }
}
