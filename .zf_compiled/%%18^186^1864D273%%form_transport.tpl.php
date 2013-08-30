<?php /* Smarty version 2.6.25, created on 2013-08-22 13:47:29
         compiled from /home/leadert/webserver/twt-consult/www/site/views/form_transport.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'form', '/home/leadert/webserver/twt-consult/www/site/views/form_transport.tpl', 19, false),array('function', 'label', '/home/leadert/webserver/twt-consult/www/site/views/form_transport.tpl', 28, false),array('function', 'input', '/home/leadert/webserver/twt-consult/www/site/views/form_transport.tpl', 37, false),array('function', 'closeformgroup', '/home/leadert/webserver/twt-consult/www/site/views/form_transport.tpl', 179, false),array('modifier', 'regex_replace', '/home/leadert/webserver/twt-consult/www/site/views/form_transport.tpl', 25, false),array('modifier', 'cat', '/home/leadert/webserver/twt-consult/www/site/views/form_transport.tpl', 58, false),)), $this); ?>
<div class="form_container">
<?php if ($this->_tpl_vars['success_transport']): ?>
    <h2 id="transport_anchor">Благодарим Вас за заявку. Наш специалист свяжется с Вами в ближайшее время. Номер вашей заявки: <?php echo $this->_tpl_vars['order1C_id']; ?>
</h2>
<?php elseif ($this->_tpl_vars['repeated_transport']): ?>
    <h2 id="transport_anchor">Ваша заявка уже добавлена.</h2>
    <a href="javascript:void(0)" id="show_form">Отредактировать заявку</a>
<?php elseif ($this->_tpl_vars['error_transport']): ?>
    <h2 id="transport_anchor">Заявка не добавлена. Попробуйте, пожалуйста, позже.</h2>
    <a href="javascript:void(0)" id="show_form">Отредактировать заявку</a>
<?php endif; ?>
<?php if (( ! $this->_tpl_vars['repeated_transport'] && ! $this->_tpl_vars['error_transport'] && ! $this->_tpl_vars['success_transport'] ) || ( $this->_tpl_vars['repeated_transport'] || $this->_tpl_vars['error_transport'] && ! $this->_tpl_vars['success_transport'] )): ?>
    <?php if ($this->_tpl_vars['repeated_transport'] || $this->_tpl_vars['error_transport']): ?>
        <div style="display:none" id="formshow">
    <?php endif; ?>
    <?php if ($this->_tpl_vars['forms_elements']['transport_req']): ?>
    <h2 id="transport_anchor">Комплексная заявка на транспортную логистику и таможенное оформление</h2>
    <?php if ($this->_tpl_vars['settings']['transport_text']): ?><div><?php echo $this->_tpl_vars['settings']['transport_text']; ?>
</div><?php endif; ?>
        <div class="form">
            <?php echo smarty_function_form(array('name' => 'transport_req','id' => 'transport_req_form'), $this);?>

                <?php if ($this->_tpl_vars['step'] > 0): ?><input type="hidden" name="step" id="step" value="<?php echo $this->_tpl_vars['step']; ?>
" /><?php endif; ?>
            <table>
                <?php $_from = $this->_tpl_vars['forms_elements']['transport_req']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['transport_req_elem']):
?>
                    <?php if ($this->_tpl_vars['transport_req_elem']['name'] != 'contact' && $this->_tpl_vars['transport_req_elem']['name'] != 'mail'): ?>
                        <?php $this->assign('tmp', $this->_tpl_vars['transport_req_elem']['name']); ?>
                        <?php $this->assign('el_name', ((is_array($_tmp=$this->_tpl_vars['tmp'])) ? $this->_run_mod_handler('regex_replace', true, $_tmp, "/\[.*/", "") : smarty_modifier_regex_replace($_tmp, "/\[.*/", ""))); ?>
                        <?php if ($this->_tpl_vars['transport_req_elem']['name'] == 'cost'): ?>
                            <tr>
                                <td width="200px"><?php echo smarty_function_label(array('name' => $this->_tpl_vars['transport_req_elem']['name']), $this);?>
<?php if ($this->_tpl_vars['transport_req_elem']['req']): ?><span style="color: red;">*</span><?php endif; ?>: </td>
                                <td>
                                    <?php $_from = $this->_tpl_vars['errors_transport']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['error']):
?>
                                        <?php if ($this->_tpl_vars['transport_req_elem']['name'] == $this->_tpl_vars['key']): ?>
                                            <span class="error"><?php echo $this->_tpl_vars['error']; ?>
