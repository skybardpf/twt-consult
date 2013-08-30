{form name='Geo_Modify'}
<br /><br />
{foreach from=$forms_elements.Geo_Modify item=element}
    {label name=$element.name}
    {input name=$element.name}
{/foreach}
{closeformgroup}
{loadview name="page/buttons"}
</form>
{if $conn}
    Существуют следующие связи со следущими данными:<br/>
    {if $conn.up}
        Связи вверх<br/>
    {/if}
    {foreach from=$conn.up item=item key=key}
        <a href="/admin/geographer/mod_geo/id/{$key}/type/data">{$item}</a><br/>
    {/foreach}
    <br/>
    {if $conn.down}
        Связи вниз<br/>
    {/if}
    {foreach from=$conn.down item=item key=key}
        <a href="/admin/geographer/mod_geo/id/{$key}/type/data">{$item}</a><br/>
    {/foreach}
{/if}