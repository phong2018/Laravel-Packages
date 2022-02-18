<?php

return [ 
    'layout'=>'laravellayout::template.xoso.home', 
    'userLogAction'=>[
        // add point
        'addPointsSuccess'=>'Nạp tiền thành công',
        'cancelAddPoints'=>'Hủy nạp tiền',
        // withdraw point
        'withdrawPointsSuccess'=>'Rút tiền thành công',
        'cancelWithdrawPoints'=>'Hủy rút tiền',

        // buyTicket
        'minusPointsToBuyTicket'=>'Trừ tiền mua vé số',
        'refundPoint'=>'Hoàn tiền do mua vé không thành công',
        'refundTicketReward'=>'Hoàn vé thưởng do mua vé không thành công',
        'payByVnPaySuccess'=>'Thanh toán qua VnPay thành công',

        //agency submit winprize
        'agencySubmiWinPrize'=>'Đại lý xác nhận trúng thưởng',
        'agencyCancelSubmiWinPrize'=>'Đại lý hủy xác nhận trúng thưởng',

        // get point to reward for customer (agaency)
        'getPointToReward'=>'Lấy điểm để trả thưởng cho khách',
        'getTicketToReward'=>'Lấy vé để hoàn vé trả thưởng cho khách',
        'cancelGetPointToReward'=>'Hủy trả thưởng cho khách nhận lại điểm',

        // customer received point win prize
        'receivedWinPrize'=>'Nhận tiền thưởng thắng giải',
        'receivedWinPrizeByTicket'=>'Nhận thưởng bằng hoàn vé',
        'cancelReceivedWinPrize'=>'Hủy nhận tiền thưởng thắng giải',

        // paid point for agency buy ticket
        'addPointBuyTicketForAgency'=>'Thanh toán tiền cho Đại lý bán vé',
        'cancelAddPointBuyTicketForAgency'=>'Hủy Thanh toán tiền cho Đại lý bán vé',
        'addPointBuyTicketForPresenter'=>'Thanh toán tiền hoa hồng mua vé số cho Người giới thiệu',
        'cancelAddPointBuyTicketForPresenter'=>'Hủy Thanh toán tiền hoa hồng mua vé số cho Người giới thiệu',
        
        //accumulated_points
        'addAccumulatedPointCustomer'=>'Cộng điểm tích lũy cho khách hàng',
        'cancelAddAccumulatedPointCustomer'=>'Hủy Cộng điểm tích lũy cho khách hàng',
        'addAccumulatedPointPresenter'=>'Cộng điểm tích lũy cho người giới thiệu',
        'cancelAddAccumulatedPointPresenter'=>'Hủy Cộng điểm tích lũy cho người giới thiệu',
        'withDrawAccumulatedPoint'=>'Xác nhận Rút điểm tích lũy',
        'cancelWithDrawAccumulatedPoint'=>'Hủy Rút điểm tích lũy',
    ]
];