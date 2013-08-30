<?php
class Entity_reqModel extends CMS_Model {
    protected $valuesConf = array(
        'jur_country_id' => array(
            'keyField' => 'code',
            'titleField' => 'title',
            'tableName' => 'countries',
            'cond' => array('where' => array('active' => 'yes'), 'order' => array('title' => 'asc'))
        ),
        'kind_activities' => array(
            'keyField' => 'id',
            'titleField' => 'title',
            'tableName' => 'kind_activities',
            'cond' => array('where' => array('active' => 'yes'), 'order' => array('title' => 'asc'))
        ),
        'currency_id' => array(
            'keyField' => 'id',
            'titleField' => 'title',
            'tableName' => 'currencies',
            'cond' => array('where' => array('active' => 'yes'), 'order' => array('pos' => 'asc'))
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
            if (in_array('jur_country_id', $fields)) {
                $data = $this->getList(
                    'countries',
                    array( 'id', 'title'),
                    array('where' => array('active' => 'yes'), 'order' => array('title' => 'asc')));
                $values = array();
                if ($data) {
                    $values[0] = 'пусто';
                    foreach ($data as $tmp) {
                        $values[$tmp['id']] = $tmp['title'];
                    }
                    $this->values['jur_country_id'] = $values;
                }
                unset($fields[array_search('jur_country_id', $fields)]);
            }
            if (in_array('country_source', $fields)) {
                if($misc['country_source']) {
                    $data = $this->getList(
                        'entity_req',
                        array('id', 'country_source'),
                        $misc['country_source']);
                    $data = current($data);
                    $data = $data['country_source'];
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
                        'entity_req',
                        array('id', 'country_receiver'),
                        $misc['country_receiver']);
                    $data = current($data);
                    $data = $data['country_receiver'];
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
        parent::initValues($fields, $misc);
    }

    public function getVal() {
        return $this->values;
    }
}