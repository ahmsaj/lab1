<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$r_id=pp($_POST['id']);
	list($r_name,$type,$unit)=get_val('lab_m_services_items','name_'.$lg.',report_type,unit',$r_id);
	$unitCode=get_val('lab_m_services_units','code',$unit);
	?>
	<div class="win_body">
    <div class="form_header">
	<div class="fl lh40 fs18 f1 clr1 ws"><?=$r_name?> <? if($unitCode){echo '<ff>[ '.$unitCode.' ]</ff>';}?></div>
    <div class="fr lh40">
    <div class="ic40x br0 ic40_add icc4 fr" onclick="lssv_add(<?=$r_id?>,0,1)" title="<?=k_add_nor_val?>"></div>
    <div class="ic40x br0 ic40_det icc1 fr mg5" onclick="lssv_add(<?=$r_id?>,0,2)" title="<?=k_add_gnr_not?>"></div>
    </div>
    </div>
	<div class="form_body so">
	<?
    $sql="select * from lab_m_services_items_normal where ana_no='$r_id' order by type ASC , id ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		?>
		<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
        <tr>
        	<th width="30">#</th>
            <th><?=k_type?></th>
            <th><?=k_sample?></th>
            <th><?=k_sex?></th>
        	<th><?=k_age?></th>
        	<th><?=k_val?></th>
        	<th><?=k_additional_values?></th>
            <th width="100"></th>
        </tr>
        <?
		$i=1;
		while($r=mysql_f($res)){
			$id=$r['id'];
			$sex=$r['sex'];
			$Q_type=$r['type'];
			$age=$r['age'];
			//$def_val=$r['def_val'];
			$add_pars=$r['add_pars'];
			$sample=$r['sample'];
			$value=$r['value'];
			$sampleTxt=k_no_sel;
			if($sample){$sampleTxt=get_val('lab_m_samples','name_'.$lg,$sample);}
			if($Q_type==2){$type=8;}
			echo '<tr>
			<td><ff>'.$i.'</ff></td>
			<td class="f1">'.$DV_types[$Q_type].'</td>
			<td class="f1">'.$sampleTxt.'</td>
			<td class="f1">'.$sex_types[$sex].'</td>
			<td>'.getAnAge($age).'</td>
			<td>'.getAnVal($type,$value).'</td>
			<td>'.getAnADDVal($type,$add_pars).'</td>
			<td><div class="ic40 icc1 ic40_edit fl" onclick="lssv_add('.$r_id.','.$id.','.$Q_type.')"></div> 
			<div class="ic40 icc2 ic40_del fl" onclick="lssv_del('.$id.')"></div></td>
			</tr>';
			$i++;
		}?>
        </table><?
	}else{
		echo '<div class="f1 fs14 clr5">'.k_no_ad_val.'</div>';
	}?>
	</div>
	<div class="form_fot fr">
		<div class="bu bu_t2 fr" onclick="win('close','#full_win1');loadModule()"><?=k_close?></div>                
	</div>
	</div><?
}?>