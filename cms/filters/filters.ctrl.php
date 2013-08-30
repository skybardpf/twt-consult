<?php
class FiltersController extends CMS_Controller
{
	public function run()
	{
		$this->model()->initValues(
			array(
				'country_id', 
				'state_id', 
				'region_id',
				'direction_id',
				'city_id',
				'metroline_id',
				'metro_id',
				'cityregion_id'
				)
		);
		parent::run();
	}
}
?>
