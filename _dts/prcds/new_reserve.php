<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['ref_id'])){
	$id=pp($_POST['id']);
    $ref_id=pp($_POST['ref_id']);
    $r=getRec('dts_x_dates',$ref_id);
    if($r['r']){
        $reg_user=$r['reg_user'];
        $d_start=$r['d_start'];
        $d_end=$r['d_end'];
        $doctor=$r['doctor'];
        $clinic=$r['clinic'];
        $mood=get_val('gnr_m_clinics','type',$clinic);        
        $r2=getRec('dts_x_dates',$id);
        if($r2['r']){
            $sql="UPDATE dts_x_dates SET clinic='$clinic' , doctor='$doctor' , d_start='$d_start' , d_end='$d_end' , reserve='$ref_id' where id='$id'";
            if(mysql_q($sql)){
                echo 1;
                datesTempUp($id);
                editTempOpr($mood,$id,9,2);
            }
        }
        
    }
}?>