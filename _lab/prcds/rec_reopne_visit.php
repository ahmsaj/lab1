<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
    $r=getRec('lab_x_visits',$id);
    if($r['r']){
        $pat=$r['patient'];
        $cln=get_val_c('gnr_m_clinics','id',2,'type');
        mysql_q("delete from gnr_x_roles where mood=2 and pat='$pat' and vis='$id' ");
        mysql_q("UPDATE lab_x_visits set status=0 where status IN(1,4) and id='$id'");
        delTempOpr(2,$id,4);
        addTempOpr($pat,4,2,$cln,$id);        
        echo $cln;
    }
}?>