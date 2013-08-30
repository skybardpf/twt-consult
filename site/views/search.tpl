
<div class="search_cont">

    <h2>Результаты поиска</h2>

    <div class="search">
        <form action="/search" method="get" id="page_search_form">
            <label class="infield" style="display: block; "></label>
            <input type="text" name="q" value="{$smarty.get.q|escape}" size="70">
            <input type="image" src="/public/site/img/search.png" alt="search" title="search">
        </form>
    </div>

    {if !empty($data)}
    <div class="search_list">
    <ol start="{$paging.from+1}" class="search">
    {foreach from=$data item=item}
        <li><a href="{$item.model.url|replace:'[id]':$item.id}">{$item.title}</a><div>{$item.excerpt}</div></li>
    {/foreach}
    {else}
    По вашему запросу ничего не найдено.
    {/if}
    </ol>
    {if $paging and $paging.pages}
    <div class="{$paging.css_class}">
        {sliding_pager
        url_append = $paging.url_append
        separator  = $paging.separator
        curpage    = $paging.curr_page
        baseurl    = $paging.base_url
        pagecount  = $paging.pages
        txt_first  = $paging.first       txt_prev = $paging.prev
        txt_next   = $paging.next        txt_last = $paging.last
        txt_skip   = $paging.skip        linknum  = $paging.linkcount
    }
    </div>
    </div>
    {/if}

</div>