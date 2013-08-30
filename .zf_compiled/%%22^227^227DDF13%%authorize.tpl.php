<?php /* Smarty version 2.6.25, created on 2013-08-22 13:47:36
         compiled from /home/leadert/webserver/twt-consult/www/site/views/authorize.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'form', '/home/leadert/webserver/twt-consult/www/site/views/authorize.tpl', 34, false),)), $this); ?>
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
				<?php echo smarty_function_form(array('name' => 'authorize'), $this);?>

					<?php if ($this->_tpl_vars['form_auth_errors']): ?>
						<script type="text/javascript">
							window.auth_errors = true;
							window.reg_errors = false;
						</script>
						<?php $_from = $this->_tpl_vars['form_auth_errors']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['err']):
?>
							<div class="error small"> <?php echo $this->_tpl_vars['err']; ?>
</div>
						<?php endforeach; endif; unset($_from); ?>
					<?php endif; ?>
					<table>
						<tr>
							<td>
								<label for="email_auth">Логин(E-mail):</label>
							</td>
						</tr>
						<tr>
							<td>
								<input id="email_auth" type="text" value="<?php echo $this->_supers['post']['auth']['email']; ?>
" name="auth[email]">
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
				<?php echo smarty_function_form(array('name' => 'registration'), $this);?>

					<?php if ($this->_tpl_vars['form_reg_errors']): ?>
						<script type="text/javascript">
							window.reg_errors = true;
							window.auth_errors = false;
						</script>
						<?php $_from = $this->_tpl_vars['form_reg_errors']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['err']):
?>
							<div class="error small"><?php echo $this->_tpl_vars['err']; ?>
</div>
						<?php endforeach; endif; unset($_from); ?>
					<?php endif; ?>
					<table>
						<tr>
							<td>
								<label for="email_reg">E-mail:</label>
							</td>
						</tr>
						<tr>
							<td>
								<input id="email_reg" type="text" value="<?php echo $this->_supers['post']['registration']['email']; ?>
" name="registration[email]">
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
								<input id="fio_reg" type="text" value="<?php echo $this->_supers['post']['registration']['name']; ?>
" name="registration[name]">
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