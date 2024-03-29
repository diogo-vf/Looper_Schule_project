<?php
$title = 'modify';

$exercise = $params->exercise;
$questions = $params->questions;
$questionTypes = $params->questionTypes;

$modifyQuestion = $params->modifyQuestion;
$questionToModify = null;
$questionLabel = '';
$questionMinLength = 1;
$submitButtonText = 'Create field';
if ($modifyQuestion) {
    $questionToModify = $params->questionToModify;
    $questionLabel = $questionToModify['label'];
    $questionMinLength = $questionToModify['minimumLength'];
    $submitButtonText = 'Modify question';
}

$idExercise = $exercise['idExercise'];

$titleSection = 'Modify Exercise : ' . $exercise['name'];

?>
<div class="questionsTable">
    <h1>Questions</h1>
    <div class="row title">
        <div class="label">Order</div>
        <div class="label">Question</div>
        <div class="label">Minimum Length</div>
        <div class="label">Answer type</div>
    </div>

    <?php foreach ($questions as $keys => $question): ?>
        <div class="row title">
            <div class="order">
                <?php if ($keys != 0) :  //when the last loop ?>
                    <a href="/exercise/<?= $idExercise ?>/order/<?= $question['order'] ?>/up">↑</a>
                <?php endif; ?>
                <?php if (next($questions)) :  //when the last loop ?>
                    <a href="/exercise/<?= $idExercise ?>/order/<?= $question['order'] ?>/down">↓</a>
                <?php endif; ?>
            </div>
            <div class="label"><?= $question['label'] ?></div>
            <div class="label"><?= $question['minimumLength'] ?></div>
            <div class="type">
                <div class="questionType"><?= $question['type'] ?></div>
                <div>
                    <input type="hidden" value="<?= $question['order'] ?>" name="order">
                    <a href="/exercise/<?= $idExercise ?>/question/<?= $question['idQuestion'] ?>/modify"
                       title="Modify question">
                        <div class="fa fa-edit ico"></div>
                    </a>
                    <a href="/exercise/<?= $idExercise ?>/question/<?= $question['idQuestion'] ?>/delete"
                       title="Delete question">
                        <div class="fas fa-trash ico"></div>
                    </a>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="buttonRow">
        <button onclick="window.location.href = 'http://<?= $_SERVER["HTTP_HOST"] ?>/exercise/<?= $idExercise ?>/completeExercise';">
            Complete and be ready for answers
        </button>
    </div>
</div>

<div class="newQuestionForm">
    <h2>
        New question
    </h2>
    <form class="createQuestion" action='/exercise/<?= $idExercise; ?>/modify' method="post">
        <label for="label">Label</label>
        <input type="text" name="label" id="label" value="<?= $questionLabel ?>" maxlength="50" required>

        <label for="minimumLength">Acceptance size</label>
        <input type="number" name="minimumLength" id="minimumLength" min="1" max="50" value="<?= $questionMinLength ?>"
               required>

        <label for="idAnswerType">Answer type</label>
        <select name="idAnswerType" id="idAnswerType">
            <?php foreach ($questionTypes as $questionType): ?>
                <option value="<?= $questionType['idQuestionType'] ?>"
                    <?php if ($modifyQuestion && $questionType['idQuestionType'] == $questionToModify['fkQuestionType']): ?>
                        selected
                    <?php endif; ?>
                ><?= $questionType['type'] ?></option>
            <?php endforeach; ?>
        </select>

        <?php if ($modifyQuestion): ?>
            <input type="text" name="idQuestionToModify" id="idQuestionToModify"
                   value="<?= $questionToModify['idQuestion'] ?>" required hidden>
        <?php endif; ?>

        <button type="submit">
            <?= $submitButtonText ?>
        </button>
    </form>
</div>

