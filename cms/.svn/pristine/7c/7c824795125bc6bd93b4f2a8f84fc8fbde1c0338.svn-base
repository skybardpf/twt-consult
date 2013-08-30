<?php
class RegionsModel extends CMS_Model
{
    public function SearchRegions($search_regions){
        $s_regions = $this->model('regions')->db->query(
            "SELECT regions.name FROM regions
            WHERE regions.name LIKE '%$search_regions%'"
        );
        return $s_regions;
    }
}