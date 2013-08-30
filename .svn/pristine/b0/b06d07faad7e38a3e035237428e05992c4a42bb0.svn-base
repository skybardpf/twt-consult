<div class="list_news">
    <h2>Новости</h2>
    <ul class="list">
    {foreach from=$news item=news}
        <li>
            <div class="hdng">
	            <div class="date">{$news.created|date_format:"%d.%m.%Y"}</div>
                <h3><a href="/news/new/id/{$news.id}">{$news.title}</a></h3>

            </div>
            <div class="text floatcontainer">
            {if $news.image}
                <div class="img">
                    <a href="/news/new/id/{$news.id}"><img alt="" title="" src="{$news.image|replace:'[dir]':'icon'}" style="width: 77px;height: 77px;"></a>
                </div>
            {/if}
                <div class="descr">
                    {$news.anonce}
                </div>
            </div>
        </li>
    {/foreach}
    </ul>
    {if $paging.pages}
        <div class="paging floatcontainer pager">
            {sliding_pager
                url_append = $paging.url_append
                separator  = ' '
                curpage    = $paging.curr_page
                baseurl    = $paging.base_url
                pagecount  = $paging.pages
                txt_first  = 'первая'
                txt_prev   = ''
                txt_next   = ''
                txt_last   = 'последняя'
                txt_skip   = '…'
                linknum    = 5
            }
        </div>
    {/if}
</div>

{*txt_prev   = '←'*}
{*txt_next   = '→'*}