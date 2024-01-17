<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){	
	$id=pp($_POST['id']);
	$r=getRec('gnr_x_prescription_itemes',$id);	
	if($r['r']){		
		$mad_id=$r['mad_id'];
		//$type=$r['type'];
		$dose=$r['dose'];
		$num=$r['num'];
		$dur=$r['duration'];
		$dose_s=$r['dose_s'];
		list($name,$type)=get_val('gnr_m_medicines','name,type',$mad_id);
		if(!$type){$type=0;}
		if(!$dose){$dose=0;}
		if(!$num){$num=0;}
		if(!$dur){$dur=0;}
		if(!$dose_s){$dose_s=0;}

		/*if($type)$type_t=get_val('gnr_m_medicines_doses_type','name_'.$lg,$type);
		if($dose)$dose_t=get_val('gnr_m_medicines_doses','name_'.$lg,$dose);
		if($num)$num_t=get_val('gnr_m_medicines_times','name_'.$lg,$num);
		if($dur)$dur_t=get_val('gnr_m_medicines_duration','name_'.$lg,$dur);*/?>
		<div class="win_body">
			<div class="form_header f1 fs16 clr1 lh50">
				<div class="fr ic40x icc2 ic40_save" onclick="alertDefWay(<?=$id?>)" title="<?=k_save?>"></div>
				<?=splitNo($name)?>
			</div>
			<div class="form_body of h100" type="pd0">			
				<div class="fxg h100 of" fxg="gtc:1fr 1fr 1fr 1fr|gtr:100%">
					<div class="r_bord pd10 h100 fxg" fxg="gtr:60px 1fr">
						<div class="f1 fs18 lh50 uLine"><?=k_dosage?>
							<? if(modPer('f0p4ukhef3',1)){?>
							<div class="fr ic40x icc4 ic40_add mg5v" onclick="addWay(1,<?=$id?>,<?=$type?>)" title="<?=k_add?>"></div>
							<? }?>
						</div>
						<div class="ofx so listStyle" actButt="act" aw1><?=getWayItems(1,$dose,$type)?></div>					
					</div>
					
					<div class="r_bord pd10 h100 fxg" fxg="gtr:60px 1fr">
						<div class="f1 fs18 lh50 uLine"><?=k_num_of_tim?>
							<? if(modPer('unrcedqkiw',1)){?>
							<div class="fr ic40x icc4 ic40_add mg5v" onclick="addWay(2,<?=$id?>,0)" title="<?=k_add?>"></div>
							<? }?>
						</div>
						<div class="ofx so listStyle" actButt="act" aw2><?=getWayItems(2,$num)?></div>
					</div>
					
					<div class="r_bord pd10 h100 fxg" fxg="gtr:60px 1fr">
						<div class="f1 fs18 lh50 uLine"><?=k_dosage_status?>
							<? if(modPer('opq6mby80',1)){?>
							<div class="fr ic40x icc4 ic40_add mg5v" onclick="addWay(4,<?=$id?>,0)" title="<?=k_add?>"></div>
							<? }?>
						</div>
						<div class="ofx so listStyle" actButt="act" aw4><?=getWayItems(4,$dose_s)?></div>
					</div>
					
					<div class="pd10 h100 fxg" fxg="gtr:60px 1fr">
						<div class="f1 fs18 lh50 uLine"><?=k_duration?>
							<? if(modPer('dljevd1mta',1)){?>
							<div class="fr ic40x icc4 ic40_add mg5v" onclick="addWay(3,<?=$id?>,0)" title="<?=k_add?>"></div>
							<? }?>
						</div>
						<div class="ofx so listStyle" actButt="act" aw3><?=getWayItems(3,$dur)?></div>
					</div>
				</div>
			</div>
			<div class="form_fot fr">
				<div class="bu bu_t3 fl" onclick="save_way(1,<?=$id?>)"><?=k_save?></div>
				<div class="bu bu_t2 fr" onclick="win('close','#m_info3')"><?=k_cancel?></div>
			</div>
		</div><?
	}
	
}?>
