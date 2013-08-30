<?php
class CMS_SiteApp extends zfApp
{
	public function getModelConfFileName($modName, $ctrlName)
	{
		return ROOT_PATH."site/conf/$modName/$modName.mod.yml";
	}
	
	public function getModelClassFileName($modName, $ctrlName)
	{
		return file_exists(ROOT_PATH."cms/modules/$ctrlName/$modName.mod.php")
			? ROOT_PATH."cms/modules/$ctrlName/$modName.mod.php"
			: ROOT_PATH."cms/modules/$modName/$modName.mod.php";
	}
}
?>
