<?php
session_start();
$listPreguntas = $_SESSION['listPreguntas'];
$j = $_SESSION['j'];
if (file_exists('Quiz.json')) {
    $filename = 'Quiz.json';
    $data = file_get_contents($filename);
    $info = json_decode($data);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>
    <?php
    function guardarRespuesta()
    {
        $id_answer = $_GET["id_answer"];
        $listAnswer = array();
        array_push($listAnswer, $$id_answer);
        return $listPreguntas;
    } ?>
    <div class="container">
        <div id="quiz">
            <h1>Quiz</h1>
            <hr style="margin-bottom: 20px">
            <p id="question"><?= $info[$listPreguntas[$j]]->question; ?></p>
            <form class="button-grp" action="guardarRespuesta()" method="get">
                <input type="hidden" name="id_pregunta" value="<?= $j ?>"></input>
                <?php
                    for ($i = 0; $i <= 3; $i++) { ?>
                        <input type="submit" id="btn0" name="id_answer" value="<?= $i + 1 . ". " . $info[$listPreguntas[$j]]->answers[$i]; ?>" ></input>
                    <?php } ?>
            </form>
            <hr style="margin-top: 50px">
            <footer>
                <p id="progress">Question <?= $j + 1 ?> of 10</p>
            </footer>
        </div>
    </div>
</body>

</html>