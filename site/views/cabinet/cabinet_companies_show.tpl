<table class="striped">
    {foreach from=$titles key=field item=value}
        <tr>
            <td>{$value}</td>
            <td>{$data.$field}</td>
        </tr>
    {/foreach}
</table>
<div><a style="font-size: 12px;" href="/cabinet/companies">назад</a></div>