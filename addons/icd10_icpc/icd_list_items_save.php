<? include("../header.php");
if(isset($_POST['vis'],$_POST['t'],$_POST['id'])){
	$vis=pp($_POST['vis']);
	$t=pp($_POST['t']);
	$id=pp($_POST['id']);	
	$r=getRec('cln_x_visits',$vis);
	$s=0;
	if($r['r']){
		$visStatus=$r['status'];
		$patient=$r['patient'];
		$table=$icd_table_x[$t];
		if($visStatus==1 || _set_whx91aq4mx){
			if(getTotalCO($table," visit ='$vis' and opr_id='$id' ")==0){				
				$res=mysql_q("INSERT INTO $table (visit,patient,doc,opr_id,date)VALUES('$vis','$patient','$thisUser','$id','$now')");	
				if($res){echo last_id();}
			}
		}
	}
}?>