<?php

namespace app\modules\teamhelper\widgets;

use app\modules\teamhelper\rbac\AuthHelper;
use Yii;
use yii\bootstrap\Nav;

class TestMgrMenu extends Nav
{
    /**
     * @inheritdoc
     */
    public $options = [
        'class' => 'nav-tabs'
    ];

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        
        $navItems = [
                    [
                        'label'   => Yii::t('app', 'Test Scenario'),
                        'url'     => ['/teamhelper/testscenario/index'],
                    ],
                    [
                        'label'   => Yii::t('app', 'Test Case'),
                        'url'     => ['/teamhelper/testcase/index'],
                    ],
                    [
                        'label'   => Yii::t('app', 'Test Step'),
                        'url'     => ['/teamhelper/teststep/index'],
                    ],
                    [
                        'label'   => Yii::t('app', 'Test Execute'),
                        'url'     => ['/teamhelper/testexecute/index'],
                    ],
                    [
                        'label'   => Yii::t('app', 'Test Execute Detail'),
                        'url'     => ['/teamhelper/testexecutedetail/index'],
                    ]
            ];
        
        $this->items = $navItems;
    }
}