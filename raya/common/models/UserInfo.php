<?php
namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Html;

/**
 * DetailesForm model
 *
 * @property integer $id
 * @property string $name
 * @property string $last_name
 * @property string  $detailes_item
 */
class UserInfo extends ActiveRecord
{
    const TITLE_REGISTER_FORM = "فرم تکمیل اطلاعات کاربری";
    const TYPE_LIST = "type_list";

    const STATUS_ACTIVE  = 1;
    const STATUS_DELETED = 0;

    public static function tableName()
    {
        return '{{%user_info}}';
    }

    public function rules()
    {
        return [
                 [ ['name', 'last_name'] , 'trim'],
                 [ ['name', 'last_name'] , 'required' , 'message' => 'فیلد ضروری'],
                 [['name', 'last_name'], 'string', 'max' => 255],
                 [['creation_date'], 'safe'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'id' => 'شناسه',
            'name' => 'نام',
            'last_name' => 'نام خانوادگی',
            'creation_date' => 'تاریخ ثبت',

        ];
    }


    static public function setItemsForUpdate($data ,$items)
    {
        $maxlength  = $data->length;
        $itemArray = self::convartJsonToArray($items);

        switch ($data->type) {
            case 'Varchar':
                $class = ['class' => 'form-control'];
                $typeInput = 'text';
                break;
            case 'int':
                $class      = ['class'=>'form-control' , 'maxlength'=> $maxlength ];
                $typeInput  = 'number';
                break;
            case 'DateTime':
                $class = ['class' => 'form-control date-picker-only', 'readonly' => "true"];
                $typeInput = 'text';
                break;
            case 'list':
                $list = Enumeration::getEnumListByType($data->title);
                $sampleInput = ' <div class="form-group field-userinfo">'
                    . ' <label class="control-label" for="userinfo">' . $data->lable . '</label>'
                    //  Html::activeDropDownList($data->title,'',Enumeration::getEnumListByType($data->type_list))
                    . ' <select id="type_list" class="form-control" name="' . $data->title . '"  tabindex="1">';
                if ($list) {
                    foreach ($list as $key => $val) {
                        $selected = "";
                        if ($key == $itemArray[$data->title])
                            $selected = "selected";
                        $sampleInput .= '<option value="' . $key . '" ' . $selected . '  > ' . $val . '</option>';
                    }
                }

                $sampleInput .= '</select>'
                    . ' <p class="help-block help-block-error"></p> </div>';
                return $sampleInput;
                break;
            default :
                break;
        }

        if (!isset($itemArray[$data->title]))
        {
            $sampleInput = "به دلیل تغییرات در آیتم های فرم امکان ویرایش اطلاعات وجود دارد" . "<br>";
        }
        else
        {
            $sampleInput =    ' <div class="form-group field-userinfo">'
                .' <label class="control-label" for="userinfo">'. $data->lable .'</label>' .
                Html::input($typeInput,$data->title,$itemArray[$data->title],$options=$class)
                .' <p class="help-block help-block-error"></p> </div>';
        }


        return $sampleInput;
    }
    static public function setItemsIn($data)
    {
        $maxlength  = $data->length;
        switch ($data->type){
            case 'Varchar':
                $class      = ['class'=>'form-control'];
                $typeInput  = 'text';
                break;
            case 'int':
                $class      = ['class'=>'form-control' , 'maxlength'=> $maxlength ];
                $typeInput  = 'number';
                break;
            case 'DateTime':
                $class      = ['class'=>'form-control date-picker-only' ,'readonly'=>"true" ];
                $typeInput  = 'text';
                break;
            case 'list':
              $list =  Enumeration::getEnumListByType($data->title);
                $sampleInput =    ' <div class="form-group field-userinfo">'
                    .' <label class="control-label" for="userinfo">'. $data->lable .'</label>'
                  . ' <select id="type_list" class="form-control" name="' . $data->title . '"  tabindex="1">';
                if ($list)
                {
                    foreach ($list as $key=>$val)
                    {
                        $sampleInput .= '<option value="'. $key .'" selected=""> ' . $val . '</option>';
                    }
                }

                $sampleInput .= '</select>'
                    .' <p class="help-block help-block-error"></p> </div>';
                return $sampleInput;
                break;
            default :
                break;
        }

        $sampleInput =    ' <div class="form-group field-userinfo">'
                         .' <label class="control-label" for="userinfo">'. $data->lable .'</label>' .
                            Html::input($typeInput,$data->title,'',$options=$class)
                         .' <p class="help-block help-block-error"></p> </div>';

        return $sampleInput;
    }

    static public function validateStatic($index ,$item)
    {
        $resultArray = [];
        if (empty($item))
        {
            $resultArray['hasError'] = true;
            $resultArray['errors'] = "$index نمیتواند خالی باشد ";
        }
        return $resultArray ;
    }
    /*
     *
     */
    static public function setSave($model , $data)
    {
        $response = new Response();
        $model->name = $data['UserInfo']['name'];
        $model->last_name = $data['UserInfo']['last_name'];

        if (!$model) {
            $response->success = false;
            $response->message = 'مدل ارسالی نامعتبر است';
            return $response;
        }
        $hasError = false;
        $errors = [];
        if (count($data)>0)
        {
            foreach ($data as $key=>$value)
            {
              $resultValidate[] =  self::validateStatic($key , $value);
            }
            if (count($resultValidate)>0)
            {
                $errorMassege = [];
                foreach ($resultValidate as $value)
                {

                    if (@$value['hasError'])
                    {
                        $errorMassege[] = $value['errors'];
                    }

                }
               if (count($errorMassege)>0)
               {
                   $response->success = false;
                   $response->message = $errorMassege;
                   return $response;
               }
            }
        }
        if (!$model->name) {
            $response->success = false;
            $response->message = 'نام ارسالی کامل نشده';
            return $response;
        }
        if (!$model->last_name) {
            $response->success = false;
            $response->message = 'نام خانوادگی ارسالی کامل نشده';
            return $response;
        }

        if ($hasError) {
            $response->success = false;
            $response->message = $errors;
            return $response;
        }

        $model->creation_date   = time();
        $array = \array_diff_key($data, ['_csrf-frontend' => "xy", "UserInfo" => "xy" , "contact-button"=>""]);
        $model->detailes_item   = json_encode($array);
        $model->status = self::STATUS_ACTIVE;

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
        }

    }
    static public function getUserInfoById($id)
    {
        $result = self::find()
            ->where(['id' => $id])
            ->one();
        if ($result)
            return $result;
        else
            return false;
    }
    static public function convartJsonToArray($data)
    {
      return  @json_decode($data , true);
    }
    public static function getUserInfoLists($asQuery = false , $status = null)
    {
        $result = self::find();
        if ($status)
        {
            $result = $result->where(['status' => self::STATUS_ACTIVE]);
        }
        $result = $result->orderBy('status ASC,creation_date DESC');
        if ($asQuery) {
            return $result;
        }

        $result = $result->all();
        return $result;
    }
    public static function getStatuses()
    {
        return [
            self::STATUS_ACTIVE  =>  'فعال',
            self::STATUS_DELETED => 'غیرفعال',
        ];
    }
}
