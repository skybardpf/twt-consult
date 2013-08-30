<?php
class AdvancedController extends Controller
{
    public    $posCond      = array();
    public    $posFields    = array('pos');
    protected $listCond     = array();
    protected $modifyCond   = array();
    protected $showCond     = array();
    protected $delCond      = array();
    protected $dontSetPos   = 0;
    protected $fields       = array();
    protected $model        = null;
    protected $fieldsNames  = array();
    public    $result_descr = '';
    protected $idFieldName  = 'id';
    protected $hasImages    = 0;
    public    $currAction   = '';
    protected $actionName   = '';
    protected $actionNames   = '';
    protected $formAction   = '';
    protected $fields2save  = array();
    public    $titles       = array();
    /**
     * Folder from load
     * 
     * @var string
     */
    public $use_folder = 'actions';

    /**
    * Returns loaded Model object represented by $modName and $ctrlName
    * 
    * @param string $modName
    * @param string $ctrlName
    * @return AdvancedModel
    */
    public function model($modName = '', $ctrlName = '')
    {
        return parent::model($modName, $ctrlName);
    }
    
    protected function actionList($modelNameOrModel, $tableName, $actions, $add, $noContent = '')
    {
        $model = is_object($modelNameOrModel) ? $modelNameOrModel : $this->model($modelNameOrModel);
        $this->page->idFieldName = $this->idFieldName;
        if ($this->app->request->pos) {

            $pos = (empty($this->conf['reverse_pos_order']) || $this->conf['reverse_pos_order'] == false)
                    ? $this->app->request->pos
                    : (($this->app->request->pos == 'up') ? 'down' : 'up');
            $model->Shift($tableName, $this->app->request->id, $pos, $this->posCond, $this->posFields);
            $location = $_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : zf::$root_url;
            if (empty($this->app->conf['modes'][$this->app->mode]['autoredirect']) && 0) {
                $this->page->result  = lang::p('pos_changed');
                $this->page->retLink = $location;
                $this->page->content = $this->renderView('result', 'actions');
                return;
            } else {
                header("Location: $location");
                exit;
            }
        }

        // Обработка поля, отвечающего за вывод информации о редакторе.
        $moder_fields = (isset($model->conf['tables'][$tableName]['moder_fields'])) ? $model->conf['tables'][$tableName]['moder_fields'] : array();
        if ($moder_fields) {
            $model->Update(
                $tableName, array($moder_fields['title'] => ''),
                array($moder_fields['date'] => array('<', date('Y-m-d H:i:s', time()-10)))
            );
        }
        // ------------------------------

        $hasPos              = $model->hasField($tableName, 'pos');
        
        $cond                = $this->listCond;
        $this->page->sLink = $this->page->sLink ? $this->page->sLink : (zf::$root_url == '/' ? '' : zf::$root_url). $this->app->request->uri;
        $this->page->sLink = preg_replace('=sort/[^/]*/=', '', $this->page->sLink);
        $this->page->sLink = preg_replace('=ajax/[^/]*/=', '', $this->page->sLink);
        $this->page->sLink = preg_replace('=dir/[^/]*/=', '', $this->page->sLink);
        $this->page->sLink = preg_replace('=page/[^/]*/=', '', $this->page->sLink);
        $this->page->sLink = preg_replace('=/id/[^/]*/=', '/', $this->page->sLink);
        $this->page->sLink = preg_replace('=/!/.*=', '/', $this->page->sLink);
        $this->page->eLink = '';
        if (empty($cond['order']) || (count($cond['order']) == 1  && preg_match('/\.pos$/', key($cond['order'])))) {
            $isSortedByPos = 1;
        } else {
            $isSortedByPos = 0;
        }

        if ($hasPos && $isSortedByPos && !$this->app->request->sort) {
            $cond = !empty($this->listCond['order']) ? $this->listCond : array_merge($this->listCond, array('order' => array($tableName . '.pos' => (isset($this->conf['reverse_pos_order']) && $this->conf['reverse_pos_order']) ? 'desc' : 'asc')));
            $this->page->usePos = 1;
        } elseif ($this->app->request->sort && empty($this->conf['dont_use_sort'])) {
            $fields_conf = $this->model()->conf['tables'][$tableName]['fields'];
            if (!empty($fields_conf[$this->app->request->sort]['virtual'])) {
                if (!empty($fields_conf[$this->app->request->sort]['sort_field'])) {
                    $cond['order'] = array($fields_conf[$this->app->request->sort]['sort_field'] => $this->app->request->dir ? 'ASC' : 'DESC');
                } else {
                    $cond['order'] = array($this->app->request->sort => $this->app->request->dir ? 'ASC' : 'DESC');
                }
            } else {
                $cond['order'] = array($this->app->request->sort => $this->app->request->dir ? 'ASC' : 'DESC');
            }
        }
        if (!empty($this->app->request->post['sort'])) {
            if (!empty($_POST['sort'])) {
                $this->app->request->page = null;
            }
            if (!isset($cond['where'])) {
                $cond['where'] = array();
            }
            $post = array();

            $i = 0;
            foreach ($this->app->request->post['sort'] as $field => $value) {
                $i++;
                $value = trim($value);
                if (!empty($value)) {
                    $post[] = 'sort['.$field.']/'.$value;
                    $sortField = (empty($this->fields)) ? $model->getFields($tableName, array($field)) : $this->fields;
	                if (!empty($sortField[$field]['type'])) {
		                switch ($sortField[$field]['type']) {
	                        case 'ip':
	                            $tmp = explode('.', $value);
	                            $i = 4 - count($tmp);
	                            end($tmp);
	                            if (!current($tmp)) {
	                                $string_from = $string_to = $value.'0';
	                            } else {
	                                $string_from = $string_to = $value;
	                            }
	                            for($t = 1; $t <= $i; $t++) {
	                                $string_from .='.0';
	                                $string_to .='.255';
	                            }
	                            $sortCond = array('BETWEEN ' ,'INET_ATON("'.$string_from.'") AND INET_ATON("'.$string_to.'")', '?i' );
	                        break;
			                case 'date_boxes':
		                    case 'datetime':
	                        case 'date':
	                            $matches = array();
	                            preg_match('|(\d*).?(\d*).?(\d*)|i', $value, $matches);
	                            $date = array('y' => null, 'm' => null, 'd' => null);
	                            for ($i = 1; $i < count($matches); $i++) {
	                                if (strlen($matches[$i]) == 4) {
	                                    $date['y'] = $matches[$i];
	                                } else if (strlen($matches[$i]) == 2) {
	                                    if (!empty($date['y']) and !empty($date['m'])) {
	                                        $date['d'] = $matches[$i];
	                                    } else if (!empty($date['y']) or !empty($date['d'])) {
	                                        $date['m'] = $matches[$i];
	                                    } else if (empty($date['y'])) {
	                                        $date['d'] = $matches[$i];
	                                    }
	                                }
	                            }
	                              $value = ($date['y'] ? $date['y'] : '%') . '-' . ($date['m'] ? $date['m'] : '%') . '-' . ($date['d'] ? $date['d'] : '%');
	                              $sortCond = array('LIKE ', "%$value%", '?');
	                        break;
	                        case 'file':
	                            if ($value == 'have') {
	                                $sortCond = array('LIKE ', "%", '?');
	                            } else {
	                                $sortCond = array('IS', null, '?i');
	                            }
	                        break;
	                        case 'select':
	                            $sortCond = $value;
                            break;
                            case 'checkboxes':
                                $sortCond = $value;
                            break;
                            default:
	                            $sortCond = array('LIKE ', "%$value%", '?');
	                        break;
	                    }
	                } else {
		                $sortCond = array('LIKE ', "%$value%", '?');
	                }
                    if (!empty($model->conf['tables'][$tableName]['admin_sorting']) && !empty($model->conf['tables'][$tableName]['admin_sorting'][$field])) {
                        $admin_cond = $model->conf['tables'][$tableName]['admin_sorting'][$field]['condition'];
                        if(is_array($admin_cond)){
                            $tmp = array();
                            foreach($admin_cond as $ac){
                                $tmp[] = '('.$ac.' LIKE "%'.$value.'%")';

                            }
                            $cond['where']['!raw'.$i] =  '('.implode(' OR ', $tmp).')';
                        } else {
                            $cond['where']['!raw'.$i] = '('.$admin_cond.' LIKE "%'.$value.'%")';
                        }
                    } elseif ((!empty($model->conf['tables'][$tableName]['foreign']) || $model->virtual_fields) and isset($model->conf['tables'][$tableName]['fields'][$field]) and empty($model->conf['tables'][$tableName]['fields'][$field]['virtual']) ) {
                        $cond['where']["$tableName.$field"] = $sortCond;
                    } else if (!empty($model->conf['tables'][$tableName]['foreign']) and isset($model->conf['tables'][$tableName]['foreign'][$field])) {
                        $foreignField = $model->conf['tables'][$tableName]['foreign'][$field];
                        $fTable = $foreignField['table'];
                        if ( !empty($model->conf['refs'][$foreignField['use_ref']]['alias']) ) {
                            $fTable = $model->conf['refs'][$foreignField['use_ref']]['alias'];
                        }
                        if (!empty($foreignField['asis']) && $foreignField['asis']) {
                            // maybe we need to check cond types here
                            $cond['where']['!raw'.$i] = '('.$foreignField['field'].' LIKE "%'.$value.'%")';
                        } else {
                            $cond['where']["$fTable.{$foreignField['field']}"] = $sortCond;
                        }
                    } elseif (!empty($model->conf['tables'][$tableName]['fields'][$field]['virtual'])) {
                        if ($sortCond[0] == 'LIKE ') {
                            $condVirtualTable = str_replace('?_', '', $model->conf['tables'][$tableName]['fields'][$field]['ref_to']['table']);
                            $condVirtual = array();
                            foreach ($model->conf['tables'][$tableName]['fields'][$field]['ref_to']['fields'] as $f) {
                                $condVirtual[] = "$condVirtualTable.$f {$sortCond[0]}'".mysql_real_escape_string($sortCond[1])."'";
                            }
                            $cond['where']['!raw'.$i] =  '('.implode(' OR ', $condVirtual).')';
                        } else {
                            $condVirtualTable = str_replace('?_', '', $model->conf['tables'][$tableName]['fields'][$field]['ref_to']['table']);
                            $condVirtual = array();
                            foreach ($model->conf['tables'][$tableName]['fields'][$field]['ref_to']['fields'] as $f) {
                                $condVirtual[] = "$condVirtualTable.$f = '".mysql_real_escape_string($sortCond)."'";
                            }
                            $cond['where']['!raw'.$i] =  '('.implode(' OR ', $condVirtual).')';
                        }
                    } else {
                        $cond['where']["$tableName.$field"] = $sortCond;
                    }
                }
            }
               $post = implode('/', $post);;
            if (!strpos($this->page->eLink, '!/')) {
                $this->page->eLink .= '!/'.$post.'/';
            } else {
                $this->page->eLink .= $post.'/';
            }
        }
        if (!$this->page->items) {
            $paging = $model->needPaging($tableName);
            if (!isset($_COOKIE['npp']) and !empty($paging) && !empty($paging['npps'])) {
                $model->setNPPToCookie($paging['npp'], $paging);
                header('Location: '.zf::$root_url.rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)), '/');
            }
            if (!empty($_GET['npp'])) {
                $model->setNPPToCookie($_GET['npp'], $paging);
                header('Location: '.zf::$root_url.rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)), '/');
            }
            if (!empty($paging)) {
                $this->page->paging = $paging;
            }
            if (!empty($paging) or (isset($_COOKIE['npp']) and $_COOKIE['npp'] != 'all')) {
                $paging['total'] = 0;
                $stop            = 0;
                if (!empty($_COOKIE['npp']) and intval($_COOKIE['npp']) > 0) {
                    $paging['npp'] = intval($_COOKIE['npp']);
                }
                do {
                    $paging['from'] = $this->app->request->page ? ($this->app->request->page-1)*$paging['npp']: 0;
                    if ($paging['total'] && $paging['from'] > $paging['total']) {
                        $this->app->request->page = 0;
                        $paging['from']           = 0;
                        $stop                     = 1;
                    }
                    $this->page->items = $model->getPageJoined($tableName, $this->fieldsNames ? $this->fieldsNames : $model->getFieldsNames($tableName, $this->actionName ? $this->actionName : 'list'), $paging['total'], $paging['from'], $paging['npp'], $cond);
                    debug::add_log("!!!!!!!!!!!!!!!!!");
                    debug::add($this->page->items);
                    if ($this->app->request->id && !$stop) {
                        $items_ids = misc::array_extract_field($this->page->items, $this->idFieldName);
                        if (!in_array($this->app->request->id, $items_ids)) {
                            $this->app->request->page += 1;
                        } else {
                            $this->app->request->uri = str_replace("/id/{$this->app->request->id}", '', $this->app->request->uri);
                            $stop = 1;
                        }
                    } else {
                        $stop = 1;
                    }
                } while (!$stop);
                $paging['base_url'] = ''; //zf::$root_url == '/' ? '' : zf::$root_url;

                if (strpos($this->page->sLink, '/page/')) {
                    $paging['base_url'] .= preg_replace('#/page/.+#', '/page/', $this->page->sLink);
                } else {
                    $paging['base_url'] .= preg_replace('#(/$)#', '/page/', $this->page->sLink);
                }
                
                if ($this->app->request->sort) {
                	$paging['base_url'] = preg_replace('#/page/#', "/sort/{$this->app->request->sort}/page/", $paging['base_url']);
                }
                if ($this->app->request->dir !== null) {
                	$paging['base_url'] = preg_replace('#/page/#', "/dir/{$this->app->request->dir}/page/", $paging['base_url']);
                }
                
                if ($this->app->request->page == 1) {
                    header('HTTP/1.1 301 Moved Permanently');
                    header('Location: ' . preg_replace(
                        '#/page/.+/#U', '/', $this->page->sLink . $this->page->eLink)
                    );
                    exit;
                }
                
                $paging['url_append'] = '/'.$this->page->eLink;
                if ($this->app->request->query) $paging['url_append'] .= '?'.$this->app->request->query;
                $paging['curr_page']  = $paging['from']/$paging['npp'] + 1;
                $paging['pages']      = ceil($paging['total']/$paging['npp']);
                if (!isset($paging['separator'])) $paging['separator'] = ' ';
                if (!isset($paging['skip'])) $paging['skip']   = ' ... ';
                $this->page->paging = $paging;
            } else {
                $this->page->items = $model->getList($tableName, $this->fieldsNames ? $this->fieldsNames : $model->getFieldsNames($tableName, $this->actionName ? $this->actionName : 'list'), $cond);
            }
        } //Здесь идет вытаскивание значений полей.  

        if (!$this->page->fields) {
            $this->page->fields = $model->getFields($tableName, $this->actionName ? $this->actionName : 'list');
        }
          //Здесь идет вытаскивание информации о полях.     
        
        if (!$this->page->titles) $this->page->titles    = $model->getTitles($tableName, $this->actionName ? $this->actionName : 'list');
          // Здесь идет вытаскивание названия полей
        
        if ($hasPos && !$this->dontSetPos) {
            $link = '';
            if ($this->app->request->pid) {
                $link .= "/pid/{$this->app->request->pid}";
            }
            
            if ($this->app->request->model) {
                $link .= "/model/{$this->app->request->model}";
            }
            $actions = array_merge(
            array(
                "{$this->ctrlName}/{$this->app->request->url}/pos/up/id/[id]".$link.'/' => lang::p('move_up'),
                "{$this->ctrlName}/{$this->app->request->url}/pos/down/id/[id]".$link.'/' => lang::p('move_down')
            ), $actions);
        } else {
            $this->page->dontSetPos = true;
        }
        $this->page->actions   = $actions;
        
        $this->page->add       = $add;
        $this->page->noContent = $noContent ? $noContent : lang::p('no_objects');  
          // Здесь прописывается то , что будет выведенно на экран , если нету объектов
        $this->page->content   = $this->renderView($this->view ? $this->view : 'list', $this->use_folder ? $this->use_folder : null);
    }
    
    protected function actionShow($modelName, $tableName)
    {
        $model = $this->model($modelName, $modelName);
        
        $fields = $this->fields ? $this->fields : $model->getFields($tableName, $this->actionNames ? $this->actionNames : 'show');
        $fieldsNames = $this->fieldsNames ? $this->fieldsNames : $model->getFieldsNames($tableName, $this->actionNames ? $this->actionNames : 'show');
        $fieldsNames = $model->check_placeholders($fieldsNames, $tableName);
        $titles = $this->titles ? $this->titles : $model->getTitles($tableName, $this->actionNames ? $this->actionNames : 'show');
        if ($this->page->data) {
            $data = $this->page->data;
        } else {
	        if (empty($this->showCond)) {
                $data = $model->Get($this->app->request->id, $tableName, $fieldsNames);

            } else {
                $data = $model->GetByCond($tableName, $this->fieldsNames ? $this->fieldsNames : $model->getFieldsNames($tableName, $this->actionNames ? $this->actionNames : 'show'), $this->showCond);
            }
        }
        $this->page->fields = $fields;
        $this->page->titles = $titles;
        $this->page->data = $data;

        $this->page->content = $this->renderView($this->view ? $this->view : 'show',  $this->use_folder ? $this->use_folder : null);
    }
    
    protected function actionModify($modelNameOrModel, $tableName, $msg_success, $msg_error, $retLink = '', $additionalData = array())
    {
        $model = is_object($modelNameOrModel) ? $modelNameOrModel : $this->model($modelNameOrModel);
        
        if (!$this->currAction) {
            $action = $this->app->request->id !== null ? 'modify' : 'add';
        } else {
            $action = $this->currAction;
        }

        $this->fieldsNames = $this->fieldsNames ? $this->fieldsNames : $model->getFieldsNames($tableName, $action);

        if ($_POST && empty($_POST['dont_save'])) {
            if ($model->hasField($tableName, 'pos') && !array_search('pos', $this->fieldsNames) && $action == 'add') {
                $this->fieldsNames[] = 'pos';
            } elseif ($model->hasField($tableName, 'pos') && ($posKey = array_search('pos', $this->fieldsNames)) && $action == 'modify') {
                unset($this->fieldsNames[$posKey]);
            }    
        }
        $fields = $this->fields ? $this->fields : $model->getFields($tableName, $this->fieldsNames);

        // Обработка получения поля, отвечающего за вывод информации о редакторе.
        $fields_for_data = $this->fieldsNames ? $this->fieldsNames : $model->getFieldsNames($tableName, $action);
        $moder_fields = (isset($model->conf['tables'][$tableName]['moder_fields'])) ? $model->conf['tables'][$tableName]['moder_fields'] : array();
        if ($moder_fields && $_POST && isset($_POST['heart_beat']) && $_POST['heart_beat']) {
            $model->Update($tableName, array($moder_fields['date'] => date('Y-m-d H:i:s')), (empty($this->modifyCond)) ? array('id' => $this->app->request->id) : $this->modifyCond);
            exit('updated date.');
        }
        if ($moder_fields) {
            $fields_for_data = array_merge($fields_for_data, array($moder_fields['title'], $moder_fields['date']));
        }
        // ------------------------------

	    $fields_for_data = $model->check_placeholders($fields_for_data, $tableName);
        if (empty($this->modifyCond)) {
            $model_data = $model->Get($this->app->request->id, $tableName, $fields_for_data);
        } else {
            $model_data = $model->GetByCond($tableName, $fields_for_data, $this->modifyCond);
        }
        $is_locked = false;
        if (($moder_fields && !$_POST && isset($model_data[$moder_fields['title']]) && $model_data[$moder_fields['title']])) {
            $is_locked = $model_data[$moder_fields['date']] > date('Y-m-d H:i:s', time()-10);
        }
        if ($is_locked) {
            $this->page->content = isset($this->conf['moder_message']) ? $this->conf['moder_message'] : lang::p('is_opened');
            return 0;
        }

        $data = ($this->app->request->id !== null && !$_POST)
            ? array_merge($model_data, $additionalData) : array_merge($_POST, $additionalData);
/*
        if ($action == 'add' && array_key_exists('pos', $fields)) {
            $fields['pos']['default'] = $model->getPos($tableName, $this->posCond);
        }
*/
        $this->loadForm('modify', $fields, $data, $this->formAction);
        $isValid = false;
        if (!(($_POST || $_FILES) && empty($_POST['dont_save']) && ($isValid = $this->form('modify')->validate($model))) && !$is_locked && $moder_fields) {
            zf::addJS('moder_script', '/public/cms/js/moder_script.js');
            $this->page->moder_script_is_on = true;
            $this->page->moder_lock_url = $this->page->root_url.$_SERVER['REQUEST_URI'];
            $model->Update(
                $tableName,
                array($moder_fields['title'] => $this->page->user['name'], $moder_fields['date'] => date('Y-m-d H:i:s')),
                (empty($this->modifyCond)) ? array('id' => $this->app->request->id) : $this->modifyCond
            );

        }

        if (($_POST || $_FILES) && empty($_POST['dont_save'])) {
            if ($isValid) {
                $data = $this->form('modify')->getData();
                if ($moder_fields && !$is_locked) {
                    $data[$moder_fields['title']] = '';
                }
                if ($additionalData) $data = array_merge($data, $additionalData);
        
                if (!$this->app->request->id && $model->hasField($tableName, 'pos')) {
                    $data['pos'] = $model->getPos($tableName, $this->posCond);
                }
                if (empty($this->modifyCond)) {
                    $cond = $this->app->request->id;
                } else {
                    $cond = array();
                    foreach ($this->modifyCond['where'] as $k => $v) {
                        $cond[str_replace($tableName.'.', '', $k)] = $v;
                    }
                }
                if (!empty($this->fields2save)) {
                    $data = array_intersect_key($data, array_flip($this->fields2save));
                }
                if (($ret = $model->Save($tableName, $data, $cond)) === null) {
                    $this->page->result       = $msg_error;
                    $this->page->result_descr = $this->result_descr;
                    if ($this->app->log_deleter) {
                        call_user_func($this->app->log_deleter, $this->app);
                    }
                } else {
                    if (!$this->app->request->id && $this->app->log_updater) {
                        call_user_func($this->app->log_updater, $this->app, array('object_id' => $ret));
                    }
                    //чистим кеш
                    if (!empty($this->app->conf['modes'][$this->app->mode]['smarty']['partial_caching'])) {
                        $this->page->smarty()->clear_all_cache();
                    }
                    $this->page->result_save  = $ret;
                    $this->page->result  = $msg_success;
                }
                $this->page->retLink = ($this->page->retLink) ? $this->page->retLink : str_replace('[ret]', $ret, $retLink ? $retLink : (!empty($this->retLink) ? $this->retLink : ''));
                $this->page->content = $this->renderView('result', 'actions');//$this->use_folder ? $this->use_folder : null);
                return $ret;
            } else {
                if ($this->app->log_deleter) {
                    call_user_func($this->app->log_deleter, $this->app);
                }
                $this->page->errors = $this->form('modify')->getErrors();
            }
        }
        $this->page->content = $this->renderView($this->view ? $this->view : 'modify',  $this->use_folder ? $this->use_folder : null);
        return 0;
    }

    /** Удаление элемента из таблицы, возвращает true в случае успешного удаления и false
     *  если удаления не было. (например при запросе на подтверждение)
     *
     * @param $modelNameOrModel
     * @param $tableName
     * @param $msg_success
     * @param $msg_fail
     * @param string $retLink
     * @param string $question
     * @return void
     */
    public function actionDelete($modelNameOrModel, $tableName, $msg_success, $msg_fail, $retLink = '', $question = '')
    {
        $model = is_object($modelNameOrModel) ? $modelNameOrModel : $this->model($modelNameOrModel);
        $modelName = $model->modName;
        if (isset($_POST['delete'])) {
            if ($_POST['delete']) {
                $result  = $model->Delete($tableName, $this->delCond ? $this->delCond : array('id' => $this->app->request->id));
                //чистим кеш
                if (!empty($this->app->conf['modes'][$this->app->mode]['smarty']['partial_caching'])) {
                    $this->page->smarty()->clear_all_cache();
                }

                if ($result == -1) {
                    $this->page->result       = $msg_fail;
                    $this->page->result_descr = lang::p('undeletable');
                } elseif ($result) {
                    $this->page->result       = $msg_success;
                } else {
                    $this->page->result       = $msg_fail;
                }
                if ($this->hasImages && $this->page->result) {
                    $this->model('images', 'images')->Delete('images',
                        array('where' => array('model' => $modelName, 'pid' => $this->app->request->id)), $modelName);
                }
                $this->page->retLink = !empty($this->retLink) ? $this->retLink : $retLink;
                $this->page->content = $this->renderView('result', 'actions');//$this->use_folder ? $this->use_folder : null);
                return ($result);
            }
            else {
                header('Location: '.str_replace(
                    array('[root_url]', '[pid]', '[type]', '[link]'),
                    array(
                        zf::$root_url,
                        $this->app->request->pid ? $this->app->request->pid : $this->app->request->id,
                        $this->app->request->type,
                        $this->app->request->link),
                    ($retLink ? $retLink : zf::$root_url)));
                exit;
            }
        }
        else {
            $this->page->question = $question ? $question : lang::p('delete_object?');
            $this->page->yes      = lang::p('yes');
            $this->page->no       = lang::p('no');            
            $this->page->content  = $this->renderView('delete_confirmation', $this->use_folder ? $this->use_folder : null);
            return false;
        }        
    }
    
    protected function actionComplexDelete($modelName, $tablesNames, $conds, $msgs_success, $msgs_fail, $retLink, $delimiter = '<br />')
    {
        $results = array();
        foreach ($tablesNames as $key => $tableName) {
            $result = $this->model($modelName)->Delete($tableName, $conds[$key]);
            if ($result) {
                $results[] = is_array($msgs_success) ? $msgs_success[$key] : $msgs_success;
            } else {
                $results[] = is_array($msgs_fail) ? $msgs_fail[$key] : $msgs_fail;
            }
        }
        $this->page->retLink = !empty($this->retLink) ? $this->retLink : $retLink;
        $this->page->result  = implode($delimiter, $results);
        $this->page->content = $this->renderView('result', 'actions');//$this->use_folder ? $this->use_folder : null);
    }
    
    protected function actionDelete_file($modelName, $tableName, $msg_success, $msg_fail, $retLink='', $question = '')
    {
        if (isset($_POST['delete'])) {
            if ($_POST['delete']) {
                $this->page->result  = $this->model($modelName)->deleteFileFromElement($tableName,
                    $this->delCond ? $this->delCond : array('id' => $this->app->request->id), $this->app->request->field
                )
                ? $msg_success : $msg_fail;
                if ($this->hasImages && $this->page->result) {
                    $this->model('images', 'images')->Delete('images',
                        array('where' => array('model' => $modelName, 'pid' => $this->app->request->id)), $modelName);
                }
                $this->page->retLink = !empty($this->retLink) ? $this->retLink : $retLink;
                $this->page->content = $this->renderView('result', 'actions');//$this->use_folder ? $this->use_folder : null);
            }
            else {
                header('Location: '.($retLink ? $retLink : zf::$root_url));
                exit;
            }
        }
        else {
            $this->page->question = $question ? $question : lang::p('delete_object?');
            $this->page->yes      = lang::p('yes');
            $this->page->no       = lang::p('no');            
            $this->page->content  = $this->renderView('delete_confirmation', $this->use_folder ? $this->use_folder : null);
        } 
    }
    
    public function actionDelete_image()
    {
        $this->model()->deleteFromImages($this->app->request->parr[1]);
        $ret_url = base64_decode($this->app->request->ret_url.'==');
        header("Location: /admin/".$ret_url);
    }
    
    public function actionCrop_image($tableName = '', $conf = array())
    {
        if ($_POST &&
            !empty($_POST['field']) && is_string($_POST['field']) &&
            !empty($_POST['dir']) && is_string($_POST['dir']) &&
            !empty($_POST['se_options']) && is_array($_POST['se_options'])
        ) {
            if (!$tableName) $tableName = $this->ctrlName;
            $this->model()->crop_image($this->app->request->id, $tableName, $_POST['field'], $_POST['dir'], $_POST['se_options'], $conf);
        }
        exit;
    }
}
?>
