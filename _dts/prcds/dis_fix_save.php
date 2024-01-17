<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'])){
	$mood=pp($_POST['mood']);
    $vis=pp($_POST['vis']);
    $dts=pp($_POST['dts']);
    $service=pp($_POST['service']);
        
    $table=$visXTables[$mood];
    $sTable=$srvXTables[$mood];
    $mTable=$srvTables[$mood];
    $visInfo=getRec($table,$vis);
    if($visInfo['r']){
        $doctor=$visInfo['doctor'];
        $patient=$visInfo['patient'];
        $clinic=$visInfo['clinic'];
        $d_start=$visInfo['d_start'];
        $pay_type=$visInfo['pay_type'];
        $status=$visInfo['status'];
        $app=$visInfo['app'];
        $pay_type_link=$visInfo['pay_type_link'];
        
        if($pay_type==0){            
            if($app){
                $srv_id=pp($_POST['srv_id']);
                $hos_part=pp($_POST['hos_part']);
                $doc_part=pp($_POST['doc_part']);
                $doc_percent=pp($_POST['doc_percent']);
                $pay_net=pp($_POST['pay_net']);
                $doc_bal=pp($_POST['doc_bal']);
                $doc_dis=pp($_POST['doc_dis']);
                $hos_bal=pp($_POST['hos_bal']);
                $hos_dis=pp($_POST['hos_dis']);
                mysql_q("UPDATE $sTable SET 
                    hos_part='$hos_part',
                    doc_part='$doc_part',
                    doc_percent='$doc_percent',
                    pay_net='$pay_net',
                    doc_bal='$doc_bal',
                    doc_dis='$doc_dis',
                    hos_bal='$hos_bal',
                    hos_dis='$hos_dis'
                    where id='$srv_id' and app=1
                ");
            }else{
                mysql_q("UPDATE $table set dts_id='$dts' where id='$vis' ");
                activeAppDiscount($mood,$vis,$service);
                echo 1;
            }
            mysql_q("UPDATE gnr_x_acc_payments SET amount='$pay_net'  where vis='$vis' and mood='$mood' and pay_type=1 ");
        }else{
            echo 0;
        }       
    }
}?>