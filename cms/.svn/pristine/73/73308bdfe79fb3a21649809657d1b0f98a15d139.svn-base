<script type="text/javascript">
{literal}
$(document).ready(function() {
	$('a.toggle_next').click(function() {
		$(this).next().toggle('fast');
		return false;
	});
});
{/literal}
</script>
{if $import_logs.error != ''}
<div style="color: red">{$import_logs.error}</div>
{else}
<div style="color: green">Поздравляем. Импорт успешно завершен.</div>
{/if}
<table>
  <tr>
    <td>Вставленно записей:</td>
    <td>
    	{$import_logs.insert_goods.count}
    	{if $import_logs.insert_goods.count > 0}
    	<a href="#" class="toggle_next">Детально</a>
    	<ul style="display: none;">
    	{foreach from=$import_logs.insert_goods item=code key=id}
	    	{if $id!='count'}
	    		<li><a href="{$root_url}catalog/modify_good/id/{$id}/" target="_blank">{$code}</a></li>
	    	{/if}
    	{/foreach}
    	</ul>
    	{/if}
    </td>
  </tr>
  <tr>
    <td>Обновлено записей:</td>
    <td>
    	{$import_logs.update_goods.count}
    	{if $import_logs.update_goods.count > 0}
    	<a href="#" class="toggle_next">Детально</a>
    	<ul style="display: none;">
    	{foreach from=$import_logs.update_goods item=code key=id}
	    	{if $id!='count'}
	    		<li><a href="{$root_url}catalog/modify_good/id/{$id}/" target="_blank">{$code}</a></li>
	    	{/if}
    	{/foreach}
    	</ul>
    	{/if}
    </td>
  </tr>
  <tr>
    <td>Ошибок записи:</td>
    <td>
    	{$import_logs.infail_goods.count}
    	{if $import_logs.infail_goods.count > 0}
    	<a href="#" class="toggle_next">Детально</a>
    	<ul style="display: none;">
    	{foreach from=$import_logs.infail_goods item=code key=id}
	    	{if $id!='count'}
	    		<li>{$code}</li>
	    	{/if}
    	{/foreach}
    	</ul>
    	{/if}
    </td>
  </tr>
  <tr>
    <td>Обновления:</td>
    <td>
    	{$import_logs.upfail_goods.count}
    	{if $import_logs.upfail_goods.count > 0}
    	<a href="#" class="toggle_next">Детально</a>
    	<ul style="display: none;">
    	{foreach from=$import_logs.upfail_goods item=code key=id}
	    	{if $id!='count'}
	    		<li><a href="{$root_url}catalog/modify_good/id/{$id}/" target="_blank">{$code}</a></li>
	    	{/if}
    	{/foreach}
    	</ul>
    	{/if}
    </td>
  </tr>
</table>