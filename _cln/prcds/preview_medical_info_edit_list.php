<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['p_id'])&&isset($_POST['serm'])&&isset($_POST['type'])){
	$p_id=pp($_POST['p_id']);
	$type=pp($_POST['type']);
	$serm=pp($_POST['serm'],'s');
	
	$q='';
	if($serm!='')$q=" and  name_".$lg." like '%".$serm."%'";
	$table=$p_mid_table_arr[$type];
	$sql="select * from $table where id NOT IN(select val from cln_x_medical_info where pationt_id='$p_id' and type='$type') $q";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		echo '<div class="op_list2">';		
		while($r=mysql_f($res)){
			$id=$r['id'];
			$name=$r['name_'.$lg];
			echo '<div num="'.$id.'" type="'.$type.'" name="'.$name.'">
			<div class="list_edit_1" onclick="editList_2('.$type.','.$id.')"></div>
			'.hlight($serm,$name).'</div>';
		}
		echo '</div>';
	}else{
		if($serm)echo '<div class="err_text f1">'.k_no_results.' <strong>( '.$serm.' )</strong><BR>'.k_m_add_but.'</div>';
	}
}?>
