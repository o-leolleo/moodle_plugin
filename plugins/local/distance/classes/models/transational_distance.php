<?php
namespace local_distance\models;

class transational_distance
{
	const table = "transational_distance";

		//basis.semestre AS 'semestre',
	const get =
	"
		SELECT
		basis.course_id,
		basis.curso AS 'curso',
		basis.periodo AS 'periodo',
		basis.disciplina_nome AS 'disciplina_nome',
		basis.disciplina_id AS 'disciplina_id',
		basis.data_inicio AS 'data_inicio',
		basis.data_fim AS 'data_fim',
		basis.aluno_nome AS 'aluno_nome',
		basis.aluno_id AS 'aluno_id',
		IFNULL(VAR01.VAR01,0) AS 'VAR01',
		IFNULL(VAR13a.VAR13a,0) AS 'VAR13a',
		IFNULL(VAR13b.VAR13b,0) AS 'VAR13b',
		IFNULL(VAR13c.VAR13c,0) AS 'VAR13c',
		IFNULL(VAR13d.VAR13d,0) AS 'VAR13d',
		IFNULL(VAR18.VAR18,0) AS 'VAR18',
		IFNULL(VAR19.VAR19,0) AS 'VAR19',
		IFNULL(VAR21.VAR21,0) AS 'VAR21',
		IFNULL(VAR22.VAR22,0) AS 'VAR22',
		IFNULL(VAR26.VAR26,0) AS 'VAR26',
		IFNULL(VAR27.VAR27,0) AS 'VAR27',
		IFNULL(VAR31.VAR31,0) AS 'VAR31',
		IFNULL(VAR34.VAR34,0) AS 'VAR34',
		IFNULL(VAR39.VAR39,0) AS 'VAR39'
		FROM
		(SELECT * FROM {".basis::table."} WHERE course_id = ?) basis
		LEFT OUTER JOIN (".self::var01.")  AS VAR01  ON VAR01.disciplina_id = basis.disciplina_id AND VAR01.aluno_id  = basis.aluno_id
		LEFT OUTER JOIN (".self::var13a.") AS VAR13a ON VAR13a.aluno_id     = basis.aluno_id AND VAR13a.disciplina_id = basis.disciplina_id
		LEFT OUTER JOIN (".self::var13b.") AS VAR13b ON VAR13b.aluno_id     = basis.aluno_id AND VAR13b.disciplina_id = basis.disciplina_id
		LEFT OUTER JOIN (".self::var13c.") AS VAR13c ON VAR13c.aluno_id     = basis.aluno_id AND VAR13c.disciplina_id = basis.disciplina_id
		LEFT OUTER JOIN (".self::var13d.") AS VAR13d ON VAR13d.aluno_id     = basis.aluno_id AND VAR13d.disciplina_id = basis.disciplina_id
		LEFT OUTER JOIN (".self::var18.")  AS VAR18  ON VAR18.aluno_id      = basis.aluno_id AND VAR18.disciplina_id  = basis.disciplina_id
		LEFT OUTER JOIN (".self::var19.")  AS VAR19  ON VAR19.disciplina_id = basis.disciplina_id AND VAR19.aluno_id  = basis.aluno_id
		LEFT OUTER JOIN (".self::var21.")  AS VAR21  ON VAR21.disciplina_id = basis.disciplina_id AND VAR21.aluno_id  = basis.aluno_id
		LEFT OUTER JOIN (".self::var22.")  AS VAR22  ON VAR22.disciplina_id = basis.disciplina_id AND VAR22.aluno_id  = basis.aluno_id
		LEFT OUTER JOIN (".self::var26.")  AS VAR26  ON VAR26.disciplina_id = basis.disciplina_id AND VAR26.aluno_id  = basis.aluno_id
		LEFT OUTER JOIN (".self::var27.")  AS VAR27  ON VAR27.disciplina_id = basis.disciplina_id AND VAR27.aluno_id  = basis.aluno_id
		LEFT OUTER JOIN (".self::var31.")  AS VAR31  ON VAR31.aluno_id      = basis.aluno_id AND VAR31.disciplina_id  = basis.disciplina_id
		LEFT OUTER JOIN (".self::var34.")  AS VAR34  ON VAR34.disciplina_id = basis.disciplina_id AND VAR34.aluno_id  = basis.aluno_id
		LEFT OUTER JOIN (".self::var39.")  AS VAR39  ON VAR39.disciplina_id = basis.disciplina_id AND VAR39.emissor   = basis.aluno_id
	";

