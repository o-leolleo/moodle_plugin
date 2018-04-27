<?php
require_once('../../config.php');
require_once($CFG->dirroot.'/local/distance/locallib.php');
require_once($CFG->libdir.'/adminlib.php');

//require_login();

//==============================================================================
// GET ID FROM URL
$disciplina_id          = optional_param('disciplina_id', 0, PARAM_INT);	// Course ID.
$aluno_id        	= optional_param('aluno_id', 0, PARAM_INT);		// Student ID.
$group_id		= optional_param('group_id', 0, PARAM_INT);             // Group ID.

//==============================================================================
// SET PAGELAYOUT
//admin_externalpage_setup('localdistance', '', null, '',['pagelayout'=>'report']);
require_login();

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/local/distance/index.php');
//$PAGE->set_title('Local Plugin');
$PAGE->set_heading(get_string('pluginname', 'local_distance'));
$PAGE->set_pagelayout('report');

//==============================================================================
// database
global $DB;

//==============================================================================
// TODO: GET THIS FROM USER
// SET DATABASE
$base_DB = 'mdl_transational_distance';

//==============================================================================
//  ____ ___ ____   ____ ___ ____  _     ___ _   _    _
// |  _ \_ _/ ___| / ___|_ _|  _ \| |   |_ _| \ | |  / \
// | | | | |\___ \| |    | || |_) | |    | ||  \| | / _ \
// | |_| | | ___) | |___ | ||  __/| |___ | || |\  |/ ___ \
// |____/___|____/ \____|___|_|   |_____|___|_| \_/_/   \_\
//
//==============================================================================

//==============================================================================
// GET ALL DISCIPLINES FROM BASE
$select = 	'SELECT DISTINCT  	`disciplina_id` AS `Id`,
					`disciplina_nome` AS `Nome`';	
$from   =	'FROM '.$base_DB;
$query  = $select.' '.$from;

$disciplinas_DB = $DB->get_records_sql($query);

//==============================================================================
// CREATE ARRAY WITH ALL DISCIPLINE FROM SQL STATEMENT
$disciplinas = array();
$disciplinas[0] = "Selecione uma Disciplina";
foreach($disciplinas_DB as $disciplina)
{
	$disciplinas[$disciplina->id] = $disciplina->nome;
}


//==============================================================================
// GET AVERAGE OF ALL INFO
if(!empty($disciplina_id))
{
	//==========================================================================
	// SQL STATEMENTS
	// var01 | var31 | var34 | var39 | var13a | var13b | var13c | var13d | var18 | var26 | var27
	$select = 'SELECT 	ROUND(AVG(`VAR01`),2) as `var01`,
				ROUND(AVG(`VAR31`),2) as `var31`,
				ROUND(AVG(`VAR34`),2)  as `var34`,
				ROUND(AVG(`VAR39`),2)  as `var39`,
				ROUND(AVG(`VAR13a`),2) as `var13a`,
				ROUND(AVG(`VAR13b`),2) as `var13b`,
				ROUND(AVG(`VAR13c`),2) as `var13c`,
				ROUND(AVG(`VAR13d`),2) as `var13d`,
				ROUND(AVG(`VAR18`),2)  as `var18`,
				ROUND(AVG(`VAR26`),2)  as `var26`,
				ROUND(AVG(`VAR27`),2)  as `var27`';
	$from = 'FROM '.$base_DB;
	$where= 'WHERE `disciplina_id` ='.$disciplina_id;

	$query = $select.' '.$from.' '.$where;
	//$query = 'SELECT AVG(`var01`) FROM mdl_transational_distance where disciplina_id=90';

	// GET FROM TABLE
	$mean_var_DB       = $DB->get_records_sql($query);
}

//==============================================================================
// CREATE CHART SERIE
if(!empty($disciplina_id))
{
	// GET FIRST ELEMENT IN $MEAN_VAR_DB
	$mean_var_object = reset($mean_var_DB);

	// CREATE ARRAY TO SPECIFIC GRAPH
	$foruns_array = array(	$mean_var_object->var01,
							$mean_var_object->var31,
							$mean_var_object->var34,
							$mean_var_object->var39
						);

	$ambiente_array = array(	$mean_var_object->var13a,
								$mean_var_object->var13b,
								$mean_var_object->var13c,
								$mean_var_object->var13d,
								$mean_var_object->var18,
								$mean_var_object->var26,
								$mean_var_object->var27

							);
	// CREATE CHART SERIES
	$foruns_serie   = new core\chart_series('Média da turma', $foruns_array);
	$ambiente_serie = new core\chart_series('Média da turma', $ambiente_array);
}

