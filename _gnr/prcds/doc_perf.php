<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$r=getRec('gnr_r_docs_details',$id);
	if($r['r']){
		$ch1='checked';
		$type=1;
		if($r['done']){			
			if($r['_vacation']){$type=2;$ch2='checked';}
			if($r['_absent']){$type=3;$ch3='checked';}
			if($r['_vacation']==0 && $r['_vacation_hrs']){$type=4;$ch4='checked';}
		}?>		
		<form name="doc_perf" id="doc_perf" action="<?=$f_path?>X/gnr_doc_perf_save.php" method="post" cb="loadModule('en4rux2ooi')" >
		<input type="hidden" name="id" value="<?=$id?>" />
		<div class="win_body">
		<div class="form_header"></div>
		<div class="form_body of" type="static">			
			<div class="fl of" fix="wp:0|hp:0">			
				<div class="fl of" fix="w:250|hp:0">
					<div class="fl so" fix="wp:10|hp:0">
						<div class="lh40 fs18 f1 uLine clr5"><?=k_doctor?> : <?=get_val('_users','name_'.$lg,$r['doc'])?></div>
						<div class="lh30 fs16 f1 cb"><?=k_date?> : <ff class="clr5" dir="ltr"><?=date('Y-m-d',$r['date'])?></ff></div>
						<div class="lh30 fs16 f1 cb"><?=k_imposed_time?> : <ff class="clr1"><?=minToHour($r['estimated'])?></ff></div>
						<div class="lh30 fs16 f1 cb"><?=k_vis_no?> : <ff class="clr1"><?=$r['v_total']?></ff></div>
						<div class="lh30 fs16 f1 cb"><?=k_srvcs_num?> : <ff class="clr1"><?=$r['s_total']?></ff></div>
					</div>
				</div>
				<div class="fl l_bord" fix="wp:251|hp:0">
					<div class="fl so pd10" fix="wp:20|hp:0">						
						<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" over="0" >
						<tr><td txt><?=k_imposed_time?>: </td><td><?=getMintInput('estimated',$r['estimated'])?></td></tr>
						<tr><td txt> <?=k_AM?> : </td><td><?=getMintInput('morning_hours',$r['morning_hours'])?></td></tr>
						<tr><td txt colspan="2"><div class="f1 fs18 fl clr1"><?=k_vac_and_absnc?></div></td></tr>
						<tr><td txt><?=k_procedure?>  : </td><td>
						<div class="radioBlc so fl" name="type"  req="1" par="dayType">
							<input type="radio" name="type" value="1" <?=$ch1?> ><label> <?=k_norm_day?></label>
							<input type="radio" name="type" value="2" <?=$ch2?> ><label><?=k_vacation?></label>
							<input type="radio" name="type" value="3" <?=$ch3?> ><label><?=k_absnc?></label>
							<input type="radio" name="type" value="4" <?=$ch4?> ><label><?=k_hour_vac?></label>
						</div>
						</td></tr>
						<tr v v1 v4><td txt><?=k_actual_times?>: </td><td><?=getMintInput('actual',$r['_actual'])?></td></tr>
						<tr v v4 class="hide"><td txt><?=k_hour_vac_time?>  : </td><td> <?=getMintInput('vaca',$r['_vacation_hrs'])?></td></tr>			
						<tr v v1 v4><td txt><?=k_dely?> : </td><td><?=getMintInput('late',$r['_delay'])?></td></tr>
						
						<tr v v1 v4><td txt colspan="2"><div class="f1 fs18 fl clr1"><?=k_additional?></div></td></tr>						
						<tr v v1 v4><td txt><?=k_norm_add?> : </td><td> <?=getMintInput('over',$r['_overtime_normal'])?></td></tr>		
						<tr v v1 v4><td txt><?=k_othrs_add?> : </td><td><?=getMintInput('over2',$r['_overtime'])?></td></tr>
						
						<tr><td txt colspan="2"><div class="f1 fs18 fl clr1"> <?=k_operations?></div></td></tr>						
						<tr><td txt><?=k_opers_no?>   : </td><td><input type="number" name="opr" value="<?=$r['_operations']?>"></td></tr>
						<tr><td txt><?=k_oprs_val?>: </td><td><input type="number" name="oprAmount" value="<?=$r['_operatons_amount']?>"></td></tr>						
						</table>
					</div>
				</div>
				
			</div>			
		</div>
		<div class="form_fot fr">
			<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>
			<div class="bu bu_t3 fl" onclick="sub('doc_perf');"><?=k_save?></div>
			
		</div>
		</div>
		</form><?=script('vewiwDP('.$type.');');
	}	
}?>