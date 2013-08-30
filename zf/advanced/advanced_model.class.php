<?php
class AdvancedModel extends Model
{
    protected $actions         = array();
    protected $titles          = array();
    protected $values          = array();
    protected $values_defaults = array();
    protected $files           = array();
    public    $loadBeforeDelete   = 1;
    protected $fields4form     = array();
    /**
     * Переменная, содержащая поле для показа видео после конвертации
     * @var string
     */
    public $showVideoField = 'hidden';
    /**
     * Переменная, содержащая значение поля для показа видео после конвертации
     * @var string
     */
    public $showVideoValue = 'no';


    public function __construct($ctrlName, $modName, $ctrl, $db = null, $directory = '')
    {
        parent::__construct($ctrlName, $modName, $ctrl, $db, $directory);
        if (isset($this->conf['tables']) && is_array($this->conf['tables'])) {
            foreach ($this->conf['tables'] as $tblName => $tbl) {
                if (empty($tbl['actions'])) continue;
                foreach ($tbl['actions'] as $actName => $act) {
                    if (!isset($this->actions[$tblName]) || !is_array($this->actions[$tblName])) $this->actions[$tblName] = array();
                    //$this->actions[$tblName][$actName] = $act == 'all' ? array_keys($tbl['fields']) : $act;
                    if($act == 'all'){
                        $this->actions[$tblName][$actName] = array_keys($tbl['fields']);
                    }
                    else if($act == 'all_with_foreigns'){
                        $this->actions[$tblName][$actName] = array_merge(array_keys($tbl['fields']), array_keys($tbl['foreign']));
                    }
                    else{
                        $this->actions[$tblName][$actName] = $act;
                    }
                }
            }
        }
    }

    protected function OnBeforeCompile(&$conf)
    {
        //debug::dump($this->conf['tables']);
        if (!empty($conf['tables'])) {
            foreach ($conf['tables'] as $tableName => $table) {
                $conf['tables'][$tableName]['use_list'] = array();
                foreach ($table['fields'] as $fieldName => $field) {
                    if (!empty($field['am']['use_list'])) {
                        $conf['tables'][$tableName]['use_list'][] = $fieldName;
                    }
                    if (!empty($field['am']['range']) && empty($field['am']['values'])) {
                        $range = $field['am']['range'];
                        if (!isset($range[2])) {
                            $vals = range($range[0], $range[1]);
                            foreach ($vals as $val) {
                                $vals2[$val] = $val;
                            }
                            $vals = $vals2;
                            $conf['tables'][$tableName]['fields'][$fieldName]['am']['values'] = $vals;
                        }
                        else {
                            switch ($range[2]) {
                                case 'day':
                                    if ($range[0] == 'now') {
                                        $range[0] = (int) date('j');
                                    } elseif ($range[1] == 'now') {
                                        $range[1] = (int) date('j');
                                    }
                                    $vals = range($range[1], $range[0]);
                                    foreach ($vals as $val) {
                                        if ($val<10) {
                                            $val = '0'.$val;
                                        }
                                        $vals2[$val] = $val;
                                    }
                                    $vals = $vals2;
                                    unset($vals2);
                                    $conf['tables'][$tableName]['fields'][$fieldName]['am']['values'] = $vals;
                                    break;
                                case 'month':
                                    $month = array('Январь', 'Февраль', 'Март', 'Апрель', 'Май', '??юнь', '??юль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь');
                                    $monthstart =  array_search($range[0], $month);
                                    $monthend =  array_search($range[1], $month);
                                    if ($range[0] == 'now') {
                                        $monthstart = (int) date('n')-1;
                                    } elseif ($range[1] == 'now') {
                                        $monthend = (int) date('n')-1;
                                    }
                                    $vals = range($monthstart, $monthend);
                                    foreach ($vals as $key => $val) {
                                        $k2 = $key+1;
                                        if ($key<9) {
                                            $k2 = (string) '0'.$k2;
                                        } else {
                                            $k2 = (string) $k2;
                                        }
                                        $vals2[$k2] = $month[$val];
                                    }
                                    $vals = $vals2;
                                    unset($vals2);
                                    $conf['tables'][$tableName]['fields'][$fieldName]['am']['values'] = $vals;
                                    break;
                                case 'year':
                                    if ($range[0] == 'now') {
                                        $range[0] = (int) date('Y');
                                        if (substr($range[1], 0, 1) == '+') {
                                            $offset = (int) substr($range[1], 1);
                                            $range[1] = $range[0]+$offset;
                                        } elseif (substr($range[1], 0, 1) == '-') {
                                            $offset = (int) substr($range[1], 1);
                                            $range[1] = $range[0]-$offset;
                                        }
                                    } elseif ($range[1] == 'now') {
                                        $range[1] = (int) date('Y');
                                        if (substr($range[0], 0, 1) == '+') {
                                            $offset = (int) substr($range[0], 1);
                                            $range[0] = $range[1]+$offset;
                                        } elseif (substr($range[0], 0, 1) == '-') {
                                            $offset = (int) substr($range[0], 1);
                                            $range[0] = $range[1]-$offset;
                                        }
                                    }
                                    $vals = range($range[1], $range[0]);
                                    foreach ($vals as $val) {
                                        $vals2[$val] = $val;
                                    }
                                    $vals = $vals2;
                                    unset($vals2);
                                    $conf['tables'][$tableName]['fields'][$fieldName]['am']['values'] = $vals;
                            }
                        }
                    }
                }
            }
        }
    }

    protected function filterVirtuals($field)
    {
        return !empty($field['virtual']);
    }

    protected function filterNotVirtuals($field)
    {
        return empty($field['virtual']);
    }

    public function getFieldsNames($tableName, $action, $with_foreign = 0, $parseTitles = false)
    {
        /*        if ($action == 'all') {
           $ret = array_keys($this->conf['tables'][$tableName]['fields']);
           $ret = $with_foreign ? array_merge($ret, array_keys($this->conf['tables'][$tableName]['foreign'])) : $ret;
           } else {
           $ret = $this->actions[$tableName][$action];
           }*/
        $ret = parent::getFieldsNames($tableName, $action, $with_foreign);
        if ($parseTitles) {
            foreach ($ret as $fieldName => &$title) {
                if ($title == '[am]') {
                    $title = misc::get(misc::get($this->getFields($tableName, array($fieldName)), $fieldName), 'title');
                }
            }
        }
        return $ret;
    }

