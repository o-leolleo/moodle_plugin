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
if(!empty($disciplina_id))
{
	echo html_writer::tag('h2',get_string('distance_forum_title', 'local_distance'));
	$chart = new core\chart_bar();
	$chart->add_series($foruns_serie);
	if(!empty($aluno_id) && $aluno_exist )
		$chart->add_series($aluno_serie_01);
	$chart->set_labels([	'Postagens de um(a) aluno(a) em fóruns.', 
				'Acessos da(o) aluna(o) aos fóruns.',
				'Tópicos criados pelo(a) aluno(a) em fóruns.',
				'Resposta(s) a outros(as) alunos(as).']);

	echo $OUTPUT->render($chart);

	echo html_writer::tag('h3',get_string('distance_environment_title', 'local_distance'));
	$ambiente_chart = new core\chart_bar();
	$ambiente_chart->add_series($ambiente_serie);
	if(!empty($aluno_id) && $aluno_exist)
		$ambiente_chart->add_series($aluno_serie_02);
	
	$ambiente_chart->set_labels([	'Acessos do(a) aluno(a) ao ambiente (Manhã)',
					'Acessos do(a) aluno(a) ao ambiente (Tarde)',
					'Acessos do(a) aluno(a) ao ambiente (Tarde)',
					'Acessos do(a) aluno(a) ao ambiente (Madrugada)',
					'Acessos do(a) aluno(a) ao ambiente no período da disciplina',
					'Média de acessos de um(a) aluno(a) aos recursos',
					'Média de acessos de um(a) aluno(a) as atividades']);

	echo $OUTPUT->render($ambiente_chart);

	//echo '<pre>'; print_r($group_id); echo '</pre>';
	//echo '<pre>'; print_r($aluno_id); echo '</pre>';
}
echo html_writer::end_div('chart_div');

//echo $OUTPUT->footer();
