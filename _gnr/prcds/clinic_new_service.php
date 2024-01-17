<? include("../../__sys/prcds/ajax_header.php");?>
<div class="win_body">
<div class="form_header lh50"><input type="text" id="nd_c" fw /></div>
<div class="form_body so"><?
if(isset($_POST['t'])){
	$t=pp($_POST['t']);
	$sql="select * from gnr_m_clinics where act=1 and type NOT IN (2) and linked=0 order by type ASC , ord ASC";
	if($t==1){
		if(_set_p7svouhmy5){
			$serClinic=$_SESSION['po_clns'];
		}else{
			$serClinic=get_val('_users','subgrp',$thisUser);
		}
		$actVisClinic=getActVisClinc(0,$serClinic,1);
		$x_clinic=array();
		$sql="select clic from gnr_x_arc_stop_clinic where e_date=0";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){while($r=mysql_f($res)){$clic=$r['clic'];array_push($x_clinic,$clic);}}
		/*********************************************************************************/
		$sql="select * from gnr_m_clinics where act=1 and linked =0 order by type ASC , ord ASC";
	}
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$act_type=0;
		$den_type=0;
		echo '<section  w="80" m="6" c_ord>';
		while($r=mysql_f($res)){
			$c_id=$r['id'];
			$name=$r['name_'.$lg];
			$photo=$r['photo'];
			$type=$r['type'];
			$ph_src=viewImage($photo,1,80,80,'img','clinic30.png');
			/****************************/
			if($t==1){
				$x_style=0;if(in_array($c_id,$x_clinic)){$x_style=1;}		
				$w_time='';
				if($actVisClinic[$c_id]['n']){
					$w_time=' <span class="ff B fs14">( '.clockStr($actVisClinic[$c_id]['t'],0).' 
					<span class="ff B fs14">/ '.$actVisClinic[$c_id]['n'].' )</span>';
				}
				$x_style=0;
				if(in_array($c_id,$x_clinic)){$x_style=1;}
				if($x_style==0){
					if(checkWorkingClinic($c_id)==0){$x_style=2;}
				}
				$w_time='&nbsp;';
				if($type==4){$teethClin=1;$name=k_dentistry;}
				if($actVisClinic[$c_id]['n']){
					$w_time=clockStr($actVisClinic[$c_id]['t'],0).' | '.$actVisClinic[$c_id]['n'];
				}
				$action='';
				if($x_style!=1){$action='onclick="loadClinic('.$c_id.','.$type.',\''.$name.'\','._set_gypwynoss.')"';}else{	
					$action='onclick="dateSc('.$c_id.',\''.$name.'\')"';
				}
			}			
			/****************************/
			if($type!=4 || ($type==4 && $den_type==0)){
				if($act_type!=$type){			
					//echo '<div class="cb f1 clr1 lh40 fs18 uLine">'.$clinicTypes[$type].'</div>';
					$act_type=$type;
					if($type==4){$den_type=1;}
				}
				if($t==1){
					$blc='
					<div style="border-bottom:12px '.$clinicTypesCol[$type].' solid" class="cli_blc of fl " s="x'.$x_style.'" Ctxt="'.$name.'"   type="n" '.$action.' c_ord >';
					if($x_style==1){$blc.='<div class="x_clinic f1">'.k_clnc_clsd.'</div>';}

					$blc.='
					<div class="cli_icon2 TC">'.$ph_src.'</div>				
					<div class="fs12 f1 cli_name2 TC lh20 clr1111">'.$name.'</div>
					<div class="ff TC lh20 B">'.$w_time.'</div>
					</div>';					
				}else{
					$blc='
					<div style="border-bottom:12px '.$clinicTypesCol[$type].' solid" class="cli_blc of fl" type="n" c_ord Ctxt="'.$name.'"  no="'.$c_id.'">
						<div class="cli_icon4 TC">'.$ph_src.'</div>				
						<div class="fs12 f1 cli_name2 TC lh20 clr1111">'.$name.'</div>
					</div>';
				}
				echo $blc;
			}
		}
		echo '</section>';
	}
}?>
</div>
<div class="form_fot fr">
	<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_cancel?></div>
	</div>
</div>





