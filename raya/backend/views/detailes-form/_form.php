<?php

use common\models\Enumeration;
use unclead\multipleinput\MultipleInput;
use unclead\multipleinput\TabularInput;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use common\models\DetailesForm;
?>
 <?php
 $form = ActiveForm::begin([
     'id'    => 'detailes-form',
         ]);  ?>
<?=
TabularInput::widget([
    'models' => $models,
    'modelClass' => DetailesForm::class,
    'cloneButton' => true,
    'sortable' => true,
    'min' => 0,
    'addButtonPosition' => [
        TabularInput::POS_HEADER,
        TabularInput::POS_FOOTER,
        TabularInput::POS_ROW
    ],
    'layoutConfig' => [
        'offsetClass'   => 'col-sm-offset-4',
        'labelClass'    => 'col-sm-2',
        'wrapperClass'  => 'col-sm-10',
        'errorClass'    => 'col-sm-4'
    ],
    'form' => $form,
    'columns' => [
        [
            'name'          => 'title',
            'title'         => 'نام',
           'attributeOptions' => [
                'enableClientValidation' => true,
                'validateOnChange' => true,
            ],
            'defaultValue' => '',
            'enableError' => true,
        ],
        [
            'name'          => 'lable',
            'title'         => 'عنوان',
            'enableError'   => true,
            'attributeOptions' => [
                'enableClientValidation' => true,
                'validateOnChange' => true,
        ],
            'options' => [
                'class' => 'input-lable',
                'type' => 'string',
            ]
        ],
        [
            'name'  => 'type',
            'type'  => 'dropDownList',
            'title' => 'نوع',
            'items' => \common\models\DetailesForm::typeLists(),
            'enableError' => true,
            'attributeOptions' => [
                'enableClientValidation' => true,
                'validateOnChange' => true,
            ],
            'options' => [
                'onchange' => <<< JS
                    var x =$(this).closest('td').next().find('select');
                    x.prop("disabled",false);
                    $.post("set-list/"+$(this).val(), function(data){
                      $(x).html(data);
                     
                        });  
                    JS
            ],
        ],
        [
            'name'          => 'type_list',
            'type'          => 'dropDownList',
            'title'         => 'انتخاب لیست',
            'enableError'   => true,
            'defaultValue'  => 0,
            'attributeOptions' => [
                'enableClientValidation' => true,
                'validateOnChange' => true,
            ],
//            'items'     => [],
            'items'     => Enumeration::getParentEnumByType(Enumeration::NOT_SHOW_IN_LIST , true ),
            'options'   => [
                'class' => "form-control list-type",
                "disabled" => "true"
                ],
            ],
        [
            'name'          => 'length',
            'title'         => 'طول',
            'enableError'   => true,
            'attributeOptions' => [
                'enableClientValidation' => true,
                'validateOnChange' => true,
            ],
            'options' => [
                'class' => 'input-length',
//                    'type' => 'number',
            ]
        ]
    ]
]);
    ?>
<div class="form-group">
 <?= Html::submitButton('ثبت', ['class' => 'btn btn-primary']) ?>
</div>
<?php
ActiveForm::end();
?>
