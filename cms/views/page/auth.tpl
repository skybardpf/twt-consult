<tr>
<td style="padding:10px 50px;">
		<div style="width: 100%; overflow: hidden; height: 40px;">
			<h2 class="header-top" style="float: left;">
				{$appTitle}
			</h2>
			<h2 class="header-top" style="float: right;">
			{if !isset($copyrights.link)}
				<a href="http://www.artektiv.ru" style="color: black; text-decoration: none;">&copy; Artektiv</a>
			{elseif $copyrights.link}
                {$copyrights.link}
			{/if}
			</h2>
		</div>
    <table style="width:100%">
            {if $error}
        <tr>
            <td>
                {loadview name="page/error"}
            </td>
        </tr>
            {/if}
        <tr>
            <td>
                <div class="login" style="width:300px;margin:auto;">
                    <h4>Авторизация</h4>
                    {form name='auth'}
                        <div class="rc10">
                        <h2 style="margin-top: 0px;">Вход:</h2>
                        {label name='login'}
                        {input name='login'}<br />
                        {label name='pass'}
                        {input name='pass'}<br />
                        <!--<div class="submit">
                            <input type="image" src="/public/cms/img/enter.gif" alt="Войти" class="submit"/>
                        </div>-->
                        <button type="submit" >Войти</button>
                        </div>
                    </form>
                </div>
            </td>
        </tr>
    </table>
</td>
</tr>