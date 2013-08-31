<?php
/**
 * @author Skibardin Andrey <webprofi9183@gmail.com>
 */
class AboutAction extends CAction
{
    public function run()
    {
        $this->controller->render('about');
    }
}