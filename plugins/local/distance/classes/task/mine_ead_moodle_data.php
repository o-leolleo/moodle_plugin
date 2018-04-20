<?php
namespace local_distance\task;

use local_distance\miner;

class mine_ead_moodle_data extends \core\task\scheduled_task 
{
	public function get_name() {
		return get_string('task_desc', 'local_distance');
	}

	public function execute() {
		(new miner())->init()->mine();
	}
}
