{if $top_content}
{$top_content}
<br /><br />
{/if}

{if $errors}
{loadview name="page/errors"}
{/if}
{form name='modify'}
<div class="submit">
    <input type="submit" value="   переместить   " name="submit"/>
</div>
<br /><br />
<table id="fm_descr" class="pages listTable" style="display: none;">
<tr class="pages-head">
<th>Наименование</th>
<th>Количество</th>
</tr>
</table>
<br /><br />
{foreach from=$forms_elements.modify item=element key=key}
    {if $key eq 'target_warehouse_id' || $key eq 'income_warehouse_id'}
        {label name=$element.name}
        <div class="input">
        <select name="{$key}" id="modify_{$key}">
            <option value='0'>нет</option>
        {foreach from=$forms_elements.modify.$key.values item=item key=id}
            <option value="{$id}"{if isset($primary_warehouse.$id)} title="prim"{elseif isset($end_warehouse.$id)} title="end"{/if}>{$item}{if isset($primary_warehouse.$id)} - первичный склад{elseif isset($end_warehouse.$id)} - конечный склад{/if}</option>
        {/foreach}
        </select>
        </div><br />
    {else}
        {if $element.req}* {/if}{label name=$element.name}
        {input name=$element.name}
    {/if}
{/foreach}
{closeformgroup}
{$more}
<br /><br />

<div id="fm" style="display: none">
</div>
<br /><br />
<a href="#" id="popuphref">Добавить товарные позиции</a>
<br /><br />

<div class="submit">
    <input type="submit" value="   переместить   "  name="submit"/>
</div>

</form>
