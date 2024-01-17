<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);?>
	<div class="win_body">
	<div class="form_header so lh40 clr1 f1 fs18"><?=get_p_name($id)?></div>
	<div class="form_body so">
	<form id="patPaySave" name="patPaySave" action="<?=$f_path?>X/gnr_patient_pay_save.php" method="post" cb="accStat(<?=$id?>)" bv="">
		<input type="hidden" name="id" value="<?=$id?>"/>
		<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" >
			<tr>
				<td txt><?=k_pay_type?></td>
				<td txt><?=selectFromArray('type',$payPatTypes,1,1,'',' t ')?></td> 
			</tr>
			<tr>
				<td txt><?=k_doctor?></td>
				<td txt>
					<? $docs=get_vals('den_x_visits_services','doc',"patient='$id'",'arr');?>
					<select name="doc" required t><option value="0"></option><?
						$sql="select * from _users  where grp_code='fk590v9lvl' and act=1 ";
						$res=mysql_q($sql);
						while($r=mysql_f($res)){
							$doc_id=$r['id'];
							$doc_name=$r['name_'.$lg];
							$c='clr6';
							if(!in_array($doc_id,$docs)){$c='clr5';}
							echo '<option value="'.$doc_id.'" class="'.$c.'">'.$doc_name.'</option>';
						}?>
					</select>
				</td>				
			</tr>
			<tr>
				<td txt><?=k_paym?></td>
				<td txt><input type="number" name="pay" value="" id="ppay" required/></td>				
			</tr>
		</table>
	</form>
    </div>
    <div class="form_fot fr">
        <div class="bu bu_t2 fr" onclick="win('close','#m_info4');"><?=k_close?></div>
		<div class="bu bu_t3 fl" onclick="savePatPay()"><?=k_save?></div>
    </div>
    </div><?
}?>