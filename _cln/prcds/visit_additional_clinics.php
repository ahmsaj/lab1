<? include("../../__sys/prcds/ajax_header.php");?>
<div class="win_body">
<div class="form_header"><div class="f1 fs18"><?=$p_name?></div></div>
<div class="form_body so"><?
$dayNo=date('w');
$x_doctor=array();
$date=date('Y-m-d');
/*********************************************************************************/
$x_clinic=array();
$sql="select clic from gnr_x_arc_stop_clinic where e_date=0 ";
$res=mysql_q($sql);
$rows=mysql_n($res);
if($rows>0){while($r=mysql_f($res)){$clic=$r['clic'];array_push($x_clinic,$clic);}}
/*********************************************************************************/
$labClnic=0;
/*********************************************************************************/
$user_clinic=get_val('_users','subgrp',$thisUser);
$actVisClinic=getActVisClinc(0,$user_clinic,1);
$sql="select * from gnr_m_clinics where act=1 and id not IN($user_clinic) order by ord ASC";
$res=mysql_q($sql);
$rows=mysql_n($res);
if($rows>0){
	echo '<section  w="80" m="8" c_ord>';
    while($r=mysql_f($res)){
	    $c_id=$r['id'];
		$name=$r['name_'.$lg];
		$photo=$r['photo'];
		$type=$r['type'];			
		$ph_src=viewImage($photo,1,80,80,'img','clinic30.png');
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
		if($actVisClinic[$c_id]['n']){
			$w_time=clockStr($actVisClinic[$c_id]['t'],0).' | '.$actVisClinic[$c_id]['n'];
		}
		$action='';
		if($x_style!=1){$action='onclick="loadClinic('.$c_id.','.$type.',\''.$name.'\','._set_gypwynoss.')"';}			
		$blc='
		<div class="cli_blc of fl " s="x'.$x_style.'" type="n" '.$action.' c_ord >';
		if($x_style==1){$blc.='<div class="x_clinic f1">'.k_clnc_clsd.'</div>';}

		$blc.='
		<div class="cli_icon2 TC">'.$ph_src.'</div>				
		<div class="fs12 f1 cli_name2 TC lh20 clr1111">'.$name.'</div>
		<div class="ff TC lh20 B">'.$w_time.'</div>
		</div>';		
		echo $blc;	
    }
	echo '</section>';
}
?>
</div>
<div class="form_fot fr">
	<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>
	</div>
</div>