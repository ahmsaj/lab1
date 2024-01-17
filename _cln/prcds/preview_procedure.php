<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['type'])){
	$type=pp($_POST['type']);
	$serl=pp($_POST['serl'],'s');
	$v_id=pp($_POST['v_id']);
	$q='';
	if($serl!='')$q=" and  name like '%".$serl."%'";
	if($type==1){$table='cln_m_prv_complaints';$tabl2='cln_x_prv_complaints';}
	if($type==2){$table='cln_m_prv_diagnosis';$tabl2='cln_x_prv_diagnosis';}
	if($type==3){$table='cln_m_prv_story';$tabl2='cln_x_prv_story';}
	if($type==4){$table='cln_m_prv_clinical';$tabl2='cln_x_prv_clinical';}	
	$sql="select * from $table where doc='$thisUser' and act=1 and id NOT IN(select opr_id from $tabl2 where visit='$v_id') $q ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		echo '<div class="op_list">';
		while($r=mysql_f($res)){				
			$id=$r['id'];
			$name=$r['name'];
			echo '<div num="'.$id.'" type="'.$type.'" name="'.$name.'">
			<div class="list_edit_1" onclick="editList_1('.$type.','.$id.')"></div>
			'.hlight($serl,$name).'</div>';
		}
		echo '</div>';
	}
	$mods=array('','Complaints','Diagnoses','Story','Clinical');
	$sendingParsToForm=getStaticPars($mods[$type]);
	echo'<script>sendingParsToForm="'.$sendingParsToForm.'"</script>';
}?>
