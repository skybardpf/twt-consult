<?php
/**
 * @author Skibardin A.A. <skybardpf@artektiv.ru>
 */
class AdminController extends CController
{
    protected $accessRules = array(
        array('allow',
//                'actions'=>array('add', 'archive'),
            'users'=>array('@'),
        ),
        array('deny',
//                'actions'=>array('delete'),
            'users'=>array('*'),
        ),
    );

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }
    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return $this->accessRules;
    }
}