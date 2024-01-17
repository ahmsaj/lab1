<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['pats'])){
	$id=pp($_POST['id']);
	$pat_name=get_p_name($id,4);
	$pats=pp($_POST['pats'],'s');
	$patsArr=explode(',',$pats);
	$patsArr[0];
	$old_pats='';
	$xIds=get_val('gnr_m_patients','old_ids',$id);
	if(in_array($id,$patsArr)){
		foreach($patsArr as $p){
			if($p!=$id){
				if($xIds!=''){$xIds.=',';}
				$xIds.=$p;
				foreach($merOprs as $mo){
					$table= $mo[1];
					$colm= $mo[2];
					$sql="UPDATE $table SET `$colm`='$id' where `$colm`='$p' ";
					mysql_q($sql);					
				}
				if($old_pats){$old_pats.=' | ';}
				$old_pats.=get_p_name($p,4);				
				mysql_q("DELETE from gnr_m_patients where id='$p' ");
				mysql_q("DELETE from gnr_m_patients_evaluation where id='$p' ");
                mysql_q("DELETE from gnr_m_patients_balance where patient='$p' ");
			}
		}
		mysql_q("UPDATE gnr_m_patients SET old_ids='$xIds' where id='$id' ");
		fixPatintAcc($id);
		$old_pats=$pat_name.'|'.$old_pats;
		mysql_q("INSERT INTO gnr_x_patients_merge (new_pat_id,old_pats,date,user)values ('$id','$old_pats','$now','$thisUser')");
		echo 1;
	}
}?>