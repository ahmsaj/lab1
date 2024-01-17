<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
    $id=pp($_POST['id']);
    $r=getRec('dts_x_dates',$id);
    if($r['r']){     
        $patient=$r['patient'];
        $p_type=$r['p_type'];
        $type=$r['type'];
        $status=$r['status'];
        if($status==1 || $status==9){
            $type=pp($_POST['cof_6hu8l19gcw']);
            $reason=pp($_POST['cof_h31yxgck']);
            $note=pp($_POST['cof_511v6h1aci'],'s');
            if($type==1 || $type==2){
                if(get_val('dts_m_cancel_reson','id',$reason)){
                    $sql="insert INTO dts_x_cancel (dts,user,type,reason,date,note) values ('$id','$thisUser','$type','$reason','$now','$note')";
                    if($res=mysql_q($sql)){
                        if(mysql_q("UPDATE dts_x_dates SET status=5  where id='$id' and status in(1,9) ")){
                            datesTempUp($id);
                            echo 1;
                            vacaConflictAlert();
                            api_notif($patient,$p_type,7,$id);
                        }
                    }
                }
            }
        }        
    }
}?>