	const var01 = "
		SELECT b.disciplina_id, b.aluno_id, count(*) AS 'VAR01'
		FROM {forum_posts} p
		INNER JOIN {forum_discussions} d ON d.id = p.discussion
		INNER JOIN {".basis::table."} b ON d.course=b.disciplina_id AND p.userid=b.aluno_id AND p.created BETWEEN b.data_inicio and b.data_fim
		GROUP BY b.disciplina_id, b.aluno_id
	";

	const var13a = "
		SELECT b.disciplina_id,b.aluno_id, count(*) AS 'VAR13a'
		FROM {".basis::table."} b
		INNER JOIN (SELECT * FROM {".minified_log::table."} WHERE action='loggedin' AND HOUR(FROM_UNIXTIME(time)) >= 6 AND HOUR(FROM_UNIXTIME(time)) < 12) l
		ON b.aluno_id=l.userid AND l.time BETWEEN b.data_inicio and b.data_fim
		GROUP BY b.disciplina_id,b.aluno_id
	";

	const var13b = "
		SELECT b.disciplina_id,b.aluno_id, count(*) AS 'VAR13b'
		FROM {".basis::table."} b
		INNER JOIN (SELECT * FROM {".minified_log::table."} WHERE action='loggedin' AND HOUR(FROM_UNIXTIME(time)) >= 12 AND HOUR(FROM_UNIXTIME(time)) < 18) l
		ON b.aluno_id=l.userid AND l.time BETWEEN b.data_inicio and b.data_fim
		GROUP BY b.disciplina_id,b.aluno_id
	";

	const var13c = "
		SELECT b.disciplina_id,b.aluno_id, count(*) AS 'VAR13c'
		FROM {".basis::table."} b
		INNER JOIN (SELECT * FROM {".minified_log::table."} WHERE action='loggedin' AND HOUR(FROM_UNIXTIME(time)) >= 18 AND HOUR(FROM_UNIXTIME(time)) < 24) l
		ON b.aluno_id=l.userid AND l.time BETWEEN b.data_inicio and b.data_fim
		GROUP BY b.disciplina_id,b.aluno_id
	";

	const var13d = "
		SELECT b.disciplina_id,b.aluno_id, count(*) AS 'VAR13d'
		FROM {".basis::table."} b
		INNER JOIN (SELECT * FROM {".minified_log::table."} WHERE action='loggedin' AND HOUR(FROM_UNIXTIME(time)) >= 0 AND HOUR(FROM_UNIXTIME(time)) < 6) l
		ON b.aluno_id=l.userid AND l.time BETWEEN b.data_inicio and b.data_fim
		GROUP BY b.disciplina_id,b.aluno_id
	";

	const var18 = "
		SELECT b.disciplina_id,b.aluno_id, count(*) AS 'VAR18'
		FROM {".basis::table."} b
		INNER JOIN (SELECT * FROM {".minified_log::table."} WHERE action='loggedin') l
		ON b.aluno_id=l.userid AND l.time BETWEEN b.data_inicio and b.data_fim
		GROUP BY b.disciplina_id,b.aluno_id
	";

	const var19 = "
		 SELECT b.disciplina_id, b.aluno_id, count(*) AS 'VAR19'
		 FROM mdl_message_read r
		 INNER JOIN {".basis::table."} b ON b.aluno_id=r.useridfrom AND r.timecreated BETWEEN b.data_inicio and b.data_fim
		 INNER JOIN {".teacher::table."} p ON p.professor_id=r.useridto AND p.disciplina_id=b.disciplina_id
		 GROUP BY b.disciplina_id, b.aluno_id
	";

