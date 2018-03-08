<?php

use \report_distance\constant\query;

class report_distance_miner
{

	public function __construct() {}

	public function create_base($base_name)
	{
		echo "\n".query::$create_base."\n";
	}
}