    /**Убирает поля, отсутствующие в БД
     *
     * @param $fields
     * @param $tableName
     * @return mixed
     */
    public function check_placeholders($fields, $tableName) {
        $ret = $fields;
        if (is_array($fields)) {
            $t_conf = $this->conf['tables'][$tableName]['fields'];
            foreach($fields as $key => $field) {
                if (isset($t_conf[$field]) && isset($t_conf[$field]['am']) && ($t_conf[$field]['am']['type'] == 'placeholder' || $t_conf[$field]['am']['type'] == 'separator' || $t_conf[$field]['am']['type'] == 'fieldset')) {
                    unset($ret[$key]);
                }
            }
        }
        return $ret;
    }
    /**
     * Returns fields
     *
     * @param string $tableName
     * @param mixed $actionOrfields
     */
    public function getFields($tableName, $actionOrFields, $calledFrom_prepareData = 0)
    {
        if ($actionOrFields === 'all') {
            $tmpFields = array_keys($this->conf['tables'][$tableName]['fields']);
        } else {
            $tmpFields = is_array($actionOrFields) ? $actionOrFields : $this->actions[$tableName][$actionOrFields];
        }
        foreach ($tmpFields as $fieldName) {
            $ret[$fieldName] = array();
        }
        if (!empty($this->fields4form[$tableName])) {
            $diff = array_diff($tmpFields, array_keys($this->fields4form[$tableName]));
            if (!$diff) {
                $ret = array();
                foreach ($tmpFields as $fieldName) {
                    $ret[$fieldName] = $this->fields4form[$tableName][$fieldName];
                }
                return $ret;
            } else {
                $retFields = $tmpFields;
                $tmpFields = $diff;
            }
        } else {
            $fields = array();
        }
        $fields = array();
        $hasVirtuals = 0;
        foreach ($tmpFields as $fieldName) {
            if (0 && !empty($this->conf['tables'][$tableName]['fields'][$fieldName]['virtual'])) {
                $vgroup = array();
                $am     = $this->conf['tables'][$tableName]['fields'][$fieldName]['am'];
                foreach ($this->conf['tables'][$tableName]['fields'][$fieldName]['fields'] as $field) {
                    $fields[] = $fieldName."[$field]";
                    $this->conf['tables'][$tableName]['fields'][$fieldName."[$field]"]['am'] = array(
                        'type'  => $am['type'][$field],
                        'title' => $am['title'][$field]
                    );
                    $vgroup[] = $fieldName."[$field]";
                }
                $this->conf['tables'][$tableName]['groups'][$fieldName] = array(
                    'title'    => $am['vtitle'],
                    'elements' => $vgroup
                );
            } else {
                //debug::dump($this->conf['tables'][$tableName]['fields']);
                $oFields = $this->conf['tables'][$tableName]['fields'];
                $fFields = !empty($this->conf['tables'][$tableName]['foreign']) ? $this->conf['tables'][$tableName]['foreign'] : array();

                if (!empty($oFields[$fieldName]['am'])) {
                    $am        = $oFields[$fieldName]['am'];
                    $isForeign = 0;
                } elseif (!empty($fFields[$fieldName]['am'])) {
                    $am        = $fFields[$fieldName]['am'];
                    $isForeign = 1;
                } else {
                    $am = null;
                }

                if ($am) {
                    if (!is_array($am)) {
                        if (strpos($am, '->') !== false) {

                            list($aTable, $aField) = explode('->', $am);
                            if (!empty($this->conf['tables'][$aTable]['fields'][$aField]['am'])) {
                                $am = $this->conf['tables'][$aTable]['fields'][$aField]['am'];
                            } elseif (!empty($this->conf['tables'][$aTable]['foreign'][$aField]['am'])) {
                                $am = $this->conf['tables'][$aTable]['foreign'][$aField]['am'];
                            }
                            if (!empty($am['use_list'])) {
                                $this->conf['tables'][$tableName]['use_list'][] = $fieldName;
                            }
                        } else {//debug::dump($am);
                            $am = !empty($oFields[$am]['am']) ? $oFields[$am]['am'] : $fFields[$am]['am'];
                        }
                        $this->conf['tables'][$tableName][$isForeign ? 'foreign' : 'fields'][$fieldName]['am'] = $am;
                    }
                }
                $fields[] = $fieldName;
            }
        }

        foreach ($fields as $fieldName) {
            if (empty($this->conf['tables'][$tableName]['fields'][$fieldName]['am']) && empty($this->conf['tables'][$tableName]['foreign'][$fieldName]['am'])) {
                continue;
                $this->conf['tables'][$tableName]['fields'][$fieldName]['am'] = array(
                    'type'     => 'integer',
                    'htmltype' => 'hidden'
                );
            } else {
                if (empty($this->conf['tables'][$tableName]['fields'][$fieldName]['am'])) {
                    $title = misc::get($this->conf['tables'][$tableName]['foreign'][$fieldName]['am'], 'title');
                } else {
                    $title = misc::get($this->conf['tables'][$tableName]['fields'][$fieldName]['am'], 'title');
                }
            }
            if ($title) $this->titles[$tableName][$fieldName] = $title;
            if (!empty($this->conf['tables'][$tableName]['fields'][$fieldName]['am'])) {
                $am = $this->conf['tables'][$tableName]['fields'][$fieldName]['am'];
            } elseif (!empty($this->conf['tables'][$tableName]['foreign'][$fieldName]['am'])) {
                $am = $this->conf['tables'][$tableName]['foreign'][$fieldName]['am'];
            } else {
                continue;
            }
            $ret[$fieldName] = $am;
            if (!empty($this->conf['tables'][$tableName]['fields'][$fieldName]['filter'])) {
                $ret[$fieldName]['filter'] = $this->conf['tables'][$tableName]['fields'][$fieldName]['filter'];
            }

            if (!empty($this->values[$fieldName])) {
                $ret[$fieldName]['values'] = $this->values[$fieldName];
            }

            if (!empty($this->conf['tables'][$tableName]['fields'][$fieldName]['type']) && strpos($this->conf['tables'][$tableName]['fields'][$fieldName]['type'], 'enum') === 0) {
                $values = explode(',',
                    str_replace(array('enum(', ')', "'"), '',
                        $this->conf['tables'][$tableName]['fields'][$fieldName]['type']));
                if (!empty($this->conf['tables'][$tableName]['fields'][$fieldName]['am']['values'])) {
                    $ret[$fieldName]['values'] = $this->conf['tables'][$tableName]['fields'][$fieldName]['am']['values'];
                } else {
                    $ret[$fieldName]['values'] = array_combine($values, $values);
                }
            }

            if (!empty($this->values_defaults[$fieldName])) {
                $ret[$fieldName]['default'] = $this->values_defaults[$fieldName];
            }

            if (!empty($am['type']) && !empty(zf::$types['types'][$am['type']])) {
                $original = $ret[$fieldName];
                $ret[$fieldName] = array();
                foreach (zf::$types['types'][$am['type']] as $k => $v) {
                    if (!empty($original[$k])) {
                        if (is_array($original[$k])) {
                            $ret[$fieldName][$k] = array_merge($v, $original[$k]);
                        } else {
                            $ret[$fieldName][$k] = $original[$k];
                        }
                    } else {
                        $ret[$fieldName][$k] = $v;
                    }
                }
                $ret[$fieldName] = array_merge($original, $ret[$fieldName]);
                if (is_array($ret[$fieldName]['htmltype'])) $ret[$fieldName]['htmltype'] = $original['htmltype'];
                if (isset($original['allowed_ext_only'])) $ret[$fieldName]['allowed_ext'] = $original['allowed_ext_only'];
            }

            if (!empty($am['type']) && $am['type'] == 'image') {
                if (!empty($this->conf['tables'][$tableName]['images'][$fieldName])) {
                    $ret[$fieldName]['dirs']         = $this->conf['tables'][$tableName]['images'][$fieldName];
                    if (empty($ret[$fieldName]['dirs']['icon'])) {
                        $ret[$fieldName]['dirs']['icon'] = zf::$types['types']['image']['icon'];
                    }
                } else {
                    $ret[$fieldName]['dirs']['icon'] = zf::$types['types']['image']['icon'];
                }
            } else if (!empty($am['type']) && $am['type'] == 'video') {
                if (!empty($this->conf['tables'][$tableName]['videos'][$fieldName])) {
                    $ret[$fieldName]['dirs'] = $this->conf['tables'][$tableName]['videos'][$fieldName];
                } else {
                    $ret[$fieldName]['dirs'] = zf::$types['types']['video']['optimized_defaults'];
                }
                unset($ret[$fieldName]['optimized_defaults']);
            } else if (!empty($am['type']) && $am['type'] == 'audio') {
                if (!empty($this->conf['tables'][$tableName]['audios'][$fieldName])) {
                    $ret[$fieldName]['dirs'] = $this->conf['tables'][$tableName]['audios'][$fieldName];
                } else {
                    $ret[$fieldName]['dirs'] = zf::$types['types']['audio']['optimized_defaults'];
                }
                unset($ret[$fieldName]['optimized_defaults']);
            }

            if (!empty($this->conf['tables'][$tableName]['fields'][$fieldName]['virtual'])) {
                if (!$hasVirtuals) $hasVirtuals;
            }

        }
        if (!empty($this->conf['tables'][$tableName]['groups'])) {
            $ret = array_merge($ret, array('form_groups' => $this->conf['tables'][$tableName]['groups']));
        }
        if (!empty($this->conf['tables'][$tableName]['skeep'])) {
            $ret = array_merge($ret, array('skeep' => $this->conf['tables'][$tableName]['skeep']));
        }



        if (!empty($this->conf['tables'][$tableName]['use_list'])) {
            foreach ($this->conf['tables'][$tableName]['use_list'] as $fieldName) {
                if (array_key_exists($fieldName, $ret) === false) continue;
                $items = $this->db->query('
                        SELECT v.id, v.value, isDefault
                        FROM ?t AS v
                        JOIN ?t AS l ON v.pid = l.id
                        WHERE l.sname = ?
                        ORDER BY v.pos ASC
                        ', '?_lists_records', '?_lists',
                    !empty($this->conf['tables'][$tableName]['fields'][$fieldName]['am']['use_list'])
                        ?
                        $this->conf['tables'][$tableName]['fields'][$fieldName]['am']['use_list']
                        :
                        $this->conf['tables'][$tableName]['foreign'][$fieldName]['am']['use_list']
                );
                foreach ($items as $item) {
                    $ret[$fieldName]['values'][$item['id']] = $item['value'];
                    if ($item['isDefault'] == 'yes') {
                        $ret[$fieldName]['default'] = $item['id'];
                    }
                }
            }
        }
        if (!empty($retFields)) {
            foreach ($retFields as $rField) {
                if (empty($ret[$rField]) && array_key_exists($rField, $this->fields4form[$tableName])) {
                    $ret[$rField] = $this->fields4form[$tableName][$rField];
                }
            }
        }
        $this->fields4form[$tableName] = !empty($this->fields4form[$tableName])
            ? array_merge($this->fields4form[$tableName], $ret)
            : $ret;
        return $ret;
    }

