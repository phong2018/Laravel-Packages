<?php

return [
    // type of Product Veso
    'blocks'=>['A','B','C','D','E','F'],
    'prizeOrder'=>[
        '0'=>'Đặt biệt',
        '1'=>'Giải nhất',
        '2'=>'Giải nhì',
        '3'=>'Giải ba',
        '4'=>'Giải tư',
        '5'=>'Giải năm',
        '6'=>'Giải sáu',
        '7'=>'Giải bảy',
        '8'=>'Giải tám', 
        '9'=>['Đặc biệt phụ',50000000], 
        '10'=>['Khuyến khích',6000000], 
    ],
    // prizeIndex 
    'extraPrize'=>[
        'last4NumPrizeDB'=>[ //11 //prize of agency 
            'key'=>'last4NumPrizeDB',
            'value'=>150000,
            'label'=>'Trùng 4 số cuối giải đặt biệt'
        ],
        'last3NumPrizeDB'=>[ //12 //prize of agency 
            'key'=>'last3NumPrizeDB',
            'value'=>100000,
            'valueForCapNguyen'=>3900000,
            'label'=>'Trùng 3 số cuối giải đặt biệt'
        ],
        'last2NumPrizeDB'=>[ //13 //prize of agency 
            'key'=>'last2NumPrizeDB',
            'value'=>'Được hoàn lại số vé đã mua',
            'label'=>'Trùng 2 số cuối giải đặt biệt'
        ],
    ],
    'methodsToPlay'=>[
        ['name'=>'Vé đơn','numberBallSelected'=>6],
        ['name'=>'Bao 5','numberBallSelected'=>5],
        ['name'=>'Bao 7','numberBallSelected'=>7],
        ['name'=>'Bao 8','numberBallSelected'=>8],
        ['name'=>'Bao 9','numberBallSelected'=>9],
        ['name'=>'Bao 10','numberBallSelected'=>10],
        ['name'=>'Bao 11','numberBallSelected'=>11],
        ['name'=>'Bao 12','numberBallSelected'=>12],
        ['name'=>'Bao 13','numberBallSelected'=>13],
        ['name'=>'Bao 14','numberBallSelected'=>14],
        ['name'=>'Bao 15','numberBallSelected'=>15],
        ['name'=>'Bao 18','numberBallSelected'=>18],
    ], 
    'methodsToPlayKeno'=>[
        ['name'=>'Bậc 1','numberBallSelected'=>1],
        ['name'=>'Bậc 2','numberBallSelected'=>2],
        ['name'=>'Bậc 3','numberBallSelected'=>3],
        ['name'=>'Bậc 4','numberBallSelected'=>4],
        ['name'=>'Bậc 5','numberBallSelected'=>5],
        ['name'=>'Bậc 6','numberBallSelected'=>6],
        ['name'=>'Bậc 7','numberBallSelected'=>7],
        ['name'=>'Bậc 8','numberBallSelected'=>8],
        ['name'=>'Bậc 9','numberBallSelected'=>9],
        ['name'=>'Bậc 10','numberBallSelected'=>10],
        ['name'=>'Chẵn/Lẽ','numberBallSelected'=>2,'key'=>['Chẵn','C 11-12','Hòa','L 11-12','Lẽ']],
        ['name'=>'Lớn/Nhỏ','numberBallSelected'=>2,'key'=>['Lớn','Hòa','Nhỏ']]
    ], 
    'priceBlocks'=>[10000,20000,50000,100000,150000,200000,500000], 
    'categoryType'=>[ 
        'traditionallottery'=>[
            'key'=>'traditionallottery',
            'name'=> 'Truyền thống',
            'gameType'=>[
                'vethuong'=>[
                    'key'=>'vethuong',
                    'name'=>'Vé thường'
                ],
                'capnguyen'=>[
                    'key'=>'capnguyen',
                    'name'=>'Cặp nguyên'
                ]
            ]
        ],
        'miennam'=> [
            'key'=>'miennam',
            'keyLatestResult'=>'latestResultMienNam',
            'numberPrize'=>9,
            'name'=> 'Xổ số Miền Nam',
            'label'=> 'Miền Nam',
            'timeNotAllowBuy'=>16,//buy before 16pm
            'prizes'=>[2000000000,30000000,15000000,10000000,3000000,1000000,400000,200000,100000], 
            'provincesFull'=>[
                'tp-hcm'=>'TP. HCM','dong-thap'=>'Đồng Tháp','ca-mau'=>'Cà Mau', 'ben-tre'=>'Bến Tre','vung-tau'=>'Vũng Tàu','bac-lieu'=>'Bạc Liêu', 'dong-nai'=>'Đồng Nai','can-tho'=>'Cần Thơ','soc-trang'=>'Sóc Trăng', 'tay-ninh'=>'Tây Ninh','an-giang'=>'An Giang','binh-thuan'=>'Bình Thuận', 'vinh-long'=>'Vĩnh Long','binh-duong'=>'Bình Dương','tra-vinh'=>'Trà Vinh', 'long-an'=>'Long An','binh-phuoc'=>'Bình Phước','hau-giang'=>'Hậu Giang', 'tien-giang'=>'Tiền Giang','kien-giang'=>'Kiên Giang','da-lat'=>'Đà Lạt',   
            ],
            'provinces'=>[
                'tp-hcm'=>'TP. HCM','dthap'=>'Đ.THÁP','cmau'=>'C.MAU','btre'=>'B.TRE','vtau'=>'V.TÀU','blieu'=>'B.LIÊU','dnai'=>'Đ.NAI','ctho'=>'C.THƠ','strang'=>'S.TRĂNG','tninh'=>'T.NINH','agiang'=>'A.GIANG','bthuan'=>'B.THUẬN','vlong'=>'V.LONG','bduong'=>'B.DƯƠNG','tvinh'=>'T.VINH','lan'=>'L.AN','bphuoc'=>'B.PHƯỚC','hgiang'=>'H.GIANG','tgiang'=>'T.GIANG','kgiang'=>'K.GIANG','dlat'=>'Đ.LẠT',
            ],
            // datehasResult: 0..6: CN-T7
            // Thứ 2: (1) TP. HCM (xshcm), (2) Đồng Tháp (xsdt), (3) Cà Mau (xscm)
            // Thứ 3: (1) Bến Tre (xsbt), (2) Vũng Tàu (xsvt), (3) Bạc Liêu (xsbl)
            // Thứ 4: (1) Đồng Nai (xsdn), (2) Cần Thơ (xsct), (3) Sóc Trăng (xsst)
            // Thứ 5: (1) Tây Ninh (xstn), (2) An Giang (xsag), (3) Bình Thuận (xsbth)
            // Thứ 6: (1) Vĩnh Long (xsvl), (2) Bình Dương (xsbd), (3) Trà Vinh (xstv)
            // Thứ 7: (1) TP. HCM (xshcm), (2) Long An (xsla), (3) Bình Phước (xsbp), (4) Hậu Giang (xshg)
            // Chủ Nhật: (1) tiền Giang (xstg), (2) Kiên Giang (xskg), (3) Đà Lạt (xsdl)
            'datehasResult'=>[
                ['tgiang','kgiang','dlat'],
                ['tp-hcm','dthap','cmau'],
                ['btre','vtau','blieu'],
                ['dnai','ctho','strang'],
                ['tninh','agiang','bthuan'],
                ['vlong','bduong','tvinh'],
                ['tp-hcm','lan','bphuoc','hgiang'], 
            ],
        ],
        'mientrung'=>[
            'key'=>'mientrung',
            'keyLatestResult'=>'latestResultMienTrung',
            'numberPrize'=>9,
            'prizes'=>[2000000000,30000000,15000000,10000000,3000000,1000000,400000,200000,100000],
            'name'=> 'Xổ số Miền Trung',
            'label'=> 'Miền Trung',
            'timeNotAllowBuy'=>16,//buy before 16pm
            'provincesFull'=>[
                'thua-t-hue'=>'Thừa T. Huế','phu-yen'=>'Phú Yên', 'dak-lak'=>'Đắk Lắk','quang-nam'=>'Quảng Nam','da-nang'=>'Đà Nẵng','binh-dinh'=>'Bình Định','quang-tri'=>'Quảng Trị','quang-binh'=>'Quảng Bình','gia-lai'=>'Gia Lai','ninh-thuan'=>'Ninh Thuận', 'quang-ngai'=>'Quảng Ngãi','dak-nong'=>'Đắk Nông','kon-tum'=>'Kon Tum'
            ],
            'provinces'=>[
                'tthue'=>'T.T.HUẾ','pyen'=>'P.YÊN','dlak'=>'Đ.LẮK','qnam'=>'Q.NAM','dnang'=>'Đ.NẴNG','khoa'=>'K.HÒA','bdinh'=>'B.ĐỊNH','qtri'=>'Q.TRỊ','qbinh'=>'Q.BÌNH','glai'=>'G.LAI','nthuan'=>'N.THUẬN','qngai'=>'Q.NGÃI','dnong'=>'Đ.NÔNG','ktum'=>'K.TUM'
            ],
            'provinces'=>[
                'tthue'=>'T.T.HUẾ','pyen'=>'P.YÊN','dlak'=>'Đ.LẮK','qnam'=>'Q.NAM','dnang'=>'Đ.NẴNG','khoa'=>'K.HÒA','bdinh'=>'B.ĐỊNH','qtri'=>'Q.TRỊ','qbinh'=>'Q.BÌNH','glai'=>'G.LAI','nthuan'=>'N.THUẬN','qngai'=>'Q.NGÃI','dnong'=>'Đ.NÔNG','ktum'=>'K.TUM'
            ],
            'prize_ticketType'=>[
                'tthue'=>'TTH','pyen'=>'PY','dlak'=>'DLK','qnam'=>'QNM','dnang'=>'DNG','khoa'=>'KH','bdinh'=>'BDI','qtri'=>'QT','qbinh'=>'QB','glai'=>'GL','nthuan'=>'NT','qngai'=>'QNG','dnong'=>'DNO','ktum'=>'KH'
            ],
            // Chủ Nhật:  Khánh Hòa (XSKH), Kon Tum (XSKT), TT Huế
            // Thứ 2: Thừa T. Huế (XSTTH), Phú Yên (XSPY)
            // Thứ 3: Đắk Lắk (XSDLK), Quảng Nam (XSQNM)
            // Thứ 4: Đà Nẵng (XSDNG), Khánh Hòa (XSKH)
            // Thứ 5: Bình Định (XSBDI), Quảng Trị (XSQT), Quảng Bình (XSQB)
            // Thứ 6: Gia Lai (XSGL), Ninh Thuận (XSNT)
            // Thứ 7: Đà Nẵng (XSDNG), Quảng Ngãi (XSQNG), Đắk Nông (XSDNO) 
            'datehasResult'=>[
                ['khoa','ktum','tthue'], 
                ['tthue','pyen'],
                ['dlak','qnam'],
                ['dnang','khoa'],
                ['bdinh','qtri','qbinh'],
                ['glai','nthuan'],
                ['dnang','qngai','dnong'],
            ],
        ],
        'mienbac'=>[
            'key'=>'mienbac',
            'keyLatestResult'=>'latestResultMienBac',
            'numberPrize'=>8,
            'prizes'=>[1000000000,10000000,5000000,1000000,400000,200000,100000,40000,40000],
            'name'=> 'Xổ số Miền Bắc',
            'label'=> 'Miền Bắc',
            'timeNotAllowBuy'=>16,//buy before 16pm
            'provincesHasResult'=>['H.Nội','H.Nội','B.Ninh','H.Nội','H.Phong','N.Định','T.Bình'],
            'provincesFull'=>[
                'thai-binh'=>'Thái Bình','ha-noi'=>'Hà Nội', 'bac-ninh'=>'Bắc Ninh', 'quang-ninh'=>'Quảng Ninh','hai-phong'=>'Hải Phòng','nam-dinh'=>'Nam Định',  
            ],
            'provinces'=>[
                'tbinh'=>'T.Bình','hnoi'=>'H.Nội', 'bninh'=>'B.Ninh', 'qninh'=>'Q.Ninh','hphong'=>'H.Phòng','ndinh'=>'N.Định',  
            ],
            // Chủ Nhật: Xổ số kiến thiết Thái Bình (xstb)
            // Thứ 2: Xổ số kiến thiết Hà Nội (xshn)
            // Thứ 3: Xổ số kiến thiết Quảng Ninh (xsqn)
            // Thứ 4: Xổ số kiến thiết Bắc Ninh (xsbn)
            // Thứ 5: Xổ số kiến thiết Hà Nội (xshn)
            // Thứ 6: Xổ số kiến thiết Hải Phòng (xshp)
            // Thứ 7: Xổ số kiến thiết Nam Định (xsnd) 
            'datehasResult'=>[
                ['tbinh'], 
                ['hnoi'], 
                ['qninh'], 
                ['bninh'], 
                ['hnoi'], 
                ['hphong'], 
                ['ndinh'], 
            ],
        ],
        // CN: 0; T2:1....
        'mega645'=>[
            'key'=>'mega645',
            'keyInServerAPI'=>'mega',
            'keyLatestResult'=>'latestResultMega645',
            'name'=>'Mega 6/45',
            'image'=>'storage/photos/1/Default/mega645.png',
            'numbersOfBall'=>45,
            'phichoibao'=>[10000,400000,70000,280000,840000,2100000,4620000,9240000,17160000,30030000,50050000,185564000],
            'weekdays'=>[0,3,5],//CN,T4,T6
            'timeNotAllowBuy'=>'17:55',//buy before '17:55'
            'prizesName'=>['Jackpot','Giải nhất','Giải nhì','Giải ba'],
            'prizesValue'=>[//method=>duplicateNumber=>valuePrize
                ['','','',30000,300000,10000000,'JACKPOT'],//ve don
                ['','',120000,2010000,31400000,'JACKPOT + 390 Triệu Đồng'],//bao 5
                ['','','',120000,1020000,21500000,'JACKPOT + 60 Triệu Đồng'],//bao 7
                ['','','',300000,2280000,34800000,'JACKPOT + 124,5 Triệu Đồng'],//bao 8
                ['','','',600000,4200000,50200000,'JACKPOT + 194,1 Triệu Đồng'],//bao 9
                ['','','',1050000,6900000,68000000,'JACKPOT + 269,4 Triệu Đồng'],//bao 10
                ['','','',1680000,10500000,88500000,'JACKPOT + 351 Triệu Đồng'],//bao 11
                ['','','',2520000,15120000,112000000,'JACKPOT + 439,5 Triệu Đồng'],//bao 12
                ['','','',3600000,20880000,138800000,'ACKPOT + 535,5 Triệu Đồng'],//bao 13
                ['','','',4950000,27900000,169200000,'JACKPOT + 639,6 Triệu Đồng'],//bao 14
                ['','','',6600000,36300000,203500000,'JACKPOT + 752,4 Triệu Đồng'],//bao 15
                ['','','',13650000,70980000,332800000,'JACKPOT + 1,149 Tỷ Đồng'],//bao 18 
            ], 
        ],
        'power655'=>[
            'key'=>'power655',
            'keyInServerAPI'=>'power',
            'keyLatestResult'=>'latestResultPower655',
            'name'=>'Power 6/55',
            'image'=>'storage/photos/1/Default/power655.png',
            'numbersOfBall'=>55,
            'phichoibao'=>[10000,400000,70000,280000,840000,2100000,4620000,9240000,17160000,30030000,50050000,185564000],
            'weekdays'=>[2,4,6],//T3,T5,T7
            'timeNotAllowBuy'=>'17:55',//buy before '17:55'
            'prizesName'=>['Jackpot 1','Jackpot 2','Giải nhất','Giải nhì','Giải ba'],
            'prizesValue'=>[//method=>duplicateNumber=>valuePrize
                ['','','',50000,500000,40000000,'Giải Jackpot 1','Giải Jackpot 2'],//ve don
                ['','',200000,3850000,104000000,'JACKPOT 1* + JACKPOT 2* + 1,920 Tỷ Đồng','(JACKPOT 2*x2) + 24 Triệu Đồng'],//bao 5
                ['','','',200000,1700000,82500000,'JACKPOT 1* + 240 Triệu Đồng','JACKPOT 2* + 42,5 Triệu Đồng','JACKPOT 1* + JACKPOT 2*'],//bao 7
                ['','','',500000,3800000,128000000,'JACKPOT 1* + 4875 Triệu Đồng','JACKPOT 2* + 88 Triệu Đồng','JACKPOT 1* + JACKPOT 2* + 247,5 Triệu Đồng'],//bao 8
                ['','','',1000000,7000000,177000000,'JACKPOT 1* + 743,5 Triệu Đồng','JACKPOT 2* + 137 Triệu Đồng','JACKPOT 1* + JACKPOT 2* + 503,5 Triệu Đồng'],//bao 9
                ['','','',1750000,11500000,230000000,'JACKPOT 1* + 1,00 Tỷ Đồng**','JACKPOT 2* + 190 Triệu Đồng','JACKPOT 1* + JACKPOT 2* + 769 Triệu Đồng'],//bao 10
                ['','','',2800000,17500000,287500000,'JACKPOT 1* + 1,28 Tỷ Đồng**','JACKPOT 2* + 247,5 Triệu Đồng','JACKPOT 1* + JACKPOT 2* + 1,04 Tỷ Đồng**'],//bao 11
                ['','','',4200000,25200000,350000000,'JACKPOT 1* + 1,57 Tỷ Đồng**','JACKPOT 2* + 310 Triệu Đồng','JACKPOT 1* + JACKPOT 2* + 1,33 Tỷ Đồng**'],//bao 12
                ['','','',6000000,34800000,418000000,'JACKPOT 1* + 1,87 Tỷ Đồng**','JACKPOT 2* + 378 Triệu Đồng','JACKPOT 1* + JACKPOT 2* + 1,63 Tỷ Đồng**'],//bao 13
                ['','','',8250000,46500000,492000000,'JACKPOT 1* + 2,18 Tỷ Đồng**','JACKPOT 2* + 452 Triệu Đồng','JACKPOT 1* + JACKPOT* 2 + 1,94 Tỷ Đồng**'],//bao 14
                ['','','',11000000,60500000,572500000,'JACKPOT 1* + 2,51 Tỷ Đồng**','JACKPOT 2* + 532,5Triệu Đồng','JACKPOT 1* + JACKPOT 2* + 2,27 Tỷ Đồng**'],//bao 15
                ['','','',22750000,118300000,858000000,'JACKPOT 1* + 3,59 Tỷ Đồng**','JACKPOT 2* + 818 Triệu Đồng','JACKPOT 1* + JACKPOT 2* + 3,35 Tỷ Đồng**'],//bao 18 
            ],
        ],
        'max3d'=>[//https://vietlott.vn/vi/choi/max3d/gioi-thieu-san-pham-max3d
            'key'=>'max3d', 
            'keyInServerAPI'=>'max3d',
            'keyLatestResult'=>'latestResultMax3D',
            'name'=>'Max 3D',
            'weekdays'=>[1,3,5],//T2,T4,T6
            'image'=>'storage/photos/1/Default/max3d.png',
            'timeNotAllowBuy'=>'17:55',//buy before '17:55'
            'indexPricesMax'=>5,
            'prizesName'=>['Đặc biệt','Giải nhất','Giải nhì','Giải ba'],
            'prizesValue'=>[1000000,350000,210000,100000,0,0,0],
        ],
        'max3dplus'=>[
            'key'=>'max3dplus', 
            'keyInServerAPI'=>'max3d+', 
            'keyLatestResult'=>'latestResultMax3DPlus',
            'name'=>'Max 3D+',
            'weekdays'=>[1,3,5],//T2,T4,T6
            'image'=>'storage/photos/1/Default/max3dplus.png',
            'timeNotAllowBuy'=>'17:55',//buy before '17:55'
            'indexPricesMax'=>5,
            'valuePrizes'=>[1000000000,40000000,10000000,5000000,1000000,150000,40000],
            'prizesName'=>['Đặc biệt','Giải nhất','Giải nhì','Giải ba','Giải tư','Giải năm','Giải sáu'],
        ],
        'max3dpro'=>[
            'key'=>'max3dpro',
            'keyInServerAPI'=>'3dprobasic', 
            'keyLatestResult'=>'latestResultMax3DPro',
            'weekdays'=>[2,4,6],//T3,T5,T7
            'image'=>'storage/photos/1/Default/max3dpro.png',
            'phichoibao'=>[10000],
            'timeNotAllowBuy'=>'17:55',//buy before '17:55'
            'name'=>'Max 3D Pro',
            'indexPricesMax'=>4,
            'valuePrizes'=>[2000000000,30000000,10000000,4000000,1000000,100000,40000,400000000],
            'prizesName'=>['Đặc biệt','Giải nhất','Giải nhì','Giải ba','Giải tư','Giải năm','Giải sáu','Đặc biệt phụ'],
        ],
        'mega4d'=>[
            'key'=>'mega4d',
            'keyLatestResult'=>'latestResultMax4D',
            'name'=>'Max 4D',
            'timeNotAllowBuy'=>'17:55',//buy before '17:55'
        ],
        'keno'=>[
            'key'=>'keno',
            'keyInServerAPI'=>'keno', 
            'keyLatestResult'=>'latestResultKeno',
            'image'=>'storage/photos/1/Default/keno.png',
            'name'=>'Keno',
            'phichoibao'=>[10000,10000,10000,10000,10000,10000,10000,10000,10000,10000,10000,10000],
            'numbersOfBall'=>80,
            'timeRestToByNextPeriod'=>5,//buy before 5'
            'indexPricesMax'=>6,
            'valuePrizes'=>[ 
                [0,20000],//1
                [0,0,90000],//2
                [0,0,20000,200000],//3
                [0,0,10000,50000,400000],//4
                [0,0,0,10000,150000,4400000],//5
                [0,0,0,10000,40000,450000,12500000],//6
                [0,0,0,10000,20000,100000,1200000,40000000],//7
                [10000,0,0,0,10000,50000,500000,5000000,200000000],//8
                [10000,0,0,0,10000,30000,150000,1500000,12000000,800000000],//9
                [10000,0,0,0,0,20000,80000,710000,8000000,150000000,2000000000],//10
                [200000,40000,20000,20000,20000,40000,200000],//Even-Odd
                [26000,10000,26000,10000,26000],//Big-Small 
            ]
        ],
    ],
];