</span><br>
                                        <?php endif; ?>
                                    <?php endforeach; endif; unset($_from); ?>
                                    <?php if ($this->_tpl_vars['step'] == 2): ?>
                                        <?php echo $this->_tpl_vars['transport_req_elem']['value']; ?>

                                        <?php echo smarty_function_input(array('name' => $this->_tpl_vars['transport_req_elem']['name'],'class' => $this->_tpl_vars['transport_req_elem']['name'],'style' => "display:none"), $this);?>

                                    <?php else: ?>
                                        <?php echo smarty_function_input(array('name' => $this->_tpl_vars['transport_req_elem']['name'],'class' => $this->_tpl_vars['transport_req_elem']['name']), $this);?>

                                    <?php endif; ?>
                        <?php elseif ($this->_tpl_vars['transport_req_elem']['name'] == 'currency'): ?>
                                    <?php $_from = $this->_tpl_vars['errors_transport']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['error']):
?>
                                        <?php if ($this->_tpl_vars['transport_req_elem']['name'] == $this->_tpl_vars['key']): ?>
                                            <span class="error"><?php echo $this->_tpl_vars['error']; ?>
</span><br>
                                        <?php endif; ?>
                                    <?php endforeach; endif; unset($_from); ?>
                                    <?php if ($this->_tpl_vars['step'] == 2): ?>
                                        <?php echo $this->_tpl_vars['transport_req_elem']['value']; ?>

                                        <?php echo smarty_function_input(array('name' => $this->_tpl_vars['transport_req_elem']['name'],'class' => $this->_tpl_vars['transport_req_elem']['name'],'style' => "display:none"), $this);?>

                                    <?php else: ?>
                                        <?php echo smarty_function_input(array('name' => $this->_tpl_vars['transport_req_elem']['name'],'class' => $this->_tpl_vars['transport_req_elem']['name']), $this);?>

                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php elseif ($this->_tpl_vars['transport_req_elem']['name'] != 'currency' && $this->_tpl_vars['transport_req_elem']['name'] != 'cost'): ?>
                            <?php $this->assign('validators', "validate["); ?>
                            <?php if ($this->_tpl_vars['transport_req_elem']['req']): ?>
                                <?php $this->assign('validators', ((is_array($_tmp=$this->_tpl_vars['validators'])) ? $this->_run_mod_handler('cat', true, $_tmp, 'required') : smarty_modifier_cat($_tmp, 'required'))); ?>
                            <?php endif; ?>
                            <?php $this->assign('validators', ((is_array($_tmp=$this->_tpl_vars['validators'])) ? $this->_run_mod_handler('cat', true, $_tmp, "]") : smarty_modifier_cat($_tmp, "]"))); ?>
                            <tr>
                                <td width="200px"<?php if ($this->_tpl_vars['transport_req_elem']['name'] == 'services'): ?> style="vertical-align: top;"<?php elseif ($this->_tpl_vars['transport_req_elem']['name'] == 'captcha'): ?> style="vertical-align: top;"<?php endif; ?>>
                                    <?php if ($this->_tpl_vars['transport_req_elem']['name'] == 'captcha'): ?>
                                        <?php if ($this->_tpl_vars['step'] == 1): ?>
                                           <?php echo smarty_function_label(array('name' => $this->_tpl_vars['transport_req_elem']['name']), $this);?>
<span style="color: red;">*</span>:
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <?php echo smarty_function_label(array('name' => $this->_tpl_vars['transport_req_elem']['name']), $this);?>
<?php if ($this->_tpl_vars['transport_req_elem']['req']): ?><span style="color: red;">*</span><?php endif; ?>:
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php $_from = $this->_tpl_vars['errors_transport']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['error']):
?>
                                        <?php if ($this->_tpl_vars['transport_req_elem']['name'] == $this->_tpl_vars['key']): ?>
                                            <span class="error"><?php echo $this->_tpl_vars['error']; ?>
</span><br>
                                        <?php endif; ?>
                                    <?php endforeach; endif; unset($_from); ?>
                        <?php if ($this->_tpl_vars['transport_req_elem']['name'] == 'services'): ?>
                            <div id="services">
                                <?php if ($this->_tpl_vars['step'] == 2): ?>
                                    <div style="display: none">
                                        <?php unset($this->_sections['checkboxes']);
