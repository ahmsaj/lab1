<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['emp'])){
	$id=pp($_POST['id']);
	$emp=pp($_POST['emp']);	
	$vType=1;
	$hide='hide';
	$s_date=date('Y-m-d');
	$e_date=date('Y-m-d');
	$s_time='AM 09:00';
	$e_time='AM 10:00';
	if($id){
		$r=getRec('gnr_x_vacations',$id);
		if($r['r']){
			$hide='';
			$emp=$r['emp'];
			$vType=$r['type'];
			$s_date=date('Y-m-d',$r['s_date']);
			$e_date=date('Y-m-d',$r['e_date']);
			$s_time=clocFromstr($r['s_hour']);
			$e_time=clocFromstr($r['e_hour']);
		}
	}
	list($empName,$emp)=get_val('_users','name_'.$lg.',id',$emp);
	if($emp){
			
		$cData=getColumesData('fph3840jvz',1);
		?>
		<div class="win_body">
		<div class="form_header so lh40 clr1 f1 fs18"><?=$empName?>
		<div class="fr ic40 icc1 ic40_ref" onclick="addVaca(0,<?=$emp?>)"></div></div>
		<form name="vaca" id="vaca" action="<?=$f_path?>X/gnr_vaca_save.php" method="post"
		cb="cbVaca([1],[2]);" bv="a,b">
		<input type="hidden" name="emp" value="<?=$emp?>">
		<input type="hidden" id="opr" name="opr" value="1">
		<input type="hidden" name="id" value="<?=$id?>">
		<div class="form_body of" type="full">			
			<table class="fTable" cellpadding="0" cellspacing="0" border="0">
				<tr><td n><?=k_vac_type?> : <span>*</span></td><td><select name="vType" id="vType">
				<option value="1" selected><?=k_daily_vac?>  </option>
				<option value="2" <? if($vType==2){ echo 'selected';}?>><?=k_hourly_vac?></option>
				</select></td></tr>
				
				<tr><td n><?=k_starting_date?> : <span>*</span></td>
				<td><input type="text" id="s_date" name="s_date" class="Date" value="<?=$s_date?>"></td></tr>
				
				<tr vt vt1 class="hide"><td n> <?=k_ending_date?> : </td>
				<td><input type="text" id="e_date" name="e_date" class="Date" value="<?=$e_date?>"></td></tr>
				
				<tr vt vt2 class="hide"><td n> <?=k_stime?> : <span>*</span></td>
				<td><input type="text" id="s_time" name="s_time" value="<?=$s_time?>" class="DUR2" step="15" d_time="9:00" ></td></tr>
				
				<tr vt vt2 class="hide"><td n><?=k_date_finish?> : <span>*</span></td>
				<td><input type="text" id="e_time" name="e_time" value="<?=$e_time?>" class="DUR2" step="30" d_time="9:15"></td></tr>
			</table>
		</div>
		</form>
		<div class="form_fot fr">
			<div class="bu bu_t3 fl" onclick="saveVac()"><?=k_save?></div>
			<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>
		</div>
		</div><?
	}
}
echo script('changVacaType('.$vType.')');?>