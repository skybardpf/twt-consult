<?php
/**
 * Class IndexAction
 */
class IndexAction extends CAction
{
    public function run()
    {
        $controller = $this->controller;
        $controller->pageTitle = Yii::app()->name . ' | Админка | Заявки на тест-драйв';

        $data = TestDrive::model()->findAllByAttributes(
            array(
                'deleted' => 0
            )
        );
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
                'current_tab' => 'test_drive'
            )
        );
    }
}