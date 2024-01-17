<? include("../header.php");
if(isset($_POST['vis'],$_POST['t'],$_POST['id'])){
	$vis=pp($_POST['vis']);
	$t=pp($_POST['t']);
	$id=pp($_POST['id']);	
	$r=getRec('cln_x_visits',$vis);
	$s=0;
	if($r['r']){
		$visStatus=$r['status'];		
		$table=$icd_table_x[$t];
		if($visStatus==1){
			$res=mysql_q("DELETE from  $table where id='$id' and doc='$thisUser' and visit='$vis' ");
			if($res){echo 1;}
		}
	}	
}?>