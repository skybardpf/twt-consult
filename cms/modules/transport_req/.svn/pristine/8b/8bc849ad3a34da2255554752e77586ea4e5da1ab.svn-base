<?php
class Transport_reqModel extends CMS_Model {
    protected $valuesConf = array(
        'loading_country' => array(
            'keyField' => 'code',
            'titleField' => 'title',
            'tableName' => 'countries',
            'cond' => array('where' => array('active' => 'yes'), 'order' => array('title' => 'asc'))
        ),
        'delivery_country' => array(
            'keyField' => 'code',
            'titleField' => 'title',
            'tableName' => 'countries',
            'cond' => array('where' => array('active' => 'yes'), 'order' => array('title' => 'asc'))
        ),
        'services' => array(
            'keyField' => 'id',
            'titleField' => 'title',
            'tableName' => 'additional',
            'cond' => array('where' => array('active' => 'yes'), 'order' => array('pos' => 'asc'))
        ),
        'currency' => array(
            'keyField' => 'code',
            'titleField' => 'title',
            'tableName' => 'currencies',
            'cond' => array('where' => array('active' => 'yes'), 'order' => array('pos' => 'asc'))
        )
    );

    public function initValues($fields, $misc = null, $isAdmin = false) {
        if($isAdmin) {
            if (in_array('loading_country', $fields)) {
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
                    $this->values['loading_country'] = $values;
                }
                unset($fields[array_search('loading_country', $fields)]);
            }
            if (in_array('delivery_country', $fields)) {
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
                    $this->values['delivery_country'] = $values;
                }
                unset($fields[array_search('delivery_country', $fields)]);
            }
        }
        parent::initValues($fields, $misc);
    }
}