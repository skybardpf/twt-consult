<?php
class CMS_Controller extends AdvancedController
{
	public $conf           = array();
	protected $viewsDir    = null;
	protected $hasConfFile = true;
	protected $useAsort    = false;

	public function __construct($ctrlName, $app)
	{
		if (!$ctrlName) return;
		parent::__construct($ctrlName, $app);
		if ($this->hasConfFile) {
			$this->conf = $this->loadConf($app->getCtrlConfFileName($ctrlName));
		}
	}

	/**
	 * @return CMS_Model
	 */
	public function model($modName = null, $ctrlName = '')
	{
		return parent::model($modName, $ctrlName);
	}

	public function loadView($view, $ctrlName = '', $render = false, $cache_id = null)
	{
		if ($this->viewsDir === null) {
			$this->page->loadView($view,  empty($this->app->conf['mvc']['use_subdirs']['views']) ? 0 : ($ctrlName === null ? 0 : 1), $ctrlName ? $ctrlName : $this->ctrlName);
		} else {
			$path = "{$this->app->app_path}modules/{$this->ctrlName}/";
			if ($this->viewsDir) $path .= rtrim($this->viewsDir, '/').'/';
			$path .= $view;
			$this->page->load_view($path);
		}
	}

	public function actionDefault()
	{
		return $this->actionList();
        
	}

	public function stop()
	{
		parent::stop();
	}

	public function run()
	{
		if ($this->hasConfFile) {
			if (!empty($this->conf['actions'])) {
				$this->page->all_actions  = $this->conf['actions'];
			}
			$action = $this->action ? $this->action : 'list';
			if (!empty($this->conf['complex'])) {
				if (isset($this->conf['list_actions'][$action])) {
					$this->page->list_actions = $this->conf['list_actions'][$action];
				} elseif (isset($this->conf['list_actions'][$action.'_'.$this->ctrlName])) {
					$this->page->list_actions = $this->conf['list_actions'][$action.'_'.$this->ctrlName];
				}
			} else {
				if (!empty($this->conf['list_actions'])) {
					$this->page->list_actions = $this->conf['list_actions'];
				}
			}
		} else {
			$this->page->list_actions = array();
		}
		parent::run();
	}

	protected function AdjustInlineListActions(&$conf, $errors, $action, $key, $mainKey = null)
	{
		$ret = array();
		if (!is_array($action)) {
			$ret = array(
                'title' => $conf['actions'][$key][0],
                'link'  => $action
			);
		} else {
			if (empty($action['title']) && array_key_exists($key, $conf['actions'])) {
				$ret = array_merge($action, array('title' => $conf['actions'][$key][0]));
			} elseif (!empty($action['title']) && !is_array($action['title']) && array_key_exists($action['title'], $conf['actions'])) {
				$ret = array_merge($action, array('title' => $conf['actions'][$action['title']][0]));
			}

			if (!empty($action['put']) && count($action['put']) == 1) {
				$put = array(
                    'pos'   => current($action['put']),
                    'link'  => $action['link'],
                    'icon'  => $action['icon'],
                    'title' => !empty($conf['actions'][$key][0])
				?
				$conf['actions'][$key][0]
				:
				(!empty($action['title']) ? $action['title'] : '')
				);

				if ($mainKey) {
					if (empty($conf['list_actions']['inline'][$mainKey][key($action['put'])]['put'])) {
						$conf['list_actions']['inline'][$mainKey][key($action['put'])]['put'] = $put;
					}
					elseif (!empty($conf['list_actions']['inline'][$mainKey][key($action['put'])]['put']['pos'])) {
						$conf['list_actions']['inline'][$mainKey][key($action['put'])]['put'] = array(
						$conf['list_actions']['inline'][$mainKey][key($action['put'])]['put'],
						$put
						);
					}
					else {
						$conf['list_actions']['inline'][$mainKey][key($action['put'])]['put'][] = $put;
					}
				} else {
					if (empty($conf['list_actions']['inline'][key($action['put'])]['put'])) {
						$conf['list_actions']['inline'][key($action['put'])]['put'] = $put;
					}
					elseif (!empty($conf['list_actions']['inline'][key($action['put'])]['put']['pos'])) {
						$conf['list_actions']['inline'][key($action['put'])]['put'] = array(
						$conf['list_actions']['inline'][key($action['put'])]['put'],
						$put
						);

					}
					else {
						$conf['list_actions']['inline'][key($action['put'])]['put'][] = $put;
					}
				}
			}

			if (!empty($action['class'])) $ret['class'] = $action['class'];
		}
		return $ret;
	}

