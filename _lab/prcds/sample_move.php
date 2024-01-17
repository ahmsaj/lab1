<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['no'] , $_POST['p'] , $_POST['r'])){
	$no=pp($_POST['no']);
	$place=pp($_POST['p'],'s');
	$rack_no=pp($_POST['r'],'s');
	$r_ord=pp($_POST['r_ord']);
	$out=0;
	$msg=k_err_occ_add;
	$place=substr($place,1);
	$rack_id=get_val_c('lab_m_racks','id',$rack_no,'no');
	$sql="select * from lab_x_visits_samlpes where no='$no'";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$id=$r['id'];
		$visit_id=$r['visit_id'];
		$pkg_id=$r['pkg_id'];
		$status=$r['status'];
		$rack=$r['rack'];
		$rack_pos=$r['rack_pos'];
		$out=AddRackPlace($rack_id,$place,$id,$rack,$rack_pos,$status,$r_ord);
		if($out==1){$msg=k_mvd_sucsfly;}
		if($out==2){$msg=k_plc_alrdy_resvd;}
	}else{$msg=k_no_sams_exsd.' <ff class="fs14">( '.$no.' )</ff>';}
	echo $out.'^'.$msg;
}
?>
