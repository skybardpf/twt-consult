{if $CAction == 'edit'}
    {loadview name=cabinet/cabinet_companies_edit}
{elseif $CAction == 'show'}
    {loadview name=cabinet/cabinet_companies_show}
{else}
	<h3 class="blue_title">Мои компании</h3>
	{if $rows}
	    <table class="striped">

	            {foreach from=$rows item=row name=i}
	                <tr>
	                    <td class="num">{$smarty.foreach.i.iteration}</td>
	                    <td>{$row.created|date_format:'%d.%m.%Y'}</td>
	                    <td><a class="except" href="/cabinet/showcompany/id/{$row.id}">{$row.name}</a></td>
	                    <td>
	                        <a class="except" href="/cabinet/editcompany/id/{$row.id}">редактировать</a>
	                    </td>
	                    <td>
	                        <a class="except remove" href="javascript:void(0)" data-remove="1" data-href="/cabinet/deletecompany/id/{$row.id}">удалить</a>
	                    </td>
	                </tr>
	            {/foreach}

	        <tr>
	            <td colspan="5" class="with-button" style="text-align: center;">
	                <a style="display: inline-block; margin-top: 20px;" href="/cabinet/addcompany">Добавить компанию</a>
	            </td>
	        </tr>
	    </table>
    {else}
        <div style="font-size: 12px;">
	        Вы не добавили ни одной компании.
        </div>
		<div style="text-align: center; font-size: 12px;">
			<a style="display: inline-block; margin-top: 20px;" href="/cabinet/addcompany">Добавить компанию</a>
		</div>

    {/if}
{/if}

<div id="dialog-confirm" title="Empty the recycle bin?" style="display: none">
    <p>Вы действительно хотите удалить компанию?</p>
    <p>
        <button data-yes="1">Да</button>
        <button data-no="1">Нет</button>
    </p>
</div>