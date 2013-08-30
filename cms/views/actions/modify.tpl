{if $top_content}
{if $render_top_content}{loadview name=$top_content}{else}{$top_content}{/if}

<br /><br />
{/if}

{if $errors}
{loadview name="page/errors"}
{/if}

{form name='modify'}
{*if $suppl}<div style="text-align: right;">{$suppl}</a></div><br />{/if*}
{if !isset($nobuttons)}
{loadview name="page/buttons"}
<br /><br />
{/if}
<table id="editfields">
{foreach from=$forms_elements.modify item=element}
<tr{if $element.type eq 'placeholder' && $element.id} id="table_{$element.id}"{if $element.hide} style="display: none;"{/if}{/if}>
<td style="width:25%;">
    {if $element.req}* {/if}{label name=$element.name}
</td>
<td>
    {input name=$element.name}
</td>
</tr>
{/foreach}
</table>
{closeformgroup}
{$more}
<br /><br />
{loadview name=$buttons_view_name|default:'page/buttons'}
</form>
