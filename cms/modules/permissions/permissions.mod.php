<?php
class PermissionsModel extends CMS_Model
{
    public function getFields($ctrl)
    {
        return array(
            'actions' => array(
                'type'     => "checkboxes",
                'req'      => 0,
                //'title'    => $ctrl['title'],
                'values'   => misc::array_extract_field($ctrl['actions'], 0, 1),
                'htmltype' => "checkboxes",
                'attrs'    => array(
                    'class' => "zf_radio"
                ),
                'name'     => 'actions',
                'input'    => "checkboxes"                    
            )
        );
    }
    
    public function getCurrentPermissions($ctrlName, $role_id)
    {
        $data = $this->db->query(
            'SELECT actionName FROM ?t WHERE ctrlName = ? and role_id = ?d',
            $this->tables['permissions'], $ctrlName, $role_id
        );
        $ret = array();
        foreach ($data as $row) {
            $ret[$row['actionName']] = array('id' => $row['actionName']);
        }
        return array('actions' => $ret);
    }
    
    public function Save($data, $ctrlName, $role_id)
    {
        $this->db->query('DELETE FROM ?t WHERE role_id = ?d AND ctrlName = ?',
            $this->tables['permissions'], $role_id, $ctrlName);
        if (empty($data)) return;
        if (empty($data['actions'])) return;
        foreach ($data['actions'] as $actionName) {
            $this->db->query('INSERT INTO ?t (?lt) VALUES (?l)',
                $this->tables['permissions'],
                array('ctrlName', 'role_id', 'actionName'),
                array($ctrlName, $role_id, $actionName)
            );
        }
    }
    
 	private $permissions = array();
 	private $ctrlActions = array();
    protected function checkPermission($ctrlName, $actionName, $role_id, $data = array())
    {
        if ($role_id === 100500) return 1;
        if (!isset($this->permissions[$role_id])) {
        	$this->permissions[$role_id] = $this->db->groupKarr(
        		'SELECT ctrlName, actionName, id FROM ?t WHERE role_id = ?d',
        		$this->tables['permissions'], $role_id
        	);
        }
        if (empty($this->permissions[$role_id][$ctrlName][$actionName])) {
            if ($actionName == 'access') return false;
            if (!empty($this->ctrlActions[$ctrlName]) && !in_array($actionName, $this->ctrlActions[$ctrlName])) return true;
            $this->ctrlActions[$ctrlName] = array_keys(misc::get($this->ctrl->parseCtrlConf($ctrlName), 'actions', array()));
            if (!in_array($actionName, $this->ctrlActions[$ctrlName]) && !empty($this->permissions[$role_id][$ctrlName]['access'])) return true;
            return false;
        } else {
            return $this->permissions[$role_id][$ctrlName][$actionName];
        }
    }    
    
    public function CanRun($ctrlName, $actionName, $user, $data = array())
    {
        if (!empty($user['roles'])) {
	    	foreach (array_keys($user['roles']) as $role_id) {
	            $canAccess = $this->checkPermission($ctrlName, 'access', $role_id, $data);
	            if ($actionName == 'access' && $canAccess) return 1;
	            $can = $this->checkPermission($ctrlName, $actionName, $role_id, $data);
	            if ($canAccess && $can) return 1;
	        }
        }
        return 0;
    }
}
?>
