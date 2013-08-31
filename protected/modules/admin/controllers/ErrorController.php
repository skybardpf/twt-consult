<?php
/**
 * @author Skibardin A.A. <skybardpf@artektiv.ru>
 */
class ErrorController extends CController
{
    public function actions()
    {
        return array(
            'error' => 'application.modules.admin.controllers.Error.ErrorAction'
        );
    }
}