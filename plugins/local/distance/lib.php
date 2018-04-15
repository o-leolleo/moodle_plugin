<?php
defined('MOODLE_INTERNAL') || die;


function local_distance_extend_navigation($navigation)
{

	$id = optional_param('id', null, PARAM_INT); // Course ID.

	if(!empty($id))
	{
		$main_node = $navigation->add(get_string('distance_navigation_title', 'local_distance'), null, 0, 'report', 'local_report');
		$main_node->nodetype = 1;
		$main_node->collapse = false;
		$main_node->forceopen = true;
		$main_node->isexpandable = true;
		$main_node->showinflatnavigation = true;

		$course_node = $main_node->add(get_string('distance_navigation_item', 'local_distance'),new moodle_url('/local/distance/index.php',array('disciplina_id'=>$id)));

		$course_node->set_parent($main_node);

		$course_node->showinflatnavigation = true;
	}

}



function local_distance_extend_navigation_course($navigation, $course, $context) {
	//if (has_capability('report/distance:view', $context)) {
	$url = new moodle_url('/local/distance/index.php', array('disciplina_id'=>$course->id));
	$navigation->add(get_string('distance_navigation_settings_item', 'local_distance'), $url, navigation_node::TYPE_COURSE, null, null, new pix_icon('i/report', ''));

				//}

}

