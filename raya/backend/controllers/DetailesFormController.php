<?php
namespace backend\controllers;

use common\models\DetailesForm;
use common\models\Enumeration;
use Yii;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\Response;
use common\models\Item;
use yii\base\Model;


/**
 * Site controller
 */
class DetailesFormController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['add-items', 'index','set-list' ,'run'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }


  /*
   * action for set options for dropdownList
   */
    public function actionSetList($type)
    {
        if ($type == 'list')
        {
            $list = Enumeration::getParentEnumByType();
            if ($list)
            {
                $stringOption = '';
                foreach ($list as $val)
                {
                    $stringOption .= '<option value="'. $val->id. '">' . $val->title .'</option>';
                }
                echo $stringOption ;
            }
        }

    }
    /*
     * create and update item for detailes form
     */
    public function actionAddItems()
    {
        $this->view->title = "تعریف جزئیات فرم ثبت اطلاعات ";
        $models = $this->getItems();

        $request = Yii::$app->getRequest();
        if ($request->isPost) {
            $data = Yii::$app->request->post('DetailesForm', []);
            //check for repeat item
            $checkRepeatItem = $this->uniqueMultidimArray($data,'title');
          if (count($checkRepeatItem)>0)
          {
              Yii::$app->session->setFlash('danger', 'ایتم تکراری ارسال شده لطفا بررسی کنید');
              $this->redirect(\Yii::$app->request->getReferrer());
              return;
          }
          else
          {
              foreach (array_keys($data) as $index) {
                  $models[$index] = new DetailesForm();
              }
              Model::loadMultiple($models, Yii::$app->request->post());
              Yii::$app->response->format = Response::FORMAT_JSON;
              $result = ActiveForm::validateMultiple($models );
              if ($result)
                  return $result;
              $resultSave = DetailesForm::detailesFormSave($models , $data);
              if (@$resultSave->success)
              {
                  Yii::$app->session->setFlash('success', 'ثبت با موفقیت انجام شد');
                  $this->redirect(\Yii::$app->request->getReferrer());
                  return;

              }
              else
                  Yii::$app->session->setFlash('danger', 'عملیات ناموفق به پایین رسید');
          }


        }

        return $this->render('_form', ['models' => $models]);
    }
    /*
     * get item for dropdown
     * list in form detailes
     * for create and update
     */
    private function getItems()
    {
        $item = DetailesForm::getDetails();
        if ($item)
        {
            $array = Json::decode($item->detailes , true);
            $data = [];
            foreach ($array as $val)
            {
               $val['id'] = $item->id;
                $data[] = $val ;
            }
        }
        else
        {
            $data = [
                [
                    'id' => 1,
                    'title' => '',
                    'lable' => '',
                    'type' => 0,
                    'type_list' => 0,
                    'length' => 1
                ]
            ];
        }

        $items = [];
        foreach ($data as $row) {
            $item = new DetailesForm();
            $item->setAttributes($row);
            $items[] = $item;
        }
        return $items;
    }
    /*
     * check function for repeat item
     */
    function uniqueMultidimArray($array, $key) {
        $temp_array = array();
        $i = 0;
        $key_array = array();
        $repeatArray = array();

        foreach($array as $val) {
            if (!in_array($val[$key], $key_array)) {
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            else
            {
                if (in_array($val[$key], $key_array)) {
                    $repeatArray[$i] = $val;
                }
            }
            $i++;
        }
        return $repeatArray;
    }

}
