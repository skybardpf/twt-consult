<?php
/**
 * @author Skibardin A.A. <skybardpf@artektiv.ru>
 */
class Test_driveController extends AdminController
{
    public function actions()
    {
        return array(
            'index' => 'application.modules.admin.controllers.TestDrive.IndexAction',
        );
    }
}