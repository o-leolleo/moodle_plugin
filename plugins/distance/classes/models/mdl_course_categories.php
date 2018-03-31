<?php
namespace report_distance\models;

class mdl_course_categories
{
	const table = "course_categories";

	const course_list = "
		SELECT id FROM {".self::table."} WHERE parent IN (
			SELECT id FROM {".self::table."}  WHERE parent = 0
		)
	";

	public static function get_course_list()
	{
		global $DB;

		$ids = [];
		$raw = $DB->get_records_sql(self::course_list); 

		// wasn't on purpose
		foreach ($raw as $row) {
			$ids[] = $row->id;
		}

		return $ids;
	}
}
