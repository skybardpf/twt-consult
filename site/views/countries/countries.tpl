<div class="list_countries">
    <h2>Страны</h2>
    {if $settings.settings_countries}{$settings.settings_countries}{/if}
    <ul class="list">
    {foreach from=$countries item=row}
        <li>
            <div class="hdng">
                <img alt="" title="" src="{$row.flag|replace:'[dir]':'small'}" align="left">&nbsp;<a href="/countries/{if $row.url}{$row.url}{else}id/{$row.id}{/if}">{$row.title}</a>
            </div>
        </li>
    {/foreach}
    </ul>
</div>