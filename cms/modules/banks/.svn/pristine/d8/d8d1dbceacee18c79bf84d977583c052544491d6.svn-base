<?php
class BanksModel extends CMS_Model {
    protected $valuesConf = array(
        'currencies' => array(
            'keyField' => 'id',
            'titleField' => 'title',
            'tableName' => 'currencies',
            'cond' => array('where' => array('active' => 'yes'), 'order' => array('pos' => 'ASC'))
        ),
        'country_id' => array(
            'keyField' => 'id',
            'titleField' => 'title',
            'tableName' => 'countries',
            'cond' => array('where' => array('active' => 'yes'), 'order' => array('title' => 'ASC'))
        )
    );

    public function initCurrencyValues($bank_id) {
        $values = array();
        $fields = $this->getFieldsNames('banks', 'currencies');
        foreach($fields as $field) {
            $tmp = $this->getList('banks', array('id', $field), array('where' => array('banks.id' => $bank_id, 'currencies.active' => 'yes')));
            $values[$field] = array();
            $tmp = current($tmp);
            $tmp = $tmp[$field];
            if($tmp) {
                foreach($tmp as $a) {
                    $values[$field][$a[$this->valuesConf[$field]['keyField']]] = $a[$this->valuesConf[$field]['titleField']];
                }
            }
        }
        $this->values = $values;
        return $values;
    }
}