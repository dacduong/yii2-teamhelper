<?php

namespace app\modules\teamhelper;

/**
 * teamhelper module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\teamhelper\controllers';
    
    //public $defaultRoute = 'teamhelper';
    
    public $layout = 'teamhelper';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
