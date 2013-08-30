<?php
class ServicesModel extends CMS_Model {
    protected $valuesConf = array(
        'pid' => array(
            'keyField'   => 'id',
            'titleField' => 'title',
            'tableName'  => 'services',
            'cond'       => array('order' => array('pos' => 'asc'))
        )
    );

 /*   public function initValues($fields, $misc = null)
    {
        if (in_array('pid', $fields)) {
            $this->valuesConf['pid'] = array(
                'keyField'   => 'id',
                'titleField' => 'title',
                'tableName'  => 'services',
                'cond'       => array('order' => array('pos' => 'asc'))
            );
        }
        parent::initValues($fields, null);
        unset($this->values['pid'][$misc]);
    }*/

    public function initValues($fields, $misc = null) {
        if (in_array('pid', $fields)){
            $data = $this->getTreeTitles('services', 'services');
            $values = array();
            if ($data) {
                foreach ($data as $key => $val) {
                    $values[$key] = $val['title'];
                }
                $this->values['pid'] = $values;
            }
            unset($fields[array_search('pid', $fields)]);
        }
        parent::initValues($fields, $misc);
    }

    public function getTreeTitles($model_name, $table_name, $id_field = 'id', $pid_field = 'pid', $title_field = 'title') {
        $model = $this->model($model_name, $model_name);
        $first_level = $model->getList(
            $table_name,
            $model->getFieldsNames($table_name, 'pid_list'),
            array(
                'where' => array(
                    $table_name.'.'.$pid_field => 0
                ),
                'order' => array($table_name.'.pos' => 'ASC')
            )
        );
        $str = array();
        if ($first_level) {
            foreach ($first_level as $f) {
                $str += $this->getStr($f, $str, $id_field, $pid_field, $title_field);
                $this->get_branch($f[$id_field], $str, $model_name, $table_name, $id_field, $pid_field, $title_field);
            }
        }
        return $str;
    }

    public function getStr($node, $str = array(), $id_field = 'id', $pid_field = 'pid', $title_field = 'title') {
        $result = false;
        if ($node[$pid_field] == 0) {
            $result[$node[$id_field]] = array($title_field => $node[$title_field], $pid_field => $node[$pid_field]);
        } else {
            $result[$node[$id_field]] = array($title_field => $str[$node[$pid_field]][$title_field].'/'.$node[$title_field], $pid_field => $node[$pid_field]);
        }
        return $result;
    }

    public function get_branch($pid, &$str, $model_name, $table_name, $id_field = 'id', $pid_field = 'pid', $title_field = 'title') {
        $model = $this->model($model_name, $model_name);
        $branch = $model->getList(
            $table_name,
            $model->getFieldsNames($table_name, 'pid_list'),
            array(
                'where' => array(
                    $table_name.'.'.$pid_field => $pid
                ),
                'order' => array($table_name.'.pos' => 'ASC')
            )
        );
        if ($branch) {
            foreach ( $branch as $row ) {
                if ($row[$pid_field] == 0) {
                    $str += $this->getStr($row, $str, $id_field, $pid_field, $title_field);
                    $this->get_branch( $row[$id_field], $str, $model_name, $table_name, $id_field, $pid_field, $title_field);
                } else {
                    $str += $this->getStr($row, $str, $id_field, $pid_field, $title_field);
                    $this->get_branch( $row[$id_field], $str, $model_name, $table_name, $id_field, $pid_field, $title_field);
                }
            }
        }
    }
}