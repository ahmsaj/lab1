<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$r_id=pp($_POST['id']);
	list($r_name,$type,$unit)=get_val('cln_m_vital','name_'.$lg.',type,unit',$r_id);
	?>
	<div class="win_body">
    <div class="form_header">
	<div class="fl lh40 fs18 f1 clr1 ws"><?=$r_name?> <? if($unitCode){echo '<ff>[ '.$unitCode.' ]</ff>';}?></div>
    <div class="fr lh40">
    <div class="ic40 icc1 ic40_add fr" onclick="vitalNormal_add(<?=$r_id?>,0,<?=$type?>)" title="<?=k_add_nor_val?>"></div>    
    </div>
    </div>
	<div class="form_body so">
	<?
    $sql="select * from cln_m_vital_normal where vital='$r_id' order by type ASC , id ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		?>
		<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH">
        <tr>
        	<th width="30">#</th>                        
            <th><?=k_sex?></th>
        	<th><?=k_age?></th>
        	<th><?=k_val?></th>
        	<th><?=k_additional_values?></th>
            <th width="90"></th>
        </tr>
        <?
		$i=1;
		while($r=mysql_f($res)){
			$id=$r['id'];
			$sex=$r['sex'];
			$n_type=$r['type'];
			$age=$r['age'];
			$def_val=$r['def_val'];
			$add_pars=$r['add_pars'];
			$sample=$r['sample'];
			$value=$r['value'];
			echo '<tr>
			<td><ff>'.$i.'</ff></td>
			<td class="f1">'.$sex_types[$sex].'</td>
			<td>'.getAnAge($age).'</td>
			<td>'.getVitalVal($type,$value).'</td>
			<td>'.getVitalADDVal($type,$add_pars).'</td>
			<td><div class="repButt fl" onclick="vitalNormal_add('.$r_id.','.$id.','.$type.')"></div> 
			<div class="repDel fr" onclick="vitalNormal_del('.$id.')"></div></td>
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