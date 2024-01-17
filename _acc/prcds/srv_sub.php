<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['mood'],$_POST['t'])){
	$id=pp($_POST['id']);
	$mood=pp($_POST['mood']);
	$t=pp($_POST['t']);
	if($t==1){
		$action='onChange="selclicCatAcc(2,'.$mood.',this.value)"';
		echo '<input type="hidden" name="mood" value="'.$mood.'"/>';
		if($mood==1 || $mood==3){			
			echo '<div class="f1 fs16 lh40 clr1">'.k_tclinic.' :</div>';
			echo make_Combo_box('gnr_m_clinics','name_'.$lg,'id'," where act =1 and type='$mood'",'subType',0,'',"$action t");
			
		}else{
			echo '<div class="f1 fs16 lh40 clr1">'.k_cat.' :</div>';
			if($mood==4){$table='den_m_services_cat';}
			if($mood==2){$table='lab_m_services_cats';}
			if($mood==5 || $mood==6){$table='bty_m_services_cat';}
			if($mood==7){$table='osc_m_services_cat';}
			echo make_Combo_box($table,'name_'.$lg,'id','','subType',0,'',"$action t");
		}
	}
	if($t==2){
		echo '<div class="f1 fs16 lh40 clr1">'.k_service.' :</div>';
		$table=$srvTables[$mood];
		if($mood==1 || $mood==3){
			$m_clinic=getMClinic($id);
			$q="where clinic='$m_clinic' ";
		}else{
			$q="where cat='$id' ";
		}
		echo make_Combo_box($table,'name_'.$lg,'id',$q,'subSrv',0,'','onchange="selclicCatAcc(3,'.$mood.')" t');
		
	}
}?>