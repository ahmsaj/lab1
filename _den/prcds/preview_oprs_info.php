<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'],$_POST['pat'],$_POST['srv'])){
	$vis=pp($_POST['vis']);
	$pat=pp($_POST['pat']);
	$srv=pp($_POST['srv']);	
	$r=getRec('den_x_visits_services',$srv);		
	if($r['r']){
		$service=$r['service'];
		$teeth=$r['teeth'];
		$d_start=$r['d_start'];
		$status=$r['status'];
		$serDoc=$r['doc'];
		$serDoc_add=$r['doc_add'];
		$end_percet=$r['end_percet'];
		$price=$r['total_pay'];
		$serviceTxt=get_val_arr('den_m_services','name_'.$lg,$service,'srv');
		if($status==0 && $serDoc==0){$status=4;}
		$editOpr=1;
		if(_set_nukjs8og6f==0){$editOpr=0;}
		if(_set_nukjs8og6f==1){if($d_start<$ss_day){$editOpr=0;}}		
		$deOpr=1;
		if($d_start<$ss_day  && $status!=4){ $deOpr=0;}
		$teethTxt='';
		if($teeth){
			$selTeeth=$teeth;
			$tt=explode(',',$teeth);
			$teethTxt.='<div class="fr lh30 r_bord ">';
			foreach($tt as $ttt){$teethTxt.='<div class="fr l_bord pd10 fs14 ff B ">'.$ttt.'</div>';}
			$teethTxt.='&nbsp;</div>';
		}
		if($serDoc==$thisUser || $serDoc==0){?>
		<div class="fl f1 fs16 b_bord1" fix="wp:0">
			<div class="fl w100 "><? 			
				if($status==1){?>
					<div class="fr i40 i40_done" endAll title="<?=k_term_levels?>"></div><?
				}
				if(($status==1 || ($status==4 && $serDoc_add==$thisUser)) && $deOpr){?>
					<div class="fr i40 i40_del" srvDel title="<?=k_del_proce?> "></div><?
				}
				if($status==1 && $editOpr){?>
					<div class="fr i40 i40_price" srvPrice title=" <?=k_edit_price?>"></div><?
				}?>		
				<div class="fl lh40 fs16 f1 pd10 "><ff>#<?=$srv?> | </ff><?=splitNo($serviceTxt)?></div>
			</div>
			<div class="fl w100 cbg4">
				<?=$teethTxt?>
				<div class="fl cbg2 lh30 pd10 clrw ff fs14 B" dir="ltr" title="<?=k_price_serv?> ">£ <?=number_format($price)?></div>
				<div class="fl cbg66 lh30 pd10 clrw ff fs14" title="<?=k_completed_percent?> ">%<?=$end_percet?></div>				
				<div class="fl f1 pd10 fs12 lh30" style="background-color:<?=$denSrvSCol[$status]?>"><?=$denSrvS[$status]?></div>
			</div>
		</div>
		<div class="fl pd10f ofx so" fix="hp*:10|wp:0"><?
			if($status==4){
				echo '<div class="f1 lh20 fs14 clr3"> '.k_planned_at.' <ff class="fs16" dir="ltr">'.date('Y-m-d',$d_start).'</ff></div>
				<div class="f1 lh30 fs14 clr3">'.k_planned_by.': '.get_val('_users','name_'.$lg,$serDoc_add).'</div>
				<div class="fl bu2 buu bu_t4" onclick="startSrv(1)">'.k_start_proce.'</div>';
			}else{				
				$levData=array();
				$sql="select * from den_x_visits_services_levels where x_srv='$srv' order by id ASC";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows){
					$i=1;
					while($r=mysql_f($res)){
						$id=$r['id'];
						$lev=$r['lev'];
						$lev_perc=$r['lev_perc'];
						$l_status=$r['status'];
						$l_date=$r['date'];
						$l_date_e=$r['date_e'];
						$levTxt=get_val('den_m_services_levels','name_'.$lg,$lev);
						$dateS=$l_date;
						if($l_status==2){$dateS=$l_date_e;}
						if($dateS){$dateS=' <ff dir="ltr" class="fs12"> (  '.date('Y-m-d',$dateS). ')</ff>';}
						?>
						<div class="ofx b_bord uLine w100 pd10v" lev="<?=$id?>" mlev="<?=$lev?>"  srv="<?=$service?>">
							<div class="fl w100 lh30 ">
								<? if($l_status!=2){?><div class="fl i30 i30_add" levAdd title="<?=k_add_note?>"></div><?}?>
								<div class="fl lh30 f1 fs16 pd10"><?=splitNo($levTxt)?></div><?
								if($l_status!=2){?>
									<div class="fr i30 i30_done" title="<?=k_end_level?>" levDone></div><?
								}else{
									if(inThisDay($l_date_e)){?>
									<div class="fr i30 i30_res" title="<?=k_reopen_level?>" levRes></div><?}
								}?>
								<div class="cb">
									<div class="fl cbg66 lh20 pd10 clrw ff fs14">%<?=$lev_perc?></div>
									<div class="f1 fs12 pd5 lh20 fl" style="background-color:<?=$denSrvSCol[$l_status]?>"><?=$denlevS[$l_status].$dateS?></div>
								</div>
							</div><? 
							$sql2="select * from den_x_visits_services_levels_w where x_srv='$srv' and x_lev='$id' order by date ASC ";
							$res2=mysql_q($sql2);
							$rows2=mysql_n($res2);
							if($rows2>0){				
								while($r2=mysql_f($res2)){
									$l_id=$r2['id'];
									$date=$r2['date'];
									$val=$r2['val'];
									$l_status=$r['status'];									
									$desTxt=get_val_arr('den_m_services_levels_text','des',$val,'des');?>
									<div class="fl mg5v pd5 levDes" fix="wp:0">
										<div class="fl f1 fs12x lh30 pd5v">
											<? if($l_status!=2){?>
												<div class="fl i30 i30_del" title="<?=k_delete_note?>" levDel no="<?=$l_id?>"></div><?
											}?>
										<ff class="fs16 clr1 pd5"><?=date('Y-m-d',$date)?> | </ff><?=nl2br($desTxt)?></div>
									</div><?
								}							
							}else{
								echo '<div class="lh30 f1 clr111 pd10">'.k_no_notes_entered.'</div>';
							}?>							
						</div><?
						$i++;
					}
				}
			}?>
		</div><?
		}else{
			echo '<div class="f1 fs14 lh40 clr5 pd10">الخدمة مسجلة باسم طبيب أخر</div>';
		}
	}				
}?>