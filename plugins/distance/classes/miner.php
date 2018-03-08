<?php

use \report_distance\constant\query;

class report_distance_miner
{ 
	public function __construct() {}

	public function create_base($base_name, $course_id)
	{
		global $DB;
		return $DB->get_recordset_sql(query::$create_base, array($course_id));
	}
}
