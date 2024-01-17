<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'])){
	$id=pp($_POST['vis']);
	$r=getRec('cln_x_visits',$id);
	if($r['r']){
		$pay_type=$r['pay_type'];
		$vis_status=$r['status'];
		$sql="select * from cln_x_visits_services where visit_id='$id' order by id ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);?>
		<div class="fl cp_tit_srv">
			<div class="fl cp_headIcon"></div>
			<div class="fl cp_tit_srv_1 fl  f1 fs16 lh50 " fix="wp:50"><?=k_rq_srv?></div>
			<div class="fl  f1 fs14 clrw pd10"><?=k_srvcs_num?> : <ff class="fs16"> ( <?=$rows?> )</ff></div>
		</div>
		<div class="fl w100 lh40 cbg3 clrw f1">
			<div class="fl pd10 f1 fs14"><?=k_services?></div>
			<? if($vis_status==1){?>
			<div class="fr ic40x icc11 ic40_done br0" doneAll title="<?=k_termin_all_ser?>"></div>
			<div class="fr ic40x icc33 ic40_add br0" addSrv title="<?=k_add_ser?>"></div>
			<? }?>			
		</div>
		<div class="fl ofx so pd10f cp_srvList" fix="hp:110|wp:0"><?
		while($r=mysql_f($res)){
			$s_id=$r['id'];
			$rev=$r['rev'];
			$s_status=$r['status'];
			$pay_net=$r['pay_net'];			
			$srv=$r['service'];
			list($s_time,$edit_price,$srvTxt)=get_val('cln_m_services','ser_time,edit_price,name_'.$lg,$srv);
			$s_time=$s_time*_set_pn68gsh6dj*60;			
			$revTxt='';
			if($rev){$revTxt=' <span class="f1 fs12 clr5"> ( '.k_review.' )</span>';}
			$cancelSrv=1;
			$actRows=getTotalCO('cln_x_visits_services',"visit_id='$id' and status not in(4)");
			if($pay_type==3){
				$cancelSrv=0;
				$ins_status_txt='';
				$res_status=get_val_con('gnr_x_insurance_rec','res_status',"service_x='$s_id' and mood=1 ");
				if($res_status!=''){
					if($res_status==0){$cls=' cbg888 clr88 '; $inTitle=k_in_wait;}
					if($res_status==1){$cls=' cbg666 clr66 '; $inTitle=k_accept;}
					if($res_status==2){$cls=' cbg555 clr55 '; $inTitle=k_reject;$cancelSrv=1;}
					$ins_status_txt='<div class="f1 fs12 pd5f '.$cls.'">'.k_insurance_status.' : '.$inTitle.'</div>';
				}else{
					$cancelSrv=1;
				}
			}
			/***********************/
			$cnclTxt='';
			$resTxt='';
			$priceChange='';
			$endTxt='';
			if($vis_status==1){
				if($s_status==0 || ($s_status==2 
				&& _set_ruqswqrrpl==1)
				&&($edit_price==0 || $pay_net)){
					$endTxt='<div class="i30 i30_done fr" done title="'.k_ed_srv.'" ></div>';
				}
				if(($s_status==0 || $s_status==2 ) && $cancelSrv){
					$cnclTxt='<div class="i30 i30_del fr" cancel title="'.k_cncl_serv.'"></div>';
				}
				if($s_status==4 || $s_status==1 || ($s_status==5 && _set_ruqswqrrpl==1)){
					$resTxt='<div class="i30 i30_res fr" res title="'.k_rt_srv.'"></div>';
				}
				
				if($edit_price==1 && ($s_status==0 || $s_status==2)){					
					$priceChange='<div class="i30 i30_price fr" price " title="'.k_set_price.'"></div>';
					if($pay_net){
						$priceChange.='<div class="lh30 fr clr5 ff B fs18 pd10" title="'.k_price_serv.'">'.number_format($pay_net).'</div>';
					}
				}
				
			}			
			/*********************************/
			$txtStatus=$cln_srv_status_Tex[$s_status];
			if($s_status==2 && _set_ruqswqrrpl==0){$txtStatus=k_waiting_service_cost;}
			echo '<div sn="'.$s_id.'">
				<div class="mg10 f1 fs14 clr1" tit>'.$srvTxt.$revTxt.$ins_status_txt.'</div>
				<div class="pd10 lh30 fs16 ff B b_bord clr9" >'.dateToTimeS2($s_time)					.$endTxt.$resTxt.$cnclTxt.$priceChange.'</div>
				<div class="pd10 f1 lh30 clr2" style="background-color:'.$cln_srv_status_color[$s_status].'">'.$txtStatus.'</div>
			</div>';
		}?>
		</div><?
	}
}?>