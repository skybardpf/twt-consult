<table>
    {foreach from=$pictures item=picture key=key}
        <tr>
            <td>
                <a href='{$root_url}{$ctrlName}/posit/dir/up/id/{$picture.id}/pid/{$pid}/'><image src="/public/cms/img/icons/arrow_up.png" style="float: left;"></a>
                <a href='{$root_url}{$ctrlName}/posit/dir/down/id/{$picture.id}/pid/{$pid}/'><image src="/public/cms/img/icons/arrow_down.png" style="float: left;"></a>
            </td>
            <td>
                <a href="{$root_url}{$ctrlName}/modify_image/id/{$picture.id}/pid/{$pid}/">
                    <image src="{$picture.image|replace:'[dir]':'icon'}" style="float: left;">
                </a>
            </td>
            <td>
                {$picture.title}<br />
            </td>
            <td>
                <a href='{$root_url}{$ctrlName}/delete_image/id/{$picture.id}/pid/{$pid}/'><image src="/public/cms/img/icons/delete.png" style="float: left;"></a>
            </td>
        </tr>
    {/foreach}
</table>
<a href='{$root_url}{$ctrlName}/add_image/pid/{$pid}/'>Добавить изображение в эту галерею</a>