    //изменяет тип поля налету
    public function alterFilterFields(array $fields)
    {
        $alteredFields = array();

        foreach ($fields as $fieldName => $field) {
            $alteredFields[$fieldName] = $field;
            if (!empty($field['filter']['type'])) {
                switch ($field['filter']['type']) {
                    case 'from-to':
                        $alteredFields[$fieldName . '_to'] = $alteredFields[$fieldName . '_from'] = $field;
                        $alteredFields[$fieldName . '_to']['title'] = $field['filter']['title_to'];
                        $alteredFields[$fieldName . '_from']['title'] = $field['filter']['title_from'];

                        break;
                    case 'multiply':
                        $alteredFields[$fieldName . '_multi'] = $field;
                        $alteredFields[$fieldName . '_multi']['htmltype'] = 'mselect';
                        $alteredFields[$fieldName . '_multi']['type'] = 'mselect';
                        $alteredFields[$fieldName . '_multi']['attrs'] = array('multiple' => true);
                        break;
                    case 'select':
                        $alteredFields[$fieldName . '_sel'] = $field;
                        $alteredFields[$fieldName . '_sel']['values'] = $field['filter']['values'];
                        $alteredFields[$fieldName . '_sel']['htmltype'] = 'select';
                        if (isset($field['filter']['default'])) {
                            $alteredFields[$fieldName . '_sel']['default'] = $field['filter']['default'];
                        }
                        break;
                    case 'from_to_date':
                        $alteredFields[$fieldName . '_to'] = $alteredFields[$fieldName . '_from'] = $field;
                        $alteredFields[$fieldName . '_to']['title'] = $field['filter']['title_to'];
                        $alteredFields[$fieldName . '_from']['title'] = $field['filter']['title_from'];
                        $alteredFields[$fieldName . '_to']['type'] = 'datetime';
                        $alteredFields[$fieldName . '_from']['title'] = 'datetime';
                        break;
                }
                unset($alteredFields[$fieldName]);
            }
        }
        return $alteredFields;
    }

