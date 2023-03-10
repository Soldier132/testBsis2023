<?php
// Открытие сессии
session_start();

// Подключение к базе данных
$mysqli = new mysqli('localhost:3311', 'moodleuser', 'moodle', 'moodle');

// Обработка ошибок подключения
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

// Получение данных пользователя
$uid = $_SESSION["uid"];
$attemptid = $_GET["attempt"];
$qno = $_GET["qno"];

// Получение данных о попытке теста
$attemptQuery = "SELECT * FROM mdl_quiz_attempts WHERE id = '$attemptid' AND userid = '$uid'";
$attemptResult = mysqli_query($mysqli, $attemptQuery);

if (mysqli_num_rows($attemptResult) > 0) {
  $attemptRow = mysqli_fetch_assoc($attemptResult);
  $quizid = $attemptRow["quiz"];
  $timestart = $attemptRow["timestart"];
  $timefinish = $attemptRow["timefinish"];
}

// Получение данных о вопросе теста
$questionQuery = "SELECT * FROM mdl_question WHERE id = '$qno'";
$questionResult = mysqli_query($mysqli, $questionQuery);

if (mysqli_num_rows($questionResult) > 0) {
  $questionRow = mysqli_fetch_assoc($questionResult);
  $questionid = $questionRow["id"];
  $questiontext = $questionRow["questiontext"];
}

// Получение данных о попытке ответа на вопрос
$questionAttemptQuery = "SELECT * FROM mdl_question_attempts WHERE questionid = '$questionid' AND questionusageid = '$attemptid'";
$questionAttemptResult = mysqli_query($mysqli, $questionAttemptQuery);

if (mysqli_num_rows($questionAttemptResult) > 0) {
  $questionAttemptRow = mysqli_fetch_assoc($questionAttemptResult);
  $fraction = $questionAttemptRow["fraction"];
}

// Получение данных о выбранных ответах
$chosenAnswersQuery = "SELECT * FROM mdl_question_attempts_answers WHERE questionattemptid = '" . $questionAttemptRow['id'] . "'";
$chosenAnswersResult = mysqli_query($mysqli, $chosenAnswersQuery);

if (mysqli_num_rows($chosenAnswersResult) > 0) {
  while ($chosenAnswersRow = mysqli_fetch_assoc($chosenAnswersResult)) {
    $answerid = $chosenAnswersRow["answerid"];
    $answerQuery = "SELECT * FROM mdl_question_answers WHERE id = '$answerid'";
    $answerResult = mysqli_query($mysqli, $answerQuery);
    if (mysqli_num_rows($answerResult) > 0) {
      $answerRow = mysqli_fetch_assoc($answerResult);
      $answertext = $answerRow["answer"];
    }
  }
}

// Получение данных о правильном ответе
$correctAnswerQuery = "SELECT * FROM mdl_question_answers WHERE question = '$questionid' AND fraction = '1'";
$correctAnswerResult = mysqli_query($mysqli, $correctAnswerQuery);

if (mysqli_num_rows($correctAnswerResult) > 0) {
  $correctAnswerRow = mysqli_fetch_assoc($correctAnswerResult);
  $correctAnswer = $correctAnswerRow["answer"];
}

// Закрытие соединения с базой данных
mysqli_close($mysqli);
?>

<!DOCTYPE html>
<html lang="en
