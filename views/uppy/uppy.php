<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* register your model here */

UppyUsset::register($this);
?>

<?php $form = ActiveForm::begin([
    'options' => [
        'autocomplete' => 'off',
        'class' => 'form-horizontal',
        'id' => 'form_sample_1',
        'enctype' => 'multipart/form-data',
    ]
]) ?>

<?= $form->field($model, 'content')
    ->textarea(['class' => 'form-control', 'placeholder' => 'Content'])
    ->label('Content', ['class' => 'form-label']) ?>

    <!-- data-url for uppy action end point call -->
    <!-- data-redirect view redirection after submit form -->
    <div id="drag-drop-area" data-url="<?= Url::to(['uppy/upload']) ?>"
         data-redirect="<?= Url::to(['uppy/index']) ?>">
    </div>

    <div class="form-group">

        <?= Html::submitButton('Submit', [
            'class' => 'btn btn-info m-r-20',
        ]) ?>

        <!--    Second button is important to send separate request within validation fields -->
        <?= Html::button('Submit', [
            'class' => 'btn btn-info m-r-20 uppy-submit',
        ]) ?>

    </div>

<?php ActiveForm::end(); ?>
