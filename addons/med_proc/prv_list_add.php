<? include("../header.php");
if(isset($_POST['vis'],$_POST['t'],$_POST['id'],$_POST['val'])){
	$vis=pp($_POST['vis']);
	$t=pp($_POST['t']);
	$id=pp($_POST['id']);
	$val=pp($_POST['val'],'s');	
	$r=getRec('cln_x_visits',$vis);
	$s=0;
	if($r['r']){
		$visStatus=$r['status'];
		$patient=$r['patient'];
		$table=$mp_table[$t];
		if($visStatus==1 || _set_whx91aq4mx){
			$val=clearTxt($val);
			if($id){
				$res=mysql_q("UPDATE $table SET val='$val' where id='$id' and doc='$thisUser' and visit='$vis' ");
			}else{
				$res=mysql_q("INSERT INTO $table (visit,patient,doc,val,date)VALUES('$vis','$patient','$thisUser','$val','$now')");				
				$id=last_id();
			}
			if($res){$s=1;}
			echo $s.','.$id.','.$val;
		}
	}	
}?>