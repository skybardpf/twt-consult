<?php
/**
 * This file requires all required files for run zFramework applications.
 *
 * @version 1.0, SVN: $Id: requirer.php 42 2009-09-08 15:06:04Z zavter $
 * @author Vladimir Fofana (zavter@gmail.com)
 * @category Framework
 * @package zFramework
 * @subpackage Core
 */
require_once ROOT_PATH.'zf/core/cacher/cacher.interface.php';
require_once ROOT_PATH.'zf/core/cacher/cacher_engines/memcache.adapter.php';
require_once ROOT_PATH.'zf/core/cacher/cacher_engines/filecache.adapter.php';
require_once ROOT_PATH.'zf/core/cacher.class.php';
require_once ROOT_PATH.'zf/core/confloader.class.php';
require_once ROOT_PATH.'zf/core/db/db.class.php';
require_once ROOT_PATH.'zf/core/request.class.php';
require_once ROOT_PATH.'zf/core/session.class.php';
require_once ROOT_PATH.'zf/core/zf.class.php';
require_once ROOT_PATH.'zf/core/zfapp.class.php';
require_once ROOT_PATH.'zf/core/misc.class.php';
require_once ROOT_PATH.'zf/core/lang.class.php';
require_once ROOT_PATH.'zf/core/image.class.php';
require_once ROOT_PATH.'zf/core/debug.class.php';
require_once ROOT_PATH.'zf/core/model.class.php';
require_once ROOT_PATH.'zf/core/controller.class.php';
require_once ROOT_PATH.'zf/third-party/smarty/libs/Smarty.class.php';
require_once ROOT_PATH.'zf/core/form.class.php';

require_once ROOT_PATH.'zf/core/page/basepage.class.php';
require_once ROOT_PATH.'zf/core/page/page.interface.php';
require_once ROOT_PATH.'zf/core/page/smartypage.class.php';
require_once ROOT_PATH.'zf/core/page/nativepage.class.php';
require_once ROOT_PATH.'zf/advanced/advanced_controller.class.php';
require_once ROOT_PATH.'zf/advanced/advanced_model.class.php';
require_once ROOT_PATH.'zf/third-party/packer/class.JavaScriptPacker.php';

//zf::prepare();

if(!function_exists('gettext')) {
    function gettext($message) {
        return $message;
    }
}
if(!function_exists('_')) {
    function _($message) {
        return $message;
    }
}
?>