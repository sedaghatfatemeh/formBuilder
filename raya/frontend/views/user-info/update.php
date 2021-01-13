<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use frontend\assets\UserInfoAsset;

UserInfoAsset::register($this);
?>
 <?php
 $form = ActiveForm::begin(['id' => 'detailes-form']);?>
        <?= $form->field($model, 'name')->textInput(['autofocus' => true]); ?>
        <?= $form->field($model, 'last_name'); ?>
        <?php
            if (@$items)
            {
                foreach ($items as $data){
                  echo   \common\models\UserInfo::setItemsForUpdate($data , $model->detailes_item);
                }
            }
        ?>

    <div class="form-group">
     <?= Html::submitButton('ذخیره', ['class' => 'btn btn-primary']) ?>
    </div>
    <?php
    ActiveForm::end();
    ?>
