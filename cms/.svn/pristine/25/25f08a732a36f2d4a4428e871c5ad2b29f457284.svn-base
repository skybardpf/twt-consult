<?php
class SettingsController extends AdvancedController
{
	public function __construct($ctrlName, $app)
	{
		parent::__construct($ctrlName, $app);
		$this->modelName = 'settings';
	}
	
	public function actionDefault()
	{
		return $this->actionModify();
	}
	
	public function actionModify()
	{

        if ($this->app->request->field) {
            if (!$_POST) {
                $this->page->title = $this->app->conf['title'];
                $this->page->question = 'Удалить?';
                $this->page->yes = 'Да';
                $this->page->no = 'Нет';
                $this->page->content = $this->renderView('delete_confirmation', 'actions');
                return 0;
            } elseif ($_POST['delete']) {
                $field = $this->app->request->field;
                $dirs = array_merge_recursive($this->app->conf['settings'][$field],array('dirs' => array('icon' => 12)));
                $file = $this->model('settings')->GetByCond('settings', array('value'), array('where' => array('name' => $field)), 1);
                $file = $file['value'];
                $this->model('settings')->deleteFile($file, $dirs);
                $this->model('settings')->Update('settings', array('value' => null), array('name' => $field));
                header("Location: ".zf::$root_url."settings/");
                return 0;
            } else {
                header("Location: ".zf::$root_url."settings/");
                return 0;
            }
        }
        else
        {

            $this->page->pageTitle   = $this->app->conf['title'];;
            $this->page->actionTitle = 'настройки';
        }
        $model = $this->model('settings');
		$model->sFields = $this->app->conf['settings'];
		$model_data = $model->getDataToForm();
		//удаляем лишние значения в таблице, если их нет в конфиге
		if (count($model_data) > count($this->app->conf['settings'])) {
			foreach ($model_data as $key => $value) {
				if (! array_key_exists($key, $this->app->conf['settings'])) {
					$this->model('settings')->Delete('settings', array('name' => $key));
				}
			}
		}
		//создаем недостающие значения в таблице
		elseif (count($model_data) < count($this->app->conf['settings'])) {
			foreach ($this->app->conf['settings'] as $name => $value) {
				if (!empty($value['dont_store'])) continue;
				
				$model->fName = $name;
				$model->nField = 'name';
				if (!array_key_exists($name, $model_data)) {
					$model->initRows($name);
				}
			}
			$model_data = $model->getDataToForm();
		}
		
		if (empty($_POST)) {
			$data = $model_data;
		} else {
			$data = array_merge($model_data, $_POST);
		}
		
		$this->loadForm('modify', $model->getFields(), $data);
		
		if ($_POST && empty($_POST['dont_save'])) {
			if ($this->form('modify')->validate()) {
				$save = $this->form('modify')->getData();
				foreach ($save as $name => $value) {
					$model->fName = $name;
					$model->nField = 'value';
                    if(isset($model_data[$name]))
                    {
                        $model->data['value'] = $model_data[$name];
                        $model->Save('settings', array('value' => $value), array('name' => $name));
                    }
                    else
                    {
                        $model->data['value'] = $value;
                        $model->Save('settings', array('value' => $value, 'name' => $name));
                    }
				}
				header("Location: ".zf::$root_url."settings/");
				exit;
			} else{
				$this->page->errors = $this->form('modify')->getErrors();
			}
		}
		
		$this->page->content = $this->renderView('modify', 'actions');
	}
}
?>