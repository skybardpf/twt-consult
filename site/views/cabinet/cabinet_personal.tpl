
{if $msg}
    <p>{$msg}</p>
{/if}
{form name=cabinet}
<h3 class="blue_title">Личные данные</h3>
{if !$logged_site_user.phone}<div style="font-size: 12px;margin-bottom: 15px;">Для более оперативной связи с Вами добавьте, пожалуйста, контактный телефон</div>{/if}
    <table class="lefter">
	    {if $error_cabinet}
		    {foreach from=$error_cabinet item=err key=key}
			    {if $key == 'name'}
				    <tr>
					    <td colspan="2">
						    <span class="error">{$err}</span>
					    </td>
				    </tr>
			    {/if}
		    {/foreach}
	    {/if}
        <tr>
            <th>Контактное лицо<span style="color: #ff0000;"> *</span>:</th>
            <td>
                <span class="text">{$logged_site_user.name}</span>
	            <a class="except toshow for_name" href="#">изменить</a>
                <span class="input for_name hidden">
                    <input type="text" name="name" value="{$logged_site_user.name}">
                </span>
            </td>
        </tr>
	    {if $error_cabinet}
		    {foreach from=$error_cabinet item=err key=key}
			    {if $key == 'phone'}
			    <tr>
				    <td colspan="2">
					    <span class="error">{$err}</span>
				    </td>
			    </tr>
			    {/if}
		    {/foreach}
	    {/if}
	    <tr>
            <th>Контактный телефон<span style="color: #ff0000;"> *</span>:</th>
            <td>
	            {if $logged_site_user.phone}
		            <span class="text">{$logged_site_user.phone}</span>
		            <a class="except toshow for_phone" href="#">изменить</a>
	            {/if}
		            <span class="input for_phone{if $logged_site_user.phone} hidden{/if}">
                        <input type="text" name="phone" value="{$logged_site_user.phone}">
                    </span>
            </td>
        </tr>
	    {if $error_cabinet}
		    {foreach from=$error_cabinet item=err key=key}
			    {if $key == 'email'}
				    <tr>
					    <td colspan="2">
						    <span class="error">{$err}</span>
					    </td>
				    </tr>
			    {/if}
		    {/foreach}
	    {/if}
        <tr>
            <th>E-mail(логин):</th>
            <td>
                <span class="text">{$logged_site_user.email}</span>
                {*<span class="input">
                    <input type="text" value="test@artektiv.ru">
                </span>*}
            </td>
        </tr>
        <tr>
            <th><a href="/cabinet/change_pass">Изменить пароль</a></th>
            <td></td>
        </tr>
        <tr>
            <td colspan="2" class="with-button">
                <input type="submit" name="cabinet" value="Сохранить">
            </td>
        </tr>
    </table>
</form>