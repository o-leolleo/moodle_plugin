<?php
namespace local_distance\models;

class minified_log
{
	const table = "base_log_reduzido";

	const get = "
		SELECT
			time,
			userid,
			course,
			module,
			action,
			ip,
			cmid
		FROM {".log_buffer::table."}";
}
