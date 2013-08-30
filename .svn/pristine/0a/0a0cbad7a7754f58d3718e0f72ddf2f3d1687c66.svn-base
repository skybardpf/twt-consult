<h3 class="blue_title">Добавление компании</h3>
{form name=modify}
<table  class="lefter">
    {foreach from=$forms_elements.modify key=k item=f}
        {if $CErrors[$k]}
            <tr>
                <td colspan="2">
                    <span class="error">{$CErrors[$k]}</span>
                </td>
            </tr>
        {/if}
        <tr>
            <td>{label name=$k}{if $f.req}<span style="color: #ff0000;"> *</span>{/if}</td>
            <td>{input name=$k}<span class="error_text"></span></td>
        </tr>
    {/foreach}
    <tr>
        <td colspan="2" class="with-button">
            <input type="submit" value="{if $c_id}Редактировать{else}Добавить{/if}">
        </td>
    </tr>
</table>
</form>
<a style="float: right;margin-right: 120px;" href="/cabinet/companies">Мои компании</a>