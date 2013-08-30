<form action="{$root_url}comments/modify/" method="post">
{if $node.id}
<p><b>Автор комментария: </b>{$node.name}</p>
<p><b>Почта комментатора: </b>{$node.mail}</p>
<p><b>Тема комментария: </b><input name="title" type="text" value="{$node.title}" size="81"></p>
<p><b>Комментарий:</b></p>
<p><textarea name="message" rows="15" cols="82">{$node.msg}</textarea></p>
<input name="id" type="hidden" value="{$node.id}">
<p><input type="submit" value="Сохранить"></p>
{else}
<p><b>Автор комментария: </b><input name="name" type="text" size="80"></p>
<p><b>Почта комментатора: </b><input name="mail" type="text" size="79"></p>
<p><b>Тема комментария: </b><input name="title" type="text" size="81"></p>
<p><b>Комментарий:</b></p>
<p><textarea name="message" rows="15" cols="82"></textarea></p>
<input name="eid" type="hidden" value="{$node.eid}">
<input name="etype" type="hidden" value="{$node.etype}">
<p><input type="submit" value="Сохранить"></p>
{/if}
</form>