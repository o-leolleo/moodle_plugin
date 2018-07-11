INSERT INTO mdl_base_log_reduzido (
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
FROM mdl_log_reduzido
WHERE course_id = ?
