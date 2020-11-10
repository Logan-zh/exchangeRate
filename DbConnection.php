<?php
    include_once 'colName.php';
    $a=new DB;
    class DB{
        public $pdo;
        public $today;
        public $checkToday;
        public $data;
        public $columns;
        function __construct(){
            $this->columns=$GLOBALS['colsOfCurrency'];
            $this->today=date('Y-m-d');
            $this->pdo=new PDO('mysql:host=localhost;dbname=test;charset=utf8','root','');
            $this->checkToday=$this->checkTodayRecord();
            if(!$this->checkToday){
                $this->data=$this->getTodayRecord();
                $this->save($this->data);
            }
        }
        function fetchAll($date,$currency){
            $sql="select * from currency as c  left join exchange_rate as e ON e.Currency_id=c.id where e.create_time like '$date%' &&( c.currency like '$currency%') && e.status='1' group by e.currency_id";
            return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        }

        function checkTodayRecord(){
            $sql="select count(*) from exchange_rate where create_time like '$this->today%'";
            return $this->pdo->query($sql)->fetchColumn();
        }

        function getTodayRecord(){
            $ch=curl_init();
            curl_setopt($ch,CURLOPT_URL,'https://rate.bot.com.tw/xrt?Lang=zh-TW');
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
            $res=curl_exec($ch);
            curl_close($ch);
        
            $res=str_replace(' ','',$res);
            $ta=strip_tags($res);
        
            preg_match_all('/[\x7f-\xff]+\(.*\)\s*[0-9\-]+\.?[0-9\-]*\s*[0-9\-]+\.?[0-9\-]*\s*[0-9\-]+\.?[0-9\-]*\s*[0-9\-]+\.?[0-9\-]*/',$ta,$array);
        
            $array=$array[0];
            foreach($array as $k=>$v){
                preg_match('/[\x7f-\xff]+/',$v,$key);
                preg_match_all('/[0-9\-]+\.?[0-9\-]*/',$v,$tt);
                $tmp[$key[0]]=$tt[0];
            }
            return $tmp;
        }
        function save($data){
            foreach($data as $k=>$v){
                $currencyId=$this->columns[$k];
                $sql="insert into `exchange_rate` (`Currency_id`,`cash_buy`,`cash_sell`,`redeposit_buy`,`redeposit_sell`) values ('$currencyId','".implode("','",$v)."')";
                
                $this->pdo->query($sql);
            }
        }
        function getCurrency(){
            return $this->pdo->query("select * from currency")->fetchAll(PDO::FETCH_ASSOC);
        }
        function query($sql){
            return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
        }
    }
?>

