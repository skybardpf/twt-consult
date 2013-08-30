{if !$import}
Чтобы начать импорт, выберите файл на своем компьютере и нажмите на кнопку "Начать импорт". Импорт может занять некоторое время, поэтому ничего не нажимайте и не обновляйте страницу, пока не появится сообщение о успешном или проваленном импортировании.<br/>
<form action="" method="post" enctype="multipart/form-data">
    <input type="file" value="" name="import_file"/>
    <input type="submit" value="Начать импорт">
</form>
{elseif $import.result == 'success'}
Импорт завершился удачно.<br />
Число незаписанных строк: {$import.fail_number}.
{else}
Импорт не удался, попробуйте еще раз или обратитесь к администратору.
    {if $import.error == 'no_file'}
    <br/> Файл импорта не найден.
    {elseif $import.error == 'wrong_file'}
    <br/> Файл импорта имеет некорректное имя.
    {elseif $import.error == 'sql_error'}
    <br/> Ошибка во время записи в базу.
    {/if}
{/if}