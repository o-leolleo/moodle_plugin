<?php
// just copied from perfomance report plugin
defined('MOODLE_INTERNAL') || die();

$ADMIN->add('reports',
	new admin_externalpage(
		'reportdistance',
		get_string('pluginname', 'report_distance'),
		$CFG->wwwroot."/report/distance/index.php",
		'report/distance:view'
	)
);

$settings = null;
