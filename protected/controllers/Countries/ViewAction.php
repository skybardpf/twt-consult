<?php
/**
 * @author Skibardin Andrey <webprofi9183@gmail.com>
 */
class ViewAction extends CAction
{
    public function run($c)
    {
        $model = Country::model()->find('url=:url', array(':url' => $c));
        if ($model === null){
            throw new CHttpException(404);
        }

        $this->controller->render('view', array(
            'model' => $model
        ));
    }
}