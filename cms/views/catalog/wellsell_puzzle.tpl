{literal}
<style>
    .wellsell-br {font-size: 20px; color: #f00; font-weight: bold;}
    .good {display: inline-block; border: 1px solid white;}
    .good-factory {border-bottom: #003A91 1px solid; padding: 15px 5px;}
    .good-head {margin:10px 0;}
    .good-head span {font-size:18px;}
</style>
{/literal}
<div id="goods" style="width: 710px;">
<input type="button" value="Сохранить" class="save">
{foreach from=$goods key=factory item=good}
    {assign var="factoryId" value=$good[0].factory.id}
    <div class="good-factory" id="factory{$factoryId}">
    <div class="good-head"><span>{$factory}</span>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="BR" class="wellsell-br" id="br{$factoryId}"></div>
    {foreach from=$good item=g}
        {if $g.title == '!!!WELLSELL BR!!!'}
            <div class="item wellsell-br">
                BR
                <input type="hidden" name="good_id" value="{$g.id}">
                <input type="hidden" name="good_pos" value="{$g.pos}">
            </div>
        {else}
            <div class="item good">
                <input type="hidden" name="good_id" value="{$g.id}">
                <input type="hidden" name="good_pos" value="{$g.pos}">
                <img alt="{$g.title}" src="{$g.photo|replace:'[dir]':'original'}">
                <div style="width: 150px;">{$g.title}</div>
            </div>
        {/if}
    {/foreach}
    </div>
{/foreach}
<br><br>
<input type="button" value="Сохранить" class="save">
</div>
<div id="clone"></div>