<?php /* Smarty version 2.6.25, created on 2013-08-22 14:01:15
         compiled from /home/leadert/webserver/twt-consult/www/site/views/calc/step2.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'number_format', '/home/leadert/webserver/twt-consult/www/site/views/calc/step2.tpl', 45, false),)), $this); ?>
<div class="service_cont calc">
<h2 id="alculator_anchor">Страховой калькулятор</h2>
	<div class="calc_outer">
	<div class="calc_bc"><a href="/calc/step1">Шаг 1</a> - <span>Шаг 2</span></div>
	<div class="calc_bc"><span>Выберите страховую компанию, на которую вы хотели бы оформить договор<span style="color: #f00;"> *</span>:</span></div>
	<?php if ($this->_tpl_vars['settings']['calculator_text']): ?><div class="calc_bc"><span><?php echo $this->_tpl_vars['settings']['calculator_text']; ?>
</span></div><?php endif; ?>
<div class="form">
    <?php if ($this->_tpl_vars['errors_calculator']): ?>
        <div> <span class="error"><?php echo $this->_tpl_vars['errors_calculator']; ?>
</span></div>
    <?php endif; ?>
    <form name='calculator_req' id='calculator_req_form' action="/calc/step2" method="post">
	    <input type="hidden" name="step2" value="1">
        <input type="hidden" id="order_number" name="order_number" value="<?php if ($this->_tpl_vars['insurance']['NumberOfPreOrder']): ?><?php echo $this->_tpl_vars['insurance']['NumberOfPreOrder']; ?>
<?php else: ?>0<?php endif; ?>">
        <input type="hidden" id="order_date" name="order_date" value="<?php if ($this->_tpl_vars['insurance']['DateOfPreOrder']): ?><?php echo $this->_tpl_vars['insurance']['DateOfPreOrder']; ?>
<?php else: ?><?php endif; ?>">
        <?php $_from = $this->_tpl_vars['insurance']['variants']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['var']):
?>
            <input type="hidden" id="order_number<?php echo $this->_tpl_vars['var']['number']; ?>
" name="variants[<?php echo $this->_tpl_vars['var']['number']; ?>
][company]" value="<?php echo $this->_tpl_vars['var']['company']; ?>
">
            <input type="hidden" id="order_number<?php echo $this->_tpl_vars['var']['number']; ?>
" name="variants[<?php echo $this->_tpl_vars['var']['number']; ?>
][company_title]" value="<?php echo $this->_tpl_vars['var']['company_title']; ?>
">
            <input type="hidden" id="order_number<?php echo $this->_tpl_vars['var']['number']; ?>
" name="variants[<?php echo $this->_tpl_vars['var']['number']; ?>
][ins_type]" value="<?php echo $this->_tpl_vars['var']['ins_type']; ?>
">
            <input type="hidden" id="order_number<?php echo $this->_tpl_vars['var']['number']; ?>
" name="variants[<?php echo $this->_tpl_vars['var']['number']; ?>
][cost]" value="<?php echo $this->_tpl_vars['var']['cost']; ?>
">
            <input type="hidden" id="order_number<?php echo $this->_tpl_vars['var']['number']; ?>
" name="variants[<?php echo $this->_tpl_vars['var']['number']; ?>
][franchise]" value="<?php echo $this->_tpl_vars['var']['franchise']; ?>
">
            <input type="hidden" id="order_number<?php echo $this->_tpl_vars['var']['number']; ?>
" name="variants[<?php echo $this->_tpl_vars['var']['number']; ?>
][guard]" value="<?php echo $this->_tpl_vars['var']['guard']; ?>
">
            <input type="hidden" id="order_number<?php echo $this->_tpl_vars['var']['number']; ?>
" name="variants[<?php echo $this->_tpl_vars['var']['number']; ?>
][currency]" value="<?php echo $this->_tpl_vars['var']['currency']; ?>
">
            <input type="hidden" id="order_number<?php echo $this->_tpl_vars['var']['number']; ?>
" name="variants[<?php echo $this->_tpl_vars['var']['number']; ?>
][number]" value="<?php echo $this->_tpl_vars['var']['number']; ?>
">
        <?php endforeach; endif; unset($_from); ?>

    <div style="margin-bottom: 15px;">
        <table class="striped">
            <thead>
                <tr>
                    <th></th>
                    <th>Компания</th>
                    <th>Вид страхования</th>
                    <th>Тариф</th>
                    <th>Франшиза</th>
                    <th>Требуется ли охрана?</th>
                </tr>
            </thead>
            <tbody>
                <?php $_from = $this->_tpl_vars['insurance']['variants']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['var']):
?>
                    <?php $this->assign('cur', $this->_tpl_vars['var']['currency']); ?>
                    <tr>
                        <td><input type="radio" id="variant"<?php if ($this->_tpl_vars['var']['selected']): ?> checked="" <?php endif; ?> name="variant" value="<?php echo $this->_tpl_vars['var']['number']; ?>
"></td>
                        <td><?php echo $this->_tpl_vars['var']['company_title']; ?>
</td>
                        <td><?php echo $this->_tpl_vars['var']['ins_type']; ?>
</td>
                        <td width="13%"><?php echo ((is_array($_tmp=$this->_tpl_vars['var']['cost'])) ? $this->_run_mod_handler('number_format', true, $_tmp, '0', '', '') : number_format($_tmp, '0', '', '')); ?>
<?php if ($this->_tpl_vars['var']['currency'] && $this->_tpl_vars['currencies'][$this->_tpl_vars['cur']]): ?> <?php echo $this->_tpl_vars['currencies'][$this->_tpl_vars['cur']]; ?>
<?php endif; ?></td>
                        <td><?php echo ((is_array($_tmp=$this->_tpl_vars['var']['franchise'])) ? $this->_run_mod_handler('number_format', true, $_tmp, '0', '', '') : number_format($_tmp, '0', '', '')); ?>
<?php if ($this->_tpl_vars['var']['currency'] && $this->_tpl_vars['currencies'][$this->_tpl_vars['cur']]): ?> <?php echo $this->_tpl_vars['currencies'][$this->_tpl_vars['cur']]; ?>
<?php endif; ?></td>
                        <td><?php if ($this->_tpl_vars['var']['guard'] == 'true'): ?>Да<?php else: ?>Нет<?php endif; ?></td>
                    </tr>
                <?php endforeach; endif; unset($_from); ?>
            </tbody>
        </table>
    </div>
		<div class="add_buttons" style="margin-top: 15px;">
			<a class="pull-left back_link" href="/calc/step1">Вернуться назад</a>
			<input type="submit" name='calculator_form' class="order_button orange_button checkauth pull-right" value="Продолжить оформление">
		</div>
		<div style="clear: both;"></div><br>
    <span style="color: red;">*</span> поля отмеченные звездочкой - обязательны для заполнения
    </form>
</div>
		</div>
	</div>