    public function alterFilterFieldsAdvanced(array $fields)
    {
        $alteredFields = array();
        foreach ($fields as $fieldName => $field) {
            if (!empty($field['filter']['type'])) {
                $filter = $field['filter'];
                if (!empty($filter['alter'])) {
                    $i=0;
                    foreach ($filter['alter'] as $alter) {
                        $alteredFields[$fieldName . '_'.$i] = $alter;
                        $i++;
                    }
                } else {
                    $alteredFields[$fieldName] = $field;
                }
            } else {
                $alteredFields[$fieldName] = $field;
            }
        }
        return $alteredFields;
    }

    public function getRawCondFromFilter($tableName, array $filters)
    {
        //debug::dump($filters);
        $raw = array();
        foreach ($filters as $field=>$value) {
            if(!empty($value)) {
                $basefield = preg_replace('/_[0-9].*?/', '', $field);
                $filter = isset($this->conf['tables'][$tableName]['fields'][$basefield]['filter'])?$this->conf['tables'][$tableName]['fields'][$basefield]['filter']:null;
                if (is_null($filter)) {
                    $raw[$basefield] = " AND `$basefield` LIKE '%$value%' ";
                } else {
                    switch($filter['type']) {
                        case 'flag':
                            if ($value == 'yes') $raw[$basefield] = " AND `$basefield` = '$value'";
                            break;
                        case 'alter':
                            $raw[$basefield] = " AND `$basefield` LIKE '%$value%' ";
                            break;
                        case 'from_to':
                            if ($filter['alter'][0]['type'] == 'datetime') {
                                if (!empty($filters[$basefield.'_0'])) $filters[$basefield.'_0']= db::datetime_to_db($this->db, $filters[$basefield.'_0']);
                                if (!empty($filters[$basefield.'_1'])) $filters[$basefield.'_1'] = db::datetime_to_db($this->db, $filters[$basefield.'_1']);
                            }
                            if (!empty($filters[$basefield.'_0']) && !empty($filters[$basefield.'_1'])) {
                                $raw[$basefield] = " AND `$basefield` BETWEEN '{$filters[$basefield.'_0']}' AND '{$filters[$basefield.'_1']}' ";
                            } elseif (!empty($filters[$basefield.'_0']) && empty($filters[$basefield.'_1'])) {
                                $raw[$basefield]= " AND `$basefield` > '{$filters[$basefield.'_0']}' ";
                            } elseif (empty($filters[$basefield.'_0']) && !empty($filters[$basefield.'_1'])) {
                                $raw[$basefield]= " AND `$basefield` < '{$filters[$basefield.'_1']}' ";
                            }
                            break;
                        case 'age':
                            if (!empty($filters[$basefield.'_0']) && !empty($filters[$basefield.'_1'])) {
                                $year_from = (int) date('Y') - (int) $filters[$basefield.'_1'];
                                $year_to = (int) date('Y') - (int) $filters[$basefield.'_0'];
                                $raw[$basefield]= " AND `$basefield` BETWEEN '{$year_from}' AND '$year_to' ";
                            } elseif (!empty($filters[$basefield.'_0']) && empty($filters[$basefield.'_1'])) {
                                $year_from = (int) date('Y') - (int) $filters[$basefield.'_0'];
                                $raw[$basefield]= " AND `$basefield` < '$year_from' ";
                            } elseif (empty($filters[$basefield.'_0']) && !empty($filters[$basefield.'_1'])) {
                                $year_to = (int) date('Y') - (int) $filters[$basefield.'_1'];
                                $raw[$basefield]= " AND `$basefield` > '$year_to' ";
                            }
                            break;
                        case 'all':
                            $all_vals = array_keys($filter['alter'][0]['values']);
                            if ($value=='any') {
                                $raw[$basefield] = '';
                                $parts = array();
                                foreach ($all_vals as $p_val) {
                                    $parts[] = "`$basefield` = '$p_val'";
                                }
                                $raw[$basefield] = 'AND (' . implode(' OR ', $parts) . ')';
                            } else {
                                $raw[$basefield] = " AND `$basefield` = '$value' ";
                            }
                            break;
                    }
                }
            }
        }
        $raw_final='';
        foreach ($raw as $cond) {
            $raw_final .= $cond;
        }
        $raw_final = substr($raw_final, 4);
        return $raw_final;
    }


    public function getTitles($tableName, $actionOrFields)
    {
        if (!is_array($actionOrFields) && isset($this->titles[$tableName][$actionOrFields])) return $this->titles[$tableName][$actionOrFields];
        $titles = array();
        if (is_array($actionOrFields)) {
            $fields = $actionOrFields;
        } else {
            $fields = $this->actions[$tableName][$actionOrFields];
        }
        foreach ($fields as $fieldName) {
            if (!empty($this->conf['tables'][$tableName]['fields'][$fieldName]['am']['title'])) {
                $title = $this->conf['tables'][$tableName]['fields'][$fieldName]['am']['title'];
            }
            elseif (!empty($this->conf['tables'][$tableName]['foreign'][$fieldName]['am']['title'])){
                $title = $this->conf['tables'][$tableName]['foreign'][$fieldName]['am']['title'];
            }
            else {
                continue;
            }
            if ($title) $titles[$fieldName] = $title;
        }
        return $titles;
    }

