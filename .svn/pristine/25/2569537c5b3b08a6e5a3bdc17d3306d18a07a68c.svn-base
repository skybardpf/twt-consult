
{if $msg}
    <p>{$msg}</p>
{else}
    {form name=cabinet}
    <h3 class="blue_title">Смена пароля</h3>
        <table class="lefter">
            {if $error_cabinet}
                {foreach from=$error_cabinet item=err key=key}
                    <tr>
                        <td colspan="2">
                            <span class="error">{$err}</span>
                        </td>
                    </tr>
                {/foreach}
            {/if}
            <tr>
                <th>Новый пароль:</th>
                <td>
                    <input type="password" name="password" value="">
                </td>
            </tr>
            <tr>
                <th>Повторите пароль:</th>
                <td>
                    <input type="password" name="password2" value="">
                </td>
            </tr>
            <tr>
                <td colspan="2" class="with-button">
                    <input type="submit" name="cabinet" value="Изменить">
                </td>
            </tr>
        </table>
    </form>
{/if}