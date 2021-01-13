<?php

use common\models\Enumeration;
use unclead\multipleinput\MultipleInput;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use common\models\DetailesForm;
?>
 <?php
 $form = ActiveForm::begin([
     'id'                        => 'detailes-form',
     'enableClientValidation'    => false,
     'validateOnSubmit'          => true,
         ]);  ?>
<?=
    $form->field($model, 'schedule')->widget(MultipleInput::className(), [
    'max' => 10,
    'id' => 'detailes-form-schedule',
    'form' => $form,
    'allowEmptyList'    => false,
    'addButtonPosition' => MultipleInput::POS_HEADER, // show add button in the header
    'data' => \common\models\DetailesForm::getData(),
//        'rowOptions' => function($model) {
//            $options = [];
//            if (empty($model['title'])) {
//                $options['class'] = 'danger';
//            }
//            return $options;
//        },
        'cloneButton' => true,
    'columns' => [
        [
            'name'          => 'title',
            'title'         => 'نام',
            'enableError' => true,
            'options' => [
                'class' => 'input-title'
            ]
        ],
        [
            'name'          => 'lable',
            'title'         => 'عنوان',
            'enableError'   => true,
            'options' => [
                'class' => 'input-lable',
                'type' => 'string',
            ]
        ],
        [
            'name'  => 'type',
            'type'  => 'dropDownList',
            'title' => 'نوع',
            'defaultValue' => 1,
            'items' => \common\models\DetailesForm::typeLists(),
            'options' => [
                'onchange' => <<< JS
                    var x =$(this).closest('td').next().find('select');
                    $.post("set-list/"+$(this).val(), function(data){
                      $(x).html(data);
                     
                        });
JS
            ],
        ],
        [
            'name'  => 'type_list',
            'type'  => 'dropDownList',
            'title' => 'انتخاب لیست',
            'items' => Enumeration::getParentEnumByType(Enumeration::NOT_SHOW_IN_LIST , true),
            'options' => [
                'class' => "form-control list-type",
                
                ],
            ],
        [
            'name'          => 'length',
            'title'         => 'طول',
            'enableError'   => true,
            'options' => [
                'class' => 'input-length',
                    'type' => 'number',
            ]
        ]
    ]
]);
    ?>
<div class="form-group">
 <?= Html::submitButton('ثبت', ['class' => 'btn btn-primary', 'name' => 'detailes-button']) ?>
</div>
<?php
ActiveForm::end();
$this->registerJs('
    $(document).on("click","input[type=text]",function(){
            var $form = $("#detailes-form"), 
            data = $form.data("yiiActiveForm");
            console.log(data);
            $.each(data.attributes, function() {
                this.status = 3;
            });
            $form.yiiActiveForm("validate");        
    });
');
?>
