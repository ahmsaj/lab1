<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);?>
	<div class="win_body">
	<div class="form_header so lh40 clr1 f1 fs18"><?=get_p_name($id)?> ( <?=k_trtmnt_procs?>   )

	<div class="fr ic40 icc4 ic40_ref" onclick="patRecDen(<?=$id?>)"></div>
	</div>
	<div class="form_body so">
		<?
		$sql="select * from den_x_visits_services where patient = '$id' and status IN(0,1,2) order by d_start ASC ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows){
			$levelData=array();
			$sql2="select * from den_x_visits_services_levels where patient = '$id' and status in(0,1,2) order by id ASC";
			$res2=mysql_q($sql2);
			while($r2=mysql_f($res2)){
				$l_id=$r2['id'];
				$l_x_srv=$r2['x_srv'];
				$levelData[$l_id]['lev']=$r2['lev'];
				$levelData[$l_id]['status']=$r2['status'];
				$levelData[$l_id]['date_e']=$r2['date_e'];
				$levelData[$l_id]['doc']=$r2['doc'];
				$levelData[$l_id]['x_srv']=$r2['x_srv'];
			}
			$i=1;
			while($r=mysql_f($res)){
				$s_id=$r['id'];
				$clinic=$r['clinic'];
				$service=$r['service'];
				$teeth=$r['teeth'];
				$doc=$r['doc'];
				$status=$r['status'];
				$d_start=$r['d_start'];
				$d_finish=$r['d_finish'];
				$srv_name=splitNo(get_val_arr('den_m_services','name_'.$lg,$service,'ds'));
				$doc_name=get_val_arr('_users','name_'.$lg,$doc,'dor');
				$dateTxt=' | '.k_started.' <ff class="fs14" dir="ltr">'.date('Y-m-d',$d_start).'</ff>';
				if($teeth){$teeth=' | '.k_teeth.' <ff class="fs14 "> ( '.$teeth.' )</ff>';}
				if($d_finish){$dateTxt.=k_finish.'  <ff class="fs14" dir="ltr">'.date('Y-m-d',$d_finish).'</ff>';}?>
				<div class="uLine">
				<div class="f1 fs16 lh20 clr1"><?='<ff>'.$i.' - </ff>'.$srv_name.' : '?></div>
					<div class="f1 fs12 lh20 pd150 clr55"><?=k_dr.'  : '.$doc_name.$dateTxt.$teeth?></div>
					<div class="f1 fs14 lh20 pd10 clr1111">- <?=k_levels?> :</div>
					<?
					foreach($levelData as $l){
						if($l['x_srv']==$s_id){
							$levName=get_val('den_m_services_levels','name_'.$lg,$l['lev']);
							if($l['date_e']){
								$l_e_date=date('Y-m-d',$l['date_e']);
								$l_e_dateTxt='<ff class="fs12" dir="ltr">'.$l_e_date.'</ff> | ';
							}
							$stsTxt='';
							$status=$l['status'];
							if($status!=2){
								$stsTxt=' <span class="fs10">( '.$denSrvS_His[$status].' )</span> ';
								$l_e_dateTxt='';
							}
							echo '<div class="f1 lh20 mg10 '.$denSrvS_HisClr[$status].'">
							- '.$l_e_dateTxt.$levName.$stsTxt.'</div>';
						}
					}
					?>
				</div><?
				$i++;
			}
		}

		?>
	</div>
	<div class="form_fot fr">
		<div class="bu bu_t2 fr" onclick="win('close','#m_info3');"><?=k_close?></div>     
	</div>
	</div><?
}?>