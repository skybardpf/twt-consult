<?php
/**
 * @author Skibardin A.A. <skybardpf@artektiv.ru>
 */
class PageController extends AdminController
{
    public function actions()
    {
        return array(
            'index' => 'application.modules.admin.controllers.Page.IndexAction',
        );
    }
}