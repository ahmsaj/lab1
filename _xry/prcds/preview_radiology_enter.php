<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] , $_POST['val'],$_POST['photo'])){
	$id=pp($_POST['id']);
	$val=pp($_POST['val'],'s');
	$photo=pp($_POST['photo'],'s');
	$r=getRec('xry_x_visits_requested_items',$id);
	if($r['r']>0){
		$doc=get_val('xry_x_visits_requested','doc',$r['r_id']);
		if($doc==$thisUser){
			if(mysql_q("update xry_x_visits_requested_items set res='$val' , res_photo='$photo' , status=3  where  id='$id' ")){echo 1;}
		}else{
			out();exit;
		}
	}
}?>