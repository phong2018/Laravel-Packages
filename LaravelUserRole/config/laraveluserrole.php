<?php

return [ 
    // all orther roles for user
    'roles' => ['Admin','Employee','Customer','Lottery Agency'],
    // permissionsForRole
    'permissionsForRole'=>[
        'User'=>[
            'label'=>'User (Người dùng)',
            'permissions'=>['viewAny'=>'View All (Xem tất cả)','view'=>'View Detail','create'=>'Create','update'=>'Update','delete'=>'Delete']
        ],
        'Customer'=>[
            'label'=>'Customer (Khách hàng)',
            'permissions'=>['viewAny'=>'View All','view'=>'View Detail','create'=>'Create','update'=>'Update','delete'=>'Delete']
        ],
        'Veso'=>[
            'label'=>'Vé số Truyền thống',
            'permissions'=>['viewAny'=>'View All','view'=>'View Detail','create'=>'Create','update'=>'Update','delete'=>'Delete']
        ],
        'Order'=>[
            'label'=>'Order',
            'permissions'=>['viewAny'=>'View All','updateOrderDetail'=>'Update  OrderDetail', 'view'=>'View Detail','create'=>'Create','update'=>'Update','delete'=>'Delete']
        ],
        'Point'=>[    
            'label'=>'Point (tiền nạp)',
            'permissions'=>['viewAny'=>'View All','view'=>'View Detail','create'=>'Create','update'=>'Update','updateOrderAddPoint'=>'Update OrderAddPoint & OrderWithdrawPoint','updatePointAgency'=>'Paid Point For Agency','delete'=>'Delete']
        ],
        'Post'=>[
            'label'=>'Post',
            'permissions'=>['viewAny'=>'View All','view'=>'View Detail','create'=>'Create','update'=>'Update','delete'=>'Delete']
        ],
        'Setting'=>[
            'label'=>'Setting',
            'permissions'=>['viewAny'=>'View All','view'=>'View Detail','create'=>'Create','update'=>'Update','delete'=>'Delete']
        ],
    ],
    // default roles when register for Customer
    'defaultRoleId'=> 3,

    // default role_id for lottery Agency
    'defaultAgencyRoleId'=> 4,

    // userStatus
    'userStatus' =>[
        'disable'=>[
            'key'=>'disable',
            'lablel'=>'Chưa kích hoạt'
        ],
        'enable'=>[
            'key'=>'enable',
            'lablel'=>'Đã kích hoạt'
        ]
    ]
];