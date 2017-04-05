<?php

namespace app\modules\teamhelper\widgets;

use app\modules\teamhelper\rbac\AuthHelper;
use Yii;
use yii\bootstrap\Nav;

class TimesheetMenu extends Nav
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
                        'label'   => Yii::t('app', 'Timetable'),
                        'url'     => ['/teamhelper/timetable/index'],
                    ],
                    [
                        'label'   => Yii::t('app', 'Ticket'),
                        'url'     => ['/teamhelper/ticket/index'],
                    ]
            ];
        
        if (AuthHelper::isAdmin()) {
            array_splice($navItems, 2, 0, [
                                    [
                                        'label'   => Yii::t('app', 'Team'),
                                        'url'     => ['/teamhelper/team/index'],
                                    ],
                                    [
                                        'label'   => Yii::t('app', 'Customer'),
                                        'url'     => ['/teamhelper/customer/index'],
                                    ],
                                    [
                                        'label'   => Yii::t('app', 'Project'),
                                        'url'     => ['/teamhelper/project/index'],
                                    ],
                                    [
                                        'label'   => Yii::t('app', 'Module'),
                                        'url'     => ['/teamhelper/module/index'],
                                    ],
                                    [
                                        'label'   => Yii::t('app', 'Phase'),
                                        'url'     => ['/teamhelper/phase/index'],
                                    ],
                                ]);
        }
        
        $this->items = $navItems;
    }
}