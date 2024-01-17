<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$r=getRec('gnr_x_patients_docs',$id);
	if($r['r']){
		$user=$r['user'];
		$type=$r['type'];
		$doc=$r['doc'];
		if($user==$thisUser){
			mysql_q("DELETE from gnr_x_patients_docs where id='$id' limit 1;");
			if(mysql_a()>0){
				if($type==1){deleteImages($doc);}
				if($type==2){deleteFiles($doc);}			
				echo 1;
			}
		}
	}
}?>