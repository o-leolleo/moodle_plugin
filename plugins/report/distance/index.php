<?php
require_once('../../config.php');
require_once($CFG->dirroot.'/report/distance/locallib.php');
require_once($CFG->libdir.'/adminlib.php');

require_login();

admin_externalpage_setup('reportdistance', '', null, '', [ 'pagelayout' => 'report' ]);

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('pluginname', 'report_distance'));

try {
	$users_count = $DB->count_records('user');
	$course_count = $DB->count_records('course');
	$course_categories_count = $DB->count_records('course_categories'); 
}
catch (dml_connection_exception $e) {
	 echo $e;
}
catch (dml_read_exception $e) {
	 echo $e;
}
catch (Exception $e) {
	 echo $e;
}

$user_series = new core\chart_series("# of users", [$users_count]);
$course_series = new core\chart_series("# of courses", [$course_count]);
$course_categories_series = new core\chart_series("# of course categories", [$course_categories_count]);

echo $OUTPUT->box(get_string('distancereportdesc', 'report_distance'), 'generalbox mdl-align');

$chart = new core\chart_bar();

$chart->add_series($user_series);
$chart->add_series($course_series);
$chart->add_series($course_categories_series);

echo $OUTPUT->render($chart);

echo $OUTPUT->footer();
