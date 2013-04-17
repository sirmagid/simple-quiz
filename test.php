<?php //test.php

include 'functions.php';
$quiz = QuizFactory::getQuiz();

$quiz->session->start();

$num = $quiz->session->get('num') ? $quiz->session->get('num') : 1;

?>
<!DOCTYPE html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" href="res/css/style.css" type="text/css" />
    <title>The Web Acronym Test</title>
    <?php 
    if (! $quiz->session->get('last')) 
    {
        echo '<script type="text/javascript" src="res/js/form.js"></script>';
    }
    ?>
</head>
<body>
<div id="wrapper">
<div id="intro">
<h1>Take the test and see how well you know your web acronyms</h1>
<p>Each acronym has 4 possible answers. Choose the answer you think is correct and click <strong>'Submit Answer'</strong>. You'll then be given the next acronym.</p>
<p>There are 20 acronyms, so let's get cracking! You'll get your score at the end of the test. It's just like facebook (honest!).</p>
<?php if( $quiz->session->get('user') ) echo '<h4>Current tester: ' . $quiz->session->get('user') . '</h4>'; ?>
</div><!--intro-->
<div id="quiz">
<?php 
if (! $quiz->session->get('last') ) 
{ 
    $question = $quiz->getQuestion($num);
    $answers = $quiz->getAnswers($num);
?>
    <h2>Acronym <?php echo $num; ?>:</h2>
    <p>What does <strong><?php echo $question; ?></strong> stand for?</p>
    <form id="questionBox" method="post" action="processor.php">
        <ul>
        <?php 
        $shuffledAnswers = shuffle_assoc($answers);

        $acount = 0;
        foreach ($shuffledAnswers as $answer) 
        {
            echo '<li><input type="radio" id="answer' . $acount . '" value="' . $answer . '" name="answers" />' .PHP_EOL;
            echo '<label for="answer' . $acount . '">' . $answer . '</label></li>' . PHP_EOL;
            $acount++;
        }
        ?>
        </ul>
        <p><input type="hidden" name="num" value="<?php echo $num; ?>" />
            <input type="hidden" name="submitter" value="TRUE" />
            <input type="submit" id="submit" name="submit" value="Submit Answer" />
        </p>
    </form>
<?php 
} 
else 
{ 
    echo $quiz->giveVerdict();
    echo '<p id="compare"><a href="results.php">See how you compare! <img src="images/arrow.png" /></a></p>';
}
?>
</div><!--quiz-->
</div><!--wrapper-->
</body>
</html>