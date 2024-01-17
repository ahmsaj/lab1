<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['n'],$_POST['srv'])){
	$id=pp($_POST['id']);
	$n=pp($_POST['n']);
	$srv=pp($_POST['srv']);
	$note='';
	if($id){
		list($note,$done,$vis)=get_val('den_x_visits_services_levels','des,end,vis',$id);
		if($vis!=$_SESSION['denVis']){exit;}
	}?>
	<div class="win_body">
	<div class="form_header so lh40 clr1 f1 fs18">إدخال تفاصيل المرحلة</div>
	<div class="form_body so">
		<form name="form_lev" id="form_lev" action="<?=$f_path?>X/den_preview_oprs_lev_save.php" method="post" cb="denLevOpr(<?=$n?>);denRefOpr(<?=$srv?>)">
			<input type="hidden" value="<?=$id?>" name="id"/> 
			<input type="hidden" value="<?=$n?>" name="n"/> 
			<input type="hidden" value="<?=$srv?>" name="srv"/>
			<?
			if($done && $id){echo '<input type="hidden" value="1" name="done"/>'; }?>
			<table class="grad_s" width="100%" cellpadding="4" cellspacing="0" type="static" over="0">				
				<tr>
					<td txt>ملاحظات</td>
					<td class="pd10"><textarea class="w100" name="note"><?=$note?></textarea></td>
				</tr><? 
				if($id==0){?>
					<tr><td txt width="150">تم انتهاء المرحلة</td>
					<td><input type="checkbox" name="done" value="1" /></td></tr><? 
				}?>
			</table>
		</form>
	</div>
    <div class="form_fot fr">
        <div class="bu bu_t2 fr" onclick="win('close','#m_info2');"><?=k_close?></div>
		<div class="bu bu_t3 fl" onclick="sub('form_lev');">تم العمل على هذه المرحلة</div>
    </div>
    </div><?
}?>