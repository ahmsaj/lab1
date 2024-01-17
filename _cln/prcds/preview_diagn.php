<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'],$_POST['cat'])){
	$vis=pp($_POST['vis']);
	$cat=pp($_POST['cat']);
	$selected=get_vals('compOrderInfo_x_prv_icd10','opr_id' ," `visit` ='$vis' ");
	$selArr=explode(',',$selected);
							
	$sql="select * from cln_m_icd10 where cat='$cat' order by code ASC";
	$res=mysql_q($sql);
	echo '<div class="ana_list_mdc" >';
	while($r=mysql_f($res)){
		$id=$r['id'];
		$code=$r['code'];
		$name=$r['name_'.$lg];
		$h='';
		$s=0;
		if(in_array($id,$selArr)){$h=' hide ';$s=1;}
		echo '<div class="norCat fs16 '.$h.' " icd_no="'.$id.'" name="'.$name.'" code="'.$code.'" sel="'.$s.'" ><ff>'.$code.'</ff> - '.$name.'</div>';
	}
	echo '</div>';
}?>