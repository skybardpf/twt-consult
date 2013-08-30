{if $result}
    {$result}<br/><br/>
    <a href="{$retlink|replace:'[root_url]':$root_url}">К списку файлов</a>
{else}
    {form name='file_red'}
    <table style="width:100%;">
    <tr>
        <td style="vertical-align: middle; width:25%;">{label name='file_content'}</td>
        <td>{input name='file_content' rows=25 cols=100}</td>
    </tr>
    </table>
    <input type="submit" name="save" value="Сохранить файл">
    </form>
{/if}