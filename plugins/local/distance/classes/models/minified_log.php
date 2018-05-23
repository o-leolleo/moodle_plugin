<?php
namespace local_distance\models;

class minified_log
{
	const table = "base_log_reduzido";

	const update = "
		INSERT INTO {".self::table."} (
			course_id,
			time,
			userid,
			course,
			module,
			action,
			ip,
			cmid
		)
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
