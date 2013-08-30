<?php /* Smarty version 2.6.25, created on 2013-08-26 11:43:10
         compiled from /home/leadert/webserver/twt-consult/www/site/views/cabinet/cabinet_orders.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'loadview', '/home/leadert/webserver/twt-consult/www/site/views/cabinet/cabinet_orders.tpl', 2, false),array('modifier', 'date_format', '/home/leadert/webserver/twt-consult/www/site/views/cabinet/cabinet_orders.tpl', 23, false),array('modifier', 'number_format', '/home/leadert/webserver/twt-consult/www/site/views/cabinet/cabinet_orders.tpl', 88, false),array('modifier', 'replace', '/home/leadert/webserver/twt-consult/www/site/views/cabinet/cabinet_orders.tpl', 110, false),)), $this); ?>
<?php if ($this->_tpl_vars['CAction'] == 'show'): ?>
    <?php echo smarty_function_loadview(array('name' => "cabinet/cabinet_orders_show"), $this);?>

<?php else: ?>
	<h3 class="blue_title">Мои заявки</h3>
    <div class="table">
	    <?php if (! $this->_tpl_vars['orders']['account'] && ! $this->_tpl_vars['orders']['entity'] && ! $this->_tpl_vars['orders']['transport'] && ! $this->_tpl_vars['orders']['calcs']): ?>
            <div style="font-size: 12px;">
                У Вас нет ни одной заявки.
            </div>
	    <?php else: ?>
            <?php if ($this->_tpl_vars['orders']['account']): ?>
                <div class="order_title">Заявки на открытие счета</div>
                <table class="striped">
                    <tr>
                        <th>Номер</th>
                        <th>Дата</th>
                        <th>Банк и валюта счета</th>
                        <th></th>
                    </tr>
                    <?php $_from = $this->_tpl_vars['orders']['account']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                        <tr>
                            <td><?php echo $this->_tpl_vars['row']['id']; ?>
</td>
                            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['row']['created'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%d-%m-%Y') : smarty_modifier_date_format($_tmp, '%d-%m-%Y')); ?>
</td>
                            <td>
                                <?php if ($this->_tpl_vars['row']['banks']): ?>
                                    <?php $_from = $this->_tpl_vars['row']['banks']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['bank']):
?>
                                        <?php echo $this->_tpl_vars['bank']['bank']; ?>
 - <?php echo $this->_tpl_vars['bank']['currency']; ?>

                                    <?php endforeach; endif; unset($_from); ?>
                                <?php endif; ?>
                            </td>
                            <td class="buttons">
                                <a href="/cabinet/showorder/id/<?php echo $this->_tpl_vars['row']['id']; ?>
/type/account">Просмотреть</a>
                            </td>
                        </tr>
                    <?php endforeach; endif; unset($_from); ?>
                </table>
            <?php endif; ?>

            <?php if ($this->_tpl_vars['orders']['entity']): ?>
                <div class="order_title">Заявки на регистрацию юридического лица</div>
                <table class="striped">
                    <tr>
                        <th>Номер</th>
                        <th>Дата</th>
                        <th>Юрисдикция</th>
                        <th>Название компании</th>
                        <th>Род деятельности</th>
                        <th>Стоимость</th>
                        <th></th>
                    </tr>
                    <?php $_from = $this->_tpl_vars['orders']['entity']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                        <tr>
                            <td><?php echo $this->_tpl_vars['row']['id']; ?>
</td>
                            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['row']['created'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%d-%m-%Y') : smarty_modifier_date_format($_tmp, '%d-%m-%Y')); ?>
</td>
                            <td><?php echo $this->_tpl_vars['row']['jurisdiction']; ?>
</td>
                            <td><?php echo $this->_tpl_vars['row']['company_name']; ?>
</td>
                            <td>
                                <?php if ($this->_tpl_vars['row']['kind_activities']): ?>
                                    <?php $_from = $this->_tpl_vars['row']['kind_activities']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['kind_activitie']):
?>
                                        <?php echo $this->_tpl_vars['kind_activitie']['title']; ?>

                                    <?php endforeach; endif; unset($_from); ?>
                                <?php endif; ?>
                            </td>
                            <td><?php echo $this->_tpl_vars['row']['price_final']; ?>
</td>
                            <td class="buttons">
                                <a href="/cabinet/showorder/id/<?php echo $this->_tpl_vars['row']['id']; ?>
/type/entity">Просмотреть</a>
                            </td>
                        </tr>
                    <?php endforeach; endif; unset($_from); ?>
                </table>
            <?php endif; ?>

            <?php if ($this->_tpl_vars['orders']['transport']): ?>
                <div class="order_title">Комплексные заявки на транспортную логистику и таможенное оформление</div>
                <table class="striped">
                    <tr>
                        <th>Номер</th>
                        <th>Дата</th>
                        <th>Наименование товара</th>
                        <th>Стоимость груза - валюта</th>
                        <th></th>
                    </tr>
                    <?php $_from = $this->_tpl_vars['orders']['transport']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['row']):
?>
                        <tr>
                            <td><?php echo $this->_tpl_vars['row']['id']; ?>
</td>
                            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['row']['created'])) ? $this->_run_mod_handler('date_format', true, $_tmp, '%d-%m-%Y') : smarty_modifier_date_format($_tmp, '%d-%m-%Y')); ?>
</td>
                            <td><?php echo $this->_tpl_vars['row']['cargo_name']; ?>
</td>
                            <td><?php echo ((is_array($_tmp=$this->_tpl_vars['row']['cost'])) ? $this->_run_mod_handler('number_format', true, $_tmp, '0', ' ', ' ') : number_format($_tmp, '0', ' ', ' ')); ?>
 - <?php echo $this->_tpl_vars['row']['currency_name']; ?>
</td>
                            <td class="buttons">
                                <a href="/cabinet/showorder/id/<?php echo $this->_tpl_vars['row']['id']; ?>
/type/transport">Просмотреть</a>
                            </td>
                        </tr>
                    <?php endforeach; endif; unset($_from); ?>
                </table>
            <?php endif; ?>

            <?php if ($this->_tpl_vars['orders']['calcs']): ?>
                <div class="order_title">Заявки по страхованию</div>
                <table class="striped">
                    <tr>
                        <th>Номер</th>
                        <th>Начало страхования</th>
                        <th>Конец страхования</th>
                        <th></th>
                        <th></th>
                    </tr>
                    <?php $_from = $this->_tpl_vars['orders']['calcs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['row']):
?>
                        <tr>
                            <td><?php echo $this->_tpl_vars['k']; ?>
</td>
                            <td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['row']['start_date'])) ? $this->_run_mod_handler('replace', true, $_tmp, 'T', ' ') : smarty_modifier_replace($_tmp, 'T', ' ')))) ? $this->_run_mod_handler('date_format', true, $_tmp, '%d-%m-%Y') : smarty_modifier_date_format($_tmp, '%d-%m-%Y')); ?>
</td>
                            <td><?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['row']['end_date'])) ? $this->_run_mod_handler('replace', true, $_tmp, 'T', ' ') : smarty_modifier_replace($_tmp, 'T', ' ')))) ? $this->_run_mod_handler('date_format', true, $_tmp, '%d-%m-%Y') : smarty_modifier_date_format($_tmp, '%d-%m-%Y')); ?>
</td>
                            <td class="buttons">
                                <a href="/cabinet/showorder/id/<?php echo $this->_tpl_vars['k']; ?>
/type/calcs">Просмотреть</a>
                            </td>
                            <td class="buttons download_file" data-filename="<?php echo $this->_tpl_vars['row']['link']; ?>
">
                                <a href="#">Скачать</a>
                            </td>
                        </tr>
                    <?php endforeach; endif; unset($_from); ?>
                </table>
            <?php endif; ?>
	    <?php endif; ?>

    </div>
<?php endif; ?>
<div id="preparing-file-modal" title="Подготовка файла..." style="display: none;">
    Подготавливается файл для скачивания, подождите...

    <div class="ui-progressbar-value ui-corner-left ui-corner-right" style="width: 100%; height:22px; margin-top: 20px;"></div>
</div>
<div id="error-modal" title="Error" style="display: none;">
    Возникли проблемы при подготовке файла, повторите попытку
</div>

<?php echo '
<script>
    $(document).ready(function(){
        $(\'.download_file\').on(\'click\', function(){
            var filename = $(this).data(\'filename\');
            var url = \'/cabinet/download_file?path=\'+filename;
            console.log(url);

            var preparingFileModal = $("#preparing-file-modal");
            preparingFileModal.dialog({ modal: true });
            $.fileDownload(
                url,
                {
                    successCallback: function (url) {
                        preparingFileModal.dialog(\'close\');
                    },
                    failCallback: function (responseHtml, url) {
                        preparingFileModal.dialog(\'close\');
                        $("#error-modal").dialog({ modal: true });
                    }
                });
            return false;
        });
    });
</script>
'; ?>