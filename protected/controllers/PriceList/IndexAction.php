<?php
/**
 * @author Skibardin Andrey <webprofi9183@gmail.com>
 */
class IndexAction extends CAction
{
    public function run()
    {
        $this->controller->render('index');
    }
}