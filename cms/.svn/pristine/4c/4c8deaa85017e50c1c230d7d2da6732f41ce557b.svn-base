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
{foreach from=$title_author key=key item=item}
    <b>{$item}:</b> {$author.$key}<br /><br />
{/foreach}
{foreach from=$parents key=key item=item}
<input name="{$key}" value="{$item}" type="hidden">
{/foreach}
{foreach from=$forms_elements.modify item=element}
    {if $element.req}* {/if}{label name=$element.name}
    {input name=$element.name}
{/foreach}
{closeformgroup}
{$more}
<br /><br />
{loadview name="page/buttons"}
</form>
