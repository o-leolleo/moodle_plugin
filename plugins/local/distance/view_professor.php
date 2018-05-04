<?php
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
/*echo $OUTPUT->header();
if(!empty($disciplina_id))
	echo $OUTPUT->heading($disciplinas[$disciplina_id]);
else
	echo $OUTPUT->heading('Por favor, selecione um curso:');
*/

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
if(!empty($disciplina_id))
{
	echo $OUTPUT->box(get_string('distance_student_input', 'local_distance'), 'generalbox');
	echo html_writer::select($alunos, 'aluno_id', $aluno_id, false, array('onchange' => 'this.form.submit()'));
}

//==============================================================================
// CLOSE FORM
echo html_writer::end_tag('form');
echo html_writer::end_div('form_div');

echo html_writer::start_div('chart_div', array('class' => 'hero-unit'));

