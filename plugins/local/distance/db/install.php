<?php
use local_distance\job\miner;

function xmldb_local_distance_install()
{
	$miner_job = new miner();
	\core\task\manager::queue_adhoc_task($miner_job);

	return true;
}

xmldb_local_distance_install();
