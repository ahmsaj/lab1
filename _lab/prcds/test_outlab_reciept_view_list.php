<? include("../../__sys/prcds/ajax_header.php");
	$serl=pp($_POST['serl'],'s');
	$q='';
  if($serl!='')$q=" and  short_name like '%".$serl."%'";
	$out='';
	$sql="SELECT * FROM `lab_m_services` WHERE `act`=1 and `outlab`=1 $q ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$out.= '<div class="op_list">';
		while($r=mysql_f($res)){
			$name=$r['short_name'];
			$ana_id=$r['id'];
			$out.= '<div class="" num="'.$ana_id.'" rep name="'.$name.'">'.$name.'</div>';
		}
		$out.= '</div>';
	}
	echo $out;
?>