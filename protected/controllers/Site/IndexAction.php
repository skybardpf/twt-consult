<?php
/**
 * @author Skibardin Andrey <webprofi9183@gmail.com>
 */
class IndexAction extends CAction
{
    public function run()
    {
        $crt = new CDbCriteria();
        $crt->order = 'pos ASC';
        $crt->condition = 'in_list=:in_list';
        $crt->params = array(':in_list' => 'yes');
        $countries = Country::model()->findAll($crt);

        $this->controller->render('index', array(
            'countries' => $countries
        ));
    }
}