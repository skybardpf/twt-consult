<?php
class Calculator_reqModel extends CMS_Model {
    protected $valuesConf = array(
        'currency' => array(
            'keyField' => 'id',
            'titleField' => 'title',
            'tableName' => 'currencies',
            'cond' => array('order' => array('title' => 'asc'))
        ),
    );


    /**
     * @static
     *
     * @param $data
     * @param bool $json
     *
     * @throws Exception
     * @internal param $class - which objects we will generate
     * @internal param $key - the first key of resulting array
     *
     * @return array
     */
    public function parseReturn($data, $json = true) {
        if (is_string($data->return) && stripos($data->return, 'error') !== false) {
            throw new Exception($data->return);
        } else {
            if (is_string($data->return) && $json) {
                $data = json_decode($data->return);
            } elseif (!$json) {
                $data = $data->return;
            } else {
                $data = NULL;
            }
        }
        return $data;
    }

}