<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['level'])){
   $lev=$_POST['level'];
	if($lev==1){
		$out='';
		$sql="select * from exc_import_processes order by p_start_date";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$out='<center><table id="tableContent"  class="grad_s holdH" width="100%" cellpadding="4" cellspacing="0" type="static">
				<tr>
					<th>'.k_file_name.'</th>
					<th>'.k_procedure_date.'</th>
					<th>'.k_level.'</th>
					<th width="100" colspan="2">'.k_operations.'</th>
				</tr>';
			while($r=mysql_f($res)){
				$date=$r['p_start_date'];
				$level=$r['level'];
				$last_import_date=$r['last_import_date'];
				$imp_end=$r['imported_end'];
				$id=$r['id'];
				$file_id=$r['file_id'];
				$upFile=getUpFiles($file_id)[0];
				$fileName=splitNo($upFile['name']);
				$txt=$levelsTxt[$level];
				$icon='<div class="ic40 icc1 ic40_icon_continue fl" title="'.k_continue.'" onclick="goLevel('.$id.')"></div>';
				if($last_import_date && $imp_end==0){//تمت عملية الاستيراد وانتهت اي لا يوجد ايقاف مؤقت
					$txt=k_imported_at.' <ff>'.date('Y-m-d',$last_import_date).'</ff> '.k_thhour.' <ff>'.date('h:sA',$last_import_date).'</ff>';
					$icon='<div class="ic40 icc4 ic40_icon_finish fl" title="'.k_procedure_details.'" onclick="info_import_view('.$id.')"></div>';
				}elseif($last_import_date){$txt=$levelsTxt[3];}
				
				$out.='<tr>
				    <td txt>'.$fileName.'</td>
					<td><ff dir="ltr">'.date('Y-m-d  h:sA',$date).'</ff></td>
					<td txt>'.$txt.'</td>
					<td tool width="100" colspan="2">'.
						$icon
						.'<div class="ic40 icc2 ic40_del fl" title="'.k_delete.'" onclick="delProcess('.$id.')"></div>
					</td>
				</tr>';
			}
			$out.='</table></center>';
		}else{ $out='<div class="fs18 clr5 f1"> '.k_no_incomplete_imports.' </div>'; }
		echo $out;
		}
	elseif(isset($_POST['id'])){
		$process_id=pp($_POST['id']);
		$template=0;
		if(isset($_POST['template'])){$template=pp($_POST['template']);}
		$rec='';
		if($lev==2){
			$rec=getRecCon("exc_import_processes","id=$process_id");
			if($rec){
				$file_id=$rec['file_id'];
				$loc=$process_id;
				if($template){
					$rec=getRecCon("exc_templates","id=$template");
					$loc=$process_id.'-'.$template;
				}
				$fields_rank=$fields_name=[];
				if($rec['cols']){
					$isCols=1;
					$fields=$rec['cols']; 
					$fields=explode(',',$fields);
					foreach($fields as $field){
						$field=explode(':',$field);
						$rank=$field[0];
						$name=$field[1];
						array_push($fields_rank,$rank);
						$fields_name[$rank]=$name;
					}
				}
				$header=$rec['header_row'];
			}
			$upFile=getUpFiles($file_id)[0];
			$path='../sFile/'.$upFile['folder'].$upFile['file'];
			if(file_exists($path)){
				$showRows=_set_p5i4bvtagg;
				$csv=getCsvContent($path,1,$showRows);
				$cId="file_header";
				$csvInfo=getCsvInfo($path);
				$cols=$csvInfo['cols'];
				$rows=$csvInfo['rows'];
				
				mysql_q("update exc_import_processes set level=1, count_rows='$rows',count_cols='$cols' where id=$process_id"); 
				
				$w=100/$cols;
				$out='<form id="importInfo" name="importInfo" method="post" action="'.$f_path.'X/exc_import_info_set.php" cb="goLevel(\''.$loc.'\')" bv="a">';
				$out.= '<table class="grad_s" Over=0 width="100%" cellpadding="2" cellspacing="0" type="static">';
				//-------checkBox-------
				$out.='<tr style="background-color:rgb(234,242,255);">';
				$out.='<th width="'.$w.'%">
					<div ch_name="selAllCol" class="form_checkBox fl cur" onclick="setAllCheckbox('.$cols.',this)">
						<div ch="on"></div>
					</div>
				</th>';
					for($i=1;$i<=$cols;$i++){
						if($rec['cols']){
							$check='on';
							if(in_array($i,$fields_rank)){$check='off';}
						}else{$check=='off';}
						$out.='<th width="'.$w.'%">
							<div ch_name="selCol_'.$i.'" class="form_checkBox fl cur" onclick="setCheckbox(\'selCol_'.$i.'\');">
								<div ch="'.$check.'"></div>
							</div>
						</th>';
					}
				$out.='</tr>';
				//---------input of fields names-------
				$out.='<tr>
					<td txt width="'.$w.'%">'.k_head_line.'</td>';
					for($i=1;$i<=$cols;$i++){
						/*$nameField='';
						if($fields_name[$i]){$nameField=$fields_name[$i];}*/
						$out.='<td width="'.$w.'%">
						<input style="width:100px" mm  name="col_'.$i.'" value=""  />
						</td>';
					};
				$out.='</tr>';
				for ($row=1;$row<=$showRows;$row++){
					$outRow='';
					$ok=1;
					if($row>0 && $row<50){
						$outRow.='<tr row="'.$row.'">';
						$id=$row; $val=0; $t=2;
						if($header==$row){$val=1;}
						$outRow.='<td width="'.$w.'%">'.makeSwitch($cId,$id,$val,$t).'</td>';
						for($col=1;$col<=$cols;$col++){
								$val=autoUTF($csv['content'][$row][$col-1]);						
								$outRow.='<td width="'.$w.'%" col="'.$col.'">';
								/*if(mb_detect_encoding($val)=='UTF-8'){$val= iconv('UTF-16LE','UTF-8',$val);}	*/		
								$outRow.=$val.'</td>';
						}  
						$outRow.='</tr>';
						if($ok){$out.= $outRow;}
					}

				}
				$out.= '</table>';
				if($template){$out.='<input type="hidden" name="template" value="'.$template.'"/>';}
				$out.='<input type="hidden" name="colsCount" value="'.$cols.'"/>
				<input type="hidden" name="file" value="'.$file_id.'"/>
				<input type="hidden" name="header_line" value="0"/>
				<input type="hidden" name="process_id" value="'.$process_id.'"/>
				<input type="hidden" name="countRows" value="'.$rows.'"/>
				<input type="hidden" name="level" value="2"/>';
				$out.= '</form>';
				echo $out.'^'.$cId.'^'.$cols;
			}
		}
		elseif($lev==3){
				$out=$out1='';
				$module=$changTable=0;
				$sett=[]; 
				list($countRows,$first,$end)=get_val('exc_import_processes','count_rows,start_line,end_line',$process_id);
				if($template){
					$sett=getImportSetting('exc_templates',$template,$changTable);
					
				}
				else{
					$sett=getImportSetting('exc_import_processes',$process_id,$changTable);
				}
				if(!empty($sett)){
					$cols=$sett['cols'];
					$arrCols=$sett['arrCols'];
					$empty_fields=$sett['empty_fields'];
					$module=$sett['module'];
					if($end>$countRows){$end=$countRows;}
					//$countRows=$sett['countRows'];
					/*------------------------------*/
					if($module)/* && $cols && $first && $end)*/{

						$sql="select code,colum,title,type from _modules_items where mod_code='$module' order by type";
						$res=mysql_q($sql);
						$rows=mysql_n($res);
						$out1.='<table class="grad_s hh1" no="330303" width="100%" cellpadding="4" cellspacing="0" type="static" style="margin-top:10px;">';
						$out1.='<tr>
									<th width="20%">'.k_module_item.'</th>
									<th width="20%">'.k_file_item.'</th>
									<th colspan="4" >'.k_props.' </th>
								</tr>';
						if($rows>0){
							while($r=mysql_f($res)){
								if($r['colum']){
									$col_id=$r['code'];
									$col_name=$r['title'];
									$col_type=$r['type'];
									$col_name=get_key($col_name);
									$field=$field_rank=$hideJoin=$fieldJoin_txt='';
									
									$hideExc_true=$hideCustom='hide'; $clrCodeCus=$clrJoin='clr5';
									$txtCodeCus=k_cod_enter;
									if($template){
										$fields=get_val_con('exc_template_fields','file_fields',"template=$template and module_col='$col_id'");
									}
									else{
										$fields=get_val_con('exc_import_process_fields','file_fields',"process=$process_id and module_col='$col_id'");
									}
									if($fields){
										$fields=explode($line,$fields);
										if(count($fields)==1){
											$field=explode($comma,$fields[0]);
											$hideJoin='hide';
											$field_rank=$field[0];
										}
										else{
											$hideJoin='';
											$clrJoin='clr6';
											$hideExc_true='';
											$field_rank='join';
											$i=0;
											
											foreach($fields as $fieldStr){
												$field=explode($comma,$fieldStr);
												$f_r=$field[0];
												$name_f='join_prop_'.$col_id.'['.$i.']['.$f_r.']';
												$attr='join_prop_'.$col_id;
												if($f_r=='not_field'){
													$notField_txt=$field[1];
													if($notField_txt==''){$notField_txt=' ';}
													$fieldJoin_txt.=$notField_txt;
													
													$out1.=
													'<input type="hidden" '.$attr.' name="'.$name_f.'" value="'.$notField_txt.'" />';
												}else{
													$fieldJoin_txt.='['.$cols[$f_r].']';
													$part_type=$field[1];
													$out1.=
													'<input type="hidden" '.$attr.' name="'.$name_f.'[part_type]" value="'.$part_type.'" />';
													if($part_type==6){
														$codeCustom=$field[2];
														$out1.=
														'<input type="hidden" '.$attr.' name="'.$name_f.'[custom]" value="'.$codeCustom.'" />';
													}else{
														$index_s=$field[2];
														$part_num=$field[3];
														$out1.=
														'<input type="hidden" '.$attr.' name="'.$name_f.'[index_s]" value="'.$index_s.'" />

														<input type="hidden" '.$attr.' name="'.$name_f.'[part_num]" value="'.$part_num.'" />';
													}
												}
												$i++;
											}
										}
									}


									$out1.='<tr id="'.$col_id.'">
										<td class="fs14" width="20%">'.$col_name.'</td>
										<td width="20%">'.selectFromArrayWithVal('selFileCols_'.$col_id,$arrCols,0,0,$field_rank,'txt="selFileCols"').'</td>';
									$out1.='<td colspan="3" prop>
									<div join>
										<div propEdit class="f1 '.$clrJoin.' Over '.$hideJoin.'" onclick="getJoinWin('.$process_id.',\''.$col_id.'\')">
										'.k_edt_prp.'
										<span exc_true class="clr6 '.$hideExc_true.' ">&#10004;</span>
										</div>
										<div fieldJoin_txt >'.$fieldJoin_txt.'</div>
									</div>
 									<div notJoin class="hide">';
									if($col_type==2){
										$style='style="width:60px;"';
										$formatDate=['dd:k_day','mm:k_month','yyyy:k_year'];
										$dateChar='-';
										$dateVals=['yyyy','mm','dd'];
										if($field!=''){
											$dateChar=$field[1];
											$dateVals=[$field[2],$field[3],$field[4]];
										}
										$out1.='
										<div class="">
											<div class="fl">
												<span  class="fl lh40 pd10 fs12  clr1 B"> '.k_delimeter.':  </span>
												<input class="fl" type="text" name="dateChar_'.$col_id.'" style="width:40px;" value="'.$dateChar.'" />
											</div>
											<div class="fl" dir="rtl" fix="w:300">
												<span class="fl lh40 pd10 fs12  clr1 B">'.k_format.': </span>
												'.selectFromArrayWithVal('date_1_'.$col_id,$formatDate,1,0,$dateVals[0],'date txt="date_1" '.$style).'
												'.selectFromArrayWithVal('date_2_'.$col_id,$formatDate,1,0,$dateVals[1],'date txt="date_2" '.$style).'
												'.selectFromArrayWithVal('date_3_'.$col_id,$formatDate,1,0,$dateVals[2],'date txt="date_3" '.$style).' 
											</div>
										</div>';
 										$out1.='
											<div  class="pd10 lh30 TL cb" >
												<span >'.k_current_date_format.':</span>
												<span style="padding-'.$align.':20px;">
													<span class="clr1 fs16" date_1>'.$dateVals[0].'</span>
													
													<span  class="clr1 fs16" dateChar>-</span>
													
													<span  class="clr1 fs16"date_2>'.$dateVals[1].'</span>
													
													<span  class="clr1 fs16" dateChar>-</span>
													
													<span  class="clr1 fs16" date_3>'.$dateVals[2].'</span>
												</span>
											</div>
											<div class="cb lh1">&nbsp;</div>
												'; 
									}else{
										$part_type=$part_num=''; $index_s=1; 
										if($field!=''){
										    $part_type=$field[1];
											if($part_type==6){
												$hideCustom='';
												$clrCodeCus='clr6';
												$txtCodeCus=k_edt_cod;
												$codeCustom=$field[2];
												$out1.='<input type="hidden" name="custom_'.$col_id.'" value="'.$codeCustom.'" />';
											}else{
												$index_s=$field[2];
												$part_num=$field[3];
											}
										}
										$arrtxt=['1:'.k_valueAll,'2:'.k_wordLast,'3:'.k_charLast,'4:'.k_wordFirst,'5:'.k_charFirst,'6:'.k_exc_custom];
										$out1.='
										<span imp_type_tit class="fl lh40 fs12  clr1 B  pd10"  >'.k_import_type.': </span>
										<div style="width:15%;"  class="fl mg10">'.selectFromArrayWithVal('part_type_'.$col_id,$arrtxt,1,0,$part_type,'txt="part_type"').'</div>

										<span indexStart class="fs12  clr1 B hide">
											'.k_start_from.':
											<input class="mg10" name="index_s_'.$col_id.'" type="number" style="width:15%;" value="'.$index_s.'" />
										</span>
										<span partCount class="fs12  clr1 B hide">
											'.k_number.':
											<input class="mg10" name="part_num_'.$col_id.'"type="number" style="width:15%;" value="'.$part_num.'"/>
										</span>
											
										<span exc_custom class="f1 lh40 Over '.$hideCustom.' '.$clrCodeCus.' " onclick="getCustomWin(\''.$col_id.'\',\'#m_info\')">'.$txtCodeCus.'   
										</span>
										<span  exc_true class="clr6 '.$hideCustom.'">&#10004;</span>
										';
						
									}
									$out1.='</div> 
											</td>
										</tr>';
								}
							}
						}		
						$out1.='</table>';
					}
					/**************************الإعدادات*************************/
					if(!$changTable){
						$out.='
							<div class="titleStyle" fix="h:100">
								<div tit>'.k_imported_lines.':</div>

									<span >'.k_from.':</span>
									<input fix="w:80" type="number" name="start_row" value="'.$first.'" onkeyup="checkError(3,'.$countRows.',\'from_to\')"/>
									<span >'.k_to.':</span>
									<input fix="w:80" type="number" name="end_row" value="'.$end.'" onkeyup="checkError(3,'.$countRows.',\'from_to\')"/>
									<div f_t id="error" ></div>
							</div>';


							$empty_arr=explode(',',$empty_fields);
							$out.='<div class="titleStyle" fix="hp:150">
								<div tit>'.k_ignore_empty_fields.':</div>';
									$out.='<div class="add_but w-auto" onclick="addFieldEmpty('.$process_id.')"> </div>';
										$out.='<div id="list_f" class="ofx so" fix="hp:70">';
											foreach($cols as $r=>$f){
												$hide='hide';
												if(in_array($r,$empty_arr)){$hide='';}
												$out.='<div class="'.$hide.'" rank="'.$r.'">
														  <div x onclick="delChoosenField('.$r.',\'live\')"></div>
														  <div t>'.$f.'</div>
													   </div>';
											}
											$h_title=' class="hide" ';
											if($empty_fields!=''){$h_title='';}
											$out.='<div notFound class="f1 clr5 TC fs12"> '.k_add.'</div>';
										$out.='</div>';

								$out.='</div>';
						$out.='<input type="hidden" name="level" value="'.$lev.'" />
							   <input type="hidden" name="id_process" value="'.$process_id.'" />
							   <input type="hidden" name="emptyFields" value="'.$empty_fields.'" />';

					}
					if($out1!='' && $out!=''){echo $out."^".$out1;}
					elseif($changTable){echo $out1;}
					//elseif($template){echo $out1.'^'.$module;}
					else {echo $out;}
				}
			}
	}
}else{
	if(isset($_POST['state'],$_POST['id'])){
		$state=$_POST['state'];
		$process_id=$_POST['id'];
		if($state='back'){
			mysql_q("update `exc_import_processes` set level=1 where id=$process_id");
			if(mysql_a()>0){ echo 1; }
		}
	}
}

?>
