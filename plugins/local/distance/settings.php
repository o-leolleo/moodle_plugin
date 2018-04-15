<?php
// just copied from perfomance report plugin
defined('MOODLE_INTERNAL') || die();

$ADMIN->add('reports',
	new admin_externalpage(
		'reportdistance',
		get_string('pluginname', 'local_distance'),
		$CFG->wwwroot."/local/distance/index.php",
		'local/distance:view'
	)
);

$settings = null;
