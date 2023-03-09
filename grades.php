<?php
	setlocale(LC_ALL, 'ru_RU.UTF-8');
	echo '<html lang="ru" xml:lang="ru" xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><style media="print" type="text/css">.noprint {display: none;}}</style></head><body style="margin-left: 100;">';
$link = mysqli_connect('localhost:3311', 'moodleuser', 'moodle', 'moodle');
if (!$link) {
    die('Ошибка подключения (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
}
mysqli_set_charset($link, "utf8");
	//strip_tags($_GET['attempt']);
	//if (!$a = intval($a)) $a = 1	
	//$attemptid = (int) $_GET['attempt'];
if (is_numeric($_GET['attempt'])) {
	echo '<span class="noprint"><center><p><input type="button" value="Назад" onClick="window.location=\'./quiz/review.php?attempt=' . $_GET['attempt'] . '\'"><input type="button" value="Печать" onclick="javascript:print()"></input></p></center></span>';
$result = mysqli_query($link, 'SELECT * FROM `mdl_quiz_attempts` WHERE `id`='.$_GET['attempt']);
	$row = mysqli_fetch_assoc($result);
	$userid = $row['userid'];
	$questions  = $row['layout'];
	$sumgrades_usr = $row['sumgrades'];
	$timestart_usr = $row['timestart'];
	$timefinish_usr = $row['timefinish'];
	$seconds = $timefinish_usr - $timestart_usr;
	$time = floor($seconds/3600).":".sprintf("%02d", floor(($seconds - 3600*floor($seconds/3600))/60)).":".sprintf("%02d", $seconds - 60*floor(($seconds - 3600*floor($seconds/3600))/60) - 3600*floor($seconds/3600));
	$result = mysqli_query('SELECT * FROM `mdl_quiz` WHERE `id`='.$row['quiz']);
	$row = mysqli_fetch_assoc($result);
	$sumgrades_quiz = $row['sumgrades'];
	$result = mysqli_query('SELECT * FROM `mdl_user` WHERE `id`='.$userid);
	$row = mysqli_fetch_assoc($result);
	$usr = $row['firstname'].' '.$row['lastname'];	
	$per = $sumgrades_usr/$sumgrades_quiz*100;
	if ($per >= 75) {$grade='Отлично';} elseif ($per >= 60 && $per < 75) {$grade='Хорошо';} elseif ($per >= 50 && $per < 60) {$grade='Удовлетворительно';} else {$grade='Неудовлетворительно';} ;
	echo
'<tt><font size="12px">
<div align="center">
				<b>ПРОТОКОЛ № _________
заседания комиссии по проверке знаний нормативно-технических документов</b><br>
<br><br>
_________________________________________________________________________________________________________
                            <br>
                            (полное наименование организации)
                            <br><br>
<br>
</div>';
	
	echo
'<div align="left" style="float:left;">
20____ г.</div>
<div  align="right" style="float:right;">
"____" ______________<br></div>
<br><br><br>
<div align="left">
В соответствии с приказом (распоряжением) работодателя (руководителя) организации <br>от "____" ____________ 20____ г. №______ комиссия в составе
<br><br>
                            председателя
                            <br><br>
</div>
<div>
                            _________________________________________________________________________________________________________
                            <br>
<div align="center">(Ф.И.О., должность)</div>
<br>

                            членов:
                            <br><br>
                            _________________________________________________________________________________________________________
                            <br>
<div align="center">(Ф.И.О., должность)</div>
<br>
                            _________________________________________________________________________________________________________
                            <br>
<div align="center">(Ф.И.О., должность)</div>
<br>
                            _________________________________________________________________________________________________________
                            <br>
<div align="center">(Ф.И.О., должность)</div>
<br>
                            провела проверку знаний ПТЭ, СНиП, СанПиН, ГОСТ Р, ГОСТ и других нормативно-технических документов
                            (ненужное
                            зачеркнуть)
                            <br>
<br>
</div>';
	echo
'<div align="left">
<u>Проверяемый</u><br>
<br>
                            Фамилия, имя, отчество - 
<b>'.$usr.'</b>
<br><br>
                            Место работы <br><br>
_________________________________________________________________________________________________________
<br><br>
                            Должность <br><br>
_________________________________________________________________________________________________________
<br>
<br>
                 Проведена ________________________________ проверка знаний по теме <br>
&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp(очередная, внеочередная и т.д.)
<br>
<br>
_________________________________________________________________________________________________________
<br>
                          <br>  в объёме, соответствующем должностным обязанностям
                            <br>
<br>
<div align="left">Дата начала проверки -
                            <b>'.strftime('%A, %d %B %Y, %R:%S', $timestart_usr).'</b>
<br>
</div>
<div align="left">Дата окончания проверки -
                            <b>'.strftime('%A, %d %B %Y, %R:%S', $timefinish_usr).'</b>
<br>
</div>
<div align="left">Время выполнения -
                            <b>'.$time.'</b>
<br>
</div>


<br>

<u><b>Заключение комиссии:</b></u>
<br>
<br>
                            Общая оценка -
                            <b>'.$grade.' ('.round($sumgrades_usr,2).' баллов из '.round($sumgrades_quiz,2).')</b>
<br>
                            Дата следующей проверки<br><br>
_________________________________________________________________________________________________________
<br>
<br>
<br>
<br>
</div>
                        Председатель комиссии
                        <div>
                            _________________________________________________________________________________________________________
                            <br>
<div align="center">(должность, фамилия и инициалы)</div>
<br>
</div>
                        Члены комиссии<br>
                        <div>
                            _________________________________________________________________________________________________________
                            <br>
<div align="center">(должность, фамилия и инициалы)</div>
<br>
                            _________________________________________________________________________________________________________
                            <br>
<div align="center">(должность, фамилия и инициалы)</div>
<br>
                            _________________________________________________________________________________________________________
                            <br>
<div align="center">(должность, фамилия и инициалы)</div>
<br>
</div>
                        С заключением комиссии ознакомлен
                        <div>
                            _________________________________________________________________________________________________________
                            <br>
<div align="center">(должность, фамилия и инициалы)</div>
<br>
</div>
<br>
<b>Результаты проверки знаний</b>';



	$que = explode(",", $questions);
	$qsize = count($que);
	$num = 0;
	for ($i=0; $i<$qsize; $i++) {
		if ($que[$i]!=0) {
			$num = $num+1;
			echo '<br><br><b>Вопрос №'.$num.'</b><br>';
			$slots = mysqli_query('SELECT * FROM `mdl_question_attempts` WHERE `slot`='.$que[$i]);
			while ($row_slots = mysqli_fetch_assoc($slots)) {
		
				$step = mysqli_query('SELECT * FROM `mdl_question_attempt_steps` WHERE `userid`='.$userid.' AND `questionattemptid`='.$row_slots['id']);
				while ($row_step = mysqli_fetch_assoc($step)) {
					if ($row_step['state'] == 'gradedwrong') {
						$stateans = 0;
						$gradepart = $row_step['fraction'];
						//echo $stateans.'    ';
					} elseif ($row_step['state'] == 'complete') {
						$queattid = $row_step['questionattemptid'];
						$gradepart = $row_step['fraction'];
						//echo $queattid.'    ';
					} elseif ($row_step['state'] == 'gradedright') {
						$stateans = 1;
						$gradepart = $row_step['fraction'];
						//echo $stateans.'    ';
					} elseif ($row_step['state'] == 'gradedpartial') {
						$queattid = $row_step['questionattemptid'];
						$gradepart = $row_step['fraction'];
						$stateans = 2;
						//echo $queattid.'    ';
					}


				}
			}
			$quer_que_attempt = mysqli_query('SELECT * FROM `mdl_question_attempts` WHERE `id`='.$queattid);
			while ($que_attempt = mysqli_fetch_assoc($quer_que_attempt)) {
				$quer_que_id = mysqli_query('SELECT * FROM `mdl_question` WHERE `id`='.$que_attempt['questionid']);
					echo 'Текст вопроса: ';
					$text = explode(":", $que_attempt['questionsummary']);
					echo '<i>'.$text[0].'</i><br>';
				//while ($que_id = mysqli_fetch_assoc($quer_que_id)) {
				//	echo 'Текст вопроса: ';
				//	echo '<i>'.$que_id['questiontext'].'</i>';
				//}
				echo 'Ответ тестируемого: ';
				echo '<i>'.$que_attempt['responsesummary'].'</i><br>';
				if ($stateans == 1) {
					echo '<b>Ответ правильный!</b><br>';
					echo '<b>Баллов: '.round($gradepart,2).'</b>';
				} elseif ($stateans == 0) {
					echo 'Ответ правильный: ';
					echo '<i>'.$que_attempt['rightanswer'].'</i><br>';
					echo '<b>Ответ неправильный!</b><br>';
					echo '<b>Баллов: '.round($gradepart,2).'</b>';
				} else {
					echo 'Ответ правильный: ';
					echo '<i>'.$que_attempt['rightanswer'].'</i><br>';
					echo '<b>Ответ частично правильный!</b><br>';
					echo '<b>Баллов: '.round($gradepart,2).'</b>';
				}
			}
		}
	}
} else {
	echo 'Неверный формат данных выводимого тестирования';
}
	mysqli_close($link);
	echo '</font></tt>';
	echo '</body></html>';
?>
