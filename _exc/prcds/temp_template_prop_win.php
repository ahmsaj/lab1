<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['state'])){
	$state=pp($_POST['state'],'s');
	$template=pp($_POST['id']);
	$rec=getRecCon('exc_templates',"id=$template");
	$templateName=$rec['name'];
	$module=$rec['module'];
	$module_name=get_val_con('_modules','title_'.$lg,"code='$module'");
	$header=$rec['header_row'];
	$empty_fields=$rec['empty_fields'];
	$cols=$rec['cols'];
	$act=$rec['cols'];
	if($state=="info"){
		$fieldsArr=explode(',',$cols);
		$arrFields=[];
		foreach($fieldsArr as $field){
			$fieldTemp=explode(':',$field);
			$rank=$fieldTemp[0];
			$name=$fieldTemp[1];
			$arrFields[$rank]=$name;
		}
		$w=100/count($arrFields);
		end($arrFields);
		$fieldLast = key($arrFields);
		$empty_fields_arr=[];
		if($empty_fields!=''){
			$empty_fields_arr=explode(',',$empty_fields);
		}
		$w2=(count($empty_fields_arr)) ? 100/count($empty_fields_arr) : 1;

	?>
		<div class="win_body"  style="height:50%;">
		<div class="form_body so" style="height:50%;">
		<table class="fTable" width="100%" cellpadding="2" cellspacing="2" >
		<tr>
			<td n><?=k_lk_md?>:</td>
			<td class="fs14 clr5 B"><?=$module_name?></td>
		</tr>
		<tr>
			<td n><?=k_head_line_num?>:</td>
			<td><ff><?=$header?></ff></td>
		</tr>
		<tr>
			<td colspan="2">
				<div class="f1 fs14 clr1111" style="margin:20px 0px 20px 0px;"> <?=k_fields_required?> </div>
			<?
			foreach($arrFields as $rank=>$name){
				if($fieldLast==$rank){
					$r_bord='r_bord';
				}else{
					$r_bord='';
				}
				?>
				<div class="fl TC lh30 t_bord b_bord l_bord <?=$r_bord?>" style="width:<?=$w?>%; background-color:#e7ffe2;">
					<div class="b_bord"><ff><?=num_to_letters($rank)?></ff></div>
					<div class="fs14"><?=$name?></div>
				</div>
			<? } ?>
			</td>
		</tr>
		<tr>
			<td colspan="2" >
				<div class="f1 fs14 clr1111" style="margin:20px 0px 20px 0px;">الحقول الفارغة المرفوضة:</div>
			<?
			if($empty_fields!=''){
				foreach($empty_fields_arr as $rank){
					$name=$arrFields[$rank];
					if($empty_fields_arr[count($empty_fields_arr)-1]==$rank){
					   $r_bord='r_bord';
					}else{$r_bord='';}?>
					<div class="fl TC lh30 t_bord b_bord l_bord <?=$r_bord?>" style="width:<?=$w2?>%; background-color:#ffeded; ">
						<div class="b_bord"><ff><?=num_to_letters($rank)?></ff></div>
						<div class="fs14"><?=$name?></div>
					</div>
				<? } 
			}else{?>
				<span class="fs14 fl clr5 B">غير محدد</span>

			<?}?>
			</td>
		</tr>
		</table>
		</div>
		<div class="form_fot fr">
			<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>        
		</div>
		</div><?
	}
	
}



?>
