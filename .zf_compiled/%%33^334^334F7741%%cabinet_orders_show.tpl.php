<?php /* Smarty version 2.6.25, created on 2013-08-23 14:09:16
         compiled from /home/leadert/webserver/twt-consult/www/site/views/cabinet/cabinet_orders_show.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', '/home/leadert/webserver/twt-consult/www/site/views/cabinet/cabinet_orders_show.tpl', 37, false),array('modifier', 'number_format', '/home/leadert/webserver/twt-consult/www/site/views/cabinet/cabinet_orders_show.tpl', 96, false),)), $this); ?>
<h3>Заявка № <?php echo $this->_tpl_vars['data']['id']; ?>
</h3>
<table class="striped">
    <?php if ($this->_tpl_vars['request']['type'] == 'calcs'): ?>
        <tr>
            <td>Наименование компании:</td>
            <td><?php echo $this->_tpl_vars['data']['contractor']; ?>
</td>
        </tr>
        <tr>
            <td>Выгодоприобретатель:</td>
            <td><?php echo $this->_tpl_vars['data']['beneficiary']; ?>
</td>
        </tr>
        <tr>
            <td>Груз (товары через запятую):</td>
            <td><?php echo $this->_tpl_vars['data']['number_of_seat']; ?>
</td>
        </tr>
        <tr>
            <td>Количество мест:</td>
            <td><?php echo $this->_tpl_vars['data']['consignment']; ?>
</td>
        </tr>
        <tr>
            <td>Единица измерения мест:</td>
            <td>
                <?php $this->assign('measure', $this->_tpl_vars['data']['number_of_seat_measure']); ?>
                <?php echo $this->_tpl_vars['NumberOfSeatMeasure'][$this->_tpl_vars['measure']]; ?>

            </td>
        </tr>
        <tr>
            <td>Общий вес:</td>
            <td><?php echo $this->_tpl_vars['data']['weight']; ?>
</td>
        </tr>
        <tr>
            <td>Список документов:</td>
            <td><?php echo $this->_tpl_vars['data']['documents']; ?>
</td>
        </tr>
        <tr>
            <td>Начало страхования:</td>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['start_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%d-%m-%Y') : smarty_modifier_date_format($_tmp, '%d-%m-%Y')); ?>
</td>
        </tr>
        <tr>
            <td>Конец страхования:</td>
            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['data']['end_date'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%d-%m-%Y') : smarty_modifier_date_format($_tmp, '%d-%m-%Y')); ?>
</td>
        </tr>
        <?php if ($this->_tpl_vars['data']['transports']): ?>
            <tr>
                <td colspan="2">Маршрут:</td>
            </tr>
            <?php $_from = $this->_tpl_vars['data']['transports']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['i'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['i']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['trans']):
        $this->_foreach['i']['iteration']++;
?>
                <tr class="nostriped">
                    <?php if (($this->_foreach['i']['iteration'] <= 1)): ?>
                        <td>Начальная точка маршрута:</td>
                    <?php elseif (! ($this->_foreach['i']['iteration'] == $this->_foreach['i']['total'])): ?>
                        <td>Промежуточная точка маршрута:</td>
                    <?php else: ?>
                        <td>Конечная точка маршрута:</td>
                    <?php endif; ?>
                    <td>
                        <table style="width: 100%;">
                            <tr>
                                <td style="width: 130px;">Страна:</td>
                                <td>
                                    <?php $this->assign('country', $this->_tpl_vars['trans']['country']); ?>
                                    <?php echo $this->_tpl_vars['countries'][$this->_tpl_vars['country']]; ?>

                                </td>
                            </tr>
                            <tr>
                                <td>Город:</td>
                                <td><?php echo $this->_tpl_vars['trans']['city']; ?>
</td>
                            </tr>
                            <tr>
                                <td>Транспорт:</td>
                                <td><?php echo $this->_tpl_vars['trans']['transport']; ?>
</td>
                            </tr>
                            <tr>
                                <td>Номер транспортного средства:</td>
                                <td><?php echo $this->_tpl_vars['trans']['registration_number']; ?>
</td>
                            </tr>
                        </table>
                    </td>
                </tr>

            <?php endforeach; endif; unset($_from); ?>
        <?php endif; ?>
    <?php else: ?>
        <?php $_from = $this->_tpl_vars['titles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['field'] => $this->_tpl_vars['value']):
?>
            <?php if ($this->_tpl_vars['field'] != 'id'): ?>
                <?php if (( is_array ( $this->_tpl_vars['data'][$this->_tpl_vars['field']] ) && $this->_tpl_vars['data'][$this->_tpl_vars['field']] ) || $this->_tpl_vars['data'][$this->_tpl_vars['field']]): ?>
                    <tr>
                        <td><?php echo $this->_tpl_vars['value']; ?>
</td>
                        <td>
                            <?php if (is_array ( $this->_tpl_vars['data'][$this->_tpl_vars['field']] ) && $this->_tpl_vars['data'][$this->_tpl_vars['field']]): ?>
                                <?php $_from = $this->_tpl_vars['data'][$this->_tpl_vars['field']]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['i'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['i']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['row']):
        $this->_foreach['i']['iteration']++;
?>
                                    <?php echo $this->_tpl_vars['row']['title']; ?>
<?php if (! ($this->_foreach['i']['iteration'] == $this->_foreach['i']['total'])): ?>, <?php endif; ?>
                                <?php endforeach; endif; unset($_from); ?>
                            <?php else: ?>
                                <?php if ($this->_tpl_vars['fields'][$this->_tpl_vars['field']]['type'] == 'float'): ?>
                                    <?php echo ((is_array($_tmp=$this->_tpl_vars['data'][$this->_tpl_vars['field']])) ? $this->_run_mod_handler('number_format', true, $_tmp, '0', ' ', ' ') : number_format($_tmp, '0', ' ', ' ')); ?>

                                <?php else: ?>
                                    <?php echo $this->_tpl_vars['data'][$this->_tpl_vars['field']]; ?>

                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?>
        <?php if ($this->_tpl_vars['data']['banks']): ?>
            <?php $_from = $this->_tpl_vars['data']['banks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['i'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['i']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['bank']):
        $this->_foreach['i']['iteration']++;
?>
                <tr>
                    <td>Банк<?php echo $this->_foreach['i']['iteration']; ?>
</td>
                    <td><?php echo $this->_tpl_vars['bank']['bank']; ?>
 - <?php echo $this->_tpl_vars['bank']['currency']; ?>
</td>
                </tr>
            <?php endforeach; endif; unset($_from); ?>
        <?php endif; ?>
    <?php endif; ?>
</table>
<div><a style="font-size: 12px;" href="/cabinet/orders">назад</a></div>