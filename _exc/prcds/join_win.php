<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['state'])){
	$state=pp($_POST['state'],'s');
?>
	<div class="win_body">
	<? if($state=='fields_sort' && isset($_POST['col_id'],$_POST['id'])){
		$col_id=pp($_POST['col_id'],'s');
		$process_id=pp($_POST['id']);
	?>
	<div class="form_header so lh40 clr1 f1 fs18">
		<?=k_choose_fields_in_order?>:
		<div class="fr ic40x icc1 ic40_ref" onclick="getJoinWin(<?=$process_id?>,'<?=$col_id?>')"></div>
	</div><?}?>
	<div class="form_body of so"   style="overflow-x: hidden;"><?
	if($state=='fields_sort' && isset($_POST['col_id'],$_POST['id']) ){
		$fields_arr=[]; $hide='hide';
		if(isset($_POST['fields'])){
			$choosenFields=$_POST['fields'];
			if(!empty($choosenFields)){
				$hide='';
			}
		}
		$process_id=pp($_POST['id']);
		$col_id=pp($_POST['col_id'],'s');
		$rows=count($fields_arr);
		$fileFields=getFileFields($process_id);
		$win='#m_info';
		$saveFunc="saveSortProcess('$col_id')";
		?>
		<div class="fl r_bord"  fix="hp:0|w:250">
			<div  class="lh40 f1 fs18 clr1 TC uLine"><?=k_file_fields?></div>
			<div fix="hp:50" class="ofx so" all>
			<? foreach($fileFields as $rank=>$name){
					?>
					<div field_rank="<?=$rank?>" onclick="infoWin(<?=$rank?>,'<?=$name?>')">
						<div rr class="fl h100 lh30" fix="w:40"><?=$rank?></div>
						<div n class="fl h100 lh30" fix="wp:40"><?=$name?></div>
					</div>
			<?}?>
			</div>
		</div>
		<div class="fl" fix="wp:250|hp:0">
			<div class="lh40 f1 fs18 clr1 TC uLine"><?=k_chosen_fields?></div>
			<div class="ofx so pd10" fix="hp:50" choosen>
				<table choosen rows=<?=$rows?> class="grad_s hh1 mlord <?=$hide?> " width="100%" cellpadding="2" cellspacing="0" type="static">
				<tbody class="ui-sortable">
				<tr>
					<th width="5%"></th>
					<th width="5%"><?=k_field_num?> </th>
					<th ><?=k_name?></th>
					<th > <?=k_number?></th>
					<th ><?=k_start_from?></th>
					<th width="10%"><div title="<?=k_new_line_add?>" style="font-size:40px;" class="buutAdd" onclick="addNewRow()">&nbsp;</div></th>
				</tr>
				<?
			        for($i=0;$i<count($choosenFields);$i++){
						foreach($choosenFields[$i] as $rank=>$props){
							if($rank=='not_field'){
								$notField_txt=$props;?>
								<tr rank="not_field">
									<td><div class="mover"></div></td>
									
									<td colspan="4" class="pd10"><input not_field type="text" placeholder="<?=k_enter_txt?>" value="<?=$notField_txt?>"/></td>
									
									<td><div class="fr ic40 icc2 ic40_del" onclick="delField(this)"></div></td>
								</tr>
							<?}else{
								$part_type=$props["part_type"];
								$index_s=$part_num=1;
								$codeCustom='';
								if($part_type==6){
									$codeCustom=$props["custom"];
									$attrs='custom="'.$codeCustom.'"';
								}else{
									$index_s=$props["index_s"];
									$part_num=$props["part_num"];
									$attrs=' index_s="'.$index_s.'" part_num="'.$part_num.'"';
								}
								$nameField=$fileFields[$rank];
								$row=getRandString(10);
							
							list($content,$start)=getFieldContentStart($part_type,$index_s,$part_num);
							$func="infoWinEditDel('$nameField','$row')";
							

							?>
							<tr ml row="<?=$row?>" rank="<?=$rank?>" part_type="<?=$part_type?>"   <?=$attrs?> >
								<td><div class="mover"></div></td>
								<td><ff class="fs16"><?=$rank?></ff></td>
								<td class="fs14"><?=$nameField?></td>
								<? if($part_type!=6){?>
									<td class="fs14"><?=$content?></td>
									<td class="fs14"><?=$start?></td>
								<? }else{?>
									<td colspan="2"><?=k_exc_custom?></td>
								<?}?>
								<td>
									<div class="fl ic40 icc1 ic40_edit" onclick="<?=$func?>"></div>
									<div class="fr ic40 icc2 ic40_del" onclick="delField(this)" ></div>
								</td>
							</tr>
							<?}
						}
					}
				?>
				</tbody>
				</table>
			</div>
		</div>
	<?}
	else if(isset($_POST['field_rank'])){
		$name='';
		$row=0;
		if(isset($_POST['name'])){
			$name=pp($_POST['name'],'s');
		}
			$field_rank=pp($_POST['field_rank'],'s');
			$arrtxt=['1:'.k_valueAll,'2:'.k_wordLast,'3:'.k_charLast,'4:'.k_wordFirst,'5:'.k_charFirst,'6:'.k_exc_custom];		
			$win='#m_info2';
			$row=getRandString(10);
			$type=1;
			$index_s=1;
			$part_num=1;
			$codeCustom='';
			$txtCodeCus=k_cod_enter;
			$hideExc_true='hide';
			$codeClr='clr5';
			if($state=='edit'){
				$type=pp($_POST['type']);
				$index_s=pp($_POST['index_s']);
				$part_num=pp($_POST['part_num']);
				$codeCustom=pp($_POST['custom_code'],'s'); 
				if($codeCustom!=''){$codeClr='clr6';$hideExc_true=''; $txtCodeCus='تحرير الكود';}
				if(isset($_POST['row'])){$row=pp($_POST['row'],'s');}
			}
			$saveFunc="saveAddEdit($field_rank,'$name','$state','$row')";
		?>
			<table width="100%" border="0" cellspacing="4" type="static" cellpadding="2" class="fTable"><tbody>
			<tr>
				<td n><?=k_import_type?>: </td>
				<td><?=selectFromArrayWithVal('part_type_'.$field_rank,$arrtxt,1,0,$type,'t s txt="part_type"')?></td>
			</tr>
			<tr indexStart>
				<td n> <?=k_start_from?>: </td>
				<td><input type="number" name="index_s_<?=$field_rank?>" value="<?=$index_s?>" /></td>
			</tr>
			<tr partCount>
				<td n><?=k_number?> : </td>
				<td><input type="number" name="part_num_<?=$field_rank?>" value="<?=$part_num?>" /></td>
			</tr>
			<tr exc_custom>
				<td n><?=k_code?> :</td>
				<td txt>
					<span codeEnter class="<?=$codeClr?> f1 Over" onclick="getCustomWin(<?=$field_rank?>,'#m_info3')"><?=$txtCodeCus?></span>
					<span exc_true class="clr6 <?=$hideExc_true?>">&#10004;</span>
					<input type="hidden" name="custom_<?=$field_rank?>" value="<?=$codeCustom?>" />
				</td>
				
			</tr>
			</tbody></table>
		<?
	 }
	
    ?>
	</div>
    <div class="form_fot fr">
        <div class="bu bu_t2 fr" onclick="win('close','<?=$win?>');"><?=k_close?></div>     
        <div class="bu bu_t1 fl" onclick="<?=$saveFunc?>"><?=k_save?></div>  
    </div>
    </div><?
}?>