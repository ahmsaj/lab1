<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);	
    $r=getRec('xry_x_visits_requested',$id);
    if($r['r']){
        $staus=$r['status'];
        $patient=$r['patient'];
        $clinic=$r['x_clinic'];
        if($staus<2){
            $sql="select * from xry_x_visits_requested_items where r_id='$id' ";
            $res=mysql_q($sql);
            $rows=mysql_n($res);
            if($rows>0){
                if(mysql_q("UPDATE xry_x_visits_requested SET status='1' where id='$id' and status=0 ")){
                    echo $id;
                    if(getTotalCo('gnr_x_temp_oprs',"type=8 and vis='$id' ")==0){                    
                        addTempOpr($patient,8,3,$clinic,$id);                        
                    }
                }
                while($r=mysql_f($res)){
                    $x_id=$r['id'];				
                    if(isset($_POST['a_'.$x_id])){
                        $v=pp($_POST['a_'.$x_id]);
                        mysql_q("UPDATE xry_x_visits_requested_items SET action='$v' where id= '$x_id' ");
                    }
                }
            }
        }
    }
}?>