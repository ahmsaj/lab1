<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] , $_POST['val'])){
	$id=pp($_POST['id']);
	$val=pp($_POST['val'],'s');
	$r=getRec('lab_x_visits_requested_items',$id);
	if($r['r']>0){
        $r_id=$r['r_id'];
		$doc=get_val('lab_x_visits_requested','doc',$r_id);
		if($doc==$thisUser){
			if(mysql_q("update lab_x_visits_requested_items set res='$val' , status=3  where  id='$id' ")){
                echo 1;
                if(getTotalCO('lab_x_visits_requested_items'," r_id='$r_id' and status=0")==0){
                    mysql_q("update lab_x_visits_requested set status=3  where  id='$r_id' and status!=4");                    
                }
            }
		}else{
			out();exit;
		}
	}
}?>