<?php
$title = 'results';
$titleSection = "Exercise : ";
$details = "<a href='/exercise/$params->exerciseId/results'>$params->exercise</a>";

?>
<h1><?= $params->results[0]->name ?></h1>
<?php foreach ( $params->results[0]->question as $question): ?>
<div class="question">
    <div class="title"><?= $question->label ?></div>
    <div class="answer"><?= $question->answer ?></div>
</div>
<?php endforeach; ?>
