<?php
namespace local_distance\task;

class mine_ead_moodle_data extends \core\task\scheduled_task
{
	public function get_name() {
		return get_string('task_desc', 'local_distance');
	}

	public function execute() {
		(new \local_distance_miner())->init()->mine();
	}
}
