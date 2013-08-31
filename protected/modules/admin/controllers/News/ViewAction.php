<?php
/**
 * Class ViewAction
 */
class ViewAction extends CAction
{
    /**
     * @param int $id
     */
    public function run($id)
    {
        $controller = $this->controller;
        $controller->pageTitle = Yii::app()->name . ' | Админка | Новости';

        $model = News::model()->findByPk($id);
        if ($model === null){
            throw new CHttpException(500, 'Новость не найдена.');
        }

        $controller->render(
            '/default/menu_tabs',
            array(
                'tab_content' => $controller->renderPartial(
                    'view',
                    array(
                        'model' => $model
                    ),
                    true
                ),
                'current_tab' => 'news'
            )
        );
    }
}