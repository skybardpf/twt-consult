<?php
/**
 * @author Skibardin A.A. <skybardpf@artektiv.ru>
 */
class LoginController extends AdminController
{
    protected $accessRules = array();

    public function actions()
    {
        return array(
            'login' => 'application.modules.admin.controllers.Login.LoginAction',
            'logout' => 'application.modules.admin.controllers.Login.LogoutAction',
        );
    }
}