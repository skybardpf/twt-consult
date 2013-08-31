<?php
/**
 * Страница с ошибками
 * @author Skibardin Andrey <skybardpf@artektiv.ru>
 */
class ErrorAction extends CAction
{
    public function run(){
        if($error=Yii::app()->errorHandler->error)
        {
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->controller->render('error', $error);
        }
    }
}