    public function initValues($fields, $misc = null)
    {
        $hash = 1;
        foreach ($fields as $key => $val) {
            if (is_numeric($key)) $hash = 0;
            $fKey = $hash ? $key : $val;
            if ($hash && is_array($val)) {
                $fieldName = $val[0];
                $val       = isset($val[1]) ? $val[1] : null;
            } else {
                $fieldName = !empty($this->valuesConf[$fKey]['fieldName'])
                    ?
                    $this->valuesConf[$fKey]['fieldName']
                    :
                    $fKey;
            }

            if (!empty($misc[$fieldName])) {
                $this->valuesConf[$fKey] = array_merge($this->valuesConf[$fKey], $misc[$fKey]);
            }

            if (is_array($this->valuesConf[$fKey]['titleField'])) {
                list($cSql, $cArgs) = $this->getConditions($this->valuesConf[$fKey]['tableName'], $this->valuesConf[$fKey]['cond']);
                $cArgs = array_merge(
                    array($this->valuesConf[$fKey]['keyField'], $this->valuesConf[$fKey]['titleField'], $this->tables[$this->valuesConf[$fKey]['tableName']]),
                    $cArgs
                );
                $this->values[$fieldName] = $this->db->karr('SELECT ?t, CONCAT_WS(" ", ?lt) FROM ?t '.$cSql, $cArgs);
            } else {
                $this->values[$fieldName] = $this->getValues(
                    $this->valuesConf[$fKey]['keyField'],
                    $this->valuesConf[$fKey]['titleField'],
                    $this->valuesConf[$fKey]['tableName'],
                    $this->valuesConf[$fKey]['cond'],
                    !empty($this->valuesConf[$fKey]['modName']) ? $this->valuesConf[$fKey]['modName'] : '',
                    !empty($this->valuesConf[$fKey]['ctrlName']) ? $this->valuesConf[$fKey]['ctrlName'] : '',
                    !empty($this->valuesConf[$fKey]['group']) ? $this->valuesConf[$fKey]['group'] : array(),
                    !empty($this->valuesConf[$fKey]['additionalFields']) ? $this->valuesConf[$fKey]['additionalFields'] : array()
                );
                if ($hash) $this->values_defaults[$fieldName] = $val;
                if (!empty($this->valuesConf[$fKey]['default'])) {
                    $this->values_defaults[$fieldName] = $this->valuesConf[$fKey]['default'];
                }
            }
            if (!empty($this->valuesConf[$fieldName]['add_values'])) {
                foreach($this->valuesConf[$fieldName]['add_values'] as $key => $val) $this->values[$fieldName][$key] = $val;
            }
        }
        return $this->values;
    }

    protected function prepareData($tableName, $data)
    {
        if (!empty($this->conf['tables'][$tableName]['on_modify']) && is_array($this->conf['tables'][$tableName]['on_modify'])) {
            $data[key($this->conf['tables'][$tableName]['on_modify'])] = date(current($this->conf['tables'][$tableName]['on_modify']));
        }
        $fields   = $this->getFields($tableName, array_keys($data), 1);
        $filesCnt = 0;
        foreach ($data as $fieldName => &$value) {
            if (!empty($this->conf['tables'][$tableName]['fields'][$fieldName]['virtual'])) {
                $this->virtual_fields[$fieldName] = array(
                    'ref'  => $this->conf['refs'][$this->conf['tables'][$tableName]['fields'][$fieldName]['ref_to']['use_ref']],
                    'tablename'  => $this->conf['tables'][$tableName]['fields'][$fieldName]['ref_to']['table'],
                    'data' => $data[$fieldName],
                    'field_type' => $this->conf['tables'][$tableName]['fields'][$fieldName]['am']['type'],
                    'a_data' => !empty($this->conf['tables'][$tableName]['fields'][$fieldName]['am']['a_data'])
                        ? $this->conf['tables'][$tableName]['fields'][$fieldName]['am']['a_data']
                        : null
                );
                unset($data[$fieldName]);
            }
            if (empty($this->conf['tables'][$tableName]['fields'][$fieldName]['type'])
                && !empty($this->conf['tables'][$tableName]['unset_no_type'])) {
                unset($data[$fieldName]);
                continue;
            }
            if ($fieldName == 'pos') {
                $posCond = array();
                foreach ($this->ctrl->posCond as $posFieldName => $posFieldCond) {
                    if ($posFieldName == 'pos') continue;
                    if (!empty($data[$posFieldName]) && misc::get($this->data, $posFieldName) != $data[$posFieldName]) {
                        $posCond[$posFieldName] = $data[$posFieldName];
                    }
                }

                foreach ($this->ctrl->posFields as $posFieldName) {
                    if ($posFieldName == 'pos') {
                        $setPos = 1;
                        continue;
                    }
                    if (!empty($data[$posFieldName]) && misc::get($this->data, $posFieldName) != $data[$posFieldName]) {
                        $posCond[$posFieldName] = $data[$posFieldName];
                    }
                }

                if ($posCond || !empty($setPos)) $data['pos'] = $this->getPos($tableName, $posCond);
                continue;
            }
            if (!empty($fields[$fieldName]['not_exists_in_db'])) {
                unset($data[$fieldName]);
                continue;
            }
            if (isset($fields[$fieldName]['type'])) {
                switch (strtolower($fields[$fieldName]['type'])) {
                    case 'file':
                    case 'flash':
                    case 'video':
                    case 'audio':
                    case 'image':
                        if (!$data[$fieldName]['name']) {
                            unset($data[$fieldName], $this->files[$fieldName]);
                            continue;
                        }
                        $parts        = explode('.', $data[$fieldName]['name']);
                        $ext          = strtolower(array_pop($parts));
                        if (is_array($fields[$fieldName]['allowed_ext'])) {
                            if (!in_array($ext, $fields[$fieldName]['allowed_ext'])) {
                                $this->ctrl->result_descr = lang::p('file_not_allowed_ext', '[ext]', $ext);
                                return null;
                            }
                        } elseif ($ext !== $fields[$fieldName]['allowed_ext']) {
                            $this->ctrl->result_descr = lang::p('file_not_allowed_ext', '[ext]', $ext);
                            return null;
                        }
                        $this->files[$fieldName] = misc::inheritArrayAdvanced($data[$fieldName], array('ext' => $ext, 'zf' => $fields[$fieldName]));
                        $filesCnt++;
                        break;

                    case 'date': $value = db::date_to_db($this->db, $value); break;
                    case 'datetime': $value = db::datetime_to_db($this->db, $value); break;
                }
            }
        }
        return $filesCnt ? $this->uploadFiles($tableName, $data) : $data;
    }

