<? include("../../__sys/mods/protected.php");?>
<? $mood=6;
if(isset($_GET['m_id'])){
	$vis=pp($_GET['m_id']);
	$r=getRec('bty_x_laser_visits',$vis);
	if($r['r']){
		$doctor=$r['doctor'];
		$pat=$r['patient'];
		$d_start=$r['d_start'];
		$d_check=$r['d_check'];	
		$sub_type=$r['sub_type'];
		$status=$r['status'];
		$clinic=$r['clinic'];
        $device=$r['device'];
		$pay_type=$r['pay_type'];
		$pay_type_link=$r['pay_type_link'];
		$mac_type=$r['mac_type'];
		$emploTxt='';
		if($emplo && $pay_type==0){
			$emploTxt=' <span class="f1 fs18 lh20 clr5 ">( '.k_employee.' )</span>';
		}
		if($doctor==0){
			mysql_q("UPDATE bty_x_laser_visits SET doctor='$thisUser' where id='$vis' ");
			mysql_q("UPDATE bty_x_laser_visits_services SET doc='$thisUser' where visit_id='$vis' ");
			$doctor=$thisUser;
		}
		if($thisUser==$doctor){
			if($mac_type==0){
				$service=get_val_c('bty_x_laser_visits_services','service',$vis,'visit_id');
				$cat=get_val('bty_m_services','cat',$service);
				if($cat){mysql_q("UPDATE bty_x_laser_visits SET mac_type='$cat' where id='$vis' ");}
			}
			if($d_check==0){
				mysql_q("UPDATE bty_x_visits set d_check='$now' where id='$visit_id' ");
				mysql_q("UPDATE gnr_x_roles set doctor='$thisUser' where vis='$visit_id' and mood=6");
			}
			if($status==2 || $status==3){
				mysql_q("UPDATE gnr_x_roles set status=4 where vis='$vis' and mood='$mood'");
				if($status==3){loc('_Laser-Visit');exit;}
			}	
			$clinic=$userSubType;
			setLaserServises($vis);
			$r2=getRec('gnr_m_patients',$pat);
			$sex=$r2['sex'];
			$birth=$r2['birth_date'];
			$birthCount=birthCount($birth);			
			$p_title=$r2['title'];
			if($p_title){
				$col=getColumesData('',0,'h4ljv9q3qf');		
				$p_titleTxt=viewRecElement($col[0],$p_title);
			}
			/*******************************************/?>
			<div class="centerSideInFull of" >
				<div class="fl lp_s1 cbg1" fix="w:320|hp:0">
					<div class="lp_s1_b2 fl w100 f1 fs16 cbg4">				
						<div class="fs16" tit1><?=$p_titleTxt.' '.get_p_name($pat).$emploTxt?></div>
						<div class="lh30 cbg1"><? 
						 if($pay_type==2){				
							$name_ch=get_val('gnr_m_charities','name_'.$lg,$pay_type_link);
							echo '<div class="f1 inf_name f1 fs14 pd10" fix="h:25">'.$name_ch.' </div>';
						}?>
						</div>
					</div>				
					<div class="fl w100 lh40 cbg2 clrw f1 ">
						<div class="fl cbg3" title="<?=k_pat_wating?>" id="patWs" <?=$swAction?>>
							<div class="fl patsIco"></div>
							<div class="fl pd10 ff lh40 fs18" id="patNo">0</div>
						</div>
						<div class="fr ic40x icc2 ic40_done br0" onclick="bty_finshLsr()" finish title="<?=k_endvis?>"></div>
						<div class="fr ic40x icc33 ic40_ref br0" back title="<?=k_back_to_visits?>" onclick="loc('_Laser-Visit');"></div>
						<div class="fl ic40x icc11 ic40_vedio br0 hide" help title="<?=k_help?>"></div>
					</div>
					<div id="timeSc" class="fl w100"></div>
					<div class="fl w100 cbg2 f1 fs16 lh30 pd10 pd10v clrw w100" id="devInfo"></div>
					<div class="fl w100 lasBut">
						<? if(chProUsed('dts')){?>
							<div class="fs14 appo" act="0" onclick="selDtSrvs(<?=$clinic?>,0,<?=$pat?>)"><?=k_appointments?></div>
						<? }?>
						<div class="fs14 titr" onclick="clbir()"><?=k_titration?></div>
						<? if(modPer('2kl1y51jl8','0')){?>
						<div class="fs14 notes" onclick="lasNotes()"><?=k_notes?></div>
						<?}?>
					</div>
				</div>						
				<div class="fl cp_s3 of" fix="wp:320|hp:0" >
					<div class="inWin fl hide " fix="hp:0|wp:0">
						<div h class="fl w100 lh50 uLine">
							<div class="fr ic30x icc2 ic30_x mg10f" title="<?=k_close?>" id="exWin"></div>
							<div class="fl f1 fs18 clr55 pd10" id="iwT"></div>		
						</div>
						<div b class="fl ofxy so" fix="hp:60|wp:0" id="iwB"></div>
					</div>
					<div class="fl cbg444 lh40 w100 b_bord">				
						<div class="fl lh50 pd10 fs16x  f1 " paInfo><?=k_services?></div>
						<? if($status!=2){?>
							<div class="fr ic30x ic30_add icc4 mg10f cbg4" addLasSrv></div>
						<? }?>
						<div class="fr ic30x ic30_ref icc1 mg10v cbg4" onclick="loadLaserServ(1)"></div>
					</div>
					<div class="fl pd10f ofx so " fix="wp:0|hp:50" id="lsrSerDet"></div>
				</div>			
			</div><?
		}else{
			$status=get_val('bty_x_laser_visits','status',$vis);
			if($status==2 || $status==3){delTempOpr($mood,$visit_id,'a');}
			loc('_Laser-Visit');
		}
	}
}
?>
<script>
	var visit_id=parseInt(<?=$vis?>);
	var patient_id=<?=$pat?>;	
	$(document).ready(function(e){setLasVisit();});	
</script>