<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	?>
	<div class="win_body">
	<div class="form_header lh40 f1 fs18 clr1"></div>
	<?
	$sql="select * from lab_x_visits_samlpes where no='$id' limit 1";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);	
		$sam_id=$r['id'];
		$visit_id=$r['visit_id'];
		$pkg_id=$r['pkg_id'];
		$services=$r['services'];
		$no=$r['no'];
		$date=$r['date'];
		$take_date=$r['take_date'];
		$status=$r['status'];
		$rack=$r['rack'];
		$rack_pos=$r['rack_pos'];
		$per_s=$r['per_s'];
		$out_lab=$r['out_lab'];
		$perTxt='';
		if($per_s){
			$per_s_no=get_val('lab_x_visits_samlpes','no',$per_s);		
			$perTxt='<span class="f1 clr5 fs14 Over" onclick="veiwSamplInfo('.$per_s_no.')">'.k_bu_sm_sm.' <ff>( '.$per_s_no.' )</ff></span>';
		}?>
        <div class="form_head so">
		<div class="fl">
		<div class="fl"><?=get_samlpViewC('x',$pkg_id,1)?></div>
            <div class="fl f1 fs20 lh50"><?=get_val('lab_m_samples_packages','name_'.$lg,$pkg_id).' <ff> ( '.$no.' )</ff>'?></div>
			<div class="cb lh30"><?=$perTxt?></div>
        </div>
        
        <div class="fr">
        	<div class="f1 clr1111 fs14"><?=$lrStatus[$status]?> : <ff><?=dateToTimeS2($now-$take_date)?></ff></div>
            <div class="fl" dir="ltr"><ff><?=getSampleAddr($rack,$rack_pos)?></ff></div>        
        </div><div class="cb lh1">&nbsp;</div>
        </div>
        <div class="form_body so"><?
		$p=get_val('lab_x_visits','patient',$visit_id);
		$patInfo=getPatInfo($p);
		echo '<div class="f1 fl fs18 lh40 clr1">'.$patInfo['n'].' (
		<span class="f1 fs16 clr1111"> '.$patInfo['s'].' </span> '.$patInfo['b'].' )</div>';
		if($out_lab){echo '<div class="f1 fs14 clr5 cb lh30"> '.k_sam_snt_ext.' ( '.get_val('lab_m_external_Labs','name_'.$lg,$out_lab).' )</div>';}
		
		$sql="select * , x.id as xid from lab_x_visits_services x , lab_m_services z where x.service=z.id and  x.id IN($services)";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>1){echo '<div class="fr newSamp" title="'.k_crt_sub_sam.'" onclick="subSamp('.$sam_id.',2)"></div>';}
		if($rows>0){
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static">
			<tr><th>'.k_analysis.'</th><th>'.k_status.'</th></tr>';
			while($r=mysql_f($res)){
				$s_id=$r['id'];
				$name=$r['short_name'];
				$outlab=$r['outlab'];
				$status=$r['status'];
				$outTxt='';
				if($outlab){$outTxt='<div class="f1 clr5 lh20">'.k_out_test.'</div>';}
				if($status==2){$pors='<div class="addLRep " title="'.k_ent_rep_val.'" onclick="showLReport('.$s_id.',1)"></div>';}				
				echo '<tr>
				<td class="ff B fs16">'.$name.$outTxt.'</td>
				<td><div class="f1">'.$anStatus[$status].'</div></td>
				</tr>';
			}
			echo '</table>';
		}?>
	</div><?
}?>
<div class="form_fot fr">
<div class="bu bu_t2 fr" onclick="win('close','#m_info3');"><?=k_close?></div>
<? if($thisGrp!='oiz49vigr'){?><div class="bu bu_t3 fl" onclick="XsDel(<?=$sam_id?>);"><?=k_destruction?></div><? }?>
</div>
</div>
<? }?>