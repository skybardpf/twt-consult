{if $top_content}
{$top_content}
<br /><br />
{/if}

{if $errors}
{loadview name="page/errors"}
{/if}
{form name='modify'}
{*if $suppl}<div style="text-align: right;">{$suppl}</a></div><br />{/if*}
{loadview name="page/buttons"}
<br /><br />
{foreach from=$forms_elements.modify item=element}
    {if $element.req}* {/if}{label name=$element.name}
    {input name=$element.name}
{/foreach}
{closeformgroup}
<table id='answers' {if !$answers}style="display: none;"{/if}>
    <tr>
        <th>Ответ</th>
        <th>Количество голосов</th>
        <th></th>
    </tr>
    {if $answers}
        {foreach from=$answers item=answer}
            <tr>
                <td><input type="text" name="answers[old][answer][]" value="{$answer.answer}"></td>
                <td><input type="text" name="answers[old][count][]" value="{$answer.count}"></td>
                <td><button class="delete_answer_button">Удалить</button></td>
            </tr>
        {/foreach}
    {/if}
</table>
{$more}
<br /><br />
{loadview name="page/buttons"}

</form>