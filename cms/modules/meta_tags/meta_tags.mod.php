<?php
class Meta_tagsModel extends AdvancedModel
{
	public function prepareData($tableName, $data)
	{
		$data        = parent::prepareData($tableName, $data);
		if ($data['url'][0] !== '/') {
			$this->ctrl->result_descr = 'url должен начинаться со слеша ("/")';
			return null;
		}
		if ($data['url'] != '/') $data['url'] = rtrim($data['url'], '/');
		return $data;
	}
	
	public function getMeta($url)
	{
        $lang = str_replace('/', '' ,zf::$root_url);
        $result = $this->GetByCond('meta_tags',
            $this->getFieldsNames('meta_tags', 'site_list', $lang),
            array(
                'where' => array(
                    'url' => $url == '/' ? '/' : rtrim($url, '/'),
                    'isActive' => 'yes'
                )
            ), 1 );

        $res = array();
        foreach($result as $key => $val){
            if(substr($key, 0, 3) == $lang . '_') {
                $newKey = str_replace($lang . '_', '' ,$key);
            } else {
                $newKey = $key;
            }
            $res[$newKey] = $val;
        }
        //$res = $this->db->assoc('SELECT * FROM ?t WHERE url = ? AND isActive = \'yes\'', $this->tables['meta_tags'], $url == '/' ? '/' : rtrim($url, '/'));
        return $res;
        
	}
}
?>
