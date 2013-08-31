<?php
/**
 * @author Skibardin Andrey <webprofi9183@gmail.com>
 */
class IndexAction extends CAction
{
    public function run()
    {
        $crt = new CDbCriteria();
        $crt->order = 'title ASC';
        $crt->condition = 'in_list=:in_list';
        $crt->params = array(':in_list' => 'yes');
        $data = Country::model()->findAll($crt);

        $this->controller->render('index', array(
            'data' => $data,
        ));
    }
}