<?php
class ImagesModel extends CMS_Model
{
	protected $fModelName = '';
    protected $valuesConf = array();
	public function __construct($ctrlName, $modName, $ctrl, $db = NULL, $directory = '')
	{
		parent::__construct($ctrlName, $modName, $ctrl, $db, $directory);
		if (!empty($this->conf['valuesConf'])) $this->valuesConf = $this->conf['valuesConf'];
	}

	public function getFields($tableName, $actionOrFields)
	{
		$ret = parent::getFields($tableName, $actionOrFields);
		if (isset($ret['image'])) {
			$ret['image']['dirs'] = !empty($ret['image']['icon']) ? 
				array_merge(
					array('icon' => $ret['image']['icon']),
					$this->conf['tables'][$tableName]['dirs'][$this->fModelName ? $this->fModelName : $this->ctrl->model]
				) : 
				$this->conf['tables'][$tableName]['dirs'][$this->fModelName ? $this->fModelName : $this->ctrl->model];
		}
		return $ret;
	}
	
	public function setFmodelName($fModelName)
	{
		$this->fModelName = $fModelName;
	}
	
	public function Delete($tableName, $cond, $fModelName = '')
	{
		if ($fModelName) $this->fModelName = $fModelName;
		$images = $this->GetList($tableName, array('id', 'image'), $cond);
		if (!$images) return 1;
		$imageField = misc::get($this->getFields($tableName, array('image')), 'image');
		foreach ($images as $image) {
			$this->deleteFile($image['image'], $imageField);
			parent::Delete($tableName, $image['id']);
		}
		return 1;
	}
    
    protected function uploadFiles($tableName, $data)
    {
        foreach ($this->files as $fieldName => $file) {
            if (!empty($this->data[$fieldName])) {
                AdvancedModel::deleteFile(ltrim($this->data[$fieldName], '/'), $file['zf']);
            }

            $dir     = AdvancedModel::getPath(!empty($data['model']) ? $data['model'] : $tableName, $file);
            $dirName = str_replace('[dir]', 'original', $dir);
            
            $file_clean = AdvancedModel::getFileName($file, $dirName);
            
            $fname    = $dir.$file_clean;
            $fileName = $dirName.$file_clean;
            
            if (!is_dir($dirName)) {
                misc::create_dir($dirName, 0777, '');
            }
            if (!move_uploaded_file($file['tmp_name'], $fileName)) {
                $this->ctrl->result_descr .= lang::p('file_upload_failure', '[filename]', $fileName);
                chmod($fileName, 0777);
            }
            else { 
                if(strpos($_SERVER['HTTP_HOST'] , 'italker.ru') !== false) {
                    if (strpos($dir,'catalog_tree/')){
                        $currjpg = $fileName;
                        $src=imagecreatefromjpeg($currjpg); 
                        $w_src = imagesx($src); 
                        $h_src = imagesy($src);
                        $w_dest = $w_src; 
                        $h_dest = $h_src - 10; 
                        $dest = imagecreatetruecolor($w_dest,$h_dest);            
                        imagecopyresized($dest,$src, 0, 0, 0, 0, $w_dest, $h_dest, $w_dest, $h_dest); 
                        imagejpeg($dest,$currjpg,100); 
                        imagedestroy($dest); 
                        imagedestroy($src);  
                    }
                }
            }
            $data[$fieldName] =  zf::$zf_root_url.$fname;
            if ($file['zf']['type'] == 'image') {
                AdvancedModel::resizeImage($fname, $fileName, $file['zf']);
                AdvancedModel::watermarkImage($fileName, 'public/userfiles/upload/images/italker_white_logo.png');
            }
        }
        return $data;
    }
}
?>