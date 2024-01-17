<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['mood'])){
	$id=pp($_POST['id']);
    $mood=pp($_POST['mood']);
    $rate=pp($_POST['r']);
    $note=pp($_POST['note'],'s');
    $table=$visXTables[$mood];
    $r=getRec($table,$id);
    if($r['r']){             
        if($r['rate']==0 && $rate){
            $pat=$r['patient'];
            $d_start=$r['d_start'];
            $d_finish=$r['d_finish'];
            $pay_type=$r['pay_type'];
            if($mood==2){
                $clinic=get_val_c('gnr_m_clinics','id',$mood,'type');
                $doctor=0;
            }else{
                $clinic=$r['clinic'];
                $doctor=$r['doctor'];
            }
            $sql="INSERT INTO gnr_x_visit_rate(`patient`,`type`,`visit`,`rate`,`note`,`doc`,`clinic`,`date`,`vis_date`,`user`) values('$pat','$mood','$id','$rate','$note','$doctor','$clinic','$now','$d_start','$thisUser')";
            if(mysql_q($sql)){
                mysql_q("UPDATE $table SET rate='$rate' where id='$id'");
                echo 1;
            }
        }
    }
}?>