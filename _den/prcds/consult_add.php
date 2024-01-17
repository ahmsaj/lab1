<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['doc'],$_POST['pat'])){
	$doc=pp($_POST['doc']);
	$pat=pp($_POST['pat']);
	$ch1=getTotalCO('_users'," id='$doc' and grp_code='fk590v9lvl' ");
	$ch2=getTotalCO('gnr_m_patients'," id='$pat'");
	if($ch1 && $ch2){
		$clinc=get_val('_users','subgrp',$doc);
		$sql="INSERT INTO den_x_visits (`doctor`,`patient`,`clinic`,`type`,`d_start`,`reg_user`) values ('$doc','$pat','$clinc','0','$now','$thisUser') ";
		$res=mysql_q($sql);
		$vis=last_id();
		if($res){addTempOpr($pat,4,4,$clinc,$vis);echo $vis;}else{echo 0;}		
	}else{
		out();
	}
}?>