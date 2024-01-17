<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['p_id'] , $_POST['v_id'] , $_POST['t']) ){
	$p_id=pp($_POST['p_id']);
	$v_id=pp($_POST['v_id']);
	$t=pp($_POST['t']);
	if($t){?><div class="win_body"><div class="form_body so" type="full"><? }
	$q='';
	if(_set_prtba6023==0){$q=" and doctor='$thisUser' ";}	
	$sql="select * from bty_x_visits where patient='$p_id' $q order by d_start DESC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		if($t){echo '
		<div class="f1 fs18 lh40">'.get_p_name($p_id).' <ff>( '.$rows.' )</ff> </div>
		<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" type="static">
		<tr><th width="30">#</th><th>'.k_date.'</th><th>'.k_status.'</th><th width="40"></th></tr>';}else{
			echo '<div class="f1 fs18 clr1 uLine lh40"> '.k_vis_no.'  : <ff>'.$rows.'</ff></div>';
		}
		$lastDay=0;
		while($r=mysql_f($res)){
			$id=$r['id'];			
			$d_start=$r['d_start'];
			$d_finish=$r['d_finish'];
			$status=$r['status'];			
			$doctor=$r['doctor'];						
			$v_date=dateToTimeS2_array($d_start);			
			$note=$r['note'];				
			
			if($t){
				echo '<tr>				
				<td><ff>'.$id.'</ff></td>
				<td><ff>'.date('Y-m-d',$d_start).'</ff></td>
				<td><span  class="f1 fs14" style="color:'.$stats_arr_col[$status].'">'.$stats_arr[$status].'</span></td>
				<td><div class="info_icon" title="'.k_visit_details.'" onclick="showVd('.$id.',0)"></div></td>
				</tr>';
			}else{
				echo '<div class="f1 fs16 clr1 lh40"><ff>#'.$id.' | '.date('Y-m-d',$d_start).'</ff> | '.k_specialist.' : '.get_val('_users','name_'.$lg,$doctor).' </div>';

				$sql2="select * from bty_x_visits_services where visit_id='$id' order by d_start DESC";
				$res2=mysql_q($sql2);
				 $rows2=mysql_n($res2);
				if($rows2>0){					
					echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" type="static">
					<tr><th>'.k_service.'</th><th>'.k_notes.'</th></tr>';
					while($r2=mysql_f($res2)){
						$srv_id=$r2['id'];
						$service=$r2['service'];					
						list($cat,$ser_name)=get_val('bty_m_services','cat,name_'.$lg,$service);
						$cat_name=get_val('bty_m_services_cat','name_'.$lg,$cat);
						$note=$r2['note'];
						echo '
						<tr><td txt>'.$cat_name.' ( '.$ser_name.' )</td><td>'.$note.'</td></tr>';
					}
					echo '</table>';
				}
           
			}
		}
		if($t){echo '</table>';
		}
	}else{
		echo '<div class="f1 fs18 clr5">'.k_npat_prv_pre.'</div>';
	}
	if($t){?></div>
    <div class="form_fot fr">
        <div class="bu bu_t2 fr" onclick="win('close','#m_info')"><?=k_close?></div>
    </div>
    </div><? }
}?>