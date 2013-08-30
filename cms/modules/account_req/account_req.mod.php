<?php
class Account_reqModel extends CMS_Model {
    protected $valuesConf = array(
        'bank_id' => array(
            'keyField' => 'id',
            'titleField' => 'title',
            'tableName' => 'banks',
            'cond' => array('where' =>array('active' => 'yes'), 'order' => array('title' => 'asc'))
        ),
        'sources' => array(
            'keyField' => 'id',
            'titleField' => 'title',
            'tableName' => 'sources',
            'cond' => array('order' => array('title' => 'asc'))
        ),
        'currency_id' => array(
            'keyField' => 'id',
            'titleField' => 'title',
            'tableName' => 'currencies',
            'cond' => array('order' => array('title' => 'asc'))
        ),
        'country_source' => array(
            'keyField' => 'code',
            'titleField' => 'title',
            'tableName' => 'countries',
            'cond' => array('where' => array('active' => 'yes', 'source' => 'yes'), 'order' => array('title' => 'asc'))
        ),
        'country_receiver' => array(
            'keyField' => 'code',
            'titleField' => 'title',
            'tableName' => 'countries',
            'cond' => array('where' => array('active' => 'yes', 'receiver' => 'yes'), 'order' => array('title' => 'asc'))
        )
    );

    public function initValues($fields, $misc = null, $isAdmin = false) {
        if($isAdmin) {
            if (in_array('country_source', $fields)) {
                if($misc['country_source']) {
                    $data = $this->getList(
                        'account_req',
                        array('id', 'country_source'),
                        $misc['country_source']);
                    $data = current($data);
                    $data = $data['country_source'];
                    unset($misc['country_source']);
                } else {
                    $data = $this->getList(
                        'countries',
                        array( 'id', 'title'),
                        array('where' => array('active' => 'yes'), 'order' => array('title' => 'asc')));
                }
                $values = array();
                if ($data) {
                    foreach ($data as $tmp) {
                        $values[$tmp['id']] = $tmp['title'];
                    }
                } else {
                    $values[0] = 'пусто';
                }
                $this->values['country_source'] = $values;
                unset($fields[array_search('country_source', $fields)]);
            }
            if (in_array('country_receiver', $fields)) {
                if($misc['country_receiver']) {
                    $data = $this->getList(
                        'account_req',
                        array('id', 'country_receiver'),
                        $misc['country_receiver']);
                    $data = current($data);
                    $data = $data['country_receiver'];
                    unset($misc['country_receiver']);
                } else {
                    $data = $this->getList(
                        'countries',
                        array( 'id', 'title'),
                        array('where' => array('active' => 'yes'), 'order' => array('title' => 'asc')));
                }
                $values = array();
                if ($data) {
                    foreach ($data as $tmp) {
                        $values[$tmp['id']] = $tmp['title'];
                    }
                } else {
                    $values[0] = 'пусто';
                }
                $this->values['country_receiver'] = $values;
                unset($fields[array_search('country_receiver', $fields)]);
            }
        }
        if (in_array('bank_id', $fields)) {
            $data = $this->db->karr('
                SELECT `b`.`id`, CONCAT_WS(", ", `b`.`title`, `c`.`title`) FROM `banks` AS `b` 
                LEFT JOIN `countries` AS `c` ON `b`.`country_id` = `c`.`id`
                WHERE `b`.`active` = "yes" ORDER BY `b`.`title` ASC 
            ');
            $values = array();
            if ($data) {
                $this->values['bank_id'] = $data;
            }
            unset($fields[array_search('bank_id', $fields)]);
        }
        parent::initValues($fields, $misc);
    }
}