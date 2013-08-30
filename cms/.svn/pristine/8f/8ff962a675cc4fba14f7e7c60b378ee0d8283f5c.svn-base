{if !$export}
Чтобы начать экспорт, выберите категорию товаров, которые вы хотиет выгрузить и нажмите на кнопку "Начать экспорт". Экспорт может занять некоторое время, поэтому ничего не нажимайте и не обновляйте страницу, пока не появится сообщение о успешном или проваленном экспорте.<br/>
<form action="" method="post">
    <select name="category_id">
        {foreach from=$export_categories item=exp_category}
            <option value="{$exp_category.id}">{$exp_category.title}</option>
        {/foreach}
    </select>
    <input type="submit" value="Начать экспорт">
</form>
{elseif $export.result == 'success'}
Экспорт завершился удачно, вы можете загрузить полученный файл <a href="/public/userfiles/export/{$export.filename}">здесь</a>
{else}
Экспорт не удался, попробуйте еще раз или обратитесь к администратору
{/if}