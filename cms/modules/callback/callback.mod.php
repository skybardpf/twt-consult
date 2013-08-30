<?php

class CallbackModel extends CMS_Model {
    protected $valuesConf = array(
        'time_id' => array(
            'keyField'   => 'id',
            'titleField' => 'title',
            'tableName'  => 'times',
            'cond'       => array('order' => array('title' => 'asc'))
        )
    );
}
