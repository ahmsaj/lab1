<? include("../../__sys/mods/protected.php");?>
<?
$ok=1;
if(_set_tauv8g02){
	if($thisGrp=='pfx33zco65'){		
		if(!$_SESSION['po_id']){
			echo header_sec($def_title);
			$ok=0;
			echo '<div class="centerSideIn of">
			<div class="f1 fs18 clr5 lh40">'.k_site_choose_to_show_alerts.'</div>
			<div class="bu buu bu_t3 fl" onclick="changPoint(0)">'.k_site_sel.'</div>
			</div>';
		}else{
			$pointName=get_val('gnr_m_resp_points','name_'.$lg,$_SESSION['po_id']);
			$pointTxt='<div class="clr5 lh20 f1 Over" onclick="changPoint(0)">'.k_recep_point.' : '.$pointName.'</div>';
		}
	}
}
if($ok){
$headerBut.='|action:'.k_daily_schedule.':ti_work_time:dateSc(0);';
$headerBut.='|action:'.k_role_info.':ti_role:showRole();';
$headerBut.='|action:'.k_service_offer_sell.':ti_offer:newPatOffer();';
$headerBut.='|action:'.k_tickt.':ti_tickt:opentick();';
if(modPer('b8kpe202f3','0')){$headerBut.='|action:'.k_documents.':ti_docs:patDocs(0,1)';	}
$headerBut.='|action:'.k_account_stats.':ti_pay:patPayDir();';
if(_set_gypwynoss==1){$headerBut.='|action:'.k_card.':ti_card:openCard()';}
if(chProUsed('dts')){$headerBut.='|action:'.k_appointments.':ti_date:newCinic(2);';}
$headerBut.='|action:.'.k_waiting.':ti_wait:newCinic(1);';
echo header_sec($def_title.$pointTxt,$headerBut);
fixCasherData($thisUser);
fixCasherBalans($thisUser);
//<div class=" ti_0 fr" onclick="open_Tools();"></div>
$class=' class="f1 fs16 clr1 lh40 uLine TC cbg44" ';
?>
<div class="centerSideIn of">	
	<div class="clicListInTitle fr" ></div>
	<div class="fl bord" fix="wp:0|hp:70" id="res_tap1">		
		<div class="fl r_bord" fix="hp:0|wp%:20">
			<div <?=$class?>><?=k_incomplete?></div>
			<div class="ofx so pd10 tapL_11"fix="hp:50"></div>
		</div>
		<div class="fl r_bord" fix="hp:0|wp%:20">
			<div <?=$class?>><?=k_insure_reqs?></div>
			<div class="ofx so pd10 tapL_12"fix="hp:50"></div>
		</div>
		<div class="fl r_bord" fix="hp:0|wp%:20">
			<div <?=$class?>><?=k_charities?> + <?=k_exemptions?></div>
			<div class="ofx so pd10 tapL_13"fix="hp:50"></div>
		</div>
		<div class="fl r_bord" fix="hp:0|wp%:20">
			<div <?=$class?>><?=k_drs_reqs?></div>
			<div class="ofx so pd10 tapL_14"fix="hp:50"></div>
		</div>
		<div class="fl " fix="hp:0|wp%:20">
			<div <?=$class?>><?=k_alerts?></div>
			<div class="ofx so pd10 tapL_15"fix="hp:50"></div>
		</div>		
	</div>	
	<div class="fl hide bord" fix="wp:0|hp:70" id="res_tap2">
		<div class="fl " fix="hp:0|wp:250">			
			<div class="ofx so tapL_21 pd5" fix="hp:0"></div>
		</div>
		<div class="fl l_bord" fix="hp:0|w:250">
			<div <?=$class?>><?=k_recent_appoints?></div>
			<div class="ofx so pd10 tapL_22" fix="hp:50"></div>
		</div>
	</div>
	<div class="fl hide bord" fix="wp:0|hp:70" id="res_tap3">
		<div class="fl r_bord" fix="hp:0|wp:250">
			<div <?=$class?>><?=k_partial_alerts?></div>
			<div class="ofx so pd10 tapL_31"fix="hp:50"></div>
		</div>
		<div class="fl " fix="hp:0|w:250">
			<div <?=$class?>><?=k_alerts?></div>
			<div class="ofx so pd10 tapL_32" fix="hp:50"></div>
		</div>
	</div>
	
</div>
<script>sezPage='Resp';$(document).ready(function(e){
	res_ref(1);refPage(3,5000);
});
	</script>
<? }?>