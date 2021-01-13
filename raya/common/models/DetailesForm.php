<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Json;
use yii\validators\RequiredValidator;

/**
 * DetailesForm model
 *
 * @property integer $id
 * @property string  $form_name
 * @property string  $detailes
 * @property int     $creation_date
 */
class DetailesForm extends ActiveRecord
{
    const TITLE_REGISTER_FORM   = "فرم تکمیل اطلاعات کاربری";
    const SCENARIO_DEFAULT      = "create";

    //set attribute
    public $type_list;  //set type dropdown list
    public $title;     //set english name for attribute
    public $lable;    // set lable for attribute
    public $type;    //set type attribute
    public $length; //set lenghth attribute



    public static function tableName()
    {
        return '{{%detailes_form}}';
    }

    public function rules()
    {
        return [
            ['form_name', 'default', 'value' => self::TITLE_REGISTER_FORM],
            ['title', 'trim'],
            ['title','match','pattern' => '/^[a-zA-Z]*$/', 'message' => 'عنوان باید انگلیسی وارد شود'],
            [['title', 'lable' ,'length'], 'required' , 'message' => 'فیلد ضروری'],
            [ ['type'], 'string', 'min' => 2, 'max'=>30 ,'tooShort' => 'فیلد ضروری'],
            [ ['length'], 'integer', 'min' => 1, 'max'=>255 ,'message' => 'فیلد ضروری'],
            [['id', 'type_list','type', 'length'], 'safe']
        ];
    }
    public function attributes()
    {
        return [
            'id',
            'form_name',
            'title',
            'lable',
            'type',
            'type_list',
            'length',
            'detailes',
            'user_id',
            'creation_date',
        ];
    }
    /*
     * return array for type input
     * use for dropdown List
     */
    static public function typeLists()
    {
       return [
           '0'          =>  'انتخاب کنید',
          'Varchar'     => 'رشته',
          'int'         => 'عدد' ,
          'DateTime'    => 'تاریخ' ,
          'list'        => 'لیست'
        ];
    }

    /*
     * save detailes
     * call in controller DetailesInfo
     * @return Respones array
     */
    static public function detailesFormSave($data , $detailes)
    {
        $response = new Response();

        if (!$data) {
            $response->success = false;
            $response->message = 'مدل ارسالی نامعتبر است';
            return $response;
        }

        $model = self::getDetails();
        if (!$model)
            $model = new DetailesForm();
        $model->detailes = Json::encode($detailes);
        $model->form_name       = self::TITLE_REGISTER_FORM ;
        $model->creation_date   = time();
        $model->user_id         = Yii::$app->user->getId();

        $transaction = Yii::$app->db->beginTransaction();
        try {
            if (!$model->save(false))
            {
                $transaction->rollBack();
                $response->success = false;
                $response->message = $model->errors;

                return $response;
            }

            $transaction->commit();
            $response->success = true;
            $response->result = $model;
            return $response;

        }catch (\ Exception $exception){
            $transaction->rollBack();
            $response->success = false;
            $response->message = [
                $exception->getMessage(),
                $exception->getFile(),
                $exception->getLine(),
                $exception->getTraceAsString(),
            ];
            return $response;
        }

    }

    /*
     * get detaile item
     * @return array
     * convert json to array
     */
    static public function getItems()
    {
        $result = self::find()
            ->orderBy('id DESC')
            ->limit(1)
            ->one();
        if ($result)
        {
            $arrayitems = [];
            $arrayitems = json_decode($result->detailes);
            return $arrayitems ;
        }
        return false;
    }
    /*
     * get one data for model
     */
    static public function getDetails()
    {
        $result = self::find()
            ->one();
        if ($result)
            return $result;
        return false;
    }

}
