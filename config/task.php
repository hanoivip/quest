<?php

return [
    // user module
    1 => [
        1 => [
			'id' => 1,
			'line' => 1,
			'trigger' => [],
			'rewards' => [],
			'detail' => 'Cap nhat thong tin ca nhan',
			'guide' => 'user.info',
			'progress_type' => 'CheckUserDetailInfo',
			'progress_ids' => [],			
		],
		2 => [
			'id' => 2,
			'line' => 1,
			'trigger' => [],
			'rewards' => [],
			'detail' => 'Cap nhat email thong bao (Email that, co the su dung de dang nhap vao Website nay)',
			'guide' => 'user.info',
			'progress_type' => 'CheckUserLoginEmail',
			'progress_ids' => [],			
		],
		3 => [
			'id' => 3,
			'line' => 1,
			'trigger' => [],
			'rewards' => [],
			'detail' => 'Bat xac thuc 2 buoc. Bao ve tk voi email',
			'guide' => 'user.info',
			'progress_type' => 'CheckUser2Fa',
			'progress_ids' => [
				1 => 'email',
			],			
		],
		4 => [
			'id' => 4,
			'line' => 1,
			'trigger' => [],
			'rewards' => [],
			'detail' => 'Bat xac thuc 2 buoc. Bao ve tk voi email',
			'guide' => 'user.info',
			'progress_type' => 'CheckUser2Fa',
			'progress_ids' => [
				1 => 'email',
			],			
		],
		5 => [
			'id' => 5,
			'line' => 1,
			'trigger' => [],
			'rewards' => [],
			'detail' => 'Bat xac thuc 2 buoc. Bao ve tk voi authenticator app',
			'guide' => 'user.info',
			'progress_type' => 'CheckUser2Fa',
			'progress_ids' => [
				1 => 'app',
			],			
		],
    ],
    // payment module
    2 => [
        1 => [
			'id' => 1,
			'line' => 2,
			'trigger' => [],
			'rewards' => [],
			'detail' => 'Nap the dau tien',
			'guide' => 'newrecharge',
			'progress_type' => 'CheckTopup',
			'progress_ids' => [],
		],
		2 => [
			'id' => 2,
			'line' => 2,
			'trigger' => [],
			'rewards' => [],
			'detail' => 'Nap the Viettel, loai the pho bien nhat, gia tri 100k',
			'guide' => 'newrecharge',
			'progress_type' => 'CheckTopupDetail',
			'progress_ids' => [
				'type' => 'Viettel',
				'amount' => 100000
			],
		],
    ],
    // recharge module
    3 => [
        1 => [
			'id' => 1,
			'line' => 3,
			'trigger' => [
				1 => 102,
			],
			'rewards' => [],
			'detail' => 'Chuyen xu, mua do trong game dau tien',
			'guide' => 'newrecharge',
			'progress_type' => 'CheckRecharge',
			'progress_ids' => [],
		],
    ],
	// vip module
	4 => [
        1 => [
			'id' => 1,
			'line' => 4,
			'trigger' => [],
			'rewards' => [],
			'detail' => 'Tien len VIP 1',
			'guide' => 'vip',
			'progress_type' => 'CheckVip',
			'progress_ids' => [
				1 => 1
			],
		],
		2 => [
			'id' => 2,
			'line' => 4,
			'trigger' => [],
			'rewards' => [],
			'detail' => 'Tien len VIP 2',
			'guide' => 'vip',
			'progress_type' => 'CheckVip',
			'progress_ids' => [
				1 => 2
			],
		],
		3 => [
			'id' => 3,
			'line' => 4,
			'trigger' => [],
			'rewards' => [],
			'detail' => 'Tien len VIP 3',
			'guide' => 'vip',
			'progress_type' => 'CheckVip',
			'progress_ids' => [
				1 => 3
			],
		],
    ],
	// user module expend
	5 => [
        1 => [
			'id' => 1,
			'line' => 5,
			'trigger' => [
				1 => 51,
				2 => 91
			],
			'rewards' => [],
			'detail' => 'Doi mat khau dang nhap',
			'guide' => 'change.pass',
			'progress_type' => 'CheckNewPass',
			'progress_ids' => [],
		],
    ],
	// vip module extension
	6 => [
        1 => [
			'id' => 1,
			'line' => 6,
			'trigger' => [
				1 => 61,
				2 => 94,
			],
			'rewards' => [],
			'detail' => 'Su dung chuc nang ho tro VIP, lien he de ho tro',
			'guide' => 'vip.support',
			'progress_type' => 'CheckVipChat',
			'progress_ids' => [],
		],
    ],
	// rank module
	7 => [
        1 => [
			'id' => 1,
			'line' => 7,
			'trigger' => [],
			'rewards' => [],
			'detail' => 'Lot vao top 3 tai phu tuan',
			'guide' => '/guide/rank-activity',
			'progress_type' => 'CheckTopRich',
			'progress_ids' => [],
		],
    ],
	// gift module
	// proceed module
	// facebook: share, achivement, ??
];