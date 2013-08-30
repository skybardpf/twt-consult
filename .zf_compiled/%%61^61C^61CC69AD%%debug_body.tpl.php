<?php /* Smarty version 2.6.25, created on 2013-08-22 14:18:49
         compiled from /home/leadert/webserver/twt-consult/www/zf/views/debug_body.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'replace', '/home/leadert/webserver/twt-consult/www/zf/views/debug_body.tpl', 25, false),array('modifier', 'escape', '/home/leadert/webserver/twt-consult/www/zf/views/debug_body.tpl', 38, false),array('modifier', 'string_format', '/home/leadert/webserver/twt-consult/www/zf/views/debug_body.tpl', 41, false),array('modifier', 'debug_print_var', '/home/leadert/webserver/twt-consult/www/zf/views/debug_body.tpl', 61, false),array('function', 'debug_get', '/home/leadert/webserver/twt-consult/www/zf/views/debug_body.tpl', 28, false),array('function', 'assign_debug_info', '/home/leadert/webserver/twt-consult/www/zf/views/debug_body.tpl', 33, false),)), $this); ?>
<div id="debugDiv">
	<?php $_from = $this->_tpl_vars['zfDebugData']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['frch'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['frch']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['key'] => $this->_tpl_vars['item']):
        $this->_foreach['frch']['iteration']++;
?>
		<div class="debug_item">
				<div class="debug_title_div" id="debug_div_<?php echo $this->_tpl_vars['key']; ?>
">
					<span class="debug_type <?php echo $this->_tpl_vars['item']['type']; ?>
"><?php echo $this->_tpl_vars['item']['type']; ?>
:</span>
					<span class="debug_title">
	<?php if ($this->_tpl_vars['item']['type'] == 'sql' || $this->_tpl_vars['item']['type'] == 'sql_error'): ?>
		<?php echo $this->_tpl_vars['item']['body']['raw_query']; ?>

	<?php elseif ($this->_tpl_vars['item']['type'] == 'sphinx' && is_array ( $this->_tpl_vars['item']['body'] )): ?>
		Words:
		<?php $_from = $this->_tpl_vars['item']['body']['words']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['sphinx'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['sphinx']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['v']):
        $this->_foreach['sphinx']['iteration']++;
?>
			<?php echo $this->_tpl_vars['k']; ?>
<?php if (! ($this->_foreach['sphinx']['iteration'] == $this->_foreach['sphinx']['total'])): ?>, <?php endif; ?>
		<?php endforeach; endif; unset($_from); ?>
		<?php if ($this->_tpl_vars['item']['body']['error']): ?>Error: <span style="color:red;"><?php echo $this->_tpl_vars['item']['body']['error']; ?>
</span><?php endif; ?>
		<?php if ($this->_tpl_vars['item']['body']['warning']): ?><span style="color:red;"><?php echo $this->_tpl_vars['item']['body']['warning']; ?>
</span><?php endif; ?>
	<?php elseif (is_array ( $this->_tpl_vars['item']['body'] )): ?>
		Array
	<?php else: ?>
		<?php echo $this->_tpl_vars['item']['body']; ?>

	<?php endif; ?>
					</span><br />
					<span class="debug_in">in file</span>
					<span class="debug_file"><?php echo $this->_tpl_vars['item']['caller']['file']; ?>
</span>
					<span class="debug_at">at line</span>
					<a class="debug_line" href="#" title="Code sniplet|<?php echo ((is_array($_tmp=$this->_tpl_vars['item']['code_sniplet'])) ? $this->_run_mod_handler('replace', true, $_tmp, "\n", "|") : smarty_modifier_replace($_tmp, "\n", "|")); ?>
"><?php echo $this->_tpl_vars['item']['caller']['line']; ?>
</a>
				</div>
				<?php if (! is_array ( $this->_tpl_vars['item']['body'] )): ?><?php else: ?>
				<div class="debug_body" id="debug_div_<?php echo $this->_tpl_vars['key']; ?>
_body"><?php echo smarty_function_debug_get(array('var' => $this->_tpl_vars['item']['body']), $this);?>
</div>
				<?php endif; ?>
		</div>
	<?php endforeach; endif; unset($_from); ?>
	<?php echo smarty_function_assign_debug_info(array(), $this);?>

	<div class="debug_item">
	<?php unset($this->_sections['templates']);
$this->_sections['templates']['name'] = 'templates';
$this->_sections['templates']['loop'] = is_array($_loop=$this->_tpl_vars['_debug_tpls']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['templates']['show'] = true;
$this->_sections['templates']['max'] = $this->_sections['templates']['loop'];
$this->_sections['templates']['step'] = 1;
$this->_sections['templates']['start'] = $this->_sections['templates']['step'] > 0 ? 0 : $this->_sections['templates']['loop']-1;
if ($this->_sections['templates']['show']) {
    $this->_sections['templates']['total'] = $this->_sections['templates']['loop'];
    if ($this->_sections['templates']['total'] == 0)
        $this->_sections['templates']['show'] = false;
} else
    $this->_sections['templates']['total'] = 0;
if ($this->_sections['templates']['show']):

            for ($this->_sections['templates']['index'] = $this->_sections['templates']['start'], $this->_sections['templates']['iteration'] = 1;
                 $this->_sections['templates']['iteration'] <= $this->_sections['templates']['total'];
                 $this->_sections['templates']['index'] += $this->_sections['templates']['step'], $this->_sections['templates']['iteration']++):
$this->_sections['templates']['rownum'] = $this->_sections['templates']['iteration'];
$this->_sections['templates']['index_prev'] = $this->_sections['templates']['index'] - $this->_sections['templates']['step'];
$this->_sections['templates']['index_next'] = $this->_sections['templates']['index'] + $this->_sections['templates']['step'];
$this->_sections['templates']['first']      = ($this->_sections['templates']['iteration'] == 1);
$this->_sections['templates']['last']       = ($this->_sections['templates']['iteration'] == $this->_sections['templates']['total']);
?>
	    <?php unset($this->_sections['indent']);
$this->_sections['indent']['name'] = 'indent';
$this->_sections['indent']['loop'] = is_array($_loop=$this->_tpl_vars['_debug_tpls'][$this->_sections['templates']['index']]['depth']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['indent']['show'] = true;
$this->_sections['indent']['max'] = $this->_sections['indent']['loop'];
$this->_sections['indent']['step'] = 1;
$this->_sections['indent']['start'] = $this->_sections['indent']['step'] > 0 ? 0 : $this->_sections['indent']['loop']-1;
if ($this->_sections['indent']['show']) {
    $this->_sections['indent']['total'] = $this->_sections['indent']['loop'];
    if ($this->_sections['indent']['total'] == 0)
        $this->_sections['indent']['show'] = false;
} else
    $this->_sections['indent']['total'] = 0;
if ($this->_sections['indent']['show']):

            for ($this->_sections['indent']['index'] = $this->_sections['indent']['start'], $this->_sections['indent']['iteration'] = 1;
                 $this->_sections['indent']['iteration'] <= $this->_sections['indent']['total'];
                 $this->_sections['indent']['index'] += $this->_sections['indent']['step'], $this->_sections['indent']['iteration']++):
$this->_sections['indent']['rownum'] = $this->_sections['indent']['iteration'];
$this->_sections['indent']['index_prev'] = $this->_sections['indent']['index'] - $this->_sections['indent']['step'];
$this->_sections['indent']['index_next'] = $this->_sections['indent']['index'] + $this->_sections['indent']['step'];
$this->_sections['indent']['first']      = ($this->_sections['indent']['iteration'] == 1);
$this->_sections['indent']['last']       = ($this->_sections['indent']['iteration'] == $this->_sections['indent']['total']);
?>&nbsp;&nbsp;&nbsp;<?php endfor; endif; ?>
	    <font color=<?php if ($this->_tpl_vars['_debug_tpls'][$this->_sections['templates']['index']]['type'] == 'template'): ?>brown<?php elseif ($this->_tpl_vars['_debug_tpls'][$this->_sections['templates']['index']]['type'] == 'insert'): ?>black<?php else: ?>green<?php endif; ?>>
	        <?php echo ((is_array($_tmp=$this->_tpl_vars['_debug_tpls'][$this->_sections['templates']['index']]['filename'])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
</font>
	    <?php if (isset ( $this->_tpl_vars['_debug_tpls'][$this->_sections['templates']['index']]['exec_time'] )): ?>
	        <span class="exectime">
	        (<?php echo ((is_array($_tmp=$this->_tpl_vars['_debug_tpls'][$this->_sections['templates']['index']]['exec_time'])) ? $this->_run_mod_handler('string_format', true, $_tmp, "%.5f") : smarty_modifier_string_format($_tmp, "%.5f")); ?>
)
	        <?php if ($this->_sections['templates']['index'] == 0): ?>(total)<?php endif; ?>
	        </span>
	    <?php endif; ?>
	    <br />
	<?php endfor; else: ?>
	    no templates included in Smarty
	<?php endif; ?>
	</div>
	
	<?php unset($this->_sections['vars']);
$this->_sections['vars']['name'] = 'vars';
$this->_sections['vars']['loop'] = is_array($_loop=$this->_tpl_vars['_debug_keys']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['vars']['show'] = true;
$this->_sections['vars']['max'] = $this->_sections['vars']['loop'];
$this->_sections['vars']['step'] = 1;
$this->_sections['vars']['start'] = $this->_sections['vars']['step'] > 0 ? 0 : $this->_sections['vars']['loop']-1;
if ($this->_sections['vars']['show']) {
    $this->_sections['vars']['total'] = $this->_sections['vars']['loop'];
    if ($this->_sections['vars']['total'] == 0)
        $this->_sections['vars']['show'] = false;
} else
    $this->_sections['vars']['total'] = 0;
if ($this->_sections['vars']['show']):

            for ($this->_sections['vars']['index'] = $this->_sections['vars']['start'], $this->_sections['vars']['iteration'] = 1;
                 $this->_sections['vars']['iteration'] <= $this->_sections['vars']['total'];
                 $this->_sections['vars']['index'] += $this->_sections['vars']['step'], $this->_sections['vars']['iteration']++):
$this->_sections['vars']['rownum'] = $this->_sections['vars']['iteration'];
$this->_sections['vars']['index_prev'] = $this->_sections['vars']['index'] - $this->_sections['vars']['step'];
$this->_sections['vars']['index_next'] = $this->_sections['vars']['index'] + $this->_sections['vars']['step'];
$this->_sections['vars']['first']      = ($this->_sections['vars']['iteration'] == 1);
$this->_sections['vars']['last']       = ($this->_sections['vars']['iteration'] == $this->_sections['vars']['total']);
?>
		<?php if ("$".($this->_tpl_vars['_debug_keys'][$this->_sections['vars']['index']]) != '$zfDebugData'): ?>
	    <div class="debug_item">
	        <div class="debug_title_div" id="debug_div_smary_vars_<?php echo $this->_sections['vars']['index']; ?>
">
	        <span class="debug_type">Smarty vars: </span>
	        <span class="debug_title">
	        	{$<?php echo ((is_array($_tmp=$this->_tpl_vars['_debug_keys'][$this->_sections['vars']['index']])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
}
	        </span>
	        </div>
	        <div class="debug_body" id="debug_div_smary_vars_<?php echo $this->_sections['vars']['index']; ?>
_body">
	        	<blockquote><?php echo smarty_modifier_debug_print_var($this->_tpl_vars['_debug_vals'][$this->_sections['vars']['index']]); ?>
</blockquote>
	        </div>
	    </div>
	    <?php endif; ?>
	<?php endfor; else: ?>
	    <div class="debug_item">no template variables assigned in Smarty</div>
	<?php endif; ?>
	
	<?php unset($this->_sections['config_vars']);
$this->_sections['config_vars']['name'] = 'config_vars';
$this->_sections['config_vars']['loop'] = is_array($_loop=$this->_tpl_vars['_debug_config_keys']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['config_vars']['show'] = true;
$this->_sections['config_vars']['max'] = $this->_sections['config_vars']['loop'];
$this->_sections['config_vars']['step'] = 1;
$this->_sections['config_vars']['start'] = $this->_sections['config_vars']['step'] > 0 ? 0 : $this->_sections['config_vars']['loop']-1;
if ($this->_sections['config_vars']['show']) {
    $this->_sections['config_vars']['total'] = $this->_sections['config_vars']['loop'];
    if ($this->_sections['config_vars']['total'] == 0)
        $this->_sections['config_vars']['show'] = false;
} else
    $this->_sections['config_vars']['total'] = 0;
if ($this->_sections['config_vars']['show']):

            for ($this->_sections['config_vars']['index'] = $this->_sections['config_vars']['start'], $this->_sections['config_vars']['iteration'] = 1;
                 $this->_sections['config_vars']['iteration'] <= $this->_sections['config_vars']['total'];
                 $this->_sections['config_vars']['index'] += $this->_sections['config_vars']['step'], $this->_sections['config_vars']['iteration']++):
$this->_sections['config_vars']['rownum'] = $this->_sections['config_vars']['iteration'];
$this->_sections['config_vars']['index_prev'] = $this->_sections['config_vars']['index'] - $this->_sections['config_vars']['step'];
$this->_sections['config_vars']['index_next'] = $this->_sections['config_vars']['index'] + $this->_sections['config_vars']['step'];
$this->_sections['config_vars']['first']      = ($this->_sections['config_vars']['iteration'] == 1);
$this->_sections['config_vars']['last']       = ($this->_sections['config_vars']['iteration'] == $this->_sections['config_vars']['total']);
?>
	    <div class="debug_item">
	        <div class="debug_title_div" id="debug_div_smary_config_vars_<?php echo $this->_sections['config_vars']['index']; ?>
">
	        <span class="debug_type">Smarty config vars: </span>
	        <span class="debug_title">
	        	{#<?php echo ((is_array($_tmp=$this->_tpl_vars['_debug_config_keys'][$this->_sections['config_vars']['index']])) ? $this->_run_mod_handler('escape', true, $_tmp, 'html') : smarty_modifier_escape($_tmp, 'html')); ?>
#}
	        </span>
	        </div>
	        <div class="debug_body" id="debug_div_smary_config_vars_<?php echo $this->_sections['config_vars']['index']; ?>
_body">
	        	<blockquote><?php echo smarty_modifier_debug_print_var($this->_tpl_vars['_debug_config_vals'][$this->_sections['config_vars']['index']]); ?>
</blockquote>
	        </div>
	    </div>
	<?php endfor; else: ?>
	    <div class="debug_item">no config vars assigned in Smarty</div>
	<?php endif; ?>
	</div>