<div class="popup-auth-reg">
    <div class="data">

	    <div class="remind_password">
		    <h3>Восстановление пароля</h3>
		    <table id="remind_table">
			    <tr>
				    <td>
					    <label for="email_remind">E-mail:</label>
				    </td>
			    </tr>
			    <tr>
				    <td>
					    <input id="email_remind" type="text" value="" name="registration[email]">
				    </td>
			    </tr>
			    <tr class="centered">
				    <td>
					    <input style="margin-top: 20px;" type="submit" class="big_butt" id="remind" name="remind" value="Восстановить">
				    </td>
			    </tr>
		    </table>
		    <table>
			    <tr><td id="remind_msg" style="color:black !important"></td></tr>
		    </table>
	    </div>

		<div class="withtabs">
			<ul>
				<li><a href="#tabs-auth" style="padding-left: 0;padding-right: 0;width: 100%;text-align: center;">Авторизация</a></li>
				<li><a href="#tabs-reg">Регистрация</a></li>
			</ul>
			<div class="authorization" id="tabs-auth">
				{form name=authorize}
					{if $form_auth_errors}
						<script type="text/javascript">
							window.auth_errors = true;
							window.reg_errors = false;
						</script>
						{foreach from=$form_auth_errors item=err}
							<div class="error small"> {$err}</div>
						{/foreach}
					{/if}
					<table>
						<tr>
							<td>
								<label for="email_auth">Логин(E-mail):</label>
							</td>
						</tr>
						<tr>
							<td>
								<input id="email_auth" type="text" value="{$smarty.post.auth.email}" name="auth[email]">
							</td>
						</tr>
						<tr>
							<td>
								<label for="pass_auth">Пароль:</label>
							</td>
						</tr>
						<tr>
							<td>
								<input id="pass_auth" type="password" name="auth[password]">
								<input type="hidden" value="1" name="auth[auth]">
							</td>
						</tr>
						<tr class="centered">
							<td>
								<a href="#" class="forgot_password">забыли пароль?</a>
							</td>
						</tr>
						<tr class="centered">
							<td>
								<input type="submit" name="auth" class="big_butt" id="auth" value="Войти">
							</td>
						</tr>
					</table>
				</form>
			</div>


			<div class="registration" id="tabs-reg">
				{form name=registration}
					{if $form_reg_errors}
						<script type="text/javascript">
							window.reg_errors = true;
							window.auth_errors = false;
						</script>
						{foreach from=$form_reg_errors item=err}
							<div class="error small">{$err}</div>
						{/foreach}
					{/if}
					<table>
						<tr>
							<td>
								<label for="email_reg">E-mail:</label>
							</td>
						</tr>
						<tr>
							<td>
								<input id="email_reg" type="text" value="{$smarty.post.registration.email}" name="registration[email]">
								<input type="hidden" value="1" name="registration[registr]">
							</td>
						</tr>
						<tr>
							<td>
								<label for="fio_reg">Имя, Фамилия:</label>
							</td>
						</tr>
						<tr>
							<td>
								<input id="fio_reg" type="text" value="{$smarty.post.registration.name}" name="registration[name]">
							</td>
						</tr>
						<tr class="centered">
							<td>
								<input onclick="yaCounter19010836.reachGoal('registr'); return true;" style="margin-top: 20px;" type="submit" class="big_butt" id="registr" name="registr" value="Зарегистрироваться">
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
    </div>
	<span class="close_popup"></span>
</div>