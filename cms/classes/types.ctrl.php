<?php
class TypesController extends AdvancedController
{
    protected $modelName;
	public function actionList_types()
	{
		$this->listCond['order'] = array('pos' => 'asc');
		$this->posFields         = array('pos');
		return parent::actionList($this->modelName, $this->modelName.'_types',
            array(
            	$this->modelName."/modify_types/id/[id]" => 'редактировать тип',
                $this->modelName."/delete_types/id/[id]" => 'удалить тип',
            ),
            array(
            	$this->modelName."/add_types" => 'добавить тип',
            	$this->modelName => 'просмотреть объекты',
            )
        );
	}
	public function actionModify_types()
	{
		$this->posFields = array('pos');
		return parent::actionModify($this->modelName, $this->modelName.'_types', 'тип успешно отредактирован', 'тип отредактировать не удалось', zf::$root_url."{$this->ctrlName}/list_types/");
	}
	public function actionAdd_types()
	{
		$this->posFields = array('pos');
		return parent::actionModify($this->modelName, $this->modelName.'_types', 'тип успешно добавлен', 'тип добавить не удалось', zf::$root_url."{$this->ctrlName}/list_types/");
	}
	public function actionDelete_types()
    {
		$this->model($this->modelName)->Get($this->app->request->id, $this->modelName.'_types', null);
    	$return = parent::actionDelete($this->modelName, $this->modelName.'_types', 'тип успешно удален', 'тип удалить не удалось', zf::$root_url."{$this->ctrlName}/list_types/");
    }
}
?>