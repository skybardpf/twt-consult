<?php
define('ROOT_PATH', dirname(__FILE__).'/');
define('SMARTY_DIR', ROOT_PATH.'zf/third-party/smarty/libs/');
require_once file_exists(ROOT_PATH.'.zf_compiled/requirer.php') ? ROOT_PATH.'.zf_compiled/requirer.php' : ROOT_PATH.'zf/requirer.php';
zf::run_app();
?>