<h3>Вывод просмотра он-лайн конференции для CMS</h3>

{loadview name="actions/show"}

{if $data.closed ne 'yes'}<a href="{$root_url}{$ctrlName}/add_question/pid/{$request.id}">Добавить вопрос</a>{/if}

<div>
    {foreach from=$questions item=item}
        <div style="margin:1em 0;">
            {$item.date},&nbsp;&nbsp;&nbsp;<b>{$item.name}</b>,&nbsp;&nbsp;&nbsp;{$item.mail}<br /><br />
            вопрос: {$item.question}<br />
            {if strip_tags(trim($item.answer))}
            	ответ: {$item.answer}<br />
            {/if}
            {strip}
            <a href="{$root_url}conferencia/change_question/field/hidden/id/{$item.id}/">
            	{if $item.hidden=='yes'}
                	скрыт
                {else}
                	виден
                {/if}
            </a>{/strip}
            &nbsp;&nbsp;&nbsp;
            <a href="{$root_url}conferencia/modify_question/pid/{$request.id}/id/{$item.id}/">
            	Редактировать вопрос
            </a>
        </div>
    {/foreach}
</div>

{if $data.closed ne 'yes' and $questions}<a href="{$root_url}{$ctrlName}/add_question/pid/{$request.id}">Добавить вопрос</a>{/if}
