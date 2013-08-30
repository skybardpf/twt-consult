<?php /* Smarty version 2.6.25, created on 2013-08-22 13:47:28
         compiled from /home/leadert/webserver/twt-consult/www/site/views/calc/calc.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'form', '/home/leadert/webserver/twt-consult/www/site/views/calc/calc.tpl', 11, false),array('function', 'input', '/home/leadert/webserver/twt-consult/www/site/views/calc/calc.tpl', 21, false),array('function', 'closeformgroup', '/home/leadert/webserver/twt-consult/www/site/views/calc/calc.tpl', 97, false),)), $this); ?>
<div class="service_cont calc">
	<?php if ($this->_tpl_vars['forms_elements']['calculator_req']): ?>
	    <h2 id="alculator_anchor">Страховой калькулятор</h2>
		<div class="calc_outer">
		<div class="calc_bc"><span>Шаг 1</span></div>
	    <?php if ($this->_tpl_vars['settings']['calculator_text']): ?><div class="calc_bc"><span><?php echo $this->_tpl_vars['settings']['calculator_text']; ?>
</span></div><?php endif; ?>
	    <div class="form">
	        <?php if ($this->_tpl_vars['errors_calculator']): ?>
	            <div> <span class="error"><?php echo $this->_tpl_vars['errors_calculator']; ?>
</span></div>
	        <?php endif; ?>
	    <?php echo smarty_function_form(array('name' => 'calculator_req','id' => 'calculator_req_form'), $this);?>

		    <input type="hidden" name="step1" value="1">
	        <div class="label celled">Способ выбора товаров<span style="color: #f00;"> *</span>:</div>
	        <div class="inputs celled_r">
	            <input type="radio" value="yes" class="zf_radio" data-tnved_selection="1"<?php if (! $this->_supers['post'] || $this->_supers['post']['tnved'] == 'yes'): ?> checked=""<?php endif; ?> name="tnved" id="calculator_req_tnved_1"><label for="calculator_req_tnved_1"> &mdash; По кодам ТНВЭД</label><br>
	            <input type="radio" value="no" data-tnved_selection="1" class="zf_radio"<?php if ($this->_supers['post']['tnved'] == 'no'): ?> checked=""<?php endif; ?> name="tnved" id="calculator_req_tnved_2"><label for="calculator_req_tnved_2"> &mdash; По кодам категорий</label>
	        </div>

	        <div class="label celled" style="margin-top: 10px;">Валюта<span style="color: #f00;"> *</span>:</div>
	        <div class="inputs celled_r">
	            <?php echo smarty_function_input(array('name' => 'currency'), $this);?>

	        </div>

	        <div style="clear: both;"></div>
	        <div class="inputs">
	            <table style="width: 100%;">
	                <thead>
	                <tr>
	                    <th>Код ТНВЭД/Код категории</th>
	                    <th>&nbsp;&nbsp;Стоимость</th>
	                </tr>
	                </thead>
	                <tbody>
	                <tr style="display: none;" id="calc_clone_row" data-new_row="1" data-one_row="1">
	                    <td style="width: 435px;max-width: 435px;">
	                        <input
	                                type="hidden"
	                                name="data[new][code]"
	                                data-placeholder="Код ТНВЭД или наименование категории"
	                                data-tnved="1"
	                                data-init_on_clone="1"
	                                data-minimum_input_length="4"
	                                data-allow_clear="1"
	                                data-ajax="1"
	                                data-ajax_url="/calc/tnved">
	                    </td>
	                    <td class="span3">
							&nbsp;&nbsp;<input type="text" name="data[new][summ]" placeholder="Стоимость" class="integer">&nbsp;&nbsp;<span data-type="currency"><?php echo $this->_tpl_vars['cur_currency_title']; ?>
</span>
						</td>
	                </tr>
	                <?php if ($this->_tpl_vars['values']): ?><?php $this->assign('i', 0); ?>
	                    <?php $_from = $this->_tpl_vars['values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
	                        <tr data-one_row="1" data-new_row="0">
	                            <td style="width: 435px;max-width: 435px;">
	                                <input
	                                        type="hidden"
	                                        name="data[old_<?php echo $this->_tpl_vars['i']; ?>
][code]"
	                                        data-placeholder="Код ТНВЭД или наименование категории"
	                                        data-tnved="1"
	                                        data-minimum_input_length="4"
	                                        data-allow_clear="1"
	                                        data-ajax="1"
	                                        data-ajax_url="/calc/tnved"
	                                        value="<?php echo $this->_tpl_vars['val']['code']; ?>
">
	                            </td>
	                            <td>
									&nbsp;&nbsp;<input type="text" name="data[old_<?php echo $this->_tpl_vars['i']; ?>
][summ]" value="<?php echo $this->_tpl_vars['val']['summ']; ?>
" placeholder="Стоимость" class="integer">&nbsp;&nbsp;<span data-type="currency"><?php echo $this->_tpl_vars['cur_currency_title']; ?>
</span>
								</td>
	                        </tr>
	                        <?php $this->assign('i', $this->_tpl_vars['i']+1); ?>
	                    <?php endforeach; endif; unset($_from); ?>
	                <?php endif; ?>
	                <tr data-one_row="1" data-new_row="1">
	                    <td style="width: 435px;max-width: 435px;">
	                        <input
	                                type="hidden"
	                                name="data[0][code]"
	                                data-placeholder="Код ТНВЭД или наименование категории"
	                                data-tnved="1"
	                                data-minimum_input_length="4"
	                                data-allow_clear="1"
	                                data-ajax="1"
	                                data-ajax_url="/calc/tnved">
	                    </td>
	                    <td class="span3">
							&nbsp;&nbsp;<input type="text" name="data[0][summ]" placeholder="Стоимость" class="integer">&nbsp;&nbsp;<span data-type="currency"><?php echo $this->_tpl_vars['cur_currency_title']; ?>
</span>
						</td>
	                </tr>
	                </tbody>
	            </table>
	        </div>
			<div class="add_buttons">
				<input type="submit" name='calculator_form' class="order_button orange_button checkauth pull-right" value="Продолжить оформление">
			</div>
			<div style="clear: both;"></div><br>
	        <span style="color: red;">*</span> поля отмеченные звездочкой - обязательны для заполнения
	    <?php echo smarty_function_closeformgroup(array(), $this);?>

	    </form>
	    </div>
	</div>
	<?php else: ?>
	    <p>Форма отсутствует</p>
	<?php endif; ?>

</div>