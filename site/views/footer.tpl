<div class="footer{if $page_content.id != 1} inner{/if}">
    <div class="footer_inner">
        {*<div class="footer_menu">
            {foreach from=$footer_menu item=menu name=footer_menu}
                <div class="color_block box_{$smarty.foreach.footer_menu.iteration}">
                    <div class="menu_header"><a href="/{$menu.url}">{$menu.title}</a></div>
                    {if $menu.children}
                    {foreach from=$menu.children item=submenu}
                        <a href="/services/{$submenu.url}">{$submenu.title}</a>
                    {/foreach}
                    {/if}
                </div>
            {/foreach}

            <div class="color_block box_6">

            </div>
        </div>*}

        <div class="footer_contacts{if $page_content.id != 1} inner{/if}">
            <div class="copyright">
                © 2012 - {$smarty.now|date_format:"%Y"}. TWT Consult<br>
                Горячая линия +7 (495) 660-81-11<br>
                {*<a href="/rights">Правовая информация</a>*}
            </div>
            <div class="counters">
                {$settings.counters}
            </div>
            <div class="search">
                <form action="/search" method="get" id="search_form">
                    <label class="infield" style="display: block; ">поиск по сайту</label>
                    <input type="text" name="q">
                    <input type="image" src="/public/site/img/search.png" alt="search" title="search">
                </form>
                <div class="search_sample" id="search_sample">
                    Например: <span>страхование груза</span>
                    {*<a href="#" id="search">расширенный поиск</a>*}
                </div>
            </div>
            <div class="our_logo">
	            <div>
		            <a href="http://artektiv.ru/" target="_blank">Разработка сайта</a>
	            </div>
                <a href="http://artektiv.ru/" target="_blank"><img alt="" title="" src="/public/site/img/art_logo.png"></a>

            </div>

        </div>
    </div>
</div>