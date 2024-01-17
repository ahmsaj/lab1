<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'],$_POST['mood'])){
	$mood=pp($_POST['mood']);
	$vis=pp($_POST['vis']);?>
	<div class="win_body">	
	<div class="form_body so"><?
	$r=getRec($visXTables[$mood],$vis);
	$ok=1;
	if($r['r']){
		$date_off_end=$now-86400;
		$sql="SELECT * from gnr_m_offers where type=5 and act= 1 and date_s < $now and date_e > $date_off_end and FIND_IN_SET('$mood',`clinics`)> 0 ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows){
			$table=$srvXTables[$mood];?>
			<form id="cumboSave" name="cumboSave" action="<?=$f_path?>X/gnr_rec_addvis_cubon_save.php" method="post" cb="saveCubon('[1]')" bv="o" >
			<input type="hidden" name="vis" value="<?=$vis?>"/>
			<input type="hidden" name="mood" value="<?=$mood?>"/>
			<table width="100%" class="fTable" cellpadding="0" cellspacing="0" border="0">
            <tr>
			<td n width="80">العرض : <span>*</span></td>
				<td n><? 
				$srvOptions='';
				while($r=mysql_f($res)){
					$o_id=$r['id'];
					$name=$r['name'];
					if($rows>1){
						$srvOptions.='<option value="'.$o_id.'">'.$name.'</option>';
					}else{
						echo $name.'<input type="hidden" name="offer" value="'.$o_id.'" />';
					}
				}
				if($rows>1){echo '<select name="offer">'.$srvOptions.'</select>';}?></td>
			</tr>
			<tr>
				<td n>الخدمة : <span>*</span></td>
				<td n><?				
				$table=$srvXTables[$mood];
				$sql="select * from $table where visit_id='$vis' and status=0 and pay_net>0" ;
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				$rowTxt='';
				if($rows){
					echo '<select name="srv" t >';
					while($r2=mysql_f($res)){							
						$srv_id=$r2['id'];						
						$srv=$r2['service'];
						$serTxt=get_val_arr($srvTables[$mood],'name_'.$lg,$srv,'srv'.$mood);
						echo '<option value="'.$srv_id.'" t>'.splitNo($serTxt).'</option>
						</option>';
					}
					echo '</select>';
				}else{
					$ok=0;
					echo '<div class="f1 fs12 clr5">لا يوجد خدمات مناسبة للكوبون</div>';
				}?>
				</td>
			</tr>
			<tr>
				<td n><?=k_coupon_num?> : <span>*</span></td>
				<td><input type="number" name="cubon" value=""  required  /></td>
			</tr>
			</table>
			</form><?	
		}else{$ok=0;}	
	}?>
    </div>
    <div class="form_fot fr">
        <div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>
		<? if($ok){?>
		<div class="bu bu_t3 fl" onclick="sub('cumboSave')"><?=k_coupno_exchng?></div>
		<? }?>
    </div>
    </div><?
}?>