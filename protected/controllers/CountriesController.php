<?php
/**
 * Class CountriesController
 * @author Skibardin Andrey <webprofi9183@gmail.com>
 */
class CountriesController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
            'index' => 'application.controllers.Countries.IndexAction',
            'view' => 'application.controllers.Countries.ViewAction',
		);
	}
}