	const var21 = "
		SELECT b.disciplina_id, b.aluno_id, count(*) AS 'VAR21'
		FROM mdl_message_read r
		INNER JOIN {".basis::table."} b ON b.aluno_id=r.useridto AND r.timecreated BETWEEN b.data_inicio and b.data_fim
		INNER JOIN {".student::table."} a ON a.aluno_id=r.useridfrom AND a.disciplina_id=b.disciplina_id
		GROUP BY b.disciplina_id, b.aluno_id
	";

	const var22 = "
		SELECT b.disciplina_id, b.aluno_id, count(*) AS 'VAR22'
		FROM mdl_message_read r
		INNER JOIN {".basis::table."} b ON b.aluno_id=r.useridfrom AND r.timecreated BETWEEN b.data_inicio and b.data_fim
		INNER JOIN {".student::table."} a ON a.aluno_id=r.useridto AND a.disciplina_id=b.disciplina_id
		GROUP BY b.disciplina_id, b.aluno_id
	";

	const var26 = "
		SELECT temp.disciplina_id,temp.aluno_id, AVG(temp.Acesso_Objeto) AS 'VAR26'
		FROM (SELECT b.disciplina_id,b.aluno_id, module,cmid, count(*) AS 'Acesso_Objeto'
			FROM {".basis::table."} b
			INNER JOIN (SELECT * FROM {".minified_log::table."} WHERE cmid IS NOT NULL AND
				(module='resource' AND action='viewed') OR
				(module='folder' AND action='viewed') OR
				(module='glossary' AND action='viewed')) l
			ON b.disciplina_id=l.course AND b.aluno_id=l.userid AND l.time BETWEEN b.data_inicio and b.data_fim
			GROUP BY b.disciplina_id,b.aluno_id,l.module,cmid) AS temp
		GROUP BY temp.disciplina_id, temp.aluno_id
	";

	const var27 = "
		SELECT temp.disciplina_id,temp.aluno_id, AVG(temp.Acesso_Objeto) AS 'VAR27'
		FROM (SELECT b.disciplina_id,b.aluno_id, module,cmid, count(*) AS 'Acesso_Objeto'
			FROM {".basis::table."} b
			INNER JOIN (SELECT * FROM {".minified_log::table."} WHERE cmid IS NOT NULL AND
				(module='assign' AND action='viewed') OR
				(module='forum' AND action='viewed') OR
				(module='quiz' AND action='viewed')) l
			ON b.disciplina_id=l.course AND b.aluno_id=l.userid AND l.time BETWEEN b.data_inicio and b.data_fim
			GROUP BY b.disciplina_id,b.aluno_id,l.module,cmid) AS temp
		GROUP BY temp.disciplina_id, temp.aluno_id
	";

	const var31 = "
		SELECT b.disciplina_id,b.aluno_id, count(*) AS 'VAR31'
		FROM {".basis::table."} b
		INNER JOIN (SELECT * FROM {".minified_log::table."} WHERE action='viewed' AND module='forum') l
		ON b.aluno_id=l.userid AND b.disciplina_id=l.course AND l.time BETWEEN b.data_inicio and b.data_fim
		GROUP BY b.disciplina_id,b.aluno_id
	";

	const var34 = "
		SELECT b.disciplina_id, b.aluno_id, count(*) AS 'VAR34'
		FROM {forum_posts} p
		INNER JOIN {forum_discussions} d ON (d.id = p.discussion)
		INNER JOIN {forum} f ON d.forum=f.id
		INNER JOIN {".basis::table."} b ON b.disciplina_id=d.course AND b.aluno_id=p.userid AND p.created BETWEEN b.data_inicio and b.data_fim
		WHERE p.parent=0
		GROUP BY b.disciplina_id, b.aluno_id
	";

	const var39 = "
		SELECT p1.disciplina_id,p1.data,post,parent, emissor, receptor, count(*) AS 'VAR39'
		FROM {posts} p1
		INNER JOIN {".basis::table."} b ON b.disciplina_id=p1.disciplina_id AND b.aluno_id=p1.emissor AND p1.data BETWEEN b.data_inicio and b.data_fim
		INNER JOIN {".student::table."} p2 ON p2.disciplina_id=p1.disciplina_id  AND p2.aluno_id=p1.receptor
		GROUP BY p1.disciplina_id, emissor
	";
}
