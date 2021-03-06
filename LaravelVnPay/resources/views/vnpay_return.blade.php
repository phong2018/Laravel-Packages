<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <title>VNPAY RESPONSE</title>
        <!-- Bootstrap core CSS -->
        <link href="{{asset('laravelvnpay/vnpay_php/assets/bootstrap.min.css')}}" rel="stylesheet"/>
        <!-- Custom styles for this template -->
        <link href="{{asset('laravelvnpay/vnpay_php/assets/jumbotron-narrow.css')}}" rel="stylesheet">   
        <script src="{{asset('laravelvnpay/vnpay_php/assets/jquery-1.11.3.min.js')}}"></script> 
        
    </head>
    <body>
        <?php
        // get config
        date_default_timezone_set('Asia/Ho_Chi_Minh'); 
        $vnp_TmnCode = config('laravelvnpay.vnp_TmnCode'); //Website ID in VNPAY System
        $vnp_HashSecret = config('laravelvnpay.vnp_HashSecret'); //Secret key
        $vnp_Url = config('laravelvnpay.vnp_Url'); 
        $vnp_Returnurl = config('laravelvnpay.vnp_Returnurl');  
        $vnp_apiUrl = config('laravelvnpay.vnp_apiUrl');  
        $startTime = date("YmdHis");
        $expire = date('YmdHis',strtotime('+15 minutes',strtotime($startTime)));
        
        // hand vnpay_return
        $vnp_SecureHash = $_GET['vnp_SecureHash'];
        $inputData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        ?>
        <!--Begin display -->
        <div class="container">
            <div class="header clearfix">
                <h3 class="text-muted">VNPAY RESPONSE</h3>
            </div>
            <div class="table-responsive">
                <div class="form-group">
                    <label >M?? ????n h??ng:</label>

                    <label><?php echo $_GET['vnp_TxnRef'] ?></label>
                </div>    
                <div class="form-group">

                    <label >S??? ti???n:</label>
                    <label><?php echo $_GET['vnp_Amount'] ?></label>
                </div>  
                <div class="form-group">
                    <label >N???i dung thanh to??n:</label>
                    <label><?php echo $_GET['vnp_OrderInfo'] ?></label>
                </div> 
                <div class="form-group">
                    <label >M?? ph???n h???i (vnp_ResponseCode):</label>
                    <label><?php echo $_GET['vnp_ResponseCode'] ?></label>
                </div> 
                <div class="form-group">
                    <label >M?? GD T???i VNPAY:</label>
                    <label><?php echo $_GET['vnp_TransactionNo'] ?></label>
                </div> 
                <div class="form-group">
                    <label >M?? Ng??n h??ng:</label>
                    <label><?php echo $_GET['vnp_BankCode'] ?></label>
                </div> 
                <div class="form-group">
                    <label >Th???i gian thanh to??n:</label>
                    <label><?php echo $_GET['vnp_PayDate'] ?></label>
                </div> 
                <div class="form-group">
                    <label >K???t qu???:</label>
                    <label>
                        <?php
                        if ($secureHash == $vnp_SecureHash) {
                            if ($_GET['vnp_ResponseCode'] == '00') {
                                echo "<span style='color:blue'>GD Thanh cong</span>";
                            } else {
                                echo "<span style='color:red'>GD Khong thanh cong</span>";
                            }
                        } else {
                            echo "<span style='color:red'>Chu ky khong hop le</span>";
                        }
                        ?>

                    </label>
                </div> 
            </div>
            <p>
                &nbsp;
            </p>
            <footer class="footer">
                   <p>&copy; VNPAY <?php echo date('Y')?></p>
            </footer>
        </div>  
    </body>
</html>
