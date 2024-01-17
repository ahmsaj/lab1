<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['no'])){
	$no=pp($_POST['no']);
	$sql="select * from lab_x_visits_samlpes where no='$no'";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$id=$r['id'];
		$visit_id=$r['visit_id'];
		$pkg_id=$r['pkg_id'];
		$status=$r['status'];		
		if($status==2){echo '0,'.k_sam_rcv_prv;}
		if($status==1){
			$s=3;
			if(_set_k9zsc2awv){$s=2;}
			if(mysql_q("UPDATE lab_x_visits_samlpes SET status='$s' ,date='$now' where id='$id'")){
				echo '1,'.k_rcvd;
				$sn=getTotalCO('lab_x_visits_samlpes'," visit_id='$visit_id' and status=1");
				if($sn==0){
					mysql_q("UPDATE lab_x_visits SET status=4 where id='$visit_id' ");
					delTempOpr(2,$visit_id,4);
					
					list($pay_type,$patient)=get_val('lab_x_visits','pay_type,patient',$visit_id);
					fixPatintAcc($patient);
					if($pay_type==2){fixCharServ(2,$visit_id);}
					if($pay_type==1){fixExeServ(2,$id);}
				}
			}		
		}
	}else{echo '0,'.k_no_sams_exsd.' <ff class="fs14">( '.$no.' )</ff>';}
}?>
