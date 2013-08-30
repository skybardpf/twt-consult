{*<div class="inner_menu">
    <div class="menu_item active">
        <img src="/public/site/img/inner_menu.png">
        <div>Дивидендные схемы</div>
    </div>
    <div class="menu_item">
        <img src="/public/site/img/inner_menu.png">
        <div>Экспортно-импортные операции</div>
    </div>
    <div class="menu_item">
        <img src="/public/site/img/inner_menu.png">
        <div>Франшизы</div>
    </div>
    <div class="menu_item right">
        <img src="/public/site/img/inner_menu.png">
        <div>Ройялити</div>
    </div>
</div>*}


{foreach from=$services item=service name=services}
    {if $service.children}
        {foreach from=$service.children item=s_child name=s_children}
            {if in_array($s_child.id, $service_ids)}
                {if $s_child.children}

                <div class="id{$smarty.foreach.services.iteration}_{$smarty.foreach.s_children.iteration} layer3 inner_menu">
                    {foreach from=$s_child.children item=s_s_child name=s_s_children}

                           <div class="menu_item{if $smarty.foreach.s_s_children.iteration % 4 == 0} right{/if}{if $s_s_child.id == $service_ids[2]} active default{/if}">
                                {if $s_s_child.icon}<img alt="" title="" src="{$s_s_child.icon|replace:'[dir]':'middle'}">{/if}
                                <div><a href="/services/{$s_s_child.url}">{$s_s_child.title}</a></div>
                            </div>

                    {/foreach}

                </div>

                {/if}
            {/if}
        {/foreach}
    {/if}
{/foreach}
