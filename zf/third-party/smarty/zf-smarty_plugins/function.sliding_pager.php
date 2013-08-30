<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     function
 * Name:     sliding_page
 * Purpose:  create a sliding-pager for page browsing
 * Version:  0.1
 * Date:     April 11, 2004
 * Last Modified:    August 4, 2008
 * Author:   Mario Witte <mario dot witte at chengfu dot net>
 * HTTP:     http://www.chengfu.net/
 * -------------------------------------------------------------
 */
function smarty_function_sliding_pager($params, &$smarty)
{
    /*
    @param  mixed   $pagecount          - number of pages to browse
    @param  int     $linknum            - max. number of links to show on one page (default: 5)
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
    @param  boolean always_show         - show paging if there is less or equal than 1 page (default: false}
    @param  boolean first_w_page        - links to the first page are with pagenubmer and page_append (default: true}
    */

    /* Define all vars with default value */
    $first_w_page = true;
    $always_show = false;
    $linknum = 5;
    $page_append= '';
    $url_append= '';
    $txt_first = 'first';
    $txt_prev  = 'prev';
    $separator = '';
    $txt_next  = 'next';
    $txt_last  = 'last';
    $txt_skip  = '...';
    $css_class = '';
    $css_current='curr';
    $link_current = false;
    $show_next_in_last = false;
	$npps = null;
	$retval = '';
    /* Import parameters */
    extract($params);

    /* Convert page count if array */
    if (is_array($pagecount)) $pagecount = sizeof($pagecount);
    if (!empty($npps)) {
	    $retval .= '<div class="npps">';
		foreach ($npps as $n) {
			$retval .= "<a href=\"?npp=$n\" class='npp'>$n</a> ";
		}
	    $retval .= '</div>';
	}
    /* Define additional required vars */
    $delta_l = 0;
    $delta_r = 0;
    if ($linknum % 2 == 0) {
        $delta_l = ($linknum / 2 ) - 1;
        $delta_r = $linknum / 2;
    } else {
        $delta_l = $delta_r = ($linknum - 1) / 2;
    }

    /* Check parameters */
    if (empty($pagecount)) {
        return $retval;
    }
    if (empty($curpage)) {
        return $retval;
    }
    if (empty($baseurl)) {
        $smarty->trigger_error("sliding_pager: missing 'baseurl' parameter");
        return $retval;
    }

    /* There is no 0th page */
    $curpage = $curpage == 0 ? 1 : $curpage;

    /* Internally we need an "array-compatible" index */
    $int_curpage = $curpage - 1;

    /* Paging needed? */
    if ($pagecount <= 1 && !$always_show) {
        // No paging needed for one page
        return $retval;
    }

    /* Build all page links (we'll delete some later if required) */
    $links = array();
    for($i = 0; $i < $pagecount; $i++) {
        $links[$i] = $i + 1;
    }

    /* Sliding needed? */
    if ($pagecount > $linknum) { // Yes
        if (($int_curpage - $delta_l) < 1) { // Delta_l needs adjustment, we are too far left
            $delta_l = $int_curpage - 1;
            $delta_r = $linknum - $delta_l - 1;
        }
        if (($int_curpage + $delta_r) > $pagecount) { // Delta_r needs adjustment, we are too far right
            $delta_r = $pagecount - $int_curpage;
            $delta_l = $linknum - $delta_r - 1;
        }
        if ($int_curpage - $delta_l > 1) { // Let's do some cutting on the left side
            array_splice($links, 0, $int_curpage - $delta_l);
        }
        if ($int_curpage + $delta_r < $pagecount) { // The right side will also need some treatment
            array_splice($links, $int_curpage + $delta_r + 2 - $links[0]);
        }
    }

    /* Build link bar */
    $css_class = $css_class ? 'class="'.$css_class.'"' : '';
    if ($curpage > 1) {
    	if ($txt_first != '') {
            $append = ($first_w_page) ? $baseurl.$page_append.'1'.$url_append : $baseurl.$url_append;
    		$retval .= '<a class="first" page="1" href="'.$append.'" '.$css_class.'>'.$txt_first.'</a>';
    		$retval .= $separator;
    	}
    	if ($txt_prev != '') {
            $append = ($curpage == 2) ? (($first_w_page) ? $baseurl.$page_append.'1'.$url_append : $baseurl.$url_append) : $baseurl.$page_append.($curpage - 1).$url_append;
	        $retval .= '<a class="prev" page="'.($curpage - 1).'" href="'.$append.'" '.$css_class.'>'.$txt_prev.'</a>';
	        $retval .= $separator;
    	}
    }
    if ($curpage == 1 and $txt_prev != '') {
    	$retval .= '<span class="prev" '.$css_class.'>'.$txt_prev.'</span>';
        $retval .= $separator;
    }
    
    if ($links[0] != 1) {
        $append = ($first_w_page) ? $baseurl.$page_append.'1'.$url_append : $baseurl.$url_append;
        $retval .= '<a page="1" href="'.$append.'" '.$css_class.'>1</a>';
        if ($links[0] == 2) {
            $retval .= $separator;
        } else {
            $retval .= '<span>'.$txt_skip.'</span>';
        }
    }
    for($i = 0; $i < sizeof($links); $i++) {
        if ($links[$i] != $curpage or $link_current) {
            $append = ($links[$i] == '1') ? (($first_w_page) ? $baseurl.$page_append.'1'.$url_append : $baseurl.$url_append) : $baseurl.$page_append.$links[$i].$url_append;
            $retval .= '<a href="'.$append.'" page="'.$links[$i].'" '.$css_class.'>'.$links[$i].'</a>';
        } else {
            $retval .= '<span class="'.$css_current.'">'.$links[$i].'</span>';
        }
        if ($i < sizeof($links) - 1) {
            $retval .= $separator;
        }
    }
    if ($links[sizeof($links) - 1] != $pagecount) {
        if ($links[sizeof($links) - 2] != $pagecount - 1) {
            $retval .= '<span>'.$txt_skip.'</span>';
        } else {
            $retval .= $separator;
        }
        $retval .= '<a href="'.$baseurl.$page_append.$pagecount.$url_append.'" page="'.$pagecount.'" '.$css_class.'>'.$pagecount.'</a>';
    }
    if ($curpage != $pagecount) {
        $retval .= $separator;
        if ($txt_next != '') {
        	$retval .= '<a class="next" page="'.($curpage + 1).'" href="'.$baseurl.$page_append.($curpage + 1).$url_append.'" '.$css_class.'>'.$txt_next.'</a>';
        }
        if ($txt_last != '') {
    	    $retval .= $separator;
	        $retval .= '<a class="last" page="'.($pagecount).'" href="'.$baseurl.$page_append.$pagecount.$url_append.'" '.$css_class.'>'.$txt_last.'</a>';
        }
    } elseif ($show_next_in_last) {
        if ($txt_next != '') {
            $retval .= $separator;
            $retval .= '<span class="next" '.$css_class.'>'.$txt_next.'</span>';
        }
    }
    return $retval;
}

/* vim: set expandtab: */
/* vim: set ts=4: */

?>