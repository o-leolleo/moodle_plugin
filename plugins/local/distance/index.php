<?php
require_once('../../config.php');
require_once($CFG->dirroot.'/local/distance/locallib.php');
require_once($CFG->libdir.'/adminlib.php');


//==============================================================================
// GET ID FROM URL
$disciplina_id          = optional_param('disciplina_id', 0, PARAM_INT);	// Course ID.
$aluno_id        	= optional_param('aluno_id', $USER->id, PARAM_INT);	// Student ID.
$group_id		= optional_param('group_id', 0, PARAM_INT);             // Group ID.

//==============================================================================
// SET PAGELAYOUT
require_login();

$PAGE->set_context(context_system::instance());
$PAGE->set_url('/local/distance/index.php');
$PAGE->set_title('PLugin Gráficos do curso');
$PAGE->set_heading(get_string('pluginname', 'local_distance'));
$PAGE->set_pagelayout('report');

//==============================================================================
// GLOBAL VARIABLES 
global $DB;	// DATABASE ACESS
global $USER;	// USER INFORMATION

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
				ROUND(AVG(`VAR39`),2)  as `var39`,
				ROUND(AVG(`VAR22`),2)  as `var22`,
				ROUND(AVG(`VAR21`),2)  as `var21`,
				ROUND(AVG(`VAR19`),2)  as `var19`,
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
				$mean_var_object->var39,
				$mean_var_object->var22,
				$mean_var_object->var21,
				$mean_var_object->var19
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
	// TODO: CREATE ARRAY WITH AVERAGE STUDENT INFO PER GROUP
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
	// CREATE ARRAY WHICH CONTAIN ALL DISCIPLINES GIVEN BY DATABASE
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
	if(!empty($alunos_DB))
	{	
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
	}
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
						`VAR39` as `2`,
						`VAR22` as `3`,
						`VAR21` as `4`,
						`VAR19` as `5`';

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

// CHECK IF 'DISCIPLINA' WAS ALREADY CHOSEN AND EXIST
if(!empty($disciplinas[$disciplina_id]))
{
	// DISPLAY THE NAME OF 'DISCIPLINA'
	echo $OUTPUT->heading($disciplinas[$disciplina_id]);

	// DISPLAY BUTTON FOR REPORT DOWNLOAD
	echo $OUTPUT->single_button(new moodle_url('export_data.php', ['disciplina_id' => $disciplina_id]), "Download");

	// GET CONTEXT 
	$course_context = context_course::instance($disciplina_id);
	
	// IF USER IS TEACHER IN THIS COURSE, SHOW INPUT FORM
	if(is_enrolled($course_context, $USER->id, 'moodle/course:update'))
	{
		include 'view_professor.php';
	}
	
	// IF USER IS ENROLLED IN COURSE, SHOW GRAPHS
	if(is_enrolled($course_context, $USER->id))
	{
		//$PAGE->set_url('/local/distance/index.php',array('aluno_id'->$USER->id));
		include 'view_graficos.php';
	}

}
else
{
	// THE DISCIPLINE CHOSEN DIDN'T EXIST IN TRANSACTIONAL TABLE
	if(!empty($disciplina_id))
	{
		echo $OUTPUT->heading('Sem informações do curso');
	}
	else
	{
		// THIS VIEW OCCUR WHEN USER OPENS REPORT MENU
		// MOODLE_ADMINISTRATION->REPORT->Visão Geral dos indicadores
		echo $OUTPUT->heading('Status do plugin');
	}
}

//
echo $OUTPUT->footer();
