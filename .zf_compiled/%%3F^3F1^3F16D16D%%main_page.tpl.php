<?php /* Smarty version 2.6.25, created on 2013-08-22 13:43:34
         compiled from /home/leadert/webserver/twt-consult/www/site/views/main_page.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'replace', '/home/leadert/webserver/twt-consult/www/site/views/main_page.tpl', 70, false),)), $this); ?>
    
        
        
<div class="main_content_slider">
    <div class="main_slider">

        <div class="con">
            <div class="monitor">
                <div class="cont">
                    <a href="/<?php echo $this->_tpl_vars['promo_banners'][0]['url']; ?>
"><img alt="" title="" style="width: 660px; height: 398px;" src="<?php echo ((is_array($_tmp=$this->_tpl_vars['promo_banners'][0]['image'])) ? $this->_run_mod_handler('replace', true, $_tmp, '[dir]', 'original') : smarty_modifier_replace($_tmp, '[dir]', 'original')); ?>
"></a>
                </div>
            </div>

            <?php if ($this->_tpl_vars['banners']): ?>
                <div id="program">
                    <ul>
                        <?php if ($this->_tpl_vars['banners']['top']): ?>
                            <li class="tv_program_li">
                                <a href="/<?php echo $this->_tpl_vars['banners']['top']['url']; ?>
"><img alt="" title="" src="<?php echo ((is_array($_tmp=$this->_tpl_vars['banners']['top']['image'])) ? $this->_run_mod_handler('replace', true, $_tmp, '[dir]', 'resized') : smarty_modifier_replace($_tmp, '[dir]', 'resized')); ?>
" style="width: 338px; height: 132px;"></a>
                            </li>
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['banners']['middle']): ?>
                            <li class="tv_program_li">
                                <a href="/<?php echo $this->_tpl_vars['banners']['middle']['url']; ?>
"><img alt="" title="" src="<?php echo ((is_array($_tmp=$this->_tpl_vars['banners']['middle']['image'])) ? $this->_run_mod_handler('replace', true, $_tmp, '[dir]', 'resized') : smarty_modifier_replace($_tmp, '[dir]', 'resized')); ?>
" style="width: 338px; height: 132px;"></a>
                            </li>
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['banners']['bottom']): ?>
                            <li class="tv_program_li">
                                <a href="/<?php echo $this->_tpl_vars['banners']['bottom']['url']; ?>
"><img alt="" title="" src="<?php echo ((is_array($_tmp=$this->_tpl_vars['banners']['bottom']['image'])) ? $this->_run_mod_handler('replace', true, $_tmp, '[dir]', 'resized') : smarty_modifier_replace($_tmp, '[dir]', 'resized')); ?>
" style="width: 338px; height: 132px;"></a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <div class="clear"></div>
        </div>
    </div>
</div>

                                                                    <div class="company_info">
                <div class="main_descr">
                  <?php echo $this->_tpl_vars['page_content']['content']; ?>

                </div>
                <div class="main_geografy">
                    <div class="descr_title">
                                                    Открываем компанию за <br>один день в:
                    </div>
                                        <table>
                        <?php $_from = $this->_tpl_vars['countries']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['countries'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['countries']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['country']):
        $this->_foreach['countries']['iteration']++;
?>
                            
                                    <tr>
                                        <td><img alt="" title="" src="/public/site/img/arrow-<?php echo $this->_tpl_vars['country']['quotation']; ?>
.png"></td>
                                        <td><a href="/countries/<?php if ($this->_tpl_vars['country']['url']): ?><?php echo $this->_tpl_vars['country']['url']; ?>
<?php else: ?>id/<?php echo $this->_tpl_vars['country']['id']; ?>
<?php endif; ?>"><img alt="" title="" src="<?php echo ((is_array($_tmp=$this->_tpl_vars['country']['flag'])) ? $this->_run_mod_handler('replace', true, $_tmp, '[dir]', 'small') : smarty_modifier_replace($_tmp, '[dir]', 'small')); ?>
"></a></td>
                                        <td><a href="/countries/<?php if ($this->_tpl_vars['country']['url']): ?><?php echo $this->_tpl_vars['country']['url']; ?>
<?php else: ?>id/<?php echo $this->_tpl_vars['country']['id']; ?>
<?php endif; ?>"><?php echo $this->_tpl_vars['country']['title']; ?>
</a></td>
                                        <td style="width: 60px;"><span class="price"><?php echo $this->_tpl_vars['country']['price']; ?>
</span></td>
                                    </tr>



                                                    <?php endforeach; endif; unset($_from); ?></table>

                                                               <br/><br/>
                    <a href="/calc">Страховой калькулятор</a>
                </div>
            </div>



                


        
    