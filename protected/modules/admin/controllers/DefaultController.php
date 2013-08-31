<?php
/**
 * @author Skibardin A.A. <skybardpf@artektiv.ru>
 */
class DefaultController extends Controller
{
//    public $layouts = 'admin';

    public function actions()
    {
        return array(
            'index' => 'application.modules.admin.controllers.Default.IndexAction',

            'login' => 'application.modules.admin.controllers.Default.LoginAction',
            'logout' => 'application.modules.admin.controllers.Default.LogoutAction',
        );
    }
}