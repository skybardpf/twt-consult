<?php /* Smarty version 2.6.25, created on 2013-08-22 13:47:29
         compiled from /home/leadert/webserver/twt-consult/www/site/views/banners.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'replace', '/home/leadert/webserver/twt-consult/www/site/views/banners.tpl', 7, false),)), $this); ?>

<?php if ($this->_tpl_vars['banners']): ?>
    <div class="banners">
        <div id="ban">
            <?php if ($this->_tpl_vars['banners']['top']): ?>
                <div id="banner1">
                    <a href="/<?php echo $this->_tpl_vars['banners']['top']['url']; ?>
"><img alt="" title="" src="<?php echo ((is_array($_tmp=$this->_tpl_vars['banners']['top']['image'])) ? $this->_run_mod_handler('replace', true, $_tmp, '[dir]', 'resized') : smarty_modifier_replace($_tmp, '[dir]', 'resized')); ?>
" style="width: 338px; height: 132px;"></a>
                </div>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['banners']['middle']): ?>
                <div id="banner2">
                    <a href="/<?php echo $this->_tpl_vars['banners']['middle']['url']; ?>
"><img alt="" title="" src="<?php echo ((is_array($_tmp=$this->_tpl_vars['banners']['middle']['image'])) ? $this->_run_mod_handler('replace', true, $_tmp, '[dir]', 'resized') : smarty_modifier_replace($_tmp, '[dir]', 'resized')); ?>
" style="width: 338px; height: 132px;"></a>
                </div>
            <?php endif; ?>
            <?php if ($this->_tpl_vars['banners']['bottom']): ?>
                <div id="banner3">
                    <a href="/<?php echo $this->_tpl_vars['banners']['bottom']['url']; ?>
"><img alt="" title="" src="<?php echo ((is_array($_tmp=$this->_tpl_vars['banners']['bottom']['image'])) ? $this->_run_mod_handler('replace', true, $_tmp, '[dir]', 'resized') : smarty_modifier_replace($_tmp, '[dir]', 'resized')); ?>
" style="width: 338px; height: 132px;"></a>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>