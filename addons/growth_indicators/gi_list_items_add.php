<? include("../header.php");
if(isset($_POST['vis'],$_POST['pat'],$_POST['id'])){
	$id=pp($_POST['id']);
	$vis=pp($_POST['vis']);
	$pat=pp($_POST['pat']);
	$r=getRecCon('cln_x_visits'," id='$vis' and patient='$pat'");	
	if($r['r']){
		$visStatus=$r['status'];
		if($visStatus==1 || _set_whx91aq4mx){
			$color=get_val_con('cln_m_addons','color',"code='ww0i5f8nzz'");
			list($sex,$birth)=get_val('gnr_m_patients','sex,birth_date',$pat);	
			$birthCount=birthCount($birth);
			$age=$r['age'];
			$age=gi_getMonthAge($birth);
			$weight=$Length=$head='';
			if($id){
				$r=getRec('gnr_x_growth_indicators',$id);
				if($r['r']>0){
					$doc=$r['user'];
					$age=$r['age'];
					$weight=$r['weight'];
					$Length=$r['Length'];
					$head=$r['head'];
					if($thisUser!=$doc){exit; out();}
				}			
			}?>
			<div class="lh40 clr1111 f1 fs14"><?
			echo get_p_name($pat);
			echo ' <span class="clr1 f1 fs14 "> ( '.$sex_types[$sex]. ' ) </span>
			<ff class="clr55"> '.$birthCount[0].' </ff>
			<span class="clr55 f1 fs14 clr55"> '.$birthCount[1]. '</span>';?>
			</div>^

			<form name="growAdd" id="growAdd" action="<?=$addPathGi?>/gi_list_items_save.php" method="post" cb="gi_save_cb([1]);" bv="a" >			
				<input type="hidden" name="id" value="<?=$id?>" />
				<input type="hidden" name="vis" value="<?=$vis?>" />
				<input type="hidden" name="pat" value="<?=$pat?>" />
				<table width="400" border="0" cellspacing="5" cellpadding="4" class="gi_table">
					<tr>
						<td class="f1 fs14">العمر: </td>
						<td><?=giAge($age)?></td>
					</tr>
					<tr>
						<td class="f1 fs14">الوزن: <span>*</span></td>
						<td inputHolder><input name="weight" value="<?=$weight?>" type="number" required>
						<div class="lh20 clr9 TL">الوزن بالكيلو غرام</div></td>
					</tr>
					<tr >
						<td class="f1 fs14">الطول: <span>*</span></td>
						<td inputHolder>
						<input name="Length" value="<?=$Length?>" type="number" required>
						<div class="lh20 clr9 TL">الطول بالسنتيمتر</div>
						</td>
					</tr>
					<tr>
						<td class="f1 fs14">محيط الرأس: </td>
						<td><input name="head" value="<?=$head?>" type="number">
							<div class="lh20 clr9 TL">المقياس بالسنتمتر</div>
						</td>
					</tr>
				</table>
				<div class="ic40 ic40_save icc2 ic40Txt fl mg10v" giSave><?=k_save?></div>
			</form><?
		}
	}
}?>