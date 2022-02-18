<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Tra cứu giao dịch</title>
        <!-- Bootstrap core CSS --> 
        <link href="{{asset('laravelvnpay/vnpay_php/assets/bootstrap.min.css')}}" rel="stylesheet"/>
        <!-- Custom styles for this template -->
        <link href="{{asset('laravelvnpay/vnpay_php/assets/jumbotron-narrow.css')}}" rel="stylesheet">   
        <script src="{{asset('laravelvnpay/vnpay_php/assets/jquery-1.11.3.min.js')}}"></script> 
    </head>
    <body>
        <div class="container">
            <div class="header clearfix">
                <h3 class="text-muted">VNPAY DEMO</h3>
            </div>
            <div style="width: 100%;padding-top:0px;font-weight: bold;color: #333333"><h3>Query dr</h3></div>
            <div style="width: 100% ;border-bottom: 2px solid black;padding-bottom: 20px" >
                <form action="{{route('vnpay.vnpay_query')}}" id="frmCreateOrder" method="post">       
                    @csrf 
                    <div class="form-group">
                        <label >OrderID</label>
                        <input class="form-control" data-val="true"  name="orderid" type="text" value="" />
                    </div>
                    <div class="form-group">
                        <label>Payment Date</label>
                        <input class="form-control" data-val="true"  name="paymentdate" type="text" value="" />
                    </div>
                    <input type="submit"  class="btn btn-default" value="Querydr" />
                </form>
            </div> 
        </div>
    </body>
</html>