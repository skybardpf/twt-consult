<?php
/**
 * Class IndexAction
 */
class IndexAction extends CAction
{
    public function run()
    {
        $controller = $this->controller;
        $controller->pageTitle = Yii::app()->name . ' | Админка | Новости';

        $data = News::model()->findAllByAttributes(array(
            'deleted' => News::DELETED_NO
        ));

        $controller->render(
            '/default/menu_tabs',
            array(
                'tab_content' => $controller->renderPartial(
                    'index',
                    array(
                        'data' => $data
                    ),
                    true
                ),
                'current_tab' => 'news'
            )
        );
    }
}