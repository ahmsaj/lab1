<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['type'])){
	$type=pp($_POST['type'],'s');
	if($type=='pro'){
		$progs_str=get_vals('_programs','code');
		$progs=explode(',',$progs_str);?>		
		<div id="progs" class="b_bord" fix="h:50"><?
			foreach($progs as $prog){?>
				<div all="0" class="fl ff B fs16 uc cbg6 mg5 mg10v pd10 lh30 clrw br5 Over" prog="<?=$prog?>"><?=$prog?></div><?
			}?>			
		</div>
		<div id="noti" class="pd10 f1 fs14  clr55 lh50 cbg555"></div>
		<div id="details_progs" class="ofx so cb" fix="hp:150"></div>
		
		<form id="reset_mod" name="reset_mod" method="post" action="<?=$f_path?>M/reset_process_do.php" cb="reset_get_view('<?=$type?>')">
			<input type="hidden" name="type" value="prog"/>
			<input type="hidden" name="prog" value=""/>
		</form>
		
	<?
	}elseif($type=='progs_mod'&& isset($_POST['prog'])){
		$prog=pp($_POST['prog'],'s');?>
		 <?=k_note?>: <?=k_prog_linked_data_will_del?> 
		&#8595;
		<?=k_approve_delete?>
		<div class="ic40x icc2 ic40_del fr mg5v" title="<?=k_delete?>" onclick="reset_do('<?=$type?>')"></div>
		^
		<table class="fTable" width="100%" cellpadding="4" cellspacing="4">
			<tr>
				<td style="width:200px; vertical-align:top;" class="fs14 f1 clr66 lh30"><?=k_linked_mods?>:</td>
				<td><?
                    $sql="select * from _modules where `progs`='$prog' and sys=0 ORDER BY `module` ASC";
                    $res=mysql_q($sql);
                    $temp='';
                    while($r=mysql_f($res)){
                        $title=$r['title_'.$lg];
                        $table=$r['table'];
                        $code=$r['code'];
                        $clr='cbg666';
                        if(in_array($code,$main_mods)){$clr='cbg555';}
                        $temp.='<div class="fl f1 '.$clr.' lh30 pd10 mg5f br5">'.$title.'</div>';
                    }
                    echo '<div class="fl f1 fs14 lh20">'.$temp.'</div>';?>					
				</td>
			</tr>
			<tr>
				<td style="vertical-align:top;"class="fs14 f1 clr66 lh30"><?=k_linked_add_mods?>:</td>
				<td><?
                    $sql="select * from _modules_ where `progs`='$prog' and sys=0 ORDER BY `module` ASC";
                    $res=mysql_q($sql);
                    $temp='';
                    while($r=mysql_f($res)){
                        $title=$r['title_'.$lg];
                        $table=$r['table'];
                        $code=$r['code'];
                        $clr='cbg666';
                        if(in_array($code,$main_mods_add)){$clr='cbg555';}
                        $temp.='<div class="fl f1 '.$clr.' lh30 pd10 mg5f br5">'.$title.'</div>';
                    }
                    echo '<div class="fl f1 fs14 lh20">'.$temp.'</div>';?>
				</td>
			</tr>
			<tr>
				<td style="vertical-align:top;" class="fs14 f1 clr66 lh30"><?=k_linked_setts?>:</td>
				<td><?
                    $sql="select * from _settings where `pro`='$prog' and admin=1  ORDER BY `id` DESC";
                    $res=mysql_q($sql);
                    $temp='';
                    while($r=mysql_f($res)){
                        $title=get_key($r['set_'.$lg]);                       
                        $temp.='<div class="fl f1 cbg888 lh30 pd10 mg5f br5">'.$title.'</div>';
                    }
                    echo '<div class="fl fs14 lh20">'.$temp.'</div>';?>
				</td>
			</tr>
			<tr>
				<td style="vertical-align:top;" class="fs14 f1 clr66 lh30"><?=k_linked_grps?>:</td>
				<td><?
                    $sql="select * from _groups where pro='$prog' ORDER BY `id` ASC";
                    $res=mysql_q($sql);
                    $temp='';
                    while($r=mysql_f($res)){
                        $title=$r['name_'.$lg];
                        $code=$r['code'];
                        $clr='cbg666';
                        if($code=='tmbx9qnjx4'){$clr='cbg555';}
                        $temp.='<div class="fl f1 '.$clr.' lh30 pd10 mg5f br5">'.$title.'</div>';
                    }
                    echo '<div class="fl fs14 lh20">'.$temp.'</div>';?>					
				</td>
			</tr>
			<tr> 
				<td style="vertical-align:top;" class="fs14 f1 clr66 lh30"><?=k_linked_basic_info?>:</td>				
                <td><?
                    $sql="select * from _information where pro='$prog' ORDER BY `id` ASC";
                    $res=mysql_q($sql);
                    $temp='';
                    while($r=mysql_f($res)){
                        $title=$r['key_'.$lg];
                        $code=$r['code'];
                        $clr='cbg666';
                        if($code=='7dvjz4qg9g'){$clr='cbg555';}
                        $temp.='<div class="fl f1 '.$clr.' lh30 pd10 mg5f br5">'.$title.'</div>';
                    }
                    echo '<div class="fl fs14 lh20">'.$temp.'</div>';?>					
				</td>
			</tr>
		</table>
	<?
	}elseif($type=='mod'){?>
		<div id="noti" class="pd10 f1 fs14  clr55 lh50 cbg555"  fix="h:50">
			<?=k_choos_mods_to_del?>
			&#8595;
			<?=k_then_press_del?>			
            <div class="ic40x icc2 ic40_del fr mg5v" title="<?=k_delete?>" onclick="reset_do('<?=$type?>')"></div>
		</div>
		<div id="details_progs" class="ofx so cb"  fix="hp:50"><?
		//('c6rw6om76p','4x7m8yfnu','jpov2uu45','seit59ukq8','f1680wpw6l','izuq64q835','	qpedd2lozz','8v301fvq7','vknbplb513','mbzlqp8a0m','6pgppn0q8','06ekl4y30')
		$sql="select * from _modules where sys!=1 ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows){?>
			<form id="reset_mod" name="reset_mod" method="post" action="<?=$f_path?>M/reset_process_do.php" cb="reset_get_view('<?=$type?>')">
				<table width="100%" border="0" cellspacing="2" cellpadding="2" class="grad_s holdH" over="0" type="static">
					<tr>
						<th><input type="checkbox" par="check_all" name="ti_bak" /></th>
						<th><?=k_module_name?></th>
                        <th><?=k_program?></th>
						<th><?=k_jx_fl?></th>
						<th><?=k_linked_tables?></th>
					</tr><?
					while($r=mysql_f($res)){
						$mod=$r['code'];
						$title=$r['title_'.$lg];
						$exFile=$r['exFile'];
						$table=$r['table'];
						$lk_tables=$r['lk_tables'];
                        $progs=$r['progs'];
						$exFiles=[];
						if($exFile){
							$exFile="'".str_replace(',',"','",$exFile)."'";							
							$exFile=get_vals('_modules_files_pro','code',"code in ($exFile) and prog NOT IN)('sys','man') ");
                            $exFiles=explode(',',trim($exFile));
						}
						$req_tables=[];
						$lk_tables=preg_replace('(_[a-zA-Z0-9]+,|,_[a-zA-Z0-9]+)','',$lk_tables);
						if($lk_tables){$req_tables=explode(',',trim($lk_tables));}
						if(!in_array($table,$req_tables)&&$table[0]!='_'){
							array_push($req_tables,$table);
							$lk_tables.=','.$table;
						}
                        $ch=1;
                        $bg='';
                        if(in_array($mod,$main_mods)){
                            $ch=0;
                            $bg='cbg555';
                        }?>						
                        <tr mod="<?=$mod?>" class="<?=$bg?>">							
                            <td width="30">
                                <? if($ch){?>
								    <input name="sel[]" type="checkbox" par="grd_chek" value="<?=$mod?>" />
                                <? }?>
							</td>
                            <td txt width="200"><?=$title?></td>
                            <td txt><?=get_val_arr('_programs','name_'.$lg,$progs,'p','code')?></td>
							<td><?
								if(count($exFiles)){?>
									<div id="ex_files" class="MultiBlc cb so"  chM="ex_<?=$mod?>" n="<?=$mod?>">
										<input type="hidden" name="ex[<?=$mod?>]" id="mlt_ex_<?=$mod?>" value="<?=$exFile?>"  n="<?=$mod?>" >
									<? foreach($exFiles as $ex_file){
											$file_name=get_val_con('_modules_files_pro','file',"code='$ex_file'");
										?>

											<div id="dd" class="cMul" v="<?=$ex_file?>" ch="on" n="<?=$mod?>" set cc="exist"><?=splitNo($file_name)?></div>
									 <?}?>
									</div>
								<?}?>
							</td>
							<td>
								<div id="lk_tables" class="MultiBlc cb so"  chM="lk_<?=$mod?>" n="lk_<?=$mod?>">
									<input type="hidden" name="lk[<?=$mod?>]" id="mlt_lk_<?=$mod?>" value="<?=$lk_tables?>"  n="lk_<?=$mod?>" >
								<? foreach($req_tables as $table){?>
										<div id="dd" class="cMul" v="<?=$table?>" ch="on" n="lk_<?=$mod?>" set ><?=splitNo($table)?></div>
								 <?}?>
								</div>

							</td>
						</tr><?
					}?>
				</table>
				<input type="hidden" name="type" value="mod"/>
			</form><?
		}?>
		</div>
	<?
	}elseif($type=='mod_'){?>
		<div id="noti" class="pd10 f1 fs14  clr55 lh50 cbg555"  fix="h:50">
			<?=k_choos_mods_to_del?>
			&#8595;
			<?=k_then_press_del?>
			<div class="ic40x icc2 ic40_del fr mg5v" title="<?=k_delete?>" onclick="reset_do('<?=$type?>')"></div>
		</div>
		<div id="details_progs" class="ofx so cb"  fix="hp:50"><?
		$sql="select * from _modules_ where sys!=1 ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows){?>
			<form id="reset_mod" name="reset_mod" method="post" action="<?=$f_path?>M/reset_process_do.php" cb="reset_get_view('<?=$type?>')">
				<table width="100%" border="0" cellspacing="2" cellpadding="2" class="grad_s holdH" over="0" type="static">
					<tr>
						<th><input type="checkbox" par="check_all" name="ti_bak"/></th> 
						<th><?=k_module_name?></th>
                        <th><?=k_program?></th>
						<th><?=k_module_file?></th>
						<th><?=k_jx_fl?></th>
						<th><?=k_linked_tables?></th>
					</tr><?
					while($r=mysql_f($res)){
						$mod=$r['code'];                        
						$title=$r['title_'.$lg];
						$exFile=$r['exFile'];
						$lk_tables=$r['lk_tables'];
						$mod_file=$r['file'];
                        $progs=$r['progs'];
						$exFiles=[];
						if($exFile){
							$exFile="'".str_replace(',',"','",$exFile)."'";
							$exFile=get_vals('_modules_files_pro','code',"code in ($exFile) and prog NOT IN)('sys','man') ");
							$exFiles=explode(',',trim($exFile));
						}
						$req_tables=[];
						$lk_tables=preg_replace('(_[a-zA-Z0-9]+,|,_[a-zA-Z0-9]+)','',$lk_tables);
						if($lk_tables){$req_tables=explode(',',trim($lk_tables));}
                        $ch=1;
                        $bg='';
                        if(in_array($mod,$main_mods_add)){
                            $ch=0;
                            $bg='cbg555';
                        }?>
						<tr mod="<?=$mod?>" class="<?=$bg?>">	
							<td width="30">
                                <? if($ch){?>
								    <input name="sel[]" type="checkbox" par="grd_chek" value="<?=$mod?>" />
                                <? }?>
							</td>
							<td txt width="200"><?=$title?></td>
                            <td txt><?=get_val_arr('_programs','name_'.$lg,$progs,'p','code')?></td>
							<td><?
								$file_name=get_val_con('_modules_files','file',"code='$mod_file'");?>
								<div id="mod_file" class="MultiBlc cb so"  chM="mod_file_<?=$mod?>" n="m_f_<?=$mod?>">
									<input type="hidden" name="mod_file[<?=$mod?>]" id="mlt_mod_file_<?=$mod?>" value="<?=$mod_file?>"  n="m_f_<?=$mod?>" >
									<div class="cMul" v="<?=$mod_file?>" ch="on" n="m_f_<?=$mod?>" set cc="exist"><?=splitNo($file_name)?></div>
								</div>
							</td>
							<td><?
								if(count($exFiles)){?>
									<div id="ex_files" class="MultiBlc cb so"  chM="ex_<?=$mod?>" n="<?=$mod?>">
										<input type="hidden" name="ex[<?=$mod?>]" id="mlt_ex_<?=$mod?>" value="<?=$exFile?>"  n="<?=$mod?>" >
									<? foreach($exFiles as $ex_file){
											 $file_name=get_val_con('_modules_files_pro','file',"code='$ex_file'");?>

											<div id="dd" class="cMul" v="<?=$ex_file?>" ch="on" n="<?=$mod?>" set cc="exist"><?=splitNo($file_name)?></div>
									 <?}?>
									</div>
								<?}?>
							</td>
							<td>
								<div id="lk_tables" class="MultiBlc cb so"  chM="lk_<?=$mod?>" n="lk_<?=$mod?>">
								   <input type="hidden" name="lk[<?=$mod?>]" id="mlt_lk_<?=$mod?>" value="<?=$lk_tables?>"  n="lk_<?=$mod?>" >
								<? foreach($req_tables as $table){?>
										<div id="dd" class="cMul" v="<?=$table?>" ch="on" n="lk_<?=$mod?>" set ><?=splitNo($table)?></div>
								 <?}?>
								</div>
							</td>

						</tr><?
					}?>
				</table>
				<input type="hidden" name="type" value="mod_"/>
			</form><?
		}?>
		</div>
	<?
	}elseif($type=='group'){?>
		<div id="noti" class="pd10 f1 fs14  clr55 lh50 cbg555"  fix="h:50">
			<?=k_choos_mods_to_del?>
 			&#8595;
			<?=k_then_press_del?>			
            <div class="ic40x icc2 ic40_del fr mg5v" title="<?=k_delete?>" onclick="reset_do('<?=$type?>')"></div>
		</div>
		<div id="details_progs" class="ofx so cb"  fix="hp:50"><?
			$sql="select * from _groups";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows){?>
				<form id="reset_mod" name="reset_mod" method="post" action="<?=$f_path?>M/reset_process_do.php" cb="reset_get_view('<?=$type?>')">
					<table width="100%" border="0" cellspacing="2" cellpadding="2" class="grad_s " over="0" type="static">
						<tr>
							<th>
								<input type="checkbox" par="check_all" name="ti_bak" />
							</th>
							<th><?=k_group_name?></th>
							<th><?=k_users_num?></th>
							<th><?=k_perms_num?></th>
						</tr><?
					  while($r=mysql_f($res)){
						$code=$r['code'];
						$name=$r['name_'.$lg];
						$users=getTotalCO('_users',"grp_code='$code'");
						$perms=getTotalCO('_perm',"g_code='$code'");?>
							<tr grp="<?=$code?>">
								<td width="30">
									<input name="sel[]" type="checkbox" par="grd_chek" value="<?=$code?>" />
								</td>
								<td txt><?=$name?></td>
								<td><ff><?=$users?></ff></td>
								<td><ff><?=$perms?></ff></td>
							</tr><?
					  }?>
					</table>
					<input type="hidden" name="type" value="group"/>
				</form><?
			}?>
		</div>
	<?
	}elseif($type=='opr'){?>
		<div id="files" fix="hp:0|w:350">
			<div class="fs16 clrw pd10 lh40 cbg66 Over TC mg10f" opr="1"><?=k_file2?> funs.js</div>
			<div class="fs16 clrw pd10 lh40 cbg66 Over TC mg10f" opr="2"><?=k_file2?> funs.php</div>
            <div class="f1 fs16 clrw pd10 lh40 cbg66 Over TC mg10f" opr="3"><?=k_main_menu_cor?></div>
            <div class="f1 fs16 clrw pd10 lh40 cbg66 Over TC mg10f" opr="4"><?=k_cor_perm?></div>
            <div class="f1 fs16 clrw pd10 lh40 cbg66 Over TC mg10f" opr="5"><?=k_del_fav?></div>
            <div class="f1 fs16 clrw pd10 lh40 cbg66 Over TC mg10f" opr="6"><?=k_empty_tables?></div>
		</div>
        <form id="reset_mod" name="reset_mod" method="post" action="<?=$f_path?>M/reset_process_do.php" cb="reset_get_view('<?=$type?>')">
            <input type="hidden" name="type" value="opr"/>
        </form><?
	}
}?>