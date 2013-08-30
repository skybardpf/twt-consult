<?php /* Smarty version 2.6.25, created on 2013-08-22 13:47:29
         compiled from /home/leadert/webserver/twt-consult/www/site/views/form_urid.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'form', '/home/leadert/webserver/twt-consult/www/site/views/form_urid.tpl', 19, false),array('function', 'label', '/home/leadert/webserver/twt-consult/www/site/views/form_urid.tpl', 26, false),array('function', 'input', '/home/leadert/webserver/twt-consult/www/site/views/form_urid.tpl', 71, false),array('function', 'closeformgroup', '/home/leadert/webserver/twt-consult/www/site/views/form_urid.tpl', 288, false),array('modifier', 'cat', '/home/leadert/webserver/twt-consult/www/site/views/form_urid.tpl', 215, false),)), $this); ?>
<div class="form_container">
<?php if ($this->_tpl_vars['success_entity']): ?>
    <h2 id="entity_anchor">Благодарим Вас за заявку. Наш специалист свяжется с Вами в ближайшее время. Номер вашей заявки: <?php echo $this->_tpl_vars['order1C_id']; ?>
</h2>
<?php elseif ($this->_tpl_vars['repeated_entity']): ?>
    <h2 id="entity_anchor">Ваша заявка уже добавлена.</h2>
    <a href="javascript:void(0)" id="show_form">Отредактировать заявку</a>
<?php elseif ($this->_tpl_vars['error_urid']): ?>
    <h2 id="entity_anchor">Заявка не добавлена. Попробуйте, пожалуйста, позже.</h2>
    <a href="javascript:void(0)" id="show_form">Отредактировать заявку</a>
<?php endif; ?>
<?php if (( ! $this->_tpl_vars['repeated_entity'] && ! $this->_tpl_vars['error_urid'] && ! $this->_tpl_vars['success_entity'] ) || ( $this->_tpl_vars['repeated_entity'] || $this->_tpl_vars['error_urid'] && ! $this->_tpl_vars['success_entity'] )): ?>
    <?php if ($this->_tpl_vars['repeated_entity'] || $this->_tpl_vars['error_urid']): ?>
        <div style="display:none" id="formshow">
    <?php endif; ?>
    <?php if ($this->_tpl_vars['forms_elements']['entity_req']): ?>
        <h2 id="entity_anchor">Заявка на регистрацию компании</h2>
        <?php if ($this->_tpl_vars['settings']['entity_text']): ?><div><?php echo $this->_tpl_vars['settings']['entity_text']; ?>
</div><?php endif; ?>
        <div class="form">
            <?php echo smarty_function_form(array('name' => 'entity_req','id' => 'entity_req_form'), $this);?>

                <?php if ($this->_tpl_vars['step'] > 0): ?><input type="hidden" name="step" id="step" value="<?php echo $this->_tpl_vars['step']; ?>
" /><?php endif; ?>
            <?php if ($this->_tpl_vars['step'] == 2): ?>
            <table>
                <?php $_from = $this->_tpl_vars['forms_elements']['entity_req']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['entity_req_elem']):
?>
                    <?php if ($this->_tpl_vars['entity_req_elem']['name'] != 'contact' && $this->_tpl_vars['entity_req_elem']['name'] != 'mail' && $this->_tpl_vars['entity_req_elem']['name'] != 'captcha' && ( $this->_tpl_vars['entity_req_elem']['name'] != 'own_kind_activities' || $this->_supers['post']['own_kind_activities'] )): ?>
                        <tr>
                            <td width="200px"><?php echo smarty_function_label(array('name' => $this->_tpl_vars['entity_req_elem']['name']), $this);?>
<?php if ($this->_tpl_vars['entity_req_elem']['req']): ?><span style="color: red;">*</span><?php endif; ?>: </td>
                            <td>
                                <?php if (is_array ( $this->_tpl_vars['entity_req_elem']['value'] )): ?>
                                    <?php if ($this->_tpl_vars['entity_req_elem']['name'] == 'country_source' || $this->_tpl_vars['entity_req_elem']['name'] == 'country_receiver'): ?>
                                        <?php $_from = $this->_tpl_vars['entity_req_elem']['values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val_elem']):
?>
                                            <?php $_from = $this->_tpl_vars['entity_req_elem']['value']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
                                                <?php if ($this->_tpl_vars['key'] == $this->_tpl_vars['val']): ?><?php echo $this->_tpl_vars['val_elem']; ?>
<br /><?php endif; ?>
                                            <?php endforeach; endif; unset($_from); ?>
                                        <?php endforeach; endif; unset($_from); ?>
                                    <?php else: ?>
                                    <?php $_from = $this->_tpl_vars['entity_req_elem']['value']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val_elem']):
?>
                                        <?php echo $this->_tpl_vars['val_elem']; ?>
<br>
                                    <?php endforeach; endif; unset($_from); ?>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <?php if ($this->_tpl_vars['entity_req_elem']['name'] == 'currency_id' || $this->_tpl_vars['entity_req_elem']['name'] == 'jur_country_id'): ?>
                                        <?php $_from = $this->_tpl_vars['entity_req_elem']['values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val_elem']):
?>
                                            <?php if ($this->_tpl_vars['key'] == $this->_tpl_vars['entity_req_elem']['value']): ?><?php echo $this->_tpl_vars['val_elem']; ?>
<?php endif; ?>
                                        <?php endforeach; endif; unset($_from); ?>
                                    <?php else: ?>
                                        <?php echo $this->_tpl_vars['entity_req_elem']['value']; ?>

                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?>
                <tr>
                    <td width="200px"></td>
                    <td style="padding-top: 20px;">
                        <div class="add_buttons">
                            <input type="submit" name='entity_form' class="order_button orange_button checkauth" value="Отредактировать заявку" onclick="$('#step').val('0');" style="height: 32px;">
                        </div>
                    </td>
                </tr>
                <?php $_from = $this->_tpl_vars['forms_elements']['entity_req']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['entity_req_elem']):
?>
                    <?php if ($this->_tpl_vars['entity_req_elem']['name'] == 'contact' || $this->_tpl_vars['entity_req_elem']['name'] == 'mail'): ?>
                        <tr style="height:40px;">
                            <td width="200px"><?php echo smarty_function_label(array('name' => $this->_tpl_vars['entity_req_elem']['name']), $this);?>
<?php if ($this->_tpl_vars['entity_req_elem']['req']): ?><span style="color: red;">*</span><?php endif; ?>: </td>
                            <td>
                                <?php $_from = $this->_tpl_vars['errors_entity']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['error']):
?>
                                    <?php if ($this->_tpl_vars['entity_req_elem']['name'] == $this->_tpl_vars['key']): ?>
                                        <span class="error"><?php echo $this->_tpl_vars['error']; ?>
</span><br>
                                    <?php endif; ?>
                                <?php endforeach; endif; unset($_from); ?>
                                <?php echo smarty_function_input(array('name' => $this->_tpl_vars['entity_req_elem']['name'],'class' => $this->_tpl_vars['entity_req_elem']['name'],'style' => "display:none;",'onblur' => "$(this).hide();$('.static".($this->_tpl_vars['entity_req_elem']['name'])."').show();$('.static".($this->_tpl_vars['entity_req_elem']['name'])."').find('.label').html($(this).val());"), $this);?>

                                <span class="static<?php echo $this->_tpl_vars['entity_req_elem']['name']; ?>
">
                                    <div style="float:right"><a href="#" onclick="$('.<?php echo $this->_tpl_vars['entity_req_elem']['name']; ?>
').show();$('.static<?php echo $this->_tpl_vars['entity_req_elem']['name']; ?>
').hide();return false;">изменить</a></div>
                                    <span class="label"><?php echo $this->_tpl_vars['entity_req_elem']['value']; ?>
</span>
                                </span>
                            </td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?>
                <tr>
                    <td width="200px"></td>
                    <td style="padding-top: 20px;">
                        <div class="add_buttons">
                            <input onclick="yaCounter19010836.reachGoal('entity_form'); return true;" type="submit" name='entity_form' class="order_button orange_button checkauth" value="отправить заявку">
                        </div>
                    </td>
                </tr>
            </table>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['step'] == 2): ?><div style="display:none"><?php endif; ?>
            <table>
                <?php $_from = $this->_tpl_vars['forms_elements']['entity_req']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['entity_req_elem']):
?>
                    <?php if ($this->_tpl_vars['entity_req_elem']['name'] != 'contact' && $this->_tpl_vars['entity_req_elem']['name'] != 'mail'): ?>
                        <?php if (in_array ( $this->_tpl_vars['entity_req_elem']['name'] , array ( 'kind_activities' , 'own_kind_activities' ) )): ?>
                            <?php if ($this->_tpl_vars['entity_req_elem']['name'] == 'kind_activities'): ?>
                                <tr>
                                    <td colspan="2" style="vertical-align: top;">
                                        <div class="kind_activities" style="margin-bottom: 10px;">
                                            <?php echo smarty_function_label(array('name' => 'kind_activities'), $this);?>
<span style="color: red;">*</span>
                                        </div>
                                        <div class="own_kind_activities" style="display: none;">
                                            <?php echo smarty_function_label(array('name' => 'own_kind_activities'), $this);?>
<span style="color: red;">*</span>
                                        </div>

                                                                                                                <?php $_from = $this->_tpl_vars['errors_entity']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['error']):
?>
                                            <?php if ($this->_tpl_vars['entity_req_elem']['name'] == $this->_tpl_vars['key']): ?>
                                                <span class="error"><?php echo $this->_tpl_vars['error']; ?>
</span><br>
                                            <?php endif; ?>
                                        <?php endforeach; endif; unset($_from); ?>
                                        <div class="kind_activities" style="overflow: hidden;">
                                            <select multiple="multiple" name='kind_activities_or[]' ondblclick="Add_v('kind_activities_original', 'kind_activities_added'); return false;" id="kind_activities_original" class="multiselect">
                                                <?php $_from = $this->_tpl_vars['entity_req_elem']['values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
                                                    <option value="<?php echo $this->_tpl_vars['v']; ?>
" title="<?php echo $this->_tpl_vars['v']; ?>
"><?php echo $this->_tpl_vars['v']; ?>
</option>
                                                <?php endforeach; endif; unset($_from); ?>
                                            </select>
                                            <div class="fly_buttons">
                                                <button onclick="Add_v('kind_activities_original', 'kind_activities_added'); return false;">>>></button>
                                                <button onclick="Add_d('kind_activities_added'); return false;"><<<</button>
                                            </div>

                                            <select multiple="multiple" name='kind_activities[]' ondblclick="Add_d('kind_activities_added'); return false;" id="kind_activities_added" class="multiselect">
                                                <?php if ($this->_supers['post']['kind_activities']): ?>
                                                    <?php $_from = $this->_supers['post']['kind_activities']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
                                                        <option value="<?php echo $this->_tpl_vars['val']; ?>
" selected="selected" title="<?php echo $this->_tpl_vars['val']; ?>
"><?php echo $this->_tpl_vars['val']; ?>
</option>
                                                    <?php endforeach; endif; unset($_from); ?>
                                                <?php endif; ?>
                                            </select>
                                            <button onclick="Add_dAll('kind_activities_added'); return false;" class="clear_button">Очистить список</button>
                                        </div>
                                        <div><input type="checkbox" id="own_kind_activities"<?php if ($this->_supers['post']['own_kind_activities']): ?> checked="checked"<?php endif; ?> style="display: block;float: left;" ><label style="font-size: 12px; padding: 0 10px 10px 5px;display: block;margin-left: 20px;">Свой род деятельности</label></div>
                                        <div class="own_kind_activities invisible"<?php if (! $this->_supers['post']['own_kind_activities']): ?> style="display: none;"<?php endif; ?>>
                                            <?php echo smarty_function_input(array('name' => 'own_kind_activities','class' => "validate[required]"), $this);?>

                                        </div>
                                    </td>
                                        </tr>
                            <?php endif; ?>
                        <?php elseif ($this->_tpl_vars['entity_req_elem']['name'] == 'country_source'): ?>
                            <tr>
                                <td>
                                    <div style="margin-bottom: 10px;">
                                        <?php echo smarty_function_label(array('name' => $this->_tpl_vars['entity_req_elem']['name']), $this);?>
<?php if ($this->_tpl_vars['entity_req_elem']['req']): ?><span style="color: red;">*</span><?php endif; ?>:
                                    </div>
                                </td>
                                <td style="vertical-align: top;">
                                    <div class="kind_activities">
                                        <select data-placeholder="Выберите страну" data-no_results_text="Не найдено" class="chzn-select" name='country_source[]' multiple="multiple" style="width:350px;">
                                        <!--<select multiple="multiple" name='country_source_or[]' ondblclick="Add_v('country_source_original', 'country_source_added'); return false;" id="country_source_original" class="multiselect">-->
                                            <?php $_from = $this->_tpl_vars['entity_req_elem']['values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
                                                <option value="<?php echo $this->_tpl_vars['k']; ?>
" title="<?php echo $this->_tpl_vars['v']; ?>
"<?php if ($this->_supers['post']['country_source'] && in_array ( $this->_tpl_vars['k'] , $this->_supers['post']['country_source'] )): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['v']; ?>
</option>
                                            <?php endforeach; endif; unset($_from); ?>
                                        </select>
                                    </div>
                                    <?php $_from = $this->_tpl_vars['errors_entity']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['error']):
?>
                                        <?php if ($this->_tpl_vars['entity_req_elem']['name'] == $this->_tpl_vars['key']): ?>
                                            <span class="error"><?php echo $this->_tpl_vars['error']; ?>
</span><br>
                                        <?php endif; ?>
                                    <?php endforeach; endif; unset($_from); ?>
                                </td>
                                    </tr>
                        <?php elseif ($this->_tpl_vars['entity_req_elem']['name'] == 'country_receiver'): ?>
                        <tr>
                            <td colspan="2" style="font-size: 12px;">
                                <input type="checkbox" id="match">Страны назначения совпадают со странами источниками
                            </td>
                        </tr>
                            <tr>
                                <td>
                                    <div style="margin-bottom: 10px;">
                                        <?php echo smarty_function_label(array('name' => $this->_tpl_vars['entity_req_elem']['name']), $this);?>
<?php if ($this->_tpl_vars['entity_req_elem']['req']): ?><span style="color: red;">*</span><?php endif; ?>:
                                    </div>
                                </td>
                                <td style="vertical-align: top;">
                                    <div class="kind_activities">
                                        <select data-placeholder="Выберите страну" data-no_results_text="Не найдено" class="chzn-select1" name='country_receiver[]' multiple="multiple" style="width:350px;">
                                            <?php $_from = $this->_tpl_vars['entity_req_elem']['values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
?>
                                                <option value="<?php echo $this->_tpl_vars['k']; ?>
" title="<?php echo $this->_tpl_vars['v']; ?>
"<?php if ($this->_supers['post']['country_receiver'] && in_array ( $this->_tpl_vars['k'] , $this->_supers['post']['country_receiver'] )): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['v']; ?>
</option>
                                            <?php endforeach; endif; unset($_from); ?>
                                        </select>
                                    </div>
                                    <?php $_from = $this->_tpl_vars['errors_entity']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['error']):
?>
                                        <?php if ($this->_tpl_vars['entity_req_elem']['name'] == $this->_tpl_vars['key']): ?>
                                            <span class="error"><?php echo $this->_tpl_vars['error']; ?>
</span><br>
                                        <?php endif; ?>
                                    <?php endforeach; endif; unset($_from); ?>
                                </td>
                                    </tr>
                        <?php elseif ($this->_tpl_vars['entity_req_elem']['name'] == 'jur_country_id'): ?>
                            <tr>
                                <td width="170px" class="error_fix"><?php echo smarty_function_label(array('name' => $this->_tpl_vars['entity_req_elem']['name']), $this);?>
<?php if ($this->_tpl_vars['entity_req_elem']['req']): ?><span style="color: red;">*</span><?php endif; ?>: </td>
                                 <td>
                                    <?php $_from = $this->_tpl_vars['errors_entity']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['error']):
?>
                                        <?php if ($this->_tpl_vars['entity_req_elem']['name'] == $this->_tpl_vars['key']): ?>
                                            <span class="error"><?php echo $this->_tpl_vars['error']; ?>
</span><br>
                                        <?php endif; ?>
                                    <?php endforeach; endif; unset($_from); ?>
                                    <?php echo smarty_function_input(array('name' => $this->_tpl_vars['entity_req_elem']['name'],'class' => $this->_tpl_vars['validators']), $this);?>

                                    <br>
                                     <div id="div" style="display: none; text-align: left; width:388px; margin-top: 5px; color: #f00; font-weight: bold;"><?php if ($this->_tpl_vars['settings']['settings_entity_text']): ?><?php echo $this->_tpl_vars['settings']['settings_entity_text']; ?>
 <?php endif; ?><span id="cur"></span></div>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $this->assign('validators', "validate["); ?>
                            <?php if ($this->_tpl_vars['entity_req_elem']['req']): ?>
                                <?php $this->assign('validators', ((is_array($_tmp=$this->_tpl_vars['validators'])) ? $this->_run_mod_handler('cat', true, $_tmp, 'required') : smarty_modifier_cat($_tmp, 'required'))); ?>
                            <?php endif; ?>
                            <?php $this->assign('validators', ((is_array($_tmp=$this->_tpl_vars['validators'])) ? $this->_run_mod_handler('cat', true, $_tmp, "]") : smarty_modifier_cat($_tmp, "]"))); ?>
                            <tr>
                                <td width="170px"><?php echo smarty_function_label(array('name' => $this->_tpl_vars['entity_req_elem']['name']), $this);?>
<?php if ($this->_tpl_vars['entity_req_elem']['req'] || $this->_tpl_vars['entity_req_elem']['name'] == 'captcha'): ?><span style="color: red;">*</span><?php endif; ?>: </td>
                                <td>
                                    <?php $_from = $this->_tpl_vars['errors_entity']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['error']):
?>
                                        <?php if ($this->_tpl_vars['entity_req_elem']['name'] == $this->_tpl_vars['key']): ?>
                                            <span class="error"><?php echo $this->_tpl_vars['error']; ?>
</span><br>
                                        <?php endif; ?>
                                    <?php endforeach; endif; unset($_from); ?>

                                                                            <?php echo smarty_function_input(array('name' => $this->_tpl_vars['entity_req_elem']['name'],'class' => $this->_tpl_vars['validators']), $this);?>

                                    
                                                                    </td>
                                                        </tr>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?>
                <tr>
                    <td width="170px"></td>
                    <td style="padding-top: 20px;">
                        <span style="color: red;">*</span> поля отмеченные звездочкой - обязательны для заполнения
                        <?php if ($this->_tpl_vars['step'] == 1): ?>
                            <div style="display: none">
                                <?php $_from = $this->_tpl_vars['forms_elements']['entity_req']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['entity_req_elem']):
?>
                                    <?php if ($this->_tpl_vars['entity_req_elem']['name'] == 'contact' || $this->_tpl_vars['entity_req_elem']['name'] == 'mail'): ?>
                                        <?php echo smarty_function_input(array('name' => $this->_tpl_vars['entity_req_elem']['name'],'class' => $this->_tpl_vars['entity_req_elem']['name']), $this);?>

                                    <?php endif; ?>
                                <?php endforeach; endif; unset($_from); ?>
                            </div>
                        <?php endif; ?>
                    </td>
                                </tr>
                <tr>
                    <td width="170px"></td>
                    <td style="padding-top: 20px;">
                        <div class="add_buttons">
                            <input type="submit" name='entity_form' class="order_button orange_button checkauth" value="отправить заявку">
                        </div>
                    </td>
                                </tr>
            </table>
            <?php if ($this->_tpl_vars['step'] == 2): ?></div><?php endif; ?>
            <br>

            <?php echo '
            <script type="text/javascript">
                $(\'form img[class*=validate]\').removeAttr(\'class\');
                $(".chzn-select").chosen().change(function(){
                    ChangeCountries();
                });
                $(".chzn-select1").chosen();
            </script>
            '; ?>



            <?php echo smarty_function_closeformgroup(array(), $this);?>

            </form>
        </div>
        <?php if ($this->_tpl_vars['repeated_entity'] || $this->_tpl_vars['error_urid']): ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>
</div>