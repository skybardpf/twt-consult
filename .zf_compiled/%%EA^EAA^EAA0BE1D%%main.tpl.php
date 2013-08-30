<?php /* Smarty version 2.6.25, created on 2013-08-22 13:43:33
         compiled from /home/leadert/webserver/twt-consult/www/site/views/main.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'default', '/home/leadert/webserver/twt-consult/www/site/views/main.tpl', 5, false),array('modifier', 'json_encode', '/home/leadert/webserver/twt-consult/www/site/views/main.tpl', 29, false),array('function', 'loadview', '/home/leadert/webserver/twt-consult/www/site/views/main.tpl', 42, false),)), $this); ?>
<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title><?php echo ((is_array($_tmp=@$this->_tpl_vars['meta']['title'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['title']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['title'])); ?>
</title>
	<meta name="keywords" content="<?php echo $this->_tpl_vars['meta']['keywords']; ?>
">
	<meta name="description" content="<?php echo $this->_tpl_vars['meta']['description']; ?>
">
    <meta name="author" content="<?php echo $this->_tpl_vars['meta']['author']; ?>
">
    <?php if ($this->_tpl_vars['meta']['meta_additional']): ?>
        <?php echo $this->_tpl_vars['meta']['meta_additional']; ?>

    <?php endif; ?>
            
    <link rel="stylesheet" href="/public/site/css/handheld.css" media="handheld,only screen and (max-device-width:480px)"/>
	<!-- CSS -->
<?php $_from = $this->_tpl_vars['pageCSS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
	<link href='<?php echo $this->_tpl_vars['item']; ?>
' rel='stylesheet' type='text/css'>
<?php endforeach; endif; unset($_from); ?>

    <link href='http://fonts.googleapis.com/css?family=Ubuntu:500&amp;subset=latin,cyrillic-ext,latin-ext,cyrillic' rel='stylesheet' type='text/css'>


	<!-- JS -->
	<script type="text/javascript">
		var root_url = '<?php echo $this->_tpl_vars['root_url']; ?>
';
		var ctrlName = '<?php echo $this->_tpl_vars['ctrlName']; ?>
';
        var siteuser = <?php if (! $this->_tpl_vars['logged_site_user']): ?><?php echo '{}'; ?>
<?php else: ?><?php echo json_encode($this->_tpl_vars['logged_site_user']); ?>
<?php endif; ?>;
	</script>
<?php $_from = $this->_tpl_vars['pageJS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
	<script src='<?php echo $this->_tpl_vars['item']; ?>
' type='text/javascript'></script>
<?php endforeach; endif; unset($_from); ?>
	<!--zf::debug:head-->
</head>    

<body>

<div class="wrapper_outer">
    <div class="wrapper_inner">

        <?php echo smarty_function_loadview(array('name' => 'header'), $this);?>


        <div class="content">

        <?php if ($this->_tpl_vars['page_content']['id'] == 1): ?>
            <?php echo smarty_function_loadview(array('name' => 'main_page'), $this);?>

        <?php else: ?>

            <?php if ($this->_tpl_vars['page_content']['content']): ?>
                <div class="content_static">
                    <?php echo smarty_function_loadview(array('name' => 'breadcrumbs'), $this);?>

                    
                    <?php echo smarty_function_loadview(array('name' => 'banners'), $this);?>

                    <div class="static_text">
                        <h2><?php echo $this->_tpl_vars['page_content']['title']; ?>
</h2>
                        <?php echo $this->_tpl_vars['page_content']['content']; ?>


                        <?php echo smarty_function_loadview(array('name' => 'form_urid'), $this);?>


                        <?php echo smarty_function_loadview(array('name' => 'form_schet'), $this);?>


                        <?php echo smarty_function_loadview(array('name' => 'form_transport'), $this);?>

                    </div>

                </div>
            <?php else: ?>
                <div class="content_inner">
                    <?php echo smarty_function_loadview(array('name' => 'breadcrumbs'), $this);?>

                                        <?php if ($this->_tpl_vars['ctrlName'] == 'services' && $this->_tpl_vars['request']['parr'][0] != 'price_list'): ?>
                        <?php echo smarty_function_loadview(array('name' => 'inner_menu'), $this);?>

                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['ctrlName'] != 'cabinet'): ?><?php echo smarty_function_loadview(array('name' => 'banners'), $this);?>
<?php endif; ?>
                    <?php echo $this->_tpl_vars['content']; ?>

                    <div class="clear"></div>

                    <?php echo smarty_function_loadview(array('name' => 'form_urid'), $this);?>


                    <?php echo smarty_function_loadview(array('name' => 'form_schet'), $this);?>


                    <?php echo smarty_function_loadview(array('name' => 'form_transport'), $this);?>


                </div>
            <?php endif; ?>

        <?php endif; ?>


        </div>

        <div class="clear"></div>

        <?php echo smarty_function_loadview(array('name' => 'footer'), $this);?>


    </div>
</div>

    <!--zf::debug:body-->
</body>
</html>