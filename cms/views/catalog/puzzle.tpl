{literal}
<style>
.br {font-size: 20px; color: #f00; font-weight: bold;}
.good {display: inline-block; border: 1px solid white;}
</style>
{/literal}
<script type="text/javascript">
var pid = {$request.pid}; 
</script>
<div id="goods" style="width: 710px;">
<input type="button" value="К коллекции" class="exit">
<input type="button" value="Сохранить" class="save">
<input type="button" value="BR" class="br">
<br><br>
{foreach from=$goods item=g}
{if $g.title == '!!!BR!!!'}
<div class="item br">
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
<br><br>
<input type="button" value="К коллекции" class="exit">
<input type="button" value="Сохранить" class="save">
<input type="button" value="BR" class="br">
</div>

<div id="clone"></div>