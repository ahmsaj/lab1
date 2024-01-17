<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$r=getRec('lab_x_visits_requested',$id);
	if($r['r']){
        $staus=$r['status'];
        $patient=$r['patient'];
        if($staus<2){
            $sql="select * from lab_x_visits_requested_items where r_id='$id' ";
            $res=mysql_q($sql);
            $rows=mysql_n($res);
            if($rows>0){                
                if(mysql_q("UPDATE lab_x_visits_requested SET status='1' where id='$id' and status=0 ")){
                    echo $id;
                    if(getTotalCo('gnr_x_temp_oprs',"type=7 and vis='$id' ")==0){                    
                        addTempOpr($patient,7,2,0,$id);
                    }
                }
                while($r=mysql_f($res)){
                    $x_id=$r['id'];				
                    if(isset($_POST['a_'.$x_id])){
                        $v=pp($_POST['a_'.$x_id]);
                        mysql_q("UPDATE lab_x_visits_requested_items SET action='$v' where id= '$x_id' ");                        
                    }
                }
            }
        }
	}
}?>