<?php
/**
 * @author Skibardin A.A. <skybardpf@artektiv.ru>
 */
class NewsController extends AdminController
{
    public function actions()
    {
        return array(
            'index' => 'application.modules.admin.controllers.News.IndexAction',
            'view' => 'application.modules.admin.controllers.News.ViewAction',
        );
    }
}