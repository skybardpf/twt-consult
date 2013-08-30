<?php
class SettingsModel extends AdvancedModel
{
	public $sFields;
	public $fName;
	public $nField;
	public $id;
	
	/**
	 * Returns fields
	 * 
	 * @param string $fields
	 */
	public function getFields($tableName = null, $actionOrFields = null)
	{
		if ($tableName === null) {
			foreach ($this->sFields as $fieldName => &$field) {
				misc::inheritArray($field, zf::$types['types'][$field['type']]);
				if ($field['type'] == 'image') {
					$field['dirs']['icon'] = $field['icon'];
				} elseif ($field['type'] == 'images') {
					$id = $this->GetByCond('settings', array('id'), array('where'=>array('name'=>$fieldName)), 1);
					if ($id != false) {
						$field['link'] = zf::$root_url."images/model/settings/pid/{$id['id']}/";
					}
				}
			}
			return $this->sFields;
		}
		else {
			return array($this->nField => $this->sFields[$this->fName]);
		}
	}
	public function getDataToForm()
	{
		return $this->db->karr("SELECT name, value FROM ?t", $this->tables['settings'], 1);
	}
	public function getImages($name)
	{
		return $this->db->query("
		SELECT *
			FROM ?t AS i
			WHERE
				model = 'settings'
					AND
				pid = (SELECT id FROM ?t AS s WHERE name = ?)
			ORDER BY pos ASC",
		$this->tables['images'], $this->tables['settings'], $name);
	}
	public function initRows($name) 
	{
		return $this->db->query("INSERT INTO ?t (name) VALUES (?)", $this->tables['settings'], $name);
	}
    public function DeleteFile($fname, $file)
    {
        parent::deleteFile($fname, $file);
    }	
}
?>