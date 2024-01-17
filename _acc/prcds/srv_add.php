<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$type=$r['type'];
	$sett=$r['sett'];
	$clinics=$r['clinics'];
	$butTxt=k_srv_chos;?>		
	<div class="win_body">	
		<div class="form_body so" type="full">
			<form name="accSrv" id="accSrv" action="<?=$f_path?>X/acc_srv_save.php" method="post" cb="loadModule('y3aymkisba')">
				<input type="hidden" name="id" value="<?=$id?>"/><?
				$hide='hide';
				if($id){
					$hide='';
					$r=getRec('acc_m_service',$id);
					if($r['r']){
						$mood=$r['mood'];
						$srv=$r['service'];
						$acc_m=$r['acc_morning'];
						$acc_n=$r['acc_night'];
						$cost=$r['codt_code'];
						$subVal=get_val($srvTables[$mood],$subTablesOfferCol[$mood],$srv);
						$subTxt=get_val($subTablesOfeer[$mood],'name_'.$lg,$subVal);
						$serTxt=get_val($srvTables[$mood],'name_'.$lg,$srv);
						echo '<div class="f1 fs16 lh40">'.k_department.' : '.$clinicTypes[$mood].'</div>';
						echo '<div class="f1 fs16 lh40"><span class="f1 clr5 fs16">'.splitNo($subTxt).' : </span>'.splitNo($serTxt).'</div>';
					}
				}else{?>		
					<div class="f1 fs16 lh40 clr1"><?=k_department?> :</div><?
					echo '<select id="clnicType" onchange="selclicCatAcc(1,this.value)" t>
					<option value="0">'.k_dept_choose.'</option>';				
					foreach($clinicTypes as $k => $part){
						if($part){
							$ch='off';
							if($parts){
								if(in_array($k,$parts)){
									$ch='on';
								}
							}
							echo '<option value="'.$k.'">'.$part.'</option>';
						}
					}
					echo '</select>
					<div id="subcT1"></div>
					<div id="subcT2"></div>';
				}?>
				<div id="subcT3" class="<?=$hide?>">
					<div class="f1 lh40 fs16 clr1">حساب صباحي :</div>
					<div class="f1 lh30 fs16 clr5"><input type="text" name="acc_m" value="<?=$acc_m?>" required/></div>
					<div class="f1 lh40 fs16 clr1">حساب مسائي  :</div>
					<div class="f1 lh30 fs16 clr5"><input type="text" name="acc_n" value="<?=$acc_n?>" required/></div>
					<div class="f1 lh40 fs16 clr1">مركز التكلفة :</div>
					<div class="f1 lh30 fs16 clr5 "><input type="text" name="cost" value="<?=$cost?>" required/></div>
				</div>
			</form>
		</div>
	
	<div class="form_fot fr">
		<div class="bu bu_t2 fr" onclick="win('close','#m_info2');"><?=k_close?></div>
		<div class="bu bu_t3 fl" onclick="accSelSrv();"><?=k_save?></div>
	</div>
	</div><?		
	
}?>