	public function OnBeforeCompile(&$conf, &$errors)
	{

		if (empty($conf['list_actions'])) return;
		$list_actions = array();
		$newListActions = array();
		foreach ($conf['list_actions'] as $type => &$actions) {
			if (!$actions) {
                debug::add("$type actions in controller config is empty.", 'err');
                continue;
            }
            foreach ($actions as $key => &$action) {
				if (!empty($conf['complex'])) { // Если модуль сложный
                    foreach ($action as $aKey => &$sAction) {
						$sAction = $newListActions['list_'.$key][$type][$aKey] = $list_actions[$aKey] = array_merge(
						is_array($sAction) ? $sAction : array(),
						$this->AdjustInlineListActions($conf, $errors, $sAction, $aKey, $key)
						);
					}
				} else { // Если модуль простой
                    $action = $list_actions[$key] = array_merge(
					is_array($action) ? $action : array(),
					$this->AdjustInlineListActions($conf, $errors, $action, $key)
					);
				}
			}
		}
		foreach ($conf['actions'] as $actionName => &$action) {
			if (isset($action[2]) && is_array($action[2])) {
				$values = $action[2];
				foreach ($values as $key => $val) {
					$conf['actions'][$actionName][2][$val] = array(
                        'link'  => $list_actions[$val]['link'],
                        'title' => $list_actions[$val]['title'],
                        'icon'  => misc::get($list_actions[$val], 'icon'),
                        'cond'  => misc::get($list_actions[$val], 'cond'),
                        'rel'   => misc::get($list_actions[$val], 'rel'),
                        'onclick'   => misc::get($list_actions[$val], 'onclick'),
                        'target'   => misc::get($list_actions[$val], 'target')
					);
					unset($action[2][$key]);
				}
			}

		}
		if ($newListActions) {
			$conf['list_actions'] = $newListActions;
		}
		//$conf['dont_compile'] = 1;
	}

	protected function setTitle($action = null)
	{
		if (!$action) $action = $this->action;
		if (!$this->page->pageTitle) {
			$this->page->pageTitle = $this->conf['title'];
		} elseif (is_array($this->page->pageTitle)) {
			$this->page->pageTitle = array_merge(array($this->conf['title']), $this->page->pageTitle);
		}
		if (!$this->action) $this->action = $action;
		$this->page->actionTitle = $this->conf['actions'][$action][1];
	}
	
	public function actionListModify($tableName = null, $modelNameOrModel = null)
	{
		$this->list_modify_mode = true;
		if(!empty($_POST)){
			if (!is_object($modelNameOrModel)) {
				$model  = $this->model($modelNameOrModel);
			}
			foreach($_POST as $k=>$v) $model->modifyFromList($tableName, $k, $v);
		}
		return $this->actionList($tableName, $modelNameOrModel);
	}

