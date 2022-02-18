<?php
namespace Phonglg\LaravelVeso\Services;

use Phonglg\LaravelLayout\Helpers\Date;

class StatisticalServices{

    // getReportDateData
    public function getFilerReportDateData($fromDate=false,$toDate=false,$orderType=false):array
    {
        $data=[]; 

        // use GET when submit by Form
        if(isset($_GET['fromDate'])) $fromDate=Date::dateDMYtoYMD($_GET['fromDate']);
        if(isset($_GET['toDate'])) $toDate=Date::dateDMYtoYMD($_GET['toDate']).' 23:59:59';
        if(isset($_GET['orderType'])) $orderType=$_GET['orderType'];
 
        // use redirect 
        if(($fromDate)) $data['fromDate']=$fromDate;
        else $data['fromDate']=date('Y-m-d');  
        if(($toDate))$data['toDate']=$toDate;
        else $data['toDate']=date('Y-m-d 23:59:59', strtotime(date('Y-m-d') . ' +2 day'));

        if(($orderType))$data['orderType']=$orderType;
        else $data['orderType']=''; 

        return $data;
    }

    public function getInvoiceStatisticsData($request):array
    {
        $data=[];
          
        if(isset($request->fromDate))$data['fromDate']=Date::dateDMYtoYMD($request->fromDate);
        else $data['fromDate']=date('Y-m-d'); 
        if(isset($request->toDate))$data['toDate']=Date::dateDMYtoYMD($request->toDate).' 23:59:59';
        else $data['toDate']=date('Y-m-d 23:59:59', strtotime(date('Y-m-d') . ' +2 day'));
        if(isset($request->orderType))$data['orderType']=$request->orderType;
        else $data['orderType']=''; 

        return $data;
    }
}

?>