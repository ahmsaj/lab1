<? include("../header.php");
if(isset($_POST['vis'],$_POST['pat'])){	
	$vis=pp($_POST['vis']);
	$pat=pp($_POST['pat']);
	$r=getRecCon('cln_x_visits'," id='$vis' and patient='$pat' and doctor='$thisUser'");
	if($r['r']){
		list($sex,$birth)=get_val('gnr_m_patients','sex,birth_date',$pat);
		$birthCount=birthCount($birth);?>
		<div class="lh40 clr1111 f1 fs14"><?
		echo get_p_name($pat);
		echo ' <span class="clr1 f1 fs14 "> ( '.$sex_types[$sex]. ' ) </span>
		<ff class="clr55"> '.$birthCount[0].' </ff>
		<span class="clr55 f1 fs14 clr55"> '.$birthCount[1]. '</span>';?>
		</div>^<?
		$r=getRecCon('gnr_m_patients_medical_info'," patient = '$pat' ");	
		if($r['r']){			
			$sex=$r['sex'];		
			$birth=$r['birth_date'];
			$f_hi=$r['father_height'];
			$m_hi=$r['mother_height'];
			$medRecEx=1;
		}
		$sel='';
		if($sex==2){$sel=' checked ';}?>
		<form name="patInfo" id="patInfo" action="<?=$addPathGi?>/gi_pat_info_save.php" method="post" cb="gi_pat_cb();" >			
			<input type="hidden" name="vis" value="<?=$vis?>" />
			<input type="hidden" name="pat" value="<?=$pat?>" />
			<table width="400" border="0" cellspacing="5" cellpadding="4" class="gi_table">
			<tr>
				<td class="f1 fs14">الجنس: <span>*</span></td>
				<td inputHolder>
					<div class="radioBlc so fl" name="sex" req="1" >
						<input type="radio" name="sex" value="1" checked/><label><?=k_male?></label>
						<input type="radio" name="sex" value="2" <?=$sel?>/><label><?=k_female?></label>
					</div>
				</td>
			</tr>
			<tr>
				<td class="f1 fs14">تاريخ الميلاد: <span>*</span></td>
				<td inputHolder><input name="birth" value="<?=$birth?>" type="text" class="Date" required></td>
			</tr>
			<tr >
				<td class="f1 fs14">طول الاب: <span>*</span></td>
				<td inputHolder><input name="f_hi" value="<?=$f_hi?>" type="number" required></td>
			</tr>
			<tr>
				<td class="f1 fs14">طول الأم: <span>*</span></td>
				<td inputHolder><input name="m_hi" value="<?=$m_hi?>" type="number" required></td>
			</tr>
			</table>
			<div class="ic40 ic40_save icc2 ic40Txt fl mg10v" giPatSave><?=k_save?></div>
		</form><?
	}
}?>