    protected function afterSave($tableName, $data, $cond, $ret)
    {
        foreach ($this->files as $field => $file) {
            if ($file['zf']['type'] == 'video' and isset($data[$field])) {
                $this->prepareVideo(
                    '.'.$data[$field],
                    '.'.str_replace('[dir]','original', $data[$field]),
                    $file['zf'],
                    $tableName,
                    $this->showVideoField,
                    $this->showVideoValue,
                    (empty($cond) ? "id=$ret" : (!is_array($cond) ? "id=$cond" : 'id='.current($cond)))
                );
            }
        }
    }

    protected function uploadFile($file)
    {

    }

    protected function prepareToOutput($tableName, $fields)
    {
        if (!is_array($fields)) return;
        foreach ($fields as $fieldName) {
            if (empty($this->conf['tables'][$tableName]['fields'][$fieldName]['am']['type'])) continue;
            switch ($this->conf['tables'][$tableName]['fields'][$fieldName]['am']['type']) {
                case 'date': $this->data[$fieldName] = db::date_from_db($this->db, $this->data[$fieldName]); break;
                case 'datetime': $this->data[$fieldName] = db::datetime_from_db($this->db, $this->data[$fieldName]); break;
            }
        }
    }

    protected function resizeImage($fname, $fileName, $file)
    {
        foreach ($file['dirs'] as $dir => $params) {
            $dest  = str_replace('[dir]', $dir, $fname);
            $dname = dirname($dest);
            if (!is_dir($dname)) {
                misc::create_dir($dname, 0777, '');
            }
            image::img_resize($fileName, $dest, $params['w'], $params['h'],
                0777, $params['ratio'], !empty($params['cut']) ? $params['cut'] : 0, !empty($params['q']) ? $params['q'] : 80, !empty($params['colormode']) ? $params['colormode']: 'color', !empty($params['watermark_img']) ? $params['watermark_img'] : 0);
        }
    }

    protected function watermarkImage($fileName, $watermark_image){
        image::watermark_image($fileName, $fileName, $watermark_image);
    }

    protected function getPath($tableName, $file)
    {
        $dir = 'public/userfiles/'.(empty($file['zf']['dir']) ? $tableName : rtrim($file['zf']['dir'], '/')).'/';
        if ($file['zf']['type'] == 'image' or $file['zf']['type'] == 'video' or $file['zf']['type'] == 'audio') {
            $dir .= '[dir]/'.(empty($file['zf']['posfix_dir']) ? '' : rtrim($file['zf']['posfix_dir'], '/').'/');
        }
        return $dir;
    }

    protected function deleteFile($fname, $file)
    {
        if (!strlen($fname)) return;
        if ($fname{strlen($fname) - 1} === '/') return;
        if (strpos($fname, '[dir]') === false) {
            if (file_exists(ltrim($fname, '/'))) {
                debug::add_log("deleting file \"$fname\"");
                unlink(ltrim($fname, '/'));
            }
        } else {
            if(isset($file['dirs'])){
                foreach ($file['dirs'] as $dir => $params) {
                    $filename = str_replace('[dir]', $dir, ltrim($fname, '/'));
                    if (!empty($params['ext'])) {
                        $filename = str_replace('.'.pathinfo($filename, PATHINFO_EXTENSION), '.'.$params['ext'], $filename);
                    }
                    if (file_exists($filename)) {
                        debug::add_log("deleting file \"$filename\"");
                        unlink($filename);
                    }
                }
            }
            $filename = str_replace('[dir]', 'original', ltrim($fname, '/'));
            if (file_exists($filename)) {
                debug::add_log("deleting file \"$filename\"");
                unlink($filename);
            }
            $filename = str_replace('[dir]', 'icon', ltrim($fname, '/'));
            if (file_exists($filename)) {
                debug::add_log("deleting file \"$filename\"");
                unlink($filename);
            }
        }
    }


    protected function getFileName($file, $dir=null)
    {
        $file['name'] = lang::transliterate($file['name']);
        if ($dir) {
            if (file_exists($dir.$file['name'])) {
                $fileName = basename($file['name'], '.'.$file['ext']).'_copy('.time().'_'.rand().').'.$file['ext'];
            }
            else {
                $fileName = $file['name'];
            }
        }
        else {
            $fileName = basename($file['name'], '.'.$file['ext']).'_copy('.time().'_'.rand().').'.$file['ext'];
        }
        return $fileName;
    }

