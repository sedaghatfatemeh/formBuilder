<?php
use yii\helpers\Html;
use app\modules\formBuilder\models\UserInfo;

?>
    <div class="panel panel-flat">
        <div class="panel-body">
            <div class="form-group col-lg-3">
                <?= $this->title ?>
            </div>

            <?php
            echo \yii\grid\GridView::widget(
                [
                    'dataProvider' => $provider,
                    'summary' => '',
                    'id' => 'grid',
                    'showHeader' => true,
                    'pager' => [
                        'firstPageLabel' => 'اولین',
                        'lastPageLabel'  =>  'آخرین'
                    ],
                    'columns' => [
                        [
                            'label' => 'وضعیت',
                            'contentOptions' => [ 'style' => 'text-align: center;width:100px' ],
                            'value' => function ($model) {
                                switch ($model['status']) {
                                    case UserInfo::STATUS_DELETED:
                                        return '<span class="label label-warning">' . UserInfo::getStatuses()[UserInfo::STATUS_DELETED] . '</span>';
                                    case UserInfo::STATUS_ACTIVE:
                                        return '<span class="label label-success ">' . UserInfo::getStatuses()[UserInfo::STATUS_ACTIVE] . '</span>';
                                    default:
                                        return '';
                                }
                            },
                            'format' => 'raw'
                        ],
                        [
                            'label' => ' درخواست ',
                            'value' => function ($model) {
                                return $model['id'];
                            },
                            'contentOptions' => [ 'style' => 'text-align: center;width:50px' ],
                        ],
                        [
                            'label' => 'نام',
                            'contentOptions' => [ 'style' => 'font-weight: 500;FONT-SIZE: 16PX;color:#3f3f3f' ],
                            'value' => function ($model) {
                                return $model['name'];
                            }
                        ],
                        [
                            'label' =>'نام خانوادگی',
                            'contentOptions' => [ 'style' => 'font-weight: 500;FONT-SIZE: 16PX;width:200px;color:#3f3f3f' ],
                            'value' => function ($model) {
                                return $model['last_name'];
                            }
                        ],
                        [
                            'label' =>'تاریخ ثبت',
                            'contentOptions' => [ 'style' => 'width:150px' ],
                            'value' => function ($model) {
                                return date('Y-m-d' , $model['creation_date']);
                            }
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'contentOptions' => [ 'style' => 'width:80px' ],
                            'template' => '{update} {view} {delete}',
                            'buttons' => [
                            ],
                        ],
                    ],
                ]);
            ?>
        </div>
    </div>


