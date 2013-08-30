<?php /* Smarty version 2.6.25, created on 2013-08-22 14:36:44
         compiled from /home/leadert/webserver/twt-consult/www/site/views/cabinet/cabinet_personal.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'form', '/home/leadert/webserver/twt-consult/www/site/views/cabinet/cabinet_personal.tpl', 5, false),)), $this); ?>

<?php if ($this->_tpl_vars['msg']): ?>
    <p><?php echo $this->_tpl_vars['msg']; ?>
</p>
<?php endif; ?>
<?php echo smarty_function_form(array('name' => 'cabinet'), $this);?>

<h3 class="blue_title">Личные данные</h3>
<?php if (! $this->_tpl_vars['logged_site_user']['phone']): ?><div style="font-size: 12px;margin-bottom: 15px;">Для более оперативной связи с Вами добавьте, пожалуйста, контактный телефон</div><?php endif; ?>
    <table class="lefter">
	    <?php if ($this->_tpl_vars['error_cabinet']): ?>
		    <?php $_from = $this->_tpl_vars['error_cabinet']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['err']):
?>
			    <?php if ($this->_tpl_vars['key'] == 'name'): ?>
				    <tr>
					    <td colspan="2">
						    <span class="error"><?php echo $this->_tpl_vars['err']; ?>
</span>
					    </td>
				    </tr>
			    <?php endif; ?>
		    <?php endforeach; endif; unset($_from); ?>
	    <?php endif; ?>
        <tr>
            <th>Контактное лицо<span style="color: #ff0000;"> *</span>:</th>
            <td>
                <span class="text"><?php echo $this->_tpl_vars['logged_site_user']['name']; ?>
</span>
	            <a class="except toshow for_name" href="#">изменить</a>
                <span class="input for_name hidden">
                    <input type="text" name="name" value="<?php echo $this->_tpl_vars['logged_site_user']['name']; ?>
">
                </span>
            </td>
        </tr>
	    <?php if ($this->_tpl_vars['error_cabinet']): ?>
		    <?php $_from = $this->_tpl_vars['error_cabinet']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['err']):
?>
			    <?php if ($this->_tpl_vars['key'] == 'phone'): ?>
			    <tr>
				    <td colspan="2">
					    <span class="error"><?php echo $this->_tpl_vars['err']; ?>
</span>
				    </td>
			    </tr>
			    <?php endif; ?>
		    <?php endforeach; endif; unset($_from); ?>
	    <?php endif; ?>
	    <tr>
            <th>Контактный телефон<span style="color: #ff0000;"> *</span>:</th>
            <td>
	            <?php if ($this->_tpl_vars['logged_site_user']['phone']): ?>
		            <span class="text"><?php echo $this->_tpl_vars['logged_site_user']['phone']; ?>
</span>
		            <a class="except toshow for_phone" href="#">изменить</a>
	            <?php endif; ?>
		            <span class="input for_phone<?php if ($this->_tpl_vars['logged_site_user']['phone']): ?> hidden<?php endif; ?>">
                        <input type="text" name="phone" value="<?php echo $this->_tpl_vars['logged_site_user']['phone']; ?>
">
                    </span>
            </td>
        </tr>
	    <?php if ($this->_tpl_vars['error_cabinet']): ?>
		    <?php $_from = $this->_tpl_vars['error_cabinet']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['err']):
?>
			    <?php if ($this->_tpl_vars['key'] == 'email'): ?>
				    <tr>
					    <td colspan="2">
						    <span class="error"><?php echo $this->_tpl_vars['err']; ?>
</span>
					    </td>
				    </tr>
			    <?php endif; ?>
		    <?php endforeach; endif; unset($_from); ?>
	    <?php endif; ?>
        <tr>
            <th>E-mail(логин):</th>
            <td>
                <span class="text"><?php echo $this->_tpl_vars['logged_site_user']['email']; ?>
</span>
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