	public function actionList($tableName = null, $modelNameOrModel = null)
	{
		zf::addJS('jquery.event.drag', '/public/cms/js/jquery.event.drag.js');
		zf::addJS('jquery.event.drop', '/public/cms/js/jquery.event.drop.js');
        if (isset($this->page->list_actions['multiple']) || isset($this->page->list_actions['multy_change'])) {
            zf::addJS('multiple_list', '/public/cms/js/multiple_list.js');
        }
		if (!$tableName) $tableName = $this->ctrlName;
		if (!$modelNameOrModel) $modelNameOrModel = $this->ctrlName;
		$action = $this->action ? $this->action : 'list';
		$this->setTitle($action);
		$this->page->rightFromTable = !empty($this->conf['actions'][$action][2]) ? $this->conf['actions'][$action][2] : array();
		if (!empty($this->conf['noContent'])) {
			if (is_array($this->conf['noContent'])) {
				$noContent = strpos($action, 'list_') !== false
				?
				$this->conf['noContent'][str_replace('list_', '', $action)]
				:
				$this->conf['noContent'][$this->ctrlName];
			} else {
				$noContent = $this->conf['noContent'];
			}
		} else {
			$noContent = lang::p('no_objects');
		}

		if ($this->useAsort && 0) {
			if (!is_object($modelNameOrModel)) {
				$model  = $this->model($modelNameOrModel);
			}
			$this->loadForm(
                'a_sort',
			    $model->getAsortFields(
                    $model->getFields($tableName, $this->actionName ? $this->actionName : 'list')
                )
			);
		}
		$ret = parent::actionList($modelNameOrModel, $tableName, array(), array(), $noContent);

		if ($this->app->request->ajax) {
			echo $this->page->content;
		}
		return $ret;
	}

    /**
     * Uses $this->fieldsNames, $this->fields, $this->modifyCond, $this->fields2save, $this->view, $this->use_folder<br><br>
     *
     * $this->view, $this->use_folder defines which template should be used <br>
     * $this->fields2save for saving only several fields<br>
     * $this->modifyCond used for getting initial data and defining save conditions<br>
     * $this->fieldsNames - fields for data<br>
     * $this->fields - fields for form (= fields for data by default)<br>
     *
     * @param null $tableName
     * @param null $modelNameOrModel
     * @param array $additionalData
     * @return int mixed null
     */
	public function actionModify($tableName = null, $modelNameOrModel = null, $additionalData = array())
	{
		if (!$tableName) $tableName = $this->ctrlName;
		if (!$modelNameOrModel) $modelNameOrModel = $this->ctrlName;
		$action = $this->action;
		$this->setTitle($action);
		$ret = parent::actionModify(
			$modelNameOrModel, $tableName, 
			$this->conf['actions'][$action][2],
			$this->conf['actions'][$action][3],
			!empty($this->conf['actions'][$action][4]) ? $this->conf['actions'][$action][4] : zf::$root_url.$this->ctrlName.'/list/',
			$additionalData
		);
		if ($_POST or $_FILES) {
			$data = $this->page->data = $this->form('modify')->getData();
		}
		return $ret;
	}

	public function actionAdd($tableName = null, $modelNameOrModel = null, $additionalData = array())
	{
		return self::actionModify($tableName, $modelNameOrModel, $additionalData);
	}

	public function actionShow($tableName = null, $modelNameOrModel = null, $additionalData = array())
	{
		if (!$tableName) $tableName = $this->ctrlName;
		if (!$modelNameOrModel) $modelNameOrModel = $this->ctrlName;
		$this->setTitle();
		parent::actionShow($modelNameOrModel, $tableName);
	}

