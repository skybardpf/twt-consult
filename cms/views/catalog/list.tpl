{if $request.pid}
Действия над категорией:
<a href="{$root_url}{$ctrlName}/add/pid/{$request.pid}/" title="Добавить подкатегорию"><img
	alt="Добавить подкатегорию" src="/public/cms/img/icons/add.png" style="margin-bottom: -4px; margin-right: 4px;"
></a>
	<a href="{$root_url}{$ctrlName}/modify/id/{$request.pid}/" title="Редактировать"><img
	alt="Редактировать" src="/public/cms/img/icons/edit.png" style="margin-bottom: -4px; margin-right: 4px;"
></a>
	<a href="{$root_url}{$ctrlName}/delete/id/{$request.pid}/" title="Удалить"><img
	alt="Удалить" src="/public/cms/img/icons/delete.png" style="margin-bottom: -4px; margin-right: 4px;"
></a>
	<a href="{$root_url}images/list/model/catalog_tree/pid/{$request.pid}/" title="Фотогалерея"><img
	alt="Фотогалерея" src="/public/cms/img/icons/gallery.gif" style="margin-bottom: -4px; margin-right: 4px;"
></a>
	<a href="{$root_url}{$ctrlName}/puzzle/pid/{$request.pid}/" title="Пазл"><img
	alt="Фотогалерея" src="/public/cms/img/icons/arrow_compass.gif" style="margin-bottom: -4px; margin-right: 4px;"
></a>
<br><br><br>

{loadview name='actions/list'}
{else}
Выберите категорию.
{/if}