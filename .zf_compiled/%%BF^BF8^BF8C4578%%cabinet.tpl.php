<?php /* Smarty version 2.6.25, created on 2013-08-22 14:36:44
         compiled from /home/leadert/webserver/twt-consult/www/site/views/cabinet/cabinet.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'loadview', '/home/leadert/webserver/twt-consult/www/site/views/cabinet/cabinet.tpl', 11, false),)), $this); ?>
<div class="cabinet">
    <h1>Личный кабинет</h1>
	<div class="personal-menu">
        <div><?php if ($this->_tpl_vars['dataBlock'] != 'personal'): ?><a href="/cabinet/"><?php endif; ?>Личные данные<?php if ($this->_tpl_vars['dataBlock'] != 'personal'): ?></a><?php endif; ?></div>
        <div><?php if ($this->_tpl_vars['dataBlock'] != 'companies'): ?><a href="/cabinet/companies/"><?php endif; ?>Компании<?php if ($this->_tpl_vars['dataBlock'] != 'companies'): ?></a><?php endif; ?></div>
        <div><?php if ($this->_tpl_vars['dataBlock'] != 'orders'): ?><a href="/cabinet/orders/"><?php endif; ?>Заявки<?php if ($this->_tpl_vars['dataBlock'] != 'orders'): ?></a><?php endif; ?></div>
	</div>
    <div class="data">
        <?php if ($this->_tpl_vars['dataBlock'] == 'personal'): ?>
            <div class="tabs personal">
                <?php echo smarty_function_loadview(array('name' => "cabinet/cabinet_personal"), $this);?>

            </div>
        <?php elseif ($this->_tpl_vars['dataBlock'] == 'companies'): ?>
            <div class="tabs companies">
                <?php echo smarty_function_loadview(array('name' => "cabinet/cabinet_companies"), $this);?>

            </div>
        <?php elseif ($this->_tpl_vars['dataBlock'] == 'orders'): ?>
            <div class="tabs orders">
                <?php echo smarty_function_loadview(array('name' => "cabinet/cabinet_orders"), $this);?>

            </div>
        <?php elseif ($this->_tpl_vars['dataBlock'] == 'change'): ?>
            <div class="tabs personal">
                <?php echo smarty_function_loadview(array('name' => "cabinet/cabinet_change_pass"), $this);?>

            </div>
        <?php endif; ?>
    </div>
</div>