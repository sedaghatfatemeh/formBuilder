<?php
use yii\widgets\DetailView;
use common\models\UserInfo;
use yii\helpers\Html;

//echo DetailView::widget([
//    'model' => $model,
//    'attributes' => [
//        'id',
//        'name',
//        'last_name',
//        'creation_date',
//    ],
//]);
?>
<div class="form-group">

    <?php echo Html::a( 'ویرایش', ['update','id' =>$model->id ], [
        'class' => 'btn btn-primary']) ?>
    <?php echo Html::a( 'حذف', ['delete','id' =>$model->id ], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'آیا برای حذف مطمئن هستید ؟',
            'method' => 'post',
        ],
    ]) ?>

</div>
<table id="w0" class="table table-striped table-bordered detail-view">
    <tr>
        <td colspan="2" class="text-right"><h4> <?= $this->title ?></h4></td>
    </tr>
    <tbody>
    <tr>
        <th>شناسه</th>
        <td><?= $model->id ?></td>
    </tr>
    <tr>
        <th>نام</th>
        <td><?= $model->name ?></td>
    </tr>
    <tr>
        <th>نام خانوادگی</th>
        <td><?= $model->last_name ?></td>
    </tr>
    <?php

    $list = UserInfo::convartJsonToArray($model->detailes_item) ;
    $string =null;
    $listLable = \common\models\DetailesForm::getItems();
    $counter = 0 ;
    foreach ($list as $key=>$value)
    {
        $check = \common\models\Enumeration::getEnumListByType($key);

        if ($check)
        {
            $string .= '<tr>';
            $string .= '<th>'. $listLable[$counter]->lable .'</th>';
            $string .= '<td>'. \common\models\Enumeration::getEnumTitileById($value) .'</td>';
            $string .= '</tr>';
        }
        else
        {
            $string .= '<tr>';
            $string .= '<th>'. $listLable[$counter]->lable .'</th>';
            $string .= '<td>'. $value .'</td>';
            $string .= '</tr>';
        }
    $counter++ ;
    }
    echo $string ;
    ?>

    <tr>
        <th>تاریخ ثبت</th>
        <td><?= date('Y-m-d' , $model->creation_date) ?></td>
    </tr>
    </tbody>
</table>
