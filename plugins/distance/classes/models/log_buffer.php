<?php
namespace report_distance\models;

class log_buffer
{
	const table = "log_reduzido";

	// TODO verificar se estes últimos
	// campos estão repetidos
	const get = "
		SELECT
		id,
		timecreated `time`,
		userid,
		courseid `course`,
		TRIM(LEADING \'mod_\' FROM component) AS `module`,
		action,
		ip,
		objectid AS `cmid`
		  FROM {logstore_standard_log} WHERE courseid IN (SELECT * FROM
		{".course_id::table."}
		 ) AND userid IN (SELECT * FROM
		{".aluno_ids::table."}
		 ) UNION SELECT id,timecreated, userid,courseid,component,action,ip,objectid FROM mdl_logstore_standard_log WHERE action=`loggedout` AND userid IN (SELECT * FROM
		{".aluno_ids::table."}
		 ) UNION SELECT id,timecreated, userid,courseid,component,action,ip,objectid  FROM mdl_logstore_standard_log  WHERE action=`loggedin` AND userid IN (SELECT * FROM
		{".aluno_ids::table."}
		 )";
}
