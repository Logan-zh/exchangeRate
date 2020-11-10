<?php
    require_once __DIR__. '/PHPExcel/Classes/PHPExcel.php';
    include_once 'colName.php';
    function outPutToExcel($data){
        $colsName=$GLOBALS['colsName'];
        $cols=$GLOBALS['cols'];
        $objPHPExcel = new PHPExcel();
        
        // =======================================================================

        $array=$data;
        $keys=array_keys($array[0]);  //欄位名稱
        $x=0;


        foreach ($keys as $key => $value) {
            if(in_array($value,$cols)){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($x, 1,$colsName[$value]);
                $x+=1;
            }
        }


            $y=2;   //直向軸以1起始
            $x=0;   //橫向軸以0起始
            foreach($array as $k=>$v){
                if(!is_array($v)){      //  只有一筆資料
                    if(in_array($k,$cols)){
                        if($k='create_time'){
                            $v=mb_substr($v,0,10);
                        }
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($x, $y,$v);
                        $x+=1;
                    }
                }else{     //多筆資料
                    $x=0;
                    foreach($array[$k] as $k=> $value){
                        if(in_array($k,$cols)){
                            if($k='create_time'){
                                $value=mb_substr($value,0,10);
                            }
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($x, $y,$value);
                            $x+=1;
                        }
                    }
                    $y+=1;
                }
            }

        

        // =======================================================================
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="simple.xlsx"')      ;
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be      needed
        header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the       past
        header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); //      always modified
        header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header ('Pragma: public'); // HTTP/1.0

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,         'Excel2007');
        $objWriter->save('php://output');
        exit;
    }
?>