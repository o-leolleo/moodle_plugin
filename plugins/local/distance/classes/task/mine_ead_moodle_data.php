<?php 
namespace local_distance\task;

ini_set('max_exection_time', 6000);
ini_set('memory_limit', '512M');

use local_distance\job\miner;

class mine_ead_moodle_data extends \core\task\scheduled_task
{
	public function get_name() {
		return get_string('task_desc', 'local_distance');
	}

	public function execute() {
		$miner = new local_distance_miner();
		$miner->init()->mine();
	}
}
