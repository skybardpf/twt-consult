<?php
/*
 * Smarty plugin
 * ------------------------------------------------------------
 * Type:     modifier
 * Name:     bbcode
 * Purpose:  Converts BBCode tags to HTML tags.
 * Version:  1.4.5
 * Date:     31.08.2006
 *
 * Install:  Drop into the plugins directory.
 * Author:   Sam
 * Homepage: http://rmcreative.ru/
 *
 * Based on Andre Rabold's bbcode modifier.
 * Added:    some new tags
 *           php code highlighting
 *           new line to <br> converter
 *              antispam mail protection
 *              rss compatibility
 *
 * Changes
 * 1.3:
 * [+] [h2],[h3],[h4],[h5],[h6] added
 * [*] [strike] tag changed to [s]
 * [*] More tags added & removed
 *
 * 1.4
 * [+] "@" replacement to ".sobaka." in email tag
 * [*] HTML entities displaying in [php] tags fixed
 * [-] HTML stripping removed
 *
 * 1.4.1
 * [*] <img/> tag changed to <img>
 *
 * 1.4.2
 * [*] All external CSS built in
 * [+] RSS Feeds Compatible
 *
 * 1.4.3
 * [*] HTML tags displaying fixed
 *
 * 1.4.4
 * [-] Some unncessary code cleaned ;)
 * [*] HTML displaying fixed once again
 * 
 * 1.4.5
 * [+] Valid e-mail indexing prevention  
 *
 * ------------------------------------------------------------
 */

