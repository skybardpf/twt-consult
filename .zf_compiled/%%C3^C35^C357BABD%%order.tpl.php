<?php /* Smarty version 2.6.25, created on 2013-08-30 11:22:46
         compiled from /home/leadert/webserver/twt-consult/www/site/views/calc/order.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'loadview', '/home/leadert/webserver/twt-consult/www/site/views/calc/order.tpl', 115, false),array('function', 'math', '/home/leadert/webserver/twt-consult/www/site/views/calc/order.tpl', 153, false),)), $this); ?>
<?php echo '
    <script type="text/javascript">
        window.order_cities_link = "/calc/cities";
    </script>
'; ?>

<div class="service_cont calc_order">
<?php if ($this->_tpl_vars['success']): ?>
    <h2 id="alculator_anchor">Страховой калькулятор</h2>
	<div class="calc_outer">
    <?php if ($this->_tpl_vars['settings']['calculator_text']): ?><div><?php echo $this->_tpl_vars['settings']['calculator_text']; ?>
</div><?php endif; ?>
    <div class="form">
        <p>Ваша заявка №<?php echo $this->_tpl_vars['order_id']; ?>
 успешно оформлена!</p>
    </div>
	</div>
<?php else: ?>
    <h2 id="alculator_anchor">Страховой калькулятор</h2>
	<div class="calc_outer">
	<div class="calc_bc"><a href="/calc/step1">Шаг 1</a> - <a href="/calc/step2">Шаг 2</a> - <span>Шаг 3</span></div>
	<?php if ($this->_tpl_vars['settings']['calculator_text']): ?><div class="calc_bc"><span><?php echo $this->_tpl_vars['settings']['calculator_text']; ?>
</span></div><?php endif; ?>
    <div class="form">
        <?php if ($this->_tpl_vars['errors_calculator']): ?>
            <div> <span class="error"><?php echo $this->_tpl_vars['errors_calculator']; ?>
</span></div>
        <?php endif; ?>
        <form name='calculator_req' id='calculator_req_form' action="/calc/step3" method="post">
	        <input type="hidden" name="step3" value="1">
            <input type="hidden" id="order_number" name="order[NumberOfPreOrder]" value="<?php if ($this->_tpl_vars['order']['NumberOfPreOrder']): ?><?php echo $this->_tpl_vars['order']['NumberOfPreOrder']; ?>
<?php else: ?>0<?php endif; ?>">
            <input type="hidden" id="order_date" name="order[DateOfPreOrder]" value="<?php if ($this->_tpl_vars['order']['DateOfPreOrder']): ?><?php echo $this->_tpl_vars['order']['DateOfPreOrder']; ?>
<?php else: ?><?php endif; ?>">

            <table width="580">
                <tr>
                    <td width="200px"><label for="order_CompanyName">Наименование компании</label></td>
                    <td><input type="text" class="validate[required]" id="order_CompanyName" name="order[CompanyName]" value="<?php if ($this->_tpl_vars['order']['CompanyName']): ?><?php echo $this->_tpl_vars['order']['CompanyName']; ?>
<?php else: ?><?php endif; ?>"></td>
                </tr>
                <tr>
                    <td width="200px"><label for="order_Beneficiary">Выгодоприобретатель</label></td>
                    <td><input type="text" class="validate[required]" id="order_Beneficiary" name="order[Beneficiary]" value="<?php if ($this->_tpl_vars['order']['Beneficiary']): ?><?php echo $this->_tpl_vars['order']['Beneficiary']; ?>
<?php else: ?><?php endif; ?>"></td>
                </tr>
                <tr>
                    <td width="200px"><label for="order_NumberOfSeat">Груз (товары через запятую)</label></td>
                    <td><textarea class="validate[required]" id="order_NumberOfSeat" name="order[NumberOfSeat]"><?php if ($this->_tpl_vars['order']['NumberOfSeat']): ?><?php echo $this->_tpl_vars['order']['NumberOfSeat']; ?>
<?php else: ?><?php endif; ?></textarea></td>
                </tr>
                <tr>
                    <td width="200px"><label for="order_Consignment">Количество мест</label></td>
                    <td><input type="text" class="validate[required]" id="order_Consignment" name="order[Consignment]" value="<?php if ($this->_tpl_vars['order']['Consignment']): ?><?php echo $this->_tpl_vars['order']['Consignment']; ?>
<?php else: ?><?php endif; ?>"></td>
                <tr>
                    <td width="200px"><label for="order_NumberOfSeatMeasure">Единица измерения мест</label></td>
                    <td>
                        <select id="order_NumberOfSeatMeasure" name="order[NumberOfSeatMeasure]">
                            <option value="">Не выбрано</option>
                            <?php $_from = $this->_tpl_vars['NumberOfSeatMeasure']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
                                <option value="<?php echo $this->_tpl_vars['k']; ?>
"<?php if ($this->_tpl_vars['order']['NumberOfSeatMeasure'] == $this->_tpl_vars['k']): ?> selected<?php else: ?><?php endif; ?>><?php echo $this->_tpl_vars['v']; ?>
</option>
                            <?php endforeach; endif; unset($_from); ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td width="200px"><label for="order_Weight">Общий вес</label></td>
                    <td><input type="text" class="validate[required] integer" id="order_Weight" name="order[Weight]" value="<?php if ($this->_tpl_vars['order']['Weight']): ?><?php echo $this->_tpl_vars['order']['Weight']; ?>
<?php else: ?><?php endif; ?>"></td>
                </tr>
                <tr>
                    <td width="200px"><label for="order_Documents">Список документов</label></td>
                    <td><textarea class="validate[required]" id="order_Documents" name="order[Documents]"><?php if ($this->_tpl_vars['order']['Documents']): ?><?php echo $this->_tpl_vars['order']['Documents']; ?>
<?php else: ?><?php endif; ?></textarea></td>
                </tr>
                <tr>
                    <td width="200px"><label for="order_StartDate">Начало страхования<span style="color: #FF0000;"> *</span></label></td>
                    <td>
                        <input type="text" name="order[StartDate]" value="<?php if ($this->_tpl_vars['order']['StartDate']): ?><?php echo $this->_tpl_vars['order']['StartDate']; ?>
<?php else: ?><?php endif; ?>"/>
                        <?php echo '
                            <script type="text/javascript">
                                $(document).ready(function(){
                                    $(\'input[name="order[StartDate]"]\').dynDateTime({
                                        singleClick: true,
                                        align: \'T\',
                                        ifFormat: \'%Y-%m-%d\',
                                        daFormat: \'%Y-%m-%d\'
                                    });
                                });
                            </script>
                        '; ?>

                    </td>
                </tr>
                <tr>
                    <td width="200px"><label for="order_EndDate">Конец страхования<span style="color: #FF0000;"> *</span></label></td>
                    <td>
                        <input type="text" name="order[EndDate]" value="<?php if ($this->_tpl_vars['order']['EndDate']): ?><?php echo $this->_tpl_vars['order']['EndDate']; ?>
<?php else: ?><?php endif; ?>"/>
                        <?php echo '
                            <script type="text/javascript">
                                $(document).ready(function(){
                                    $(\'input[name="order[EndDate]"]\').dynDateTime({
                                        singleClick: true,
                                        align: \'T\',
                                        ifFormat: \'%Y-%m-%d\',
                                        daFormat: \'%Y-%m-%d\'
                                    });
                                });
                            </script>
                        '; ?>

                    </td>
                </tr>
            </table>
            <br/>
            <table id="route_points_table" width="580">
                <thead>
                <tr>
                    <th>Маршрут</th>
                    <th style="padding-left: 110px; font-size: 12px;">
                        <span>
							<a id="route_point_add_button" href="javascript:void(0);">Добавить промежуточную точку маршрута</a>
                        </span>
                    </th>
                </tr>
                </thead>
                <tr style="display: none;" id="route_point" data-route_middle="1">
                    <td class="small_font"><span>Промежут. точка маршрута</span></td>
                    <td><?php echo smarty_function_loadview(array('name' => "calc/route_point",'field' => 'middle','iteration' => '__iteration__'), $this);?>
</td>
                </tr>
                <tr id="route_first_point">
                    <td class="small_font" style="width: 101px;"><span>Начальная точка маршрута<span style="color: #FF0000;"> *</span></span></td>
                    <td>
                        <?php if ($this->_tpl_vars['order']['route']['begin']): ?>
                            <?php $this->assign('point', $this->_tpl_vars['order']['route']['begin']); ?>
                        <?php else: ?>
                            <?php $this->assign('point', null); ?>
                        <?php endif; ?>
                        <?php echo smarty_function_loadview(array('name' => "calc/route_point",'field' => 'begin','iteration' => false,'point' => $this->_tpl_vars['point'],'cities' => $this->_tpl_vars['begin_cities']), $this);?>

                    </td>
                </tr>
                <?php if ($this->_tpl_vars['order']['route']['middle']): ?>
                    <?php $_from = $this->_tpl_vars['order']['route']['middle']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['iter'] => $this->_tpl_vars['point']):
?>
                        <tr data-route_middle="1">
                            <td class="small_font"><span>Промежуточная точка маршрута</span></td>
                            <td><?php echo smarty_function_loadview(array('name' => "calc/route_point",'field' => 'middle','iteration' => $this->_tpl_vars['iter'],'point' => $this->_tpl_vars['point'],'cities' => $this->_tpl_vars['point']['cities']), $this);?>
</td>
                        </tr>
                    <?php endforeach; endif; unset($_from); ?>
                <?php endif; ?>

                <tr id="route_last_point">
                    <td class="small_font"><span>Конечная точка маршрута<span style="color: #FF0000;"> *</span></span></td>
                    <td>
                        <?php if ($this->_tpl_vars['order']['route']['end']): ?>
                            <?php $this->assign('point', $this->_tpl_vars['order']['route']['end']); ?>
                        <?php else: ?>
                            <?php $this->assign('point', null); ?>
                        <?php endif; ?>
                        <?php echo smarty_function_loadview(array('name' => "calc/route_point",'field' => 'end','iteration' => false,'point' => $this->_tpl_vars['point'],'cities' => $this->_tpl_vars['end_cities']), $this);?>

                    </td>
                </tr>
            </table>
            <table width="580">
                <tr>
                    <td width="200px">
						<br><label for="order_CompanyName">Введите текст с картинки</label><br>
						<?php echo smarty_function_math(array('equation' => 'rand()','assign' => 'rand'), $this);?>

						<img style='cursor: pointer;' src="/captcha/?<?php echo $this->_tpl_vars['rand']; ?>
"/>
					</td>
                    <td>
                        <div style='position:relative;'>
                            <img style='display:none; position:absolute; top:0; left:0;' src='/public/zf/img/loading.gif' alt=''/>
                        </div><br />
                        <input type="text" name="order[verifyCode]" value=""/>
                    </td>
                </tr>
            </table>
			<div class="add_buttons">
				<a class="pull-left back_link" href="/calc/step2">Вернуться назад</a>
				<input type="submit" name='calculator_form' class="order_button orange_button checkauth pull-right" value="Оформить заявку">
			</div>
			<div style="clear: both;"></div><br>
            <span style="color: red;">*</span> поля отмеченные звездочкой - обязательны для заполнения
        </form>
    </div>
	</div>
<?php endif; ?>
</div>