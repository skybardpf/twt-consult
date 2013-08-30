<?php
/**
 * This file contains base class for all classes in zFramework which need to load YAML configuration files.
 *
 * @version 1.0, SVN: $Id: confloader.class.php 27 2009-09-01 22:32:28Z zavter $
 * @author Vladimir Fofana (zavter@gmail.com)
 * @category Framework
 * @package zFramework
 * @subpackage Core
 */

/**
 * Base class for all classes in zFramework which need to load YAML configuration files.
 *
 * @category Framework
 * @package zFramework
 * @subpackage Core
 */
class ConfLoader
{
	/**
	 * Stores loaded configuration
	 *
	 * @var mixed
	 */
	public $conf;

	/**
	 * Indicates whether configuration file has been compiled
	 *
	 * @var integer
	 */
	public $has_been_compiled;

	/**
	 * Loads configuration into $this->conf from the file name specified.
	 *
	 * @param string $fileName file name with path where configuration in YAML format stored.
	 * @return true
	 */
	public function loadConf()
	{
		$args     = func_get_args();
		$fileName = array_shift($args);

		if (count($args)) {
			$dont_call_OnBeforeCompile = array_shift($args);
			if (count($args)) {
				$call_parent_OnBeforeCompile = array_shift($args);
			} else {
				$call_parent_OnBeforeCompile = 0;
			}
		} else {
			$dont_call_OnBeforeCompile = 0;
			$call_parent_OnBeforeCompile = 0;
		}
		$prefix   = (isset($this->db) && is_callable(array($this->db, 'getPrefix')) ? $this->db->getPrefix() : '');
		$prefix  .= (!empty(zf::$instance) && !empty(zf::$instance->app->run_at)) ? zf::$instance->app->run_at : '';
		$compiled = ROOT_PATH.'.zf_compiled/'.md5($prefix.$fileName.filemtime($fileName)).'.conf.php';

		if (file_exists($compiled) && !defined('NO_COMPILE')) {
			$this->has_been_compiled = 0;
			require $compiled;

			return $conf;
		} elseif (file_exists($compiled)) {
            unlink($compiled);
        }

		require_once ROOT_PATH.'zf/third-party/Horde/Yaml/Dumper.php';
		require_once ROOT_PATH.'zf/third-party/Horde/Yaml/Exception.php';
		require_once ROOT_PATH.'zf/third-party/Horde/Yaml/Loader.php';
		require_once ROOT_PATH.'zf/third-party/Horde/Yaml/Node.php';
		require_once ROOT_PATH.'zf/third-party/Horde/Yaml.php';

		//test Spyc
		require_once ROOT_PATH.'zf/third-party/Horde/spyc.php';

		if (!defined('USE_SPYC')) {
			$yaml = new Horde_Yaml();
			$conf = $yaml->loadFile($fileName);
		} else {
			$spyc = new Spyc();
			$conf = $spyc->loadFile($fileName);
		}
		$errors = array();
		if (!$dont_call_OnBeforeCompile) {
			$call_parent_OnBeforeCompile
			? parent::OnBeforeCompile($conf, $errors)
			: $this->OnBeforeCompile($conf, $errors);
		}
		if ($errors) {
			misc::file_safe_put(
			ROOT_PATH.'.zf_compiled/errors.log',
			file_get_contents(ROOT_PATH.'.zf_compiled/errors.log')."\r\n".implode("\r\n", $errors)
			);
		}
		if (!empty($conf['dont_compile'])) return $conf;
		misc::file_safe_put($compiled, "<?php\r\n\$conf = ".var_export($conf, 1).";\r\n?>");
/*		$cList  = file_exists(ROOT_PATH.'.zf_compiled/compiled.list') ? file_get_contents(ROOT_PATH.'.zf_compiled/compiled.list') : '';
		if ($cList && strpos($cList, $fileName) !== false) {
			$fileName = str_replace('\\', '/', $fileName);
			if (preg_match("#{$fileName}: (.*)#", $cList, $out)) {
				$oldFname = trim($out[1]);
				$cList    = str_replace($oldFname, $compiled, $cList);
//				if (file_exists($oldFname)) unlink($oldFname);
			}
		} else {
			if ($cList) $cList .= "\r\n";
			$cList .= "$fileName: $compiled";
		}
		misc::file_safe_put(ROOT_PATH.'.zf_compiled/compiled.list', $cList, isset($oldFname) ? $oldFname : '');*/
		$this->has_been_compiled = 1;
		return $conf;
	}

	protected function OnBeforeCompile(&$conf)
	{

	}
}
?>