    protected function uploadFiles($tableName, $data)
    {
        foreach ($this->files as $fieldName => $file) {
            if (!empty($this->data[$fieldName])) {
                $this->deleteFile(ltrim($this->data[$fieldName], '/'), $file['zf']);
            }

            $dir     = $this->getPath(!empty($data['model']) ? $data['model'] : $tableName, $file);
            $dirName = str_replace('[dir]', 'original', $dir);
            $file_clean = $this->getFileName($file, $dirName);

            $fname    = $dir.$file_clean;
            $fileName = $dirName.$file_clean;

            if (!is_dir($dirName)) {
                misc::create_dir($dirName, 0777, '');
            }
            if (!empty($file['move'])) {
                if (!rename($file['tmp_name'], $fileName)) {
                    $this->ctrl->result_descr .= lang::p('file_upload_failure', '[filename]', $fileName);
                }
            } else {
                if (!move_uploaded_file($file['tmp_name'], $fileName)) {
                    $this->ctrl->result_descr .= lang::p('file_upload_failure', '[filename]', $fileName);
                }
            }
            if ($file['zf']['type'] == 'image') {
                $this->resizeImage($fname, $fileName, $file['zf']);
                unset($this->files[$fieldName]);
            } else if ($file['zf']['type'] == 'file') {
                unset($this->files[$fieldName]);
            } else if ($file['zf']['type'] == 'video') {
                //$this->prepareVideo($fname, $fileName, $file['zf']);
            } else if ($file['zf']['type'] == 'audio') {
                $this->prepareAudio($fname, $fileName, $file['zf']);
            }
            $data[$fieldName] =  zf::$zf_root_url.$fname;
        }
        return $data;
    }
    protected function prepareVideo($fname, $fileName, $file, $tableName, $field, $value, $cond)
    {
        $fileName = escapeshellarg(realpath($fileName));
        $fname = str_replace('.'.pathinfo($fname, PATHINFO_EXTENSION), '.[ext]', $fname);
        $commands = array();
        foreach ($file['dirs'] as $folder => $params) {
            $ext = $params['ext'];
            unset($params['ext']);
            $args = array();
            foreach ($params as $arg => $val) {
                $args[] = '-'.$arg.' '.$val;
            }
            $args = implode(' ', $args);
            $name = str_replace(array('[dir]', '[ext]'), array($folder, $ext), $fname);
            if (!is_dir(pathinfo($name, PATHINFO_DIRNAME))) {
                misc::create_dir(pathinfo($name, PATHINFO_DIRNAME), 0777, '');
            }
            $name = escapeshellarg(getcwd().'/'.$name);
            $script_name = escapeshellarg(realpath('./zf/tools/ffmpeg.php'));
            $commands[] = "php $script_name -y -i $fileName $args $name > ".ROOT_PATH.".zf_tmp/".date('Y-m-d_H-i-s_').md5("php $script_name -y -i $fileName $args $name").".log";
        }
        $conf = $this->ctrl->app->conf['run_at'][$this->ctrl->app->run_at];
        $dsn  = $conf['db_engine'].'://'.$conf['db_user'].':'.$conf['db_pass'].'@'.$conf['db_host'].'/'.$conf['db_name'];
        $script_name = escapeshellarg(realpath('./zf/tools/mysql.php'));
        $commands[] = "php $script_name -dsn $dsn -t ".$this->db->getPrefix()."$tableName -f $field -v $value -w $cond > ".ROOT_PATH.".zf_tmp/".date('Y-m-d_H-i-s_').md5("php $script_name -y -i $fileName $args $name").".log";
        $file = array();
        if (is_file("./public/userfiles/$tableName/original/convert.txt")) {
            $file = file("./public/userfiles/$tableName/original/convert.txt");
            $file = array_map('trim', $file);
        }
        $commands = array_diff($commands, $file);
        if (!empty($commands)) {
            misc::file_safe_put("./public/userfiles/$tableName/original/convert.txt", implode("\n", $commands)."\n", FILE_APPEND);
        }
    }

    protected function prepareAudio($fname, $fileName, $file)
    {
        $fileName = escapeshellarg(realpath($fileName));
        $fname = str_replace('.'.pathinfo($fname, PATHINFO_EXTENSION), '.[ext]', $fname);
        foreach ($file['dirs'] as $folder => $params) {
            $ext = $params['ext'];
            unset($params['ext']);
            $args = array();
            foreach ($params as $arg => $val) {
                $args[] = '-'.$arg.' '.$val;
            }
            $args = implode(' ', $args);
            $name = str_replace(array('[dir]', '[ext]'), array($folder, $ext), $fname);
            if (!is_dir(pathinfo($name, PATHINFO_DIRNAME))) {
                misc::create_dir(pathinfo($name, PATHINFO_DIRNAME), 0777, '');
            }
            $name = escapeshellarg(getcwd().'/'.$name);
            $script_name = escapeshellarg(realpath('./zf/tools/ffmpeg.php'));
            misc::execInBg("php $script_name -y -i $fileName $args $name");
        }
    }

    public function Delete($tableName, $cond)
    {
        if ($this->no_deleting($tableName)) {
            if (isset($this->conf['tables'][$tableName]['fields']['deleted'])) {
                return $this->Save($tableName, array('deleted' => 'yes'), $cond);
            }
            else {
                debug::add('Несмотря на запрет удаления строк, в таблице '.$tableName.' отсутствует поле deleted.<br/>'.
                        'deleted: {type: "enum(\'yes\',\'no\')", default: \'no\', notnull: 1, am: {type: string, title: Удален, values: {no: нет, yes: да}}}',
                    'error');
                return null;
            }
        } elseif ($this->loadBeforeDelete) {
            $this->initFields($tableName);
            if (!is_array($cond)) {
                $key   = 'id';
                $value = $cond;
            } else {
                list($key, $value) = each($cond);
            }
            if (strtolower($key) == 'id' && (!empty($this->conf['tables'][$tableName]['foreign']) || $this->virtual_fields)) {
                $gCond[$tableName.'.'.$key] = $value;
            } else {
                $gCond = $cond;
            }

            if ($this->virtual_fields) {

            }

            $this->GetByCond($tableName, array(), $gCond, 1);
            if (misc::get($this->data, 'undeletable') === 'yes') {
                return -1;
            }
            $ret = parent::Delete($tableName, $cond);
            if ($ret) {
                $fields = $this->getFields($tableName, 'all');
                // deleting image and file =======>
                if ($fields) {
                    foreach ($fields as $fieldName => $field) {
                        if (!empty($field['type'])
                            && in_array($field['type'], array('image', 'images', 'file', 'files', 'flash', 'video', 'audio'))) {
                            if ($field['type'] == 'files' || $field['type'] == 'images') {
                                foreach($this->data[$fieldName] as $val) {
                                    $this->deleteFile($val[$field['field_name']], $field);
                                }
                            } else {
                                $this->deleteFile($this->data[$fieldName], $field);
                            }
                        }
                    }
                }
                // <======= deleting image and file

                // deleting virtual references =======>
                if (!empty($cond['id'])) {
                    $deleteVirt = array();
                    foreach ($this->virtual_fields as $vFieldName => $vField) {
                        if (empty($this->refs[$this->fields[$tableName][$vFieldName]['use_ref']]['tables'][$tableName])) {
                            $ref_from = array();
                            $ref_to   = array();
                            foreach ($this->refs[$this->fields[$tableName][$vFieldName]['use_ref']]['tables'] as $refs) {
                                foreach ($refs as $ref) {
                                    if ($ref['table'] == $tableName) {
                                        $ref_from = $ref;
                                    } else {
                                        $ref_to = $ref;
                                    }
                                }
                                if ($ref_from) break;
                            }
                            $deleteVirt[] = $ref_to;
                        } else {
                            $ref = $this->refs[$this->fields[$tableName][$vFieldName]['use_ref']]['tables'];
                            unset($ref[$tableName]);
                            $deleteVirt[] = array('table' => key($ref), 'field' => current($ref));
                        }
                    }

                    foreach ($deleteVirt as $virt) {
                        $this->data = null;
                        $this->Delete($virt['table'], array($virt['field'] => $cond['id']));
                    }
                }
                // <======= deleting virtual references
            }
            return $ret;
        } else {
            return parent::Delete($tableName, $cond);
        }
    }

