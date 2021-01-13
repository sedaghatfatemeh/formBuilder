<?php
namespace backend\controllers;

use common\models\DetailesForm;
use common\models\User;
use common\models\UserInfo;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\Url;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;


class UserInfoController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['register','view' , 'update' ,'delete' ,'index'],
                        'allow' => true,
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
     * render index list
     */
    public function actionIndex()
    {
        $this->view->title = 'لیست درخواست های';

        $query = UserInfo::getUserInfoLists(true , UserInfo::STATUS_ACTIVE);
        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);
//        $dataArray = [] ;
//        foreach ($list as $dataList)
//        {
//            foreach ($dataList as $key=>$value)
//            {
//                $data[$key] = $value ;
//                if ($key == "detailes_item")
//                {
//
//                    $array = UserInfo::convartJsonToArray($value);
//                    if ($array)
//                    {
//                        foreach ($array as $keyNew=>$valueNew)
//                        {
//                            $data[$keyNew] = $valueNew ;
//                        }
//                    }
//                }
//            }
//            $dataArray[] = \array_diff_key($data, ["detailes_item"=>""]); ;
//        }
//        $provider = new ArrayDataProvider([
//            'allModels' => $dataArray,
//            'pagination' => [
//                'pageSize' => 100,
//            ],
//        ]);
        return $this->render('index', [
            'provider' => $provider,
        ]);
    }
    /*
     * create form for register
     * return form when not post data
     * if post data save data for register user
     */
    public function actionRegister()
    {
        $this->view->title = DetailesForm::TITLE_REGISTER_FORM;
        $model = new UserInfo();
        $items = DetailesForm ::getItems();
        if (Yii::$app->request->post()) {
             $data = Yii::$app->request->post();
            $resultSave = UserInfo::setSave($model , $data);
            if ($resultSave->success)
            {
                Yii::$app->session->setFlash('success', 'ثبت با موفقیت انجام شد');
                $this->redirect( Url::to(['view','id'=> $resultSave->result['id']] ));
            }
            elseif (!$resultSave->success && !empty($resultSave->message))
            {
                $msg = '';
                foreach ($resultSave->message as $text)
                {
                    $msg .= $text . "<br>";
                }
                Yii::$app->session->setFlash('danger', $msg);
            }
            else
                Yii::$app->session->setFlash('danger', 'عملیات ناموفق به پایین رسید');
        }

            return $this->render('_form',
                [
                'model' => $model,
                'items' => $items,
            ]);

    }
    /*
     * show preview data for $id
     */
    public function actionView($id)
    {
        $this->view->title = "مشاهده اطلاعات ثبت شده";
       return $this->render('view',['model'=>UserInfo::getUserInfoById($id)]);
    }

    /*
     * update form and update data register $id
     */
    public function actionUpdate($id)
    {
        $this->view->title =  'ویرایش اطلاعات';

        $userModel = UserInfo::getUserInfoById($id);
        $items = DetailesForm ::getItems();
        if (!$userModel) {

            Yii::$app->session->setFlash('danger',  'اطلاعاتی یافت نشد');
            return $this->redirect(Url::to(['/register']));
        }

        if (Yii::$app->request->post()) {
            $data = Yii::$app->request->post();
            $resultSave = UserInfo::setSave($userModel , $data);
            if ($resultSave->success)
            {
                Yii::$app->session->setFlash('success', 'ثبت با موفقیت انجام شد');
                $this->redirect( Url::to(['view','id'=> $resultSave->result['id']] ));
            }
            elseif (!$resultSave->success && !empty($resultSave->message))
            {
                $msg = '';
                foreach ($resultSave->message as $text)
                {
                    $msg .= $text . "<br>";
                }
                Yii::$app->session->setFlash('danger', $msg);
            }
            else
                Yii::$app->session->setFlash('danger', 'عملیات ناموفق به پایین رسید');
        }
        return $this->render('update', [
            'model' => $userModel,
            'items' => $items,
        ]);
    }

    /*
     * Logical deletion $id
     */
    public function actionDelete($id)
    {
        $this->view->title =  'حذف کاربر';

        $userModel = UserInfo::getUserInfoById($id);
        if (!$userModel) {
            Yii::$app->session->setFlash('danger','کاربر یافت نشد');
            return $this->redirect(Yii::$app->request->referrer);
        }

        $userModel->status = UserInfo::STATUS_DELETED;
        $saveResult = $userModel->save();
        if ($saveResult) {
            Yii::$app->session->setFlash('success', 'کاربر با موفقیت حذف شد');
        } else {
            Yii::$app->session->setFlash('danger', 'حذف کاربر ناموفق بوده است');
        }

        return $this->redirect(Url::to(['/register-list']));
    }
}
