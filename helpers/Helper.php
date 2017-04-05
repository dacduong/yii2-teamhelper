<?php

namespace app\modules\teamhelper\helpers;

class Helper {

    public static $statuses = [
        1 => 'Activated',
        0 => 'Deactivated',
    ];

    public static $priorities = [
        0 => 'Low',
        1 => 'Medium',
        2 => 'High',
    ];
    
    public static $resultStatus = [
        0 => 'Fail',
        1 => 'Pass',
        2 => 'Pending',
    ];
}
