{loadview name='actions/show'}
<table class="listTable">
  <tr>
	<th class="pos"></th>
	<th>Название</th>
	<th>Количество</th>
	<th>Цена, р.</th>
	<th>Цена, &euro;</th>
  </tr>
{foreach from=$data.details item=good name="list"}
  <tr class="{if $smarty.foreach.list.index % 2 eq 1}odd{/if}">
	<td class="pos"></td>
	<td><a href="{$root_url}catalog/show_good/id/{$good.good_id}/">{$good.good_title}</a></td>
	<td>{$good.good_count}</td>
	<td>{$good.good_price_rur}</td>
	<td>{$good.good_price}</td>
  </tr>
{/foreach}
</table>
<br><br>
<b>Статус:</b> <br>
<form action="" method="post">
<select name="state">
{foreach from=$fields.state.values key=key item=state}
<option value="{$key}"{if $key == $data.state} selected="selected"{/if}>{$state}</option>
{/foreach}
</select>
<br>
{if isset($data.shop_comment)}
<br>
<b>{$fields.shop_comment.title}:</b><br>
<textarea style="width: 360px; height: 96px;" name="shop_comment">
</textarea><br>
{/if}

{if isset($data.inner_comment)}
<br>
<b>{$fields.inner_comment.title}:</b><br>
<textarea style="width: 360px; height: 96px;" name="inner_comment">
{$data.inner_comment}
</textarea><br>
{/if}
<br /><br />
<input type="submit" value="Сохранить">
</form>
<br /><br />
<table class="listTable">
  <tr>
    <th class="pos"></th>
    <th>Дата изменения</th>
    <th>Состояние</th>
    <th>Комментарий</th>
  </tr>
{foreach from=$data.state_log item=log name="list"}
  <tr class="{if $smarty.foreach.list.index % 2 eq 1}odd{/if}">
	<td class="pos"></td>
	<td>{$log.cDate}</td>
	<td>{$fields.state.values[$log.state]}</td>
	<td>{$log.comments}</td>
  </tr>
{/foreach}
</table>