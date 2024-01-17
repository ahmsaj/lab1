<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['l'])){	
	$vis=pp($_POST['id']);
	$l=pp($_POST['l']);
	$sql="select * from lab_x_visits where id='$vis' order by id ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$patient=$r['patient'];
		$d_start=$r['d_start'];
		$d_check=$r['d_check'];
		$d_finish=$r['d_finish'];
		$vis_status=$r['status'];
		$doc_ord=$r['doc_ord'];
		$visit_link=$r['visit_link'];
		$mobileTxt='';
		$docAction='';
		//$lastSample=getLastSample($patient,$vis);
		if(getTotalCO('lab_x_visits_samlpes'," visit_id='$vis' and per_s=0")==0){
			autoAddSample($vis);
		}
		list($mobile,$sex,$birth)=get_val('gnr_m_patients','mobile,sex,birth_date',$patient);
		if($birth){
			$birthCount=birthCount($birth);
			$birthTxt='<div class="clr1 f1 fs12 clr5 ">
				<span class="clr55 f1 fs14">'.$sex_types[$sex].' | </span>
				<ff14> '.$birthCount[0].' </ff14> 
				<span class="f1 fs12 "> '.$birthCount[1].' </span>
			</div>';
		}else{
			$birthTxt='<div class="ic30 icc2 ic30_edit ic30Txt" onclick="editPat2('.$patient.','.$vis.');">'.k_birdat_nt_spcf.'</div>';
		}
		if($mobile){
			$mobileTxt='<div class="f1 fs12 lh30">'.k_mobile.' : </span><ff14 dir="ltr">'.$mobile.'</ff14></div>';
		}
		if($doc_ord){
			if($visit_link){
				$doc=get_val('_users','name_'.$lg,$doc_ord);
			}else{
				$doc=get_val('gnr_m_doc_req','name',$doc_ord);
			}
		}
		if($visit_link==0){$docAction='onclick="editLDoc('.$vis.')"';}
		if($doc){
			$docTxt='<div class="f1 clr3 fs12" '.$docAction.'>'.k_requester_doctor.' : '.$doc.'</div>';	
		}else{			
			$docTxt='<div class="ic30 icc2 ic30_edit ic30Txt" '.$docAction.' onclick="editPat2('.$patient.','.$vis.');">'.k_doc_nt_idntf.'</div>';
		}
		/****************************/
		$sampleArr=get_arr('lab_m_samples','id','name_'.$lg);			
		$xSrvData=array();
		$xSrv='';
		$sql="select * from lab_x_visits_services x where visit_id='$vis' ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			while($r=mysql_f($res)){
				$ser_id=$r['id'];
				$xSrvData[$ser_id]=$r;
				$service=$r['service'];
				$xSrv.=$service.',';
			}
		}
		$xSrv=rtrim($xSrv,',');
		$srvesNames=get_arr('lab_m_services','id','short_name,ch_sample',"id IN($xSrv)");
		/****************************/
		$samplData=array();
		$backUpSam=array();
		$sql="select * from lab_x_visits_samlpes  where visit_id='$vis' ";
		$res=mysql_q($sql);
		$sam_rows=mysql_n($res);
		while($r=mysql_f($res)){
			$s_id=$r['id'];	
			$samplData[$s_id]=$r;
			array_push($backUpSam,$r['per_s']);
		}
		/***********************************/
		$srvList='<div class="drag dragTop">&nbsp;</div>';
		foreach($xSrvData as $s){
			$srv_id=$s['id'];
			$ana=$s['service'];
			$srv_status=$s['status'];
			$sample_id=$s['sample'];
			$fast=$s['fast'];
			$drag='';
			$delBut='';
			$st_txt='';
			if($srv_status==0){$drag='drag';}
			if($srv_status==0 || $srv_status==2){				
				$delBut='<div class="fr i30 i30_del" delLabSrv title="'.k_cancel_ana.'"></div>';
			}
			if($srv_status==3 || $srv_status==4){				
				$delBut='<div class="fr i30 i30_res" resLabSrv title="'.k_re_ana.'"></div>';
			}
			if(in_array($srv_status,array(2,4))){
				$st_txt=' ( '.$lab_srv_status[$srv_status].' )';			
			}
			$fastTxt='';
			if($fast){
				$fastTxt='<div class="fr ic30x i30_emer"></div>';
			}
			$sampleName='('.($sampleArr[$sample_id] ?? '-').')';
			if($srvesNames[$ana]['ch_sample']){
				$sampleName='<select changeSample="'.$srv_id.'" style="width:150px" t>';
				foreach($sampleArr as $s_id=>$s_name){
					$sel='';
					if($s_id==$sample_id)$sel=' selected ';
					$sampleName.='<option value="'.$s_id.'" '.$sel.'>'.$s_name.'</option>';
				}
				$sampleName.='</select>';
			}
			$srvList.='<div class="b_bord mg10v TL pd5v fs14x lh30 '.$drag.'" sn="'.$srv_id.'" anaSt="'.$srv_status.'" title="'.$lab_srv_status[$srv_status].'">				
				'.$delBut.$srvesNames[$ana]['short_name'].$st_txt.$fastTxt.' <b> '.$sampleName.'</b> 
			</div>';
		}		
		/***********************************/
		$samList='';
		foreach($samplData as $k=>$sam){
			$tube=$sam['pkg_id'];
			$services=$sam['services'];
			$sam_status=$sam['status'];
			$full_tube=$sam['full_tube'];
			$s_no=$sam['no'];
			$per_s=$sam['per_s'];
			$editSam=0;
			$redClr='';
			if($sam_status<2){$editSam=1;}
			if($editSam){$set='set="0"';}
			$per_sTxt='';
			if($per_s){$per_sTxt='<div class="f1 clr5 lh50 pd10"> ( '.k_bu_sam.' )</div>';}
			$s_noTxt='';			
			if(_set_khbw5sn3qs && $sam_status<2 && !$s_no){$s_no=samAutoNum($k);}
			if($s_no){
				$shNo='';
				if($vis_status==1){$shNo='shNo="'.$s_no.'"';}
				$s_noTxt='<div class="fr pd10 lh50" '.$shNo.' '.$set.'><ff>#'.$s_no.'</ff></div>';
			}else{
				$s_noTxt='
				<input type="number" samin class="cbg777 fs12" placeHolder="'.k_sample_no.'" set="0">';
			}
			$fullTxt='';
			if($full_tube==1){
				$redClr='redBord';
				$fullTxt='<div class="f1 clr5 lh50 pd10"> ( '.k_sample_one_ana.' ) </div>';
			}
			if($vis_status==1){
				$tools='';
				$tools.='<div class="f1 lh40 pd10 b_bord" smo_print>'.k_print.'</div>';
				if(!in_array($k,$backUpSam)){
					$tools.='<div class="f1 lh40 pd10 b_bord" smo_del>'.k_del_sample.'</div>';
				}
				if($per_s==0 && !in_array($k,$backUpSam)){					
					$tools.='<div class="f1 lh40 pd10 b_bord" smo_bu>'.k_crt_busm.'</div>';
				}
				$dropp='';
				if($full_tube==0){$dropp='dropp';}			
				$sam_menu=' <div class="fl sam_menu" smo="'.$k.'"><div class="bord cbg2" sn="'.$k.'">'.$tools.'</div></div>';
			}			
			$samList.='<div class=" samBlc in w100 '.$redClr.'">
			<div class="fl w100 lh40 b_bord cbgw">'.$sam_menu.'
				<div class="fl">'.get_samlpViewC(0,$tube).$per_sTxt.$fullTxt.'</div>
				<div class="fr mg5v pd5" samn="'.$k.'" no="'.$s_no.'">
				'.$s_noTxt.'
				</div>
			</div>';
			if($per_s==0){
				$samList.='<div class="fl pd10f in w100 samSrv '.$dropp.'" samBlc="'.$k.'">';
				$services=$sam['services'];
				if($services){
					$srvArr=explode(',',$services);
					foreach($srvArr as $s){
						$aSrv_id=$xSrvData[$s]['id'];
						$ana=$xSrvData[$s]['service'];
						$srvStatus=$xSrvData[$s]['status'];
						$unlinkBut='';
						$drag='';
						$redClr='';
						if($vis_status==1){
							$unlinkBut='<div class="fr i30 i30_unlink mg5v " title="'.k_ana_from_sample.'" srvSam="'.$aSrv_id.'"></div>';
							$drag='dragIn';
						}
						if($full_tube==1){$drag='';}
						$ana=$xSrvData[$s]['service'];
						$samList.='<div class="b_bord mg10v TL pd5 fs14x lh40 '.$drag.'" sn="'.$aSrv_id.'">
						 '.$unlinkBut.$srvesNames[$ana]['short_name'].'
						</div>';
					}
				}
				$samList.='</div>';
			}
			$samList.='</div>';
		}
		/***********************************/
		if($l==0){
			echo $srvList.'^'.$samList;
		}else{?>
			<div class="winButts">
				<div class="wB_x fr" onclick="win('close','#full_win1');samples_ref(0)"></div>
			</div>
			<div class="win_free of">
                <div class="fxg h100" fxg="gtc:400px 1fr|gtr: calc(100vh - 45px) ">
                    <div class="of r_bord h100 fxg" fxg="gtr:auto auto 1fr">
                        <div class="fl w100 pd10f "> 
                            <div class="lh30 fs16x f1s clr1111 Over" onclick="editPat2(<?=$patient?>,<?=$vis?>);">
                                <ff class="fs16">#<?=$patient?> |  </ff><?=get_p_name($patient)?> 
                            </div><?=$birthTxt.$mobileTxt?>
                            <div class="f1 fs12 lh20"><?=k_visit_num?> : <ff14><?=$vis?></ff14></div>
                            <div class="f1 fs12 lh30"><?=$docTxt?></div>

                        </div>
                        <div class="fl w100 f1 fs14 clr1 lh40 pd10 cbg444 t_bord b_bord">
                            <div class="fr i30 i30_add mg5v" addLabSer></div>
                            <div class="i30 mg5f i30_emer fr" srvEmerg title="<?=k_emergency?>"></div>
                            <?=k_reqrd_tests?> <ff14>( <?=$rows?> )</ff14>
                        </div>
                        <div class="pd10 ofx so labSrvList"><?=$srvList?></div>
                    </div>
                    <div class="fxg" fxg="gtr:50px 1fr">
                        <div class="w100 fl lh50 b_bord cbg4">
                            <? if($vis_status==1){?>
                                <div class="i30 i30_add fl mg10v mg5" addSam title="<?=k_add_new_sample?>"></div>
                            <?}?>
                            <div class="fl lh50 pd5 f1 fs16"><?=k_sampels?> <ff>(<?=$sam_rows?>)</ff></div>
                            <? if($vis_status==1){?>
                            <div class="ic40x mg5f icc4 ic40_done fr" vlEnd title="<?=k_end?>"></div>
                            <? }?>
                            <div class="ic40x mg5f icc2 ic40_print fr" vlPrint title="<?=k_print?>"></div>
                            <div class="ic40x mg5f icc1 ic40_ref fr" onclick="openLabSWin(1,<?=$vis?>)" title="<?=k_refresh?>"></div>
                        </div>
                        <div class="w100 ofx so lh50 cbg444 pd10f" >
                            <center class="samHolder labSrvListContent" id="samHolder"><?=$samList?></center>
                        </div>
                    </div>
                </div>
			</div><?
		}
	}
}?>

