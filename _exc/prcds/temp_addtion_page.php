<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['state'])){
	$state=pp($_POST['state'],'s');
	if($state=='view' && isset($_POST['id'])){
	    $process=pp($_POST['id']);
		$template=$file=$start=$end=0;
		if($process!=0){
			$proRec=getRecCon('exc_import_processes',"id=$process");
			if($proRec['r']>0){
				//$file=$proRec['file_id'];
				$start=$proRec['start_line'];
				$end=$proRec['end_line'];
				$template=$proRec['template'];
			}
			$header=0;
			if($template!=0){
				list($name_temp,$date_addition,$h)=get_val('exc_templates','name,addition_date,header_row',$template);
				if($h){$header=$h;}
				if($template && $date_addition){$dateTxt=' - <span dir="ltr">'.date('Y-m-d   h:mA',$date_addition).'</span>';}
				$start=$header+1;
			}
		}
		
?>
		<div class="win_body">
		<div class="form_body so">
			<form name="importForm" id="importForm" action="<?=$f_path?>X/exc_temp_addtion_page.php" method="post" cb="getimportStartView(<?=$process?>);" bv="id">
			<table class="fTable" cellpadding="0" cellspacing="0" border="0">
				<tr>
					<td n><?=k_import_template?>: <span>*</span></td>
					<td>
						<div>
							<input type="hidden" id="temps_list" name="temps_list"  value="<?=$template?>" />
							<div class="fl ser_but" onclick="selectionTemplate()"></div>
							<div class="bigselText"  id="name_temp" onclick="selectionTemplate()"><?=$name_temp.$dateTxt?></div>
						</div>
					</td>
				</tr>
				
			<?
				$cData=getColumesData('is7z48epg',1,0,'1=1'); 
				echo co_getFormInput($process,$cData['fo5i5z27zd'],$start,0);
				echo co_getFormInput($process,$cData['7oq1hki4c'],$end,0);
			?>
			</table>
			<input type="hidden" name="state" value="submit"/>
			<input type="hidden" name="id_process"/>
			</form>
		</div>
		<div class="form_fot fr">
			<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>     
			<div class="bu bu_t1 fl" onclick="saveAdditionPage_client(<?=$process?>)"><?=k_import?></div>     
		</div>
		</div>

<? }
	elseif($state=='submit'){
		if(isset($_POST['cof_fo5i5z27zd'],$_POST['cof_7oq1hki4c'],$_POST['id_process'],$_POST['temps_list'])){
			$out='';
			$from=pp($_POST['cof_fo5i5z27zd']);
			$to=pp($_POST['cof_7oq1hki4c']);
			$id_process=pp($_POST['id_process']);
			$template=pp($_POST['temps_list']);
			
				
			$sql="update `exc_import_processes`p, `exc_templates` t set p.level='2',p.start_line='$from', p.end_line='$to',p.cols=t.cols, p.header_row=t.header_row,p.module=t.module,p.template='$template',p.empty_fields=t.empty_fields where p.id=$id_process and t.id=$template";

			if(mysql_q($sql)){
				$sql_del="delete from exc_import_process_fields where process='$id_process'";
				if(mysql_q($sql_del)){
					$sql="insert into exc_import_process_fields (`process`,`module_col`,`type_col`,`file_fields`) select '$id_process',`module_col`,`type_col`,`file_fields` from exc_template_fields where template='$template'";
					if(mysql_q($sql)){
						$out=$id_process;
					}
				}
			}
			echo $out;
		}
	}
	elseif($state=='checkError'){
		if(isset($_POST['from'],$_POST['to'],$_POST['template'],$_POST['id'])){
			$from=pp($_POST['from']);
			$to=pp($_POST['to']);
			$template=pp($_POST['template']);
			$process=pp($_POST['id']);
			list($countRows,$countCols)=get_val('exc_import_processes','count_rows,count_cols',$process);
			$err=0; $out=1;
			list($cols,$module)=get_val('exc_templates','cols,module',$template);
			$cols_arr=explode(',',$cols);
			$ranks=[];
			foreach($cols_arr as $col){
				array_push($ranks,explode(':',$cols)[0]);
			}
			$isModule=get_val_con('_modules','1',"code=$module");
			if($isModule==1){
				$out=k_linked_module_not_exist;
				$err=1;
			}
			if(count($col_arr)>$countCols || max($ranks)>$countCols){
				$out=k_cols_num_not_compatiable;
				$err=1;
			}
			if(!$err && $from>$countRows){
				$out=k_err_end_line_grtr_file_rows;
				$err=1;
			}
			if(!$err && $to<$from){
				$out=k_start_line_grtr_end_line;
				$err=1;
			}
			echo $out.'^'.$countRows;
		}
	}
	elseif($state=='changeTemplate'){
		if(isset($_POST['template'])){
			$template=pp($_POST['template']);
			if($template!=''){
				$header=get_val('exc_templates','header_row',$template);
				$start=$header+1;
				echo $start;
			}
		}
	}
	elseif($state=='view_select_temp'){?> 
		<div class="win_body">  
			<div class="form_header f1 lh40 fs20">
				<input type="text" onkeyup="search_template()" placeholder="<?=k_search?>" class="ser_icons" style="margin-bottom:10px;" id="list_ser_option">    
			</div>
			<div class="form_body so" type="full" style="min-height: 100px; height: 455px; overflow-x: hidden;" id="list_option">
				<? 
				$cb='tempFileImport('.$template.')';?>
				<?=upFile('ex','',1,$cb,'add_but w-auto')?>
				
				<?
				$sql="select * from exc_templates where act=1";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows>0){
					while($r=mysql_f($res)){
						$name=$r['name'];
						$id=$r['id'];
						$date=$r['addition_date'];
						$nameTxt=$name.' - <span dir=\\\'ltr\\\'>'.date('Y-m-d   h:mA',$date).'</span>';
				?>
						<div class="listOptbutt TC  B" temp="<?=$name?>" onclick="selectTempDo(<?=$id?>,'<?=$nameTxt?>')">
							<?=$name?>
							<div style="padding-top:5px;" class="clr5" dir="ltr"><?=date('Y-m-d   h:mA',$date)?></div>
						</div>
						
				<?	}
				}
									   
				 ?>
				
			</div>	
			<div class="form_fot fr">
				<div class="bu bu_t2 fr" onclick="win('close','#m_info2')"><?=k_cancel?></div>
			</div>
		</div>
		
<?	}

}
if($state=='view_select_temp'||$state=='view'){?>
	<link href="../__sys/excel/css.php?d=<?=$l_dir?>" rel="stylesheet" type="text/css" />
<?}
?>