function smarty_modifier_bbcode($message) {
    $preg = array(
          //'~<([^<]+)>~' => '&lt;$1&gt;',
          // Macromedia flash object (commented for security reasons)
          //'~(?<!\\\\)\[flash(?::\w+)?=(.*?)x(.*?)\](.*?)\[/flash(?::\w+)?\]~si' => '<object width="\1" height="\2"><param name="movie" value="\3" /><embed src="\3" width="\1" height="\2"></embed></object>',
          // Text arrtibutes
          '~(?<!\\\\)\[s(?::\w+)?\](.*?)\[/s(?::\w+)?\]~si'        => '<span style="text-decoration:line-through;">\1</span>',
          '/(?<!\\\\)\[b(?::\w+)?\](.*?)\[\/b(?::\w+)?\]/si'                 => "<span style=\"font-weight:bold\">\\1</span>",
          '/(?<!\\\\)\[i(?::\w+)?\](.*?)\[\/i(?::\w+)?\]/si'                 => "<span style=\"font-style:italic\">\\1</span>",
          '/(?<!\\\\)\[u(?::\w+)?\](.*?)\[\/u(?::\w+)?\]/si'                 => "<span style=\"text-decoration:underline\">\\1</span>",
          '/(?<!\\\\)\[color(?::\w+)?=(.*?)\](.*?)\[\/color(?::\w+)?\]/si'   => "<span style=\"color:\\1\">\\2</span>",
          //align
          '/(?<!\\\\)\[leftfloat(?::\w+)?\](.*?)\[\/leftfloat(?::\w+)?\]/si' => "<div style=\"float: left; margin-right: 10px; margin-left: 10px; clear: none;\">\\1</div>",
          '/(?<!\\\\)\[rightfloat(?::\w+)?\](.*?)\[\/rightfloat(?::\w+)?\]/si' => "<div style=\"float: right; margin-right: 10px; margin-left: 10px; clear: none\">\\1</div>",
          '/(?<!\\\\)\[center(?::\w+)?\](.*?)\[\/center(?::\w+)?\]/si'       => "<div style=\"text-align: center\">\\1</div>",
          '/(?<!\\\\)\[left(?::\w+)?\](.*?)\[\/left(?::\w+)?\]/si'           => "<div style=\"text-align: left\">\\1</div>",
          '/(?<!\\\\)\[right(?::\w+)?\](.*?)\[\/right(?::\w+)?\]/si'         => "<div style=\"text-align: right\">\\1</div>",
          //headers
          '/(?<!\\\\)\[h1(?::\w+)?\](.*?)\[\/h1(?::\w+)?\]/si'               => "<span style=\"font-size:145%;\">\\1</span>",
          '/(?<!\\\\)\[h2(?::\w+)?\](.*?)\[\/h2(?::\w+)?\]/si'               => "<span style=\"font-size:135%;\">\\1</span>",
          '/(?<!\\\\)\[h3(?::\w+)?\](.*?)\[\/h3(?::\w+)?\]/si'               => "<span style=\"font-size:125%;\">\\1</span>",
          '/(?<!\\\\)\[h4(?::\w+)?\](.*?)\[\/h1(?::\w+)?\]/si'               => "<span style=\"font-size:115%;\">\\1</span>",
          '/(?<!\\\\)\[h5(?::\w+)?\](.*?)\[\/h2(?::\w+)?\]/si'               => "<span style=\"font-size:105%;\">\\1</span>",
          '/(?<!\\\\)\[h6(?::\w+)?\](.*?)\[\/h3(?::\w+)?\]/si'               => "<span style=\"font-size:95%;\">\\1</span>",

          // Code & PHP frames. PHP is highlighted ;)
          '/(?<!\\\\)\[code(?::\w+)?\](.*?)\[\/code(?::\w+)?\]/si'           => "<div style=\"text-align: left; border: 1px solid #cccccc; background-color: #e8e8e8; padding-left: 10px; padding-right: 10px; font-family: Courier-new, monospace; font-size:13\">\\1</div>",
          '/(?<!\\\\)\[php(?::\w+)?\](.*?)\[\/php(?::\w+)?\]/sei'            => "'<div style=\"text-align: left; border: 1px solid #cccccc; background-color: #e8e8e8; padding-left: 10px; padding-right: 10px; font-family: Courier-new, monospace; font-size:13\">'.highlight_string('<?php\n'.'$1'.'\n?>', true).'</div>'",

          // email with indexing prevention & @ replacement
          '/(?<!\\\\)\[email(?::\w+)?\](.*?)\[\/email(?::\w+)?\]/sei'         => "'<a rel=\"noindex\" href=\"mailto:'.str_replace('@', '.at.','$1').'\">'.str_replace('@', '.at.','$1').'</a>'",
          '/(?<!\\\\)\[email(?::\w+)?=(.*?)\](.*?)\[\/email(?::\w+)?\]/sei'   => "'<a rel=\"noindex\" href=\"mailto:'.str_replace('@', '.at.','$1').'\">$2</a>'",
          //"'\\1'.strtoupper('\\2').'\\3'"
          // links
          '/(?<!\\\\)\[url(?::\w+)?\]www\.(.*?)\[\/url(?::\w+)?\]/si'        => "<a href=\"http://www.\\1\">\\1</a>",
          '/(?<!\\\\)\[url(?::\w+)?\](.*?)\[\/url(?::\w+)?\]/si'             => "<a href=\"\\1\">\\1</a>",
          '/(?<!\\\\)\[url(?::\w+)?=(.*?)?\](.*?)\[\/url(?::\w+)?\]/si'      => "<a href=\"\\1\">\\2</a>",
          // images
          '/(?<!\\\\)\[img(?::\w+)?\](.*?)\[\/img(?::\w+)?\]/si'             => "<img src=\"$1\" alt=\"$1\" style=\"border: 2px solid #DCD6C4\">",
          '/(?<!\\\\)\[img(?::\w+)?=(.*?)x(.*?)\](.*?)\[\/img(?::\w+)?\]/si' => "<img width=\"$1\" height=\"$2\" src=\"$3\" alt=\"$3\" style=\"border: 2px solid #DCD6C4\">",
          // alt. images
          '/(?<!\\\\)\[nbimg(?::\w+)?\](.*?)\[\/nbimg(?::\w+)?\]/si'             => "<img src=\"$1\" alt=\"$1\" style=\"border-style: none\" />",
          '/(?<!\\\\)\[nbimg(?::\w+)?=(.*?)x(.*?)\](.*?)\[\/nbimg(?::\w+)?\]/si' => "<img width=\"$1\" height=\"$2\" src=\"$3\" alt=\"$3\" style=\"border-style: none\">",
          // quoting
          '/(?<!\\\\)\[quote(?::\w+)?\](.*?)\[\/quote(?::\w+)?\]/si'         => "<div>Цитата:<div style=\"border: 1px solid #cccccc; background-color: #e8e8e8; padding: 10px\">\\1</div></div>",
          '/(?<!\\\\)\[quote(?::\w+)?=(?:&quot;|"|\')?(.*?)["\']?(?:&quot;|"|\')?\](.*?)\[\/quote\]/si'   => "<div>\\1:<div style=\"border: 1px solid #cccccc; background-color: #e8e8e8; padding: 10px\">\\2</div></div>",
          // lists
          '/(?<!\\\\)(?:\s*<br\s*\/?>\s*)?\[\*(?::\w+)?\](.*?)(?=(?:\s*<br\s*\/?>\s*)?\[\*|(?:\s*<br\s*\/?>\s*)?\[\/?list)/si' => "\n<li>\\1</li>",
          '/(?<!\\\\)(?:\s*<br\s*\/?>\s*)?\[\/list(:(?!u|o)\w+)?\](?:<br\s*\/?>)?/si'    => "\n</ul>",
          '/(?<!\\\\)(?:\s*<br\s*\/?>\s*)?\[\/list:u(:\w+)?\](?:<br\s*\/?>)?/si'         => "\n</ul>",
          '/(?<!\\\\)(?:\s*<br\s*\/?>\s*)?\[\/list:o(:\w+)?\](?:<br\s*\/?>)?/si'         => "\n</ol>",
          '/(?<!\\\\)(?:\s*<br\s*\/?>\s*)?\[list(:(?!u|o)\w+)?\]\s*(?:<br\s*\/?>)?/si'   => "\n<ul>",
          '/(?<!\\\\)(?:\s*<br\s*\/?>\s*)?\[list:u(:\w+)?\]\s*(?:<br\s*\/?>)?/si'        => "\n<ul>",
          '/(?<!\\\\)(?:\s*<br\s*\/?>\s*)?\[list:o(:\w+)?\]\s*(?:<br\s*\/?>)?/si'        => "\n<ol>",
          '/(?<!\\\\)(?:\s*<br\s*\/?>\s*)?\[list(?::o)?(:\w+)?=1\]\s*(?:<br\s*\/?>)?/si' => "\n<ol style=\"list-style-type:decimal\">",
          '/(?<!\\\\)(?:\s*<br\s*\/?>\s*)?\[list(?::o)?(:\w+)?=i\]\s*(?:<br\s*\/?>)?/s'  => "\n<ol style=\"list-style-type:lower-roman\">",
          '/(?<!\\\\)(?:\s*<br\s*\/?>\s*)?\[list(?::o)?(:\w+)?=I\]\s*(?:<br\s*\/?>)?/s'  => "\n<ol style=\"list-style-type:upper-roman\">",
          '/(?<!\\\\)(?:\s*<br\s*\/?>\s*)?\[list(?::o)?(:\w+)?=a\]\s*(?:<br\s*\/?>)?/s'  => "\n<ol style=\"list-style-type:lower-alpha\">",
          '/(?<!\\\\)(?:\s*<br\s*\/?>\s*)?\[list(?::o)?(:\w+)?=A\]\s*(?:<br\s*\/?>)?/s'  => "\n<ol style=\"list-style-type:upper-alpha\">",

          // escaped tags like \[b], \[color], \[url], e.t.c.
          '/\\\\(\[\/?\w+(?::\w+)*\])/'                                      => "\\1",

          //new line to <br>
          //'~\n~' => '<br>'
          
          
  );
  return preg_replace(array_keys($preg), array_values($preg), $message);
}