	public function actionDelete($tableName = null, $modelNameOrModel = null)
	{
		if (!$tableName) $tableName = $this->ctrlName;
		if (!$modelNameOrModel) $modelNameOrModel = $this->ctrlName;
		$this->setTitle();

		$model = is_object($modelNameOrModel) ? $modelNameOrModel : $this->model($modelNameOrModel);

		if ($_POST && empty($_POST['delete'])) {
			$this->page->data = $model->Get($this->app->request->id, $tableName, $model->getFieldsNames($tableName, 'list'));
		}

		return parent::actionDelete(
			$modelNameOrModel,
			$tableName,
			!empty($this->conf['actions'][$this->action][2]) ? $this->conf['actions'][$this->action][2] : lang::p('delete_object_success'),
			!empty($this->conf['actions'][$this->action][3]) ? $this->conf['actions'][$this->action][3] : lang::p('delete_object_fail'),
			!empty($this->conf['actions'][$this->action][4]) ? $this->conf['actions'][$this->action][4] : zf::$root_url.$this->ctrlName.'/list/',
			!empty($this->conf['actions'][$this->action][5]) ? $this->conf['actions'][$this->action][5] : lang::p('delete_object?')
		);
	}

	public function actionSwap($tableName = null, $modelNameOrModel = null)
	{
		if (!$tableName) $tableName = $this->ctrlName;
		if (!$modelNameOrModel) $modelNameOrModel = $this->ctrlName;
		 
		$model   = is_object($modelNameOrModel) ? $modelNameOrModel : $this->model($modelNameOrModel);

		$posCond   = $this->posCond;
		$posFields = $this->posFields;

		if ($this->app->request->iid > 0 and $this->app->request->id > 0 and $this->app->request->id != $this->app->request->iid) {
			$id = intval($this->app->request->id);
			$iid = intval($this->app->request->iid);
			$objects = $model->getList($tableName, array_merge($posFields, array('id')), array('where' => array('id' => array('IN', "($id, $iid)"))));
			$first = $model->Update($tableName, array($posFields[0] => $objects[0][$posFields[0]]), array('id' => $objects[1]['id']));
			$second = $model->Update($tableName, array($posFields[0] => $objects[1][$posFields[0]]), array('id' => $objects[0]['id']));
			return array(
				$objects[1]['id'] => array(
	        		'pos' => $objects[0][$posFields[0]],
	        		'res' => $first
				),
				$objects[0]['id'] => array(
	        		'pos' => $objects[1][$posFields[0]],
	        		'res' => $second
				)
			);
		}
		return false;
	}

	public function actionChange($tableName = null, $modelNameOrModel = null, $callback = null)
	{
		if ($this->app->request->table) $tableName = $this->app->request->table;
		if (!$tableName) $tableName = $this->ctrlName;
		if (!$modelNameOrModel) $modelNameOrModel = $this->ctrlName;

		$model   = is_object($modelNameOrModel) ? $modelNameOrModel : $this->model($modelNameOrModel);
		$field   = $this->app->request->field;
		$currVal = misc::get($model->Get($this->app->request->id, $tableName, array($field)), $field);
		$values  = misc::get(misc::get($model->getFields($tableName, array($field)), $field), 'values');

		unset($values[$currVal]);
		$newVal  = key($values);
		$model->Save($tableName, array($field => $newVal), $this->app->request->id);
		if ($callback && isset($callback['call']) && is_callable($callback['call'])) {
			$argv = isset($callback['argv']) ? $callback['argv'] : array();
			call_user_func_array($callback['call'], $argv);
			if (isset($callback['debug']) && $callback['debug']) {
				return;
			}
		}
		header('Location: '.zf::$root_url.$this->ctrlName.'/'.
            (($this->app->request->ret_action) ? $this->app->request->ret_action : '').
            (($this->app->request->pid) ? "/pid/{$this->app->request->pid}" : '').
            '/');
        exit;
	}

