<?php
/**
 * @author Skibardin A.A. <skybardpf@artektiv.ru>
 */
class Press_about_usController extends AdminController
{
    public function actions()
    {
        return array(
            'index' => 'application.modules.admin.controllers.PressAboutUs.IndexAction',
        );
    }
}