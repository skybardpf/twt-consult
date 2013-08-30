<?php /* Smarty version 2.6.25, created on 2013-08-22 13:43:34
         compiled from /home/leadert/webserver/twt-consult/www/site/views/footer.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', '/home/leadert/webserver/twt-consult/www/site/views/footer.tpl', 22, false),)), $this); ?>
<div class="footer<?php if ($this->_tpl_vars['page_content']['id'] != 1): ?> inner<?php endif; ?>">
    <div class="footer_inner">
        
        <div class="footer_contacts<?php if ($this->_tpl_vars['page_content']['id'] != 1): ?> inner<?php endif; ?>">
            <div class="copyright">
                © 2012 - <?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%Y") : smarty_modifier_date_format($_tmp, "%Y")); ?>
. TWT Consult<br>
                Горячая линия +7 (495) 660-81-11<br>
                            </div>
            <div class="counters">
                <?php echo $this->_tpl_vars['settings']['counters']; ?>

            </div>
            <div class="search">
                <form action="/search" method="get" id="search_form">
                    <label class="infield" style="display: block; ">поиск по сайту</label>
                    <input type="text" name="q">
                    <input type="image" src="/public/site/img/search.png" alt="search" title="search">
                </form>
                <div class="search_sample" id="search_sample">
                    Например: <span>страхование груза</span>
                                    </div>
            </div>
            <div class="our_logo">
	            <div>
		            <a href="http://artektiv.ru/" target="_blank">Разработка сайта</a>
	            </div>
                <a href="http://artektiv.ru/" target="_blank"><img alt="" title="" src="/public/site/img/art_logo.png"></a>

            </div>

        </div>
    </div>
</div>