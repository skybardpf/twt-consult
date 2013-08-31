<?php
/**
 * Class IndexAction
 */
class IndexAction extends CAction
{
    public function run()
    {
        $controller = $this->controller;
        $controller->pageTitle = Yii::app()->name . ' | Админка | Страницы';

        $controller->render(
            '/default/menu_tabs',
            array(
                'tab_content' => $controller->renderPartial(
                    'index',
                    array(),
                    true
                ),
                'current_tab' => 'pages'
            )
        );
    }
}