<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace core\web;

use Yii;
use yii\base\InvalidRouteException;
use yii\helpers\Url;

/**
 * Application is the base class for all web application classes.
 *
 * For more details and usage information on Application, see the [guide article on applications](guide:structure-applications).
 *
 * @property ErrorHandler $errorHandler The error handler application component. This property is read-only.
 * @property string $homeUrl The homepage URL.
 * @property Request $request The request component. This property is read-only.
 * @property Response $response The response component. This property is read-only.
 * @property Session $session The session component. This property is read-only.
 * @property User $user The user component. This property is read-only.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Application extends \yii\web\Application
{


    /**
     * {@inheritdoc}
     */
    protected function bootstrap()
    {
        $request = $this->getRequest();
        Yii::setAlias('@webroot', dirname($request->getScriptFile()));
        Yii::setAlias('@web', $request->getBaseUrl());
//        Yii::setAlias('@common', dirname(__DIR__));
        Yii::setAlias('@common', dirname(__DIR__));
        Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
        Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
        Yii::setAlias('@console', dirname(dirname(__DIR__)) . '/console');
        Yii::setAlias('@core', dirname(dirname(__DIR__)) . '/core');

        parent::bootstrap();
    }

}
