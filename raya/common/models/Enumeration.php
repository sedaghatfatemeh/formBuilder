<?php
namespace common\models;

use Yii;
use yii\base\Arrayable;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Enumeration model
 *
 * @property integer    $id
 * @property string     $type
 * @property string     $title
 * @property integer    $status
 * @property integer    $show
 * @property integer    $creatione_date
 * @property integer    $position
 */
class Enumeration extends ActiveRecord
{

    const SHOW_IN_LIST      = 1;
    const NOT_SHOW_IN_LIST  = 0;

    const STATUS_ACTIVE     = 1;
    const STATUS_DEACTIVE   = 0;

    public static function tableName()
    {
        return '{{%enumeration}}';
    }
    /*
     * get Parent Enum ByType
     * @return array for parent
     */
    public static function getParentEnumByType( $show = self::NOT_SHOW_IN_LIST , $isArray = false )
    {
        $result = self::find()
            ->select('id , title')
            ->where(['status'   => self::STATUS_ACTIVE])
            ->andWhere(['show'  => $show])
            ->orderBy('id')
            ->all();
        if ($result)
        {
            if ($isArray)
            {
               $result[] = ["id" => 0, "title"=>'انتخاب کنید'];
                return ArrayHelper::map($result, 'id','title' );
            }
          return $result;
        }
        else false;
    }

    /*
   * get Enum Type By Id
   * @return object data
   */
    public static function getEnumTypeById($enumertionId , $show = self::NOT_SHOW_IN_LIST)
    {
        $result = self::find()
            ->select('type')
            ->where(['status'   => self::STATUS_ACTIVE])
            ->andWhere(['show'  => $show])
            ->andWhere(['id' => $enumertionId])
            ->one();
        if ($result)
        {
          return $result->type;
        }
        else false;
    }

    /*
   * get Enum list By Type
   * @return array for  dropdown list
   */
    public static function getEnumListByType( $type, $show = self::SHOW_IN_LIST)
    {
        $result = [];
            $result = self::find()
                ->select('id , title')
                ->where(['status'   => self::STATUS_ACTIVE])
                ->andWhere(['show'  => $show])
                ->andWhere(['type' => $type])
                ->orderBy('id')
                ->all();
            if ($result)
            {
                    $result[] = ["id" => 0, "title"=>'انتخاب کنید'];
                return ArrayHelper::map($result, 'id','title' );
            }
        else false;
    }
     /*
     * get Enum Title By EnumId
     * @return array for  dropdown list
     */
    public static function getEnumTitileById($enumertionId)
    {
        $result = self::find()
            ->select('title')
            ->andWhere(['id' => $enumertionId])
            ->one();
        if ($result)
        {
            return $result->title;
        }
        else false;
    }

}