    public function deleteFromImages($encodedName) {
        $image = base64_decode($encodedName.'==');
        $res = $this->db->one("
		SELECT model FROM ?t WHERE
		?t LIKE ?
		",
            $this->tables['images'],
            'image',
            '%'.$image
        );
        $dirs = array_keys($this->model('images', 'images')->conf['tables']['images']['dirs'][$res]);
        foreach ($dirs as $dir) {
            unlink(ROOT_PATH.'public/userfiles/'.$res.'/'.$dir.'/'.$image);
        }
        unlink(ROOT_PATH.'public/userfiles/'.$res.'/original/'.$image);
        $this->db->query("
		DELETE FROM ?t WHERE
		?t LIKE ?
		",
            $this->tables['images'],
            'image',
            '%'.$image);
    }

    public function deleteFileFromElement($tableName, $cond, $fieldName, $deleteSQL=false)
    {
        $field = misc::get($this->getFields($tableName, array($fieldName)), $fieldName);
        $file  = misc::get($this->GetByCond($tableName, array($fieldName), $cond), $fieldName);

        list($sql, $args) = $this->getConditions($tableName, array('where' => $cond));
        if ($deleteSQL) {
            $res = $this->db->query('DELETE FROM ?t '.$sql,
                array_merge(array($this->tables[$tableName]), $args));
        } else {
            $res = $this->db->query('UPDATE ?t SET ?t = "" '.$sql,
                array_merge(array($this->tables[$tableName], $fieldName), $args));
        }
        if ($res !== null) {
            $this->deleteFile($file, $field);
            return 1;
        }
        return 0;
    }
    public function needPaging($tableName)
    {
        return !empty($this->conf['tables'][$tableName]['paging']) ? $this->conf['tables'][$tableName]['paging'] : array();
    }

    public function setNPPToCookie($npp, $paging)
    {
        $path = zf::$root_url;
        if (!empty($paging['cookie']['path'])) {
            if ($paging['cookie']['path'] == 'relative') $path = null;
            elseif ($paging['cookie']['path'] == 'absolute') $path == zf::$root_url;
            else $path == $paging['cookie']['path'];
        }
        return setcookie(
            'npp',
            $npp,
            time() + (!empty($paging['cookie']['expire']) ? $paging['cookie']['expire'] * 86400 : 2592000) ,
            $path
        );
    }

    public function no_deleting($tableName)
    {
        return misc::get($this->conf['tables'][$tableName], 'do_not_delete') === true;
    }
    public function no_deleting_cond($tableName, $cond)
    {
        // Если в таблице сказано что строки удалять нельзя, и в условии не задано 'all' или конкретное значение
        // то по умолчанию "удаленные" не отображать.
        if ($this->no_deleting($tableName)){
            if (!isset($cond['where']['deleted'])) {
                $cond['where']['deleted'] = 'no';
            } elseif ($cond['where']['deleted'] == 'both') {
                unset ($cond['where']['deleted']);
            }
        }
        return $cond;
    }

    public function getList($tableName, $fields, $cond = array(), $additionalSql = '', $additionalArgs = array(), $fSQL = '')
    {
        $cond = $this->no_deleting_cond($tableName, $cond);
        return parent::getList($tableName, $fields, $cond, $additionalSql, $additionalArgs, $fSQL);
    }

    public function getListJoined($tableName, $fields, $cond = array(), $additionalSql = '', $additionalArgs = array(), $fSQL = '?li')
    {
        $cond = $this->no_deleting_cond($tableName, $cond);
        return parent::getListJoined($tableName, $fields, $cond, $additionalSql, $additionalArgs, $fSQL);
    }
    public function getPage($tableName, $fields, &$total, $from, $npp, $cond = array(), $additionalSql = '', $additionalArgs = array())
    {
        $cond = $this->no_deleting_cond($tableName, $cond);
        return parent::getPage($tableName, $fields, $total, $from, $npp, $cond, $additionalSql, $additionalArgs);
    }
    public function getPageJoined($tableName, $fields, &$total, $from, $npp, $cond = array(), $additionalSql = '', $additionalArgs = array(), $fSQL = '?li')
    {
        if (is_string($fields) and !empty($fields)) {
            $fields = $this->getFieldsNames($tableName, $fields);
        }
        $cond = $this->no_deleting_cond($tableName, $cond);
        return parent::getPageJoined($tableName, $fields, $total, $from, $npp, $cond, $additionalSql, $additionalArgs, $fSQL);
    }
    public function Shift($tableName, $id, $to, $cond = array(), $posFields = array('pos')) {
        $tmp = $this->no_deleting_cond($tableName, array('where' => $cond));
        $cond = $tmp['where'];
        return parent::Shift($tableName, $id, $to, $cond, $posFields);
    }

    public function crop_image($id, $tableName, $field, $dir, $area, $conf)
    {
        $dconf = (!empty($conf)) ? $conf : $this->conf['tables'][$tableName]['images'][$field][$dir];
        $image = $this->get($id, $tableName, array($field));
        $image = $image[$field];
        $cropdir = isset($dconf['cropdir']) ? $dconf['cropdir'] : 'original';
        $from = ROOT_PATH.str_replace('[dir]', $cropdir, $image);
        $to = str_replace('[dir]', $dir, $image);
        $temporary = tempnam('.zf_tmp', 'crop_');
        image::img_crop($from, $temporary, $area);
        if (empty($dconf['chmod'])) $dconf['chmod'] = 0777;
        if (empty($dconf['cut'])) $dconf['cut'] = 0;
        if (empty($dconf['quality'])) $dconf['quality'] = 100;
        if (empty($dconf['colormode'])) $dconf['colormode'] = 0xffffff;
        if (is_file(ROOT_PATH.$to)) { unlink(ROOT_PATH.$to); }
        image::img_resize($temporary, ROOT_PATH.$to, $dconf['w'], $dconf['h'], $dconf['chmod'], $dconf['ratio'], $dconf['cut'], $dconf['quality'], $dconf['colormode']);
        unlink($temporary);
    }
}
?>