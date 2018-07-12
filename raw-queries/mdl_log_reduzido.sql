INSERT INTO mdl_log_reduzido (
	id,
	time,
	userid,
	course,
	course_id,
	module,
	action,
	ip,
	cmid
)
SELECT
	id,
	timecreated `time`,
	userid,
	courseid `course`,
	13 `course_id`,
	TRIM(LEADING 'mod_' FROM component) `module`,
	action,
	ip,
	objectid `cmid`
FROM mdl_logstore_standard_log
WHERE (
	action='loggedout' OR
	action='loggedin' OR
	courseid IN (
		SELECT disciplina_id FROM mdl_id_disciplinas WHERE course_id = 13
	)
)
AND userid IN (
	SELECT aluno_id FROM mdl_id_alunos WHERE course_id = 13
)
ON DUPLICATE KEY UPDATE
	time      = VALUES(time),
	userid    = VALUES(userid),
	course    = VALUES(course),
	course_id = VALUES(course_id),
	module    = VALUES(module),
	action    = VALUES(action),
	ip        = VALUES(ip),
	cmid      = VALUES(cmid)
