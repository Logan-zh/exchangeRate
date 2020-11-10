<?php
    session_start();
    if($_SERVER['REQUEST_METHOD']=='GET'){
        include_once 'DbConnection.php';
        $date=!empty($_GET['date'])?$_GET['date']:'%';
        $currency=!empty($_GET['currency'])?checkPlural($_GET['currency']):'%';
        if(!empty($_GET['id'])){
            changeStatus($_GET['id'],$date);
        }else{
            $db=new DB;
            $data=$db->fetchAll($date,$currency);
            $lists=$db->getCurrency();
            $_SESSION['data']=$data;
            $_SESSION['lists']=$lists;
            header("location:index.php?date=".$_GET['date']."&&currency=".$_GET['currency']);
        }
    }elseif($_SERVER['REQUEST_METHOD']=='POST'){
        include_once 'dataToExcel.php';
        outPutToExcel($_SESSION['data']);
    }
    
    function checkPlural($tmp){
        $tmp=(!empty(mb_strstr($tmp,'、')))?explode('、',$tmp):$tmp;
        if(is_array($tmp)){
            $tmp=implode("%' || c.currency like '",$tmp);
        }
        return  $tmp;
    }
    
    function changeStatus($id,$date){
        include 'colName.php';
        $db=new DB;
        $before= $db->query("select status from currency where id='$id'");
        $status=($before['status']+1)%2;
        $db->query("update currency set status = $status where id = '$id'");
        if($before['status']==0){

            $res=$db->query("select * from exchange_rate where Currency_id='$id' && create_time like '$date%'");

            $res['create_time']=substr($res['create_time'],0,10);
            $res['cur']=$rcolsOfCurrency[$res['Currency_id']];
            echo json_encode($res,JSON_UNESCAPED_UNICODE);
        }else{
            echo json_encode('remove');
        }
    }
?>