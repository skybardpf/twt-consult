<?php /* Smarty version 2.6.25, created on 2013-08-22 13:43:34
         compiled from /home/leadert/webserver/twt-consult/www/site/views/header.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'replace', '/home/leadert/webserver/twt-consult/www/site/views/header.tpl', 95, false),array('modifier', 'trim', '/home/leadert/webserver/twt-consult/www/site/views/header.tpl', 96, false),)), $this); ?>
<div class="header<?php if ($this->_tpl_vars['page_content']['id'] == 1): ?> main<?php else: ?> inner<?php endif; ?>">
    <div class="blue"></div>
    <div class="header_inner">
        <div class="logo"><?php if ($this->_tpl_vars['page_content']['id'] != 1): ?><a href="/"><?php endif; ?><img alt="" title="" src="/public/site/img/logo.png"><?php if ($this->_tpl_vars['page_content']['id'] != 1): ?></a><?php endif; ?></div>
        <div class="top_menu">
            <table>
                <tr>
                    <td>
                        <table class="inner_table">
                            <tr>

                                <?php $this->assign('prev_match', false); ?>
                                
                                <?php $_from = $this->_tpl_vars['main_menu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['menu'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['menu']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['m']):
        $this->_foreach['menu']['iteration']++;
?>
                                    <?php if (! ( $this->_tpl_vars['request']['parr'][0] == $this->_tpl_vars['m']['url'] || $this->_tpl_vars['ctrlName'] == $this->_tpl_vars['m']['url'] || $this->_tpl_vars['current_url'] == $this->_tpl_vars['m']['url'] ) && ! $this->_tpl_vars['prev_match'] && $this->_tpl_vars['m']['url'] != 'requests' && ! ($this->_foreach['menu']['iteration'] <= 1)): ?>
										<td class="delimiter">|</td>
									<?php endif; ?>
                                    <?php if ($this->_tpl_vars['prev_match']): ?>
                                        <?php $this->assign('prev_match', false); ?>
                                    <?php endif; ?>
                                    <td<?php if ($this->_tpl_vars['m']['url'] == 'requests'): ?> class="zayavki-menu"<?php endif; ?><?php if ($this->_tpl_vars['request']['parr'][0] == $this->_tpl_vars['m']['url'] || $this->_tpl_vars['ctrlName'] == $this->_tpl_vars['m']['url'] || $this->_tpl_vars['current_url'] == $this->_tpl_vars['m']['url']): ?> class="active"<?php endif; ?><?php if (( $this->_tpl_vars['request']['parr'][0] == $this->_tpl_vars['m']['url'] || $this->_tpl_vars['ctrlName'] == $this->_tpl_vars['m']['url'] || $this->_tpl_vars['current_url'] == $this->_tpl_vars['m']['url'] ) || $this->_tpl_vars['m']['url'] == 'requests'): ?><?php $this->assign('prev_match', true); ?><?php endif; ?>><a href="/<?php echo $this->_tpl_vars['m']['url']; ?>
"><?php echo $this->_tpl_vars['m']['title']; ?>
</a></td>
                                <?php endforeach; endif; unset($_from); ?>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
        <div class="contacts">
            <a class="location" href="/services/price_list">
                <img alt="" title="" src="/public/site/img/header_pricelist.png">
                <span class="wrp">
					<span class="price">Прайс-лист</span>
                    <span class="bottom">посмотреть</span>
                </span>
            </a>
            <a class="earphones" href="#" id="call_back1">
                <img alt="" title="" src="/public/site/img/header_earphones.png">
                <span class="wrp">
                    <span class="code">+7 (495) </span>660-81-11
                    <span class="bottom">заказать обратный звонок</span>
                    <span id="div_call_back"></span>
                </span>
            </a>
			<?php if ($this->_tpl_vars['logged_site_user']): ?>
				<div class="lk logged_in">
					<img alt="" title="" src="/public/site/img/header_user.png">
					<span class="wrp">
						<span class="bottom">
							Добро пожаловать,<br><a href="/cabinet"><?php echo $this->_tpl_vars['logged_site_user']['name']; ?>
</a> | <a href="/logout">Выход</a>
						</span>
					</span>
				</div>
			<?php else: ?>
				<a class="lk" href="javascript:void(0);" data-auth="1" data-url="/checkauth">
					<img alt="" title="" src="/public/site/img/header_user.png">
					<span class="wrp">
						<span class="price">ЛИЧНЫЙ КАБИНЕТ</span>
						<span class="bottom">
							авторизация/регистрация
						</span>
					</span>
				</a>
			<?php endif; ?>
        </div>

    </div>
    <div class="main_menu">
        <div class="main_menu inner">

            <div class="layer1">
                <table>
                    <tr>
                        <?php $_from = $this->_tpl_vars['services']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['services'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['services']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['service']):
        $this->_foreach['services']['iteration']++;
?>
                            <td<?php if ($this->_tpl_vars['service_ids'][0] == $this->_tpl_vars['service']['id']): ?> class="active default"<?php endif; ?>>
                                    <div id="id<?php echo $this->_foreach['services']['iteration']; ?>
"<?php if (! $this->_tpl_vars['service']['children']): ?> class="no_arrowed"<?php endif; ?> >
                                        <a href="/services/<?php echo $this->_tpl_vars['service']['url']; ?>
"><?php echo $this->_tpl_vars['service']['title']; ?>
</a>
                                    </div>
                                                                                                                                            </td>
                        <?php endforeach; endif; unset($_from); ?>
                    </tr>
                </table>
            </div>

            <?php $_from = $this->_tpl_vars['services']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['services'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['services']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['service']):
        $this->_foreach['services']['iteration']++;
?>
                <?php if ($this->_tpl_vars['service']['children']): ?>
                        <div class="id<?php echo $this->_foreach['services']['iteration']; ?>
 layer2<?php $_from = $this->_tpl_vars['service']['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['s_children'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['s_children']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['s_child']):
        $this->_foreach['s_children']['iteration']++;
?><?php if (( $this->_tpl_vars['s_child']['id'] == $this->_tpl_vars['service_ids'][1] ) || ( $this->_tpl_vars['service_ids'][0] == $this->_tpl_vars['service']['id'] )): ?> default<?php endif; ?><?php endforeach; endif; unset($_from); ?>">
                            <table>
                                <tr>
                                <?php $_from = $this->_tpl_vars['service']['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['s_children'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['s_children']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['s_child']):
        $this->_foreach['s_children']['iteration']++;
?>
                                    <td class="imaged"><?php if ($this->_tpl_vars['s_child']['icon']): ?><img alt="" title="" src="<?php echo ((is_array($_tmp=$this->_tpl_vars['s_child']['icon'])) ? $this->_run_mod_handler('replace', true, $_tmp, '[dir]', 'small') : smarty_modifier_replace($_tmp, '[dir]', 'small')); ?>
"><?php endif; ?></td>
                                    <td<?php if ($this->_tpl_vars['service_ids'][1] == $this->_tpl_vars['s_child']['id']): ?> class="active default"<?php endif; ?><?php if ($this->_foreach['services']['iteration'] == 1 && ($this->_foreach['s_children']['iteration'] == $this->_foreach['s_children']['total'])): ?> style="width: 45%;"<?php endif; ?><?php if ($this->_foreach['services']['iteration'] == 3 && ($this->_foreach['s_children']['iteration'] == $this->_foreach['s_children']['total'])): ?> style="width: 30%;"<?php endif; ?>><div id="id<?php echo $this->_foreach['services']['iteration']; ?>
_<?php echo $this->_foreach['s_children']['iteration']; ?>
"><a href="/services/<?php echo ((is_array($_tmp=$this->_tpl_vars['s_child']['url'])) ? $this->_run_mod_handler('trim', true, $_tmp) : trim($_tmp)); ?>
"><?php echo $this->_tpl_vars['s_child']['title']; ?>
</a></div></td>
                                    <?php if ($this->_foreach['services']['iteration'] == 2 && $this->_foreach['s_children']['iteration'] == 4): ?>
                                        </tr>
                                        <tr>
                                    <?php endif; ?>
                                    <?php if ($this->_foreach['services']['iteration'] == 3 && $this->_foreach['s_children']['iteration'] == 4): ?>
                                        </tr>
                                        <tr>
                                    <?php endif; ?>
                                    <?php if ($this->_foreach['services']['iteration'] == 3 && $this->_foreach['s_children']['iteration'] == 8): ?>
                                        </tr>
                                    </table>
                                    <table>
                                        <tr>
                                    <?php endif; ?>
                                                                       <?php if ($this->_foreach['services']['iteration'] == 1 && $this->_foreach['s_children']['iteration'] == 3): ?>
                                    </tr>
                                    </table>
                                    <table>
                                    <tr>
                                    <?php endif; ?>
                                <?php endforeach; endif; unset($_from); ?>
                                </tr>
                            </table>
                        </div>
                <?php endif; ?>
            <?php endforeach; endif; unset($_from); ?>

            


           
           

        </div>
    </div>
</div>