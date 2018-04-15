<?php
namespace report_distance\models;

class minified_log
{
	const table = "base_log_reduzido";

	const get = "
		SELECT
			course_id,
			time,
			userid,
			course,
			module,
			action,
			ip,
			cmid
		FROM {".log_buffer::table."}
		WHERE course_id = ?
		";
}
