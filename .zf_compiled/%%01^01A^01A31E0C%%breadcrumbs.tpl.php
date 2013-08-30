<?php /* Smarty version 2.6.25, created on 2013-08-22 13:47:29
         compiled from /home/leadert/webserver/twt-consult/www/site/views/breadcrumbs.tpl */ ?>
<div class="breadcrumbs">
    <?php $_from = $this->_tpl_vars['bread_crumbs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['bc'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['bc']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['m']):
        $this->_foreach['bc']['iteration']++;
?>
        <?php if ($this->_tpl_vars['key'] == ""): ?>
        <em><?php echo $this->_tpl_vars['m']; ?>
</em><?php if (! ($this->_foreach['bc']['iteration'] == $this->_foreach['bc']['total'])): ?> / <?php endif; ?>
            <?php else: ?>

        <a <?php if (! in_array ( $this->_tpl_vars['key'] , array ( '/orders/' , '/works/' ) )): ?>href="<?php echo $this->_tpl_vars['key']; ?>
"<?php endif; ?>><?php echo $this->_tpl_vars['m']; ?>
</a><?php if (! ($this->_foreach['bc']['iteration'] == $this->_foreach['bc']['total'])): ?> / <?php endif; ?>

        <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?>
</div>