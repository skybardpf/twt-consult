<?php
class ListsModel extends AdvancedModel
{
	public function Delete($tableName, $cond)
	{
		$ret = parent::Delete($tableName, $cond);
		if ($ret && $tableName == 'lists') {
			$this->db->query('DELETE FROM ?t WHERE pid = ?d', $this->tables['lists_records'], $this->ctrl->app->request->pid);
		}
		return $ret;
	}
	
	public function prepareData($tableName, $data)
	{
		$ret = parent::prepareData($tableName, $data);
		if ($ret && isset($data['isDefault']) && $data['isDefault'] == 'yes') {
			$this->db->query('UPDATE ?t SET isDefault = "no" WHERE pid = ?d', $this->tables['lists_records'], $this->data['pid']);
		}
		return $ret;
	}
    
    public function getValuesByListSname($listSname)
    {
        return $this->db->karr('
            SELECT v.id, v.value
            FROM ?t AS l
            JOIN ?t AS v ON l.id = v.pid
            WHERE l.sname = ?
            ORDER BY `v`.`pos`',
            $this->tables['lists'], $this->tables['lists_records'], $listSname
        );
    }
}
?>
