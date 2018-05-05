<?php
namespace local_distance\job;

class miner extends \core\task\adhoc_task
{
	public function execute() {
		(new \local_distance_miner)->init()->mine();
	}
} 