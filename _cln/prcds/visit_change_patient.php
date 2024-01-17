<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['t'])){
	$id=pp($_POST['id']);
	$type=pp($_POST['t']);
	if($type==1){$table='cln_x_visits';$table2='cln_x_visits_services';}
	if($type==2){$table='lab_x_visits';$table2='lab_x_visits_services';}
	if($type==3){$table='xry_x_visits';$table2='xry_x_visits_services';}
	if($type==4){$table='den_x_visits';$table2='';}
	$patient=get_val($table,'patient',$id);
	if($patient){?>
		<form name="change_pat" id="change_pat" action="<?=$f_path?>X/cln_visit_change_patient_do.php" method="post"  cb="check_tik_do('<?=$type?>-<?=$id?>')" bv="">
		<input type="hidden" name="id" value="<?=$id?>"/>
		<input type="hidden" name="type" value="<?=$type?>"/>
		<input type="hidden" name="old_pat" value="<?=$patient?>"/>
		<div class="win_body">
			<div class="form_header">
				<div class="lh40 clr1 fl fs18 f1"><?=get_p_name($patient)?></div>
				<div class="lh40 clr1 fr"><ff>#<?=$id?></ff></div>
			</div>
			<div class="form_body so">
				<div class="lh40 clr1 f1 fs14"><?=k_enter_alt_patient_num?> :</div>
				<div class="lh40"><input name="new_pat" type="number" id="newPat" required/></div>			
			</div>
			<div class="form_fot fr">
				<div class="bu bu_t3 fl" onclick="sub('change_pat');"><?=k_save?></div>
				<div class="bu bu_t2 fr" onclick="win('close','#m_info2');"><?=k_close?></div>
			</div>
		</div>
		</form><?
	}
}?>