//==============================================================================
//   _____ ____ _____ _   _ ____    _    _   _ _____ _____
//  | ____/ ___|_   _| | | |  _ \  / \  | \ | |_   _| ____|
//  |  _| \___ \ | | | | | | | | |/ _ \ |  \| | | | |  _|
//  | |___ ___) || | | |_| | |_| / ___ \| |\  | | | | |___
//  |_____|____/ |_|  \___/|____/_/   \_\_| \_| |_| |_____|
//
//==============================================================================
// GET ALL STUDENT FROM TABLE AND PUT IN ARRAY
if(!empty($disciplina_id))
{

	//=============================================================================
	// GROUP 
	//-----------------------------------------------------------------------------	
	
	//=============================================================================
	// SQL STATEMENTS
	$select = 'SELECT 	`id` AS `Id`,
				`name` AS `Nome`';

	$from  = 'FROM `mdl_groups`';
	$where = 'WHERE `courseid` = '.$disciplina_id;

	//==============================================================================
	// GET RERCORD FROM TABLE
	$query = $select.' '.$from.' '.$where;
	$alunos_group_DB = $DB->get_records_sql($query);
	
	//==============================================================================
	// CREATE ARRAY WICH CONTAIN ALL DISCIPLINES GIVEN BY DATABASE
	$alunos_group = array();
	$alunos_group[0] = "Selecione um pólo:";
	foreach($alunos_group_DB as $aluno_group)
	{
		$alunos_group[$aluno_group->id] = $aluno_group->nome;
	}

	//=============================================================================
	// STUDENT
	//-----------------------------------------------------------------------------
	
	//=============================================================================
	// SQL STATEMENTS
	$select = 'SELECT 	`aluno_id` AS `Id`, `aluno_nome` AS `Nome`';
	$from  = 'FROM '.$base_DB;
	$where = 'WHERE `disciplina_id` = '.$disciplina_id;
	
	//==============================================================================
	// GET RERCORD FROM TABLE
	$query = $select.' '.$from.' '.$where;
	$alunos_DB = $DB->get_records_sql($query);
	
	//=============================================================================
	// SQL STATEMENTS
	// SELECT `groupid`,`userid` FROM `mdl_groups_members` WHERE 1
	$select = 'SELECT `userid` AS `id`';

	$from  = 'FROM `mdl_groups_members`';
	$where = 'WHERE `groupid` = '.$group_id;

	//==============================================================================
	// GET RERCORD FROM TABLE
	$query = $select.' '.$from.' '.$where;
	$alunos_group_DB = $DB->get_records_sql($query);
		
	
	//==============================================================================
	// CREATE ARRAY WICH CONTAIN ALL DISCIPLINES GIVEN BY DATABASE
	$alunos = array();
	
	foreach($alunos_DB as $aluno)
	{
		$alunos_disciplina[$aluno->id] = $aluno->nome;
	}
	if(empty($alunos_group_DB))
	{
		$alunos = $alunos_disciplina;
	}
	else
	{
		foreach($alunos_group_DB as $aluno)
		{
			if(!empty($alunos_disciplina[$aluno->id]))
				$alunos[$aluno->id] = $alunos_disciplina[$aluno->id];
		}

	}
	asort($alunos);
	//array_push($alunos, "Selecione um aluno");
	//$alunos[0] = "Selecione um aluno";
}

// CHECK IF STUDENT EXIST IN TABLE, GET HIS VALUES FROM TABLE
// THAN CREATE GRAPH SERIE
if(!empty($aluno_id) && !empty($disciplina_id)) 
{
	//==========================================================================
	// SQL STATEMENTS
	
	if($group_id == 0)
	{
		// CONDICTION WITHOUT GROUP
		$select = 	'SELECT *';
		$from   = 	'FROM '.$base_DB;
		$where  =	'WHERE `aluno_id` = '.$aluno_id
				.' AND `disciplina_id` = '.$disciplina_id;
	}		
	else
	{
		// CONDICTION WITH GROUP SELECTED
		$select = 	'SELECT *';
		$from   = 	'FROM mdl_groups_members';
		$where  =	'WHERE `userid` = '.$aluno_id
				.' AND `groupid` = '.$group_id;
	}

	//==========================================================================
	// FIRST CHECK IF STUDENT EXIST IN TABLE
	$query = $select.' '.$from.' '.$where;
	
	$aluno_exist = $DB->record_exists_sql($query);
	
	// TODO: CREATE TWO ARRAY WITH DATA FROM ONLY ONE OBJECT
	if($aluno_exist)
	{
		//==========================================================================
		// SQL STATEMENTS
		// CONDICTION
		$from = 	'FROM '.$base_DB;
		$where=		'WHERE `aluno_id` = '.$aluno_id
				.' AND `disciplina_id` = '.$disciplina_id;

		//----------------------------------------------------------------------------
		// TODO: JOIN THIS TWO SELECT IN ONLY ONE	
		// GRAPH: RELACIONADAS AOS FORUNS
		$graph01_select = 'SELECT	`VAR01` as `0`,
						`VAR31` as `1`,
						`VAR34` as `2`,
						`VAR39` as `3`';

		// GRAPH: RELACIONADAS AOS ACESSOS
		$graph02_select = 'SELECT	`VAR13a` as `0`,
						`VAR13b` as `1`,
						`VAR13c` as `2`,
						`VAR13d` as `3`,
						`VAR18`  as `4`,
						`VAR26`  as `5`,
						`VAR27`  as `6`';

		///=====================================================================
		// 
		$query = $graph01_select.' '.$from.' '.$where;
		$aluno_DB = $DB->get_records_sql($query);
		$aluno_array = (array) reset($aluno_DB);

		//======================================================================
		// CREATE GRAPH SERIE
		$aluno_serie_01   = new core\chart_series($alunos[$aluno_id], $aluno_array);
		//$aluno_serie->set_type(\core\chart_series::TYPE_LINE);

		//======================================================================
		//
		$query = $graph02_select.' '.$from.' '.$where;
		$aluno_DB = $DB->get_records_sql($query);
		$aluno_array = (array) reset($aluno_DB);

		//======================================================================
		// CREATE GRAPH SERIE
		$aluno_serie_02 = new core\chart_series($alunos[$aluno_id], $aluno_array);
		//$aluno_serie->set_type(\core\chart_series::TYPE_LINE);
	}
}

