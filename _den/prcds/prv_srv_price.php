<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$r=getRec('den_x_visits_services',$id);
	if($r['r']){
		$doc=$r['doc'];
		$service=$r['service'];
		$total_pay=$r['total_pay'];
		$status=$r['status'];
		$d_start=$r['d_start'];
		fixDenLevPrices($id);
		$editOpr=1;		
		if(_set_nukjs8og6f==0){$editOpr=0;}
		if(_set_nukjs8og6f==1){if($d_start<$ss_day){$editOpr=0;}}
		if($editOpr || $thisGrp=='hrwgtql5wk'){
			if((($doc==$thisUser || $doc==0) && $status!=4)||$thisGrp=='hrwgtql5wk'){?>
				<div class="fl bord cbg444 mg20f pd20f br5">
                    <div class="f1 lh40 clr1 fs16 "><?=get_val('den_m_services','name_'.$lg,$service)?></div>
                    <div class="lh40 clr5 f1 fs14"><?=k_price_dnt_chng_cls_win?></div>
                    <div><input id="srvDPrice" value="<?=$total_pay?>" type="number"/></div>
                    <div class="ic40 ic40_save icc2 ic40Txt mg20v" saveSrvPrice><?=k_save?></div>
                    <div class="cb lh1"></div>
				</div><?
			}
		}
	}
}?>