$this->_sections['checkboxes']['name'] = 'checkboxes';
$this->_sections['checkboxes']['loop'] = is_array($_loop=$this->_tpl_vars['transport_req_elem']['values']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['checkboxes']['show'] = true;
$this->_sections['checkboxes']['max'] = $this->_sections['checkboxes']['loop'];
$this->_sections['checkboxes']['step'] = 1;
$this->_sections['checkboxes']['start'] = $this->_sections['checkboxes']['step'] > 0 ? 0 : $this->_sections['checkboxes']['loop']-1;
if ($this->_sections['checkboxes']['show']) {
    $this->_sections['checkboxes']['total'] = $this->_sections['checkboxes']['loop'];
    if ($this->_sections['checkboxes']['total'] == 0)
        $this->_sections['checkboxes']['show'] = false;
} else
    $this->_sections['checkboxes']['total'] = 0;
if ($this->_sections['checkboxes']['show']):

            for ($this->_sections['checkboxes']['index'] = $this->_sections['checkboxes']['start'], $this->_sections['checkboxes']['iteration'] = 1;
                 $this->_sections['checkboxes']['iteration'] <= $this->_sections['checkboxes']['total'];
                 $this->_sections['checkboxes']['index'] += $this->_sections['checkboxes']['step'], $this->_sections['checkboxes']['iteration']++):
$this->_sections['checkboxes']['rownum'] = $this->_sections['checkboxes']['iteration'];
$this->_sections['checkboxes']['index_prev'] = $this->_sections['checkboxes']['index'] - $this->_sections['checkboxes']['step'];
$this->_sections['checkboxes']['index_next'] = $this->_sections['checkboxes']['index'] + $this->_sections['checkboxes']['step'];
$this->_sections['checkboxes']['first']      = ($this->_sections['checkboxes']['iteration'] == 1);
$this->_sections['checkboxes']['last']       = ($this->_sections['checkboxes']['iteration'] == $this->_sections['checkboxes']['total']);
?>
                                            <?php echo smarty_function_input(array('name' => $this->_tpl_vars['transport_req_elem']['name'],'class' => $this->_tpl_vars['validators'],'num' => $this->_sections['checkboxes']['iteration']-1), $this);?>

                                        <?php endfor; endif; ?>
                                    </div>
                                    <?php $_from = $this->_tpl_vars['transport_req_elem']['values']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['val_elem']):
?>
                                        <?php $_from = $this->_tpl_vars['transport_req_elem']['value']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['val']):
?>
                                            <?php if ($this->_tpl_vars['key'] == $this->_tpl_vars['val']): ?>
                                                <?php echo $this->_tpl_vars['val_elem']; ?>
<br />
                                            <?php endif; ?>
                                        <?php endforeach; endif; unset($_from); ?>
                                    <?php endforeach; endif; unset($_from); ?>
                                <?php else: ?>
                                    <?php unset($this->_sections['checkboxes']);
$this->_sections['checkboxes']['name'] = 'checkboxes';
$this->_sections['checkboxes']['loop'] = is_array($_loop=$this->_tpl_vars['transport_req_elem']['values']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['checkboxes']['show'] = true;
$this->_sections['checkboxes']['max'] = $this->_sections['checkboxes']['loop'];
$this->_sections['checkboxes']['step'] = 1;
$this->_sections['checkboxes']['start'] = $this->_sections['checkboxes']['step'] > 0 ? 0 : $this->_sections['checkboxes']['loop']-1;
if ($this->_sections['checkboxes']['show']) {
    $this->_sections['checkboxes']['total'] = $this->_sections['checkboxes']['loop'];
    if ($this->_sections['checkboxes']['total'] == 0)
        $this->_sections['checkboxes']['show'] = false;
} else
    $this->_sections['checkboxes']['total'] = 0;
if ($this->_sections['checkboxes']['show']):

            for ($this->_sections['checkboxes']['index'] = $this->_sections['checkboxes']['start'], $this->_sections['checkboxes']['iteration'] = 1;
                 $this->_sections['checkboxes']['iteration'] <= $this->_sections['checkboxes']['total'];
                 $this->_sections['checkboxes']['index'] += $this->_sections['checkboxes']['step'], $this->_sections['checkboxes']['iteration']++):
$this->_sections['checkboxes']['rownum'] = $this->_sections['checkboxes']['iteration'];
$this->_sections['checkboxes']['index_prev'] = $this->_sections['checkboxes']['index'] - $this->_sections['checkboxes']['step'];
$this->_sections['checkboxes']['index_next'] = $this->_sections['checkboxes']['index'] + $this->_sections['checkboxes']['step'];
$this->_sections['checkboxes']['first']      = ($this->_sections['checkboxes']['iteration'] == 1);
$this->_sections['checkboxes']['last']       = ($this->_sections['checkboxes']['iteration'] == $this->_sections['checkboxes']['total']);
?>
                                        <div class="subject-tags">
                                            <?php echo smarty_function_input(array('name' => $this->_tpl_vars['transport_req_elem']['name'],'class' => $this->_tpl_vars['validators'],'num' => $this->_sections['checkboxes']['iteration']-1), $this);?>

                                        </div>
                                    <?php endfor; endif; ?>
                                <?php endif; ?>
                                <div style="clear:both"></div>
                            </div>
                        <?php elseif ($this->_tpl_vars['transport_req_elem']['name'] == 'captcha'): ?>
                            <?php if ($this->_tpl_vars['step'] == 1): ?>
                                <?php echo smarty_function_input(array('name' => $this->_tpl_vars['transport_req_elem']['name'],'class' => $this->_tpl_vars['validators']), $this);?>

                            <?php endif; ?>
                        <?php else: ?>
                            <?php if ($this->_tpl_vars['step'] == 2): ?>
                                <?php echo $this->_tpl_vars['transport_req_elem']['value']; ?>

                                <?php echo smarty_function_input(array('name' => $this->_tpl_vars['transport_req_elem']['name'],'class' => $this->_tpl_vars['validators'],'style' => "display:none"), $this);?>

                            <?php else: ?>
                                <?php echo smarty_function_input(array('name' => $this->_tpl_vars['transport_req_elem']['name'],'class' => $this->_tpl_vars['validators']), $this);?>

                            <?php endif; ?>
                        <?php endif; ?>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?>
                <?php if ($this->_tpl_vars['step'] == 1): ?>
                    <tr>
                        <td width="200px"></td>
                        <td style="padding-top: 20px;font-size: 13px;">
                            <span style="color: red;">*</span> поля отмеченные звездочкой - обязательны для заполнения
                            <div style="display: none">
                                <?php $_from = $this->_tpl_vars['forms_elements']['transport_req']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['transport_req_elem']):