	public function actionChange_pass($tableName = null, $modelNameOrModel = null, $passField = 'pass', $newPass = null)
	{
		if (!$tableName) $tableName = $this->ctrlName;
		if (!$modelNameOrModel) $modelNameOrModel = $this->ctrlName;
		$this->setTitle();
		$model = is_object($modelNameOrModel) ? $modelNameOrModel : $this->model($modelNameOrModel);
		$this->page->data = $model->Get($this->app->request->id, $tableName, $model->getFieldsNames($tableName, 'list'));
		$fields = array (
		    $passField => array(
                'type' => 'pass',
                'htmltype' => 'pass',
                'title' => 'Новый пароль',
                'req'   => true
		    ),

            "re-$passField" => array(
                'type' => 'pass',
                'htmltype' => 'pass',
                'title' => 'Повторите пароль',
                'req'   => true,
                'validate' => array('re_pass' => '"Пароль" и "Повтор пароля" не совпадают')
		    )
		);

		$data = $_POST;
		$this->loadForm('modify', $fields, $data);
		if ($_POST) {
			if($this->form('modify')->validate()) {
				$model->Save(
				$tableName,
				array($passField => $newPass ? $newPass : md5($this->app->request->post[$passField])),
				$this->app->request->id
				);

				$this->page->result = $this->conf['actions']['change_pass'][2];
				$this->page->retLink = !empty($this->conf['actions'][$this->action][4]) ? $this->conf['actions'][$this->action][4] : zf::$root_url.$this->ctrlName.'/list/';
				$this->page->content = $this->renderView('result', 'actions');
				return;
			} else {
				$this->page->errors = $this->form('modify')->getErrors();
			}
		}
		$this->page->content = $this->renderView('modify', 'actions');
	}

	public function actionDelete_file($tableName = null, $modelNameOrModel = null)
	{
		if (!$tableName) $tableName = $this->ctrlName;
		if (!$modelNameOrModel) $modelNameOrModel = $this->ctrlName;
        $this->setTitle();
		$model   = is_object($modelNameOrModel) ? $modelNameOrModel : $this->model($modelNameOrModel);
		return parent::actionDelete_file(
		$modelNameOrModel,
		$tableName,
		!empty($this->conf['actions'][$this->action][2]) ? $this->conf['actions'][$this->action][2] : lang::p('delete_file_success'),
		!empty($this->conf['actions'][$this->action][3]) ? $this->conf['actions'][$this->action][3] : lang::p('delete_file_fail'),
		!empty($this->conf['actions'][$this->action][4]) ? str_replace(
			array('[root_url]', '[model]', '[pid]', '[id]'), array(zf::$root_url, $this->app->request->model, $this->app->request->pid, $this->app->request->id),
			$this->conf['actions'][$this->action][4]
		) : zf::$root_url.$this->ctrlName.'/list/',
		!empty($this->conf['actions'][$this->action][5]) ? $this->conf['actions'][$this->action][5] : lang::p('delete_file?')
		);
	}

	static public function getAvailableCtrls()
	{
		$app      = zf::gi()->app;
		$dir      = $app->app_path.'modules/';
		$d        = dir($dir);
		$aCtrls   = array();
		$disabled = misc::get($app->conf, 'disabled_modules', array());
		while (($ctrlName = $d->read()) !== false) {
			if (strpos($ctrlName, '.') === 0 || in_array($ctrlName, $disabled)) {
				continue;
			}
			$ctrlFile = realpath("$dir$ctrlName/$ctrlName.ctrl.php");
			if (file_exists($ctrlFile)) {
				$aCtrls[$ctrlName] = $app->ctrl->parseCtrlConf($ctrlName, $app);
			}
		}
		$d->close();
		return $aCtrls;
	}

	public function parseCtrlConf($ctrlName)
	{
		$confFileName = $this->app->getCtrlConfFileName($ctrlName);
		if (!file_exists($confFileName)) return array();
		$conf   = $this->loadConf($confFileName);
        $parsed = array('title' => $conf['title'],
            'actions' => array(
                'access' => array('<b>Доступ к модулю</b>', 'Доступ к модулю'),
                'default' => array('<i>Действие по умолчанию</i>', 'Действие по умолчанию')
            )
        );
		if (!empty($conf['actions'])) {
			foreach ($conf['actions'] as $action => $actionTitles) {
				$parsed['actions'][$action] = $actionTitles;
			}
		}
		return $parsed;
	}
}
?>
