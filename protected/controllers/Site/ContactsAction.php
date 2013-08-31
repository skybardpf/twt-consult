<?php
/**
 * @author Skibardin Andrey <webprofi9183@gmail.com>
 */
class ContactsAction extends CAction
{
    public function run()
    {
        $this->controller->render('contacts');
    }
}