?>
                                    <?php if ($this->_tpl_vars['transport_req_elem']['name'] == 'contact' || $this->_tpl_vars['transport_req_elem']['name'] == 'mail'): ?>
                                        <?php echo smarty_function_input(array('name' => $this->_tpl_vars['transport_req_elem']['name'],'class' => $this->_tpl_vars['transport_req_elem']['name']), $this);?>

                                    <?php endif; ?>
                                <?php endforeach; endif; unset($_from); ?>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php if ($this->_tpl_vars['step'] == 2): ?>
                    <tr>
                        <td width="200px"></td>
                        <td style="padding-top: 20px;">
                            <div class="add_buttons">
                                <input type="submit" name='transport_form' class="order_button orange_button checkauth" value="Отредактировать заявку" onclick="$('#step').val('0');" style="height: 32px;">
                            </div>
                        </td>
                    </tr>
                    <?php $_from = $this->_tpl_vars['forms_elements']['transport_req']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['transport_req_elem']):
?>
                        <?php if ($this->_tpl_vars['transport_req_elem']['name'] == 'contact' || $this->_tpl_vars['transport_req_elem']['name'] == 'mail'): ?>
                            <tr style="height:40px;">
                                <td width="200px"><?php echo smarty_function_label(array('name' => $this->_tpl_vars['transport_req_elem']['name']), $this);?>
<?php if ($this->_tpl_vars['transport_req_elem']['req']): ?><span style="color: red;">*</span><?php endif; ?>: </td>
                                <td>
                                    <?php $_from = $this->_tpl_vars['errors_transport']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['error']):
?>
                                        <?php if ($this->_tpl_vars['transport_req_elem']['name'] == $this->_tpl_vars['key']): ?>
                                            <span class="error"><?php echo $this->_tpl_vars['error']; ?>
</span><br>
                                        <?php endif; ?>
                                    <?php endforeach; endif; unset($_from); ?>
                                    <?php echo smarty_function_input(array('name' => $this->_tpl_vars['transport_req_elem']['name'],'class' => $this->_tpl_vars['transport_req_elem']['name'],'style' => "display:none;",'onblur' => "$(this).hide();$('.static".($this->_tpl_vars['transport_req_elem']['name'])."').show();$('.static".($this->_tpl_vars['transport_req_elem']['name'])."').find('.label').html($(this).val());"), $this);?>

                                    <span class="static<?php echo $this->_tpl_vars['transport_req_elem']['name']; ?>
">
                                        <div style="float:right"><a href="#" onclick="$('.<?php echo $this->_tpl_vars['transport_req_elem']['name']; ?>
').show();$('.static<?php echo $this->_tpl_vars['transport_req_elem']['name']; ?>
').hide();return false;">изменить</a></div>
                                        <span class="label"><?php echo $this->_tpl_vars['transport_req_elem']['value']; ?>
</span>
                                    </span>
                                </td>
                            </tr>
                        <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?>
                <?php endif; ?>
                <tr>
                    <td width="200px"></td>
                    <td style="padding-top: 20px;">
                        <div class="add_buttons">
                            <input <?php if ($this->_tpl_vars['step'] == 2): ?>onclick="yaCounter19010836.reachGoal('transport_form'); return true;"<?php endif; ?> type="submit" name='transport_form' class="order_button orange_button checkauth" value="отправить заявку">
                        </div>
                    </td>
                </tr>
            </table>

            <br>

            <script type="text/javascript">
                $('form img[class*=validate]').removeAttr('class');
            </script>


            <?php echo smarty_function_closeformgroup(array(), $this);?>

            </form>
        </div>
        <?php if ($this->_tpl_vars['repeated_transport'] || $this->_tpl_vars['error_transport']): ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>
</div>