//==============================================================================
//        _   _ _____ __  __ _
//	 | | | |_   _|  \/  | |
//	 | |_| | | | | |\/| | |
//	 |  _  | | | | |  | | |___
//	 |_| |_| |_| |_|  |_|_____|
//
//==============================================================================

//==============================================================================
// HEADER
echo $OUTPUT->header();
if(!empty($disciplina_id))
	echo $OUTPUT->heading($disciplinas[$disciplina_id]);
else
	echo $OUTPUT->heading('Por favor, selecione um curso:');


//==============================================================================
// SMALL EXPLAIN IN TOP
//echo $OUTPUT->box(get_string('distance_desc', 'local_distance'), 'generalbox mdl-align');

//==============================================================================
// CREATE A FORM
echo html_writer::start_div('form_div', array('class' => 'moodle-dialogue-base'));
echo html_writer::start_tag('form', array('id' => 'selectform', 'method' => 'get', 'action' => ''));

//==============================================================================
// CREATE A DROP MENU WITH ALL DISCIPLINE
if(empty($disciplina_id))
{
	echo $OUTPUT->box(get_string('distance_course_input', 'local_distance'),'generalbox');
	echo html_writer::select($disciplinas, 'disciplina_id', $disciplina_id, false, array('type'=>'hidden','onchange' => 'this.form.submit()'));
}

//==============================================================================
// CLOSE FORM
echo html_writer::end_tag('form');
echo html_writer::end_div('form_div');

//==============================================================================
// CREATE A FORM
echo html_writer::start_div('form_div', array('class' => 'moodle-dialogue-base'));
echo html_writer::start_tag('form', array('id' => 'selectform', 'method' => 'post', 'action' => ''));

//==============================================================================
// CREATE A DROP MENU WITH ALL GROUPS
if(!empty($disciplina_id))
{
	echo $OUTPUT->box(get_string('distance_group_input', 'local_distance'), 'generalbox');
	echo html_writer::select($alunos_group, 'group_id', $group_id, false, array('onchange' => 'this.form.submit()'));
}


//==============================================================================
// CREATE A DROP MENU WITH ALL STUDENT
if(!empty($disciplina_id) && !empty($alunos))
{
	echo $OUTPUT->box(get_string('distance_student_input', 'local_distance'), 'generalbox');
	echo html_writer::select($alunos, 'aluno_id', $aluno_id, false, array('onchange' => 'this.form.submit()'));
}

//==============================================================================
// CLOSE FORM
echo html_writer::end_tag('form');
echo html_writer::end_div('form_div');

echo html_writer::start_div('chart_div', array('class' => 'hero-unit'));

//==============================================================================
if(!empty($disciplina_id))
{
	echo html_writer::tag('h2',get_string('distance_forum_title', 'local_distance'));
	$chart = new core\chart_bar();
	$chart->add_series($foruns_serie);
	if(!empty($aluno_id) && $aluno_exist )
		$chart->add_series($aluno_serie_01);
	$chart->set_labels([	'Postagens nos fóruns', 
				'Acessos aos fóruns',
				'Tópicos criados em fóruns',
				'Respostas a outros estudantes em fóruns']);

	echo $OUTPUT->render($chart);

	echo html_writer::tag('h3',get_string('distance_environment_title', 'local_distance'));
	$ambiente_chart = new core\chart_bar();
	$ambiente_chart->add_series($ambiente_serie);
	if(!empty($aluno_id) && $aluno_exist)
		$ambiente_chart->add_series($aluno_serie_02);
	
	$ambiente_chart->set_labels([	'Acessos turno Manhã',
					'Acessos turno Tarde',
					'Acessos turno Noite',
					'Acessos turno Madrugada',
					'Total de acessos à disciplina',
					'Média de acessos aos recursos',
					'Média de acessos às atividades']);

	echo $OUTPUT->render($ambiente_chart);

	//echo '<pre>'; print_r($group_id); echo '</pre>';
	//echo '<pre>'; print_r($aluno_id); echo '</pre>';
}
echo html_writer::end_div('chart_div');

echo $OUTPUT->footer();
