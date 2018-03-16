<?php

use \report_distance\models\basis;

class report_distance_miner
{ 
	public function __construct() {}

	public function create_base($base_name, $course_id)
	{
		global $DB;
		return $DB->get_recordset_sql(basis::create_base, array($course_id));
	}
}
