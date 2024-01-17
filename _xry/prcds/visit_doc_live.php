<? include("../../__sys/prcds/ajax_header.php");
$mood=3;
$stopAlert='';
$limitPatData='';
echo clinicOpr_icons($mood);
echo '^';
echo clinicOpr_docStatus($mood);
echo '^';
echo clinicOpr_waiting($mood);
echo '^';
if(chProUsed('dts')){echo clinicOpr_DTS($mood);}
echo '^';
echo $limitPatData;
echo $stopAlert;
echo clinicOpr_alerts($mood);
echo '^';
$sql="select * from xry_x_visits_services where `status`=6  order by id ASC";
$res=mysql_q($sql);
$rows=mysql_n($res);
if($rows>0){
	while($r=mysql_f($res)){
		$s_id=$r['id'];
		$clinic=$r['clinic'];
		$patient=$r['patient'];
		$d_start=$r['d_start'];
		$status=$r['status'];
		$service=$r['service'];
		$doc=$r['doc'];
		$docName='';	
		$cbg='cbg2';
		$action= 'xry_erep('.$s_id.',0)';
		if($doc){				
			if($doc==$thisUser){				
				$docName='';
				$cbg='cbg6';
			}else{
				$docName=k_doctor.' : '.get_val('_users','name_'.$lg,$doc);
				$action='';
				$cbg='cbg5';				
			}
		}
		$status_txt='';
		$r_time=' <ff> '.dateToTimeS2($now-$d_start).' </ff>';
		$srvTxt=get_val_arr('xry_m_services','name_'.$lg,$service,'s');
		$clinicTxt=get_val_arr('gnr_m_clinics','name_'.$lg,$clinic,'c');
		if($thisGrp=='nlh8spit9q'){			
			echo'
			<div class="fl w100 bord cbgw ">				
				<div class="lh40 fl w100 b_bord cbg3 clrw">
					<div class="fl r_bord lh40 TC '.$cbg.'" dir="ltr" fix="w:100">'.$r_time.'</div>
					<div class="fl f1 fs16 lh40 pd10 fl TC " fix="wp:141">'.$clinicTxt.'</div>';
					if($action){
						echo '<div class="fr ic40x icc1 ic40_det" title="'.k_write_the_report.'" onclick="'.$action.'"></div>';
					}
				echo '</div>
				<div class="f1 fs14 lh40 pd10  TC b_bord">'.$docName.'</div>
				<div class="f1 fs16 lh40 TC b_bord">'.get_p_name($patient).'</div>				
				<div class="lh40 fl w100 b_bord ">
					<div class="fl lh40 TC " fix="w:80"><ff>'.$s_id.'</ff></div>
					<div class="f1 l_bord fs16 lh40 pd10 fl TC" fix="wp:81">'.$srvTxt.'</div>
				</div>				
			</div>
			<div>&nbsp;</div>';
		}
		if($thisGrp=='1ceddvqi3g'){
			echo'
			<div class="fl w100 bord cbg4 ">				
				<div class="lh40 fl w100 b_bord cbg3 clrw">
					<div class="fl r_bord lh40 TC cbg2" dir="ltr" fix="w:100">'.$r_time.'</div>
					<div class="fl f1 fs16 lh40 pd10 fl TC " fix="wp:101">'.$clinicTxt.'</div>
				</div>
				<div class="f1 fs16 lh40 TC b_bord">'.get_p_name($patient).'</div>
				<div class="f1 fs14 lh40 pd10  TC b_bord">'.$docName.'</div>				
				<div class="lh40 fl w100 b_bord ">
					<div class="fl lh40 TC " fix="w:80"><ff>'.$s_id.'</ff></div>
					<div class="f1 l_bord fs16 lh40 pd10 fl TC" fix="wp:81">'.$srvTxt.'</div>					
				</div>				
			</div>
			<div>&nbsp;</div>';
		}
	}    
}?>