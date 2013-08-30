<?php

/*
 * Smarty plugin
 * --------------------------------------------------------------
 * Type:     function
 * Name:     pager
 * Purpose:  creating a pager
 * Version:  0.1
 * Date:     Ceptember 2011
 * Last Modified:    02.09.2011
 * Author:   Yury aka Forgon
 * --------------------------------------------------------------
 */
function smarty_function_new_pager($params, &$smarty)
{
    /*
    @param  int     $linknum            - max. number of links to show on one page (default: false)
    @param  int     $delta_l            - number of links left to current (default: false);
    @param  int     $delta_r            - number of links right to current (default: false);

    @param  mixed   $pages              - number of pages to browse
    @param  boolean always_show         - show paging if there is less or equal than 1 page (default: false}

    @param  int     $curpage            - current page number
    @param  string  baseurl             - baseurl to which the pagenumber will appended
    @param  string  url_append          - text to append to url after pagenumber, e.g. "html" (default: "")
    @param  string  page_append         - text to append to url before pagenumber and after baseurl, e.g. "html" (default: "")
    @param  string  txt_first           - text for link to first page (default: "&&")
    @param  string  txt_prev            - text for link to previous page (default: "&")
    @param  string  separator           - text to print between page numbers (default: "&|&")
    @param  string  txt_next            - text for link to next page (default: "&")
    @param  string  txt_last            - text for link to last page (default: "&&")
    @param  string  txt_skip            - text shown when page s are skipped (not shown) (default: "&...&")
    @param  string  css_class           - css class for the pager (default: "")
    @param  boolean link_current        - whether to link the current page (default: false)
    @param  boolean first_w_page        - links to the first page are with pagenubmer and page_append (default: true}
    */

    /* Define all vars with default value */
    $linknum = false;
    $delta_l = false;
    $delta_r = false;
    $always_show = false;

    $container = 'ul';
    $container_class = '';
    $links_container = 'li';
    $link_current = false;

    $prev_txt   = 'prev';
    $prev_class = '';
    $show_prev_in_first = false;

    $next_txt   = 'next';
    $next_class = '';
    $show_next_in_last = false;

    $first_txt = 'first';
    $first_w_page = true;

    $last_txt  = false;


    $page_append= '';
    $url_append= '';

    $separator = '';

    $txt_skip  = '...';

/*    $css_class = '';
    $css_current='curr';*/

	$npps = null;
	$retval = '';
    /* Import parameters */
    extract($params);

    /* Convert page count if array *//*
    if (is_array($pagecount)) $pagecount = sizeof($pagecount);
    if (!empty($npps)) {
	    $retval .= '<div class="npps">';
		foreach ($npps as $n) {
			$retval .= "<a href=\"?npp=$n\" class='npp'>$n</a> ";
		}
	    $retval .= '</div>';
	}*/

    /* Check parameters */
    if (empty($curpage) || empty($pages) || empty($baseurl)) {
        return $retval;
    }

    /* Paging needed? */
    if ($pages <= 1 && !$always_show) {
        // No paging needed for one page
        return $retval;
    }

    /* There is no 0th page */
    if ($curpage) $curpage = ($curpage == 0) ? 1 : $curpage;

    /* Define additional required vars */
    if ($delta_l && $delta_r && $linknum) {
        $smarty->trigger_error("pager: You have set all 3 parameters (delta_r, delta_l, linknum)");
        return $retval;
    }
    elseif ($delta_l && $delta_r) {
        $linknum = $delta_l + $delta_r + 1;
    }
    elseif ($delta_l && $linknum) {
        $delta_r = ($linknum-1 > $delta_l) ? $linknum-1-$delta_l : 0;
    }
    elseif ($delta_r && $linknum) {
        $delta_l = ($linknum-1 > $delta_r) ? $linknum-1-$delta_r : 0;
    }
    elseif ($linknum) {
        if ($linknum % 2 == 0) {
            $delta_l = ($linknum / 2 ) - 1;
            $delta_r = $linknum / 2;
        } else {
            $delta_l = $delta_r = ($linknum - 1) / 2;
        }
    }
    else {
        $smarty->trigger_error("pager: cant count links. You have to set linknum or 2 any parameters (delta_r, delta_l, linknum)");
        return $retval;
    }
    if ($curpage > $pages) {
        $curpage = $pages;
    }
    if ($pages < $linknum) {
        $linknum = $pages;
    }
    if ($curpage - $delta_l < 1) {
        $delta_r = $linknum - $curpage;
        $delta_l = $curpage - 1;
    }
    if ($curpage + $delta_r > $pages) {
        $delta_r = $pages - $curpage;
        $delta_l = $linknum - 1 - $delta_r;
    }

    $links = array();
    for ($i = 0; $i < $delta_l; $i++) {
        $links[] = $curpage - $delta_l + $i;
    }
    $links[] = $curpage;
    for ($i = 0; $i < $delta_r; $i++) {
        $links[] = $curpage + $i + 1;
    }

    /* Build link bar */
    $retval .= '<'.$container.(($container_class) ? (' class="'.$container_class.'"') : '').'>';

    // First page link
    if ($first_txt !== false) {
    // Forgon to do
    }

    // Previous page link
    if ($prev_txt !== false && ($links[0] !== 1 || $show_prev_in_first)) {
        $retval .= '<'.$links_container.(($prev_class) ? (' class="'.$prev_class.'"') : '').'>';
        if ($curpage >= 2) {
            if ($curpage >= 2) {
                $i = $curpage-1;
            } else {
                $i = 1;
            }
            if ($i == 1) {
                $link = $baseurl.(($first_w_page) ? ($page_append.'1') : '').$url_append;
            } else {
                $link = $baseurl.$page_append.$i.$url_append;
            }
            $retval .= '<a href="'.$link.'">';
        }
        $retval .= $prev_txt;
        if ($links[0] !== 1) {
            $retval .= '</a>';
        }
        $retval .= '</'.$links_container.'>';
    }

    // Skipper if needed
    if ($links[0] != 1) {
        $retval .= '<'.$links_container.'>'.$txt_skip.'</'.$links_container.'>';
    }

    // Links to the left
    for ($i = 0; $i < $delta_l; $i++) {
        $link = $baseurl.(($links[$i] == 1 && !$first_w_page) ? '' : $page_append.$links[$i]).$url_append;
        $retval .=
            '<'.$links_container.'>'.
            '<a href="'.$link.'">'.$links[$i].'</a>'.
            '</'.$links_container.'>';
    }

    // Curr page
    $retval .=
        '<'.$links_container.'>'.
            (($link_current)
                ? '<a href="'.$baseurl.$page_append.$curpage.$url_append.'">'.$curpage.'</a>'
                : $curpage
            ).
        '</'.$links_container.'>';

    // Links to the right
    for ($i = 0; $i < $delta_r; $i++) {
        $link = $baseurl.$page_append.$links[$delta_l+1+$i].$url_append;
        $retval .=
            '<'.$links_container.'>'.
            '<a href="'.$link.'">'.$links[$delta_l+1+$i].'</a>'.
            '</'.$links_container.'>';
    }
    
    // Skipper if needed
    if (end($links) != $pages) {
        $retval .= '<'.$links_container.'>'.$txt_skip.'</'.$links_container.'>';
    }

    // Next page link
    if ($next_txt !== false  && (end($links) !== $pages || $show_next_in_last)){
        $link = $baseurl.$page_append.($curpage + 1).$url_append;
        $retval .=
            '<'.$links_container.(($next_class) ? (' class="'.$next_class.'"') : '').'>'.
            '<a href="'.$link.'">'.$next_txt.'</a>'.
            '</'.$links_container.'>';
    }
    $retval .= '</'.$container.'>';

    // Last page link
    if ($last_txt !== false) {
        // Forgon to do
    }

    return $retval;
}
?>