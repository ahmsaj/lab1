<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['state'])){
	$catsTxt=[k_bmod,k_amod];
	$tables=['_modules','_modules_'];
	$items=['title_'.$lg,'title_'.$lg];
	$state=pp($_POST['state'],'s');
	if($state=='wind_add'){?>
		<div class="win_body">
		<div class="form_body so">
			<table class="fTable" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td n width="20%"><?=k_mods_file?> :</td>
                    <td>
                        <div style="margin-top:15px;">
                            <?=upFile('exp_mwd','',1,'exp_content_exported_file()')?>
                        </div>
                    </td>
                </tr>
			</table>
		</div>
		<div class="form_fot fr">
			<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>     
		</div>
		</div><?
   }elseif($state=='live'){
		if(isset($_POST['file'])){
			$file=pp($_POST['file']);
			$upFile=getUpFiles($file)[0];
		    $path='../../sFile/'.$upFile['folder'].$upFile['file'];
			if(file_exists($path)){
				$content_raw=trim(file_get_contents($path));
				$encoding=intval($content_raw[0]);
				$content=substr($content_raw,1);
				if($encoding){
					$content=Decode($content,_pro_id);
				}
				if($content && $content!=''){
					$arr=json_decode($content,true);
					if(count($arr['mods'])>0){?>
						<form id="exp_form_mod_import" name="exp_form_mod_import" method="post" action="<?=$f_path?>M/exp_import_do.php" cb="exp_callBack_import(<?=$file?>,'[1],[2],[3],[4]')" bv="m,m_,t_data,f">
						<input type="hidden" name="exp_file" value="<?=$file?>" />
						<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" type="static" over="0">
						<tbody>
							<tr>
								<th>
									<input type="checkbox" par="check_all" name="ti_bak" />
								</th>
								<th><?=k_file_mods?></th>
								<th><?=k_program?></th>
								<th><?=k_usd_pro?></th>
								<th><?=k_jx_fl?></th>
								<th><?=k_amod_file?></th>
								<th><?=k_lnkd_tbls_contnt?></th>
								<th></th>
							</tr>
							<? 
								foreach($arr['mods'] as $cat_num=>$mods){
									$cat_title=$catsTxt[$cat_num];
									foreach($mods as $mod=>$mod_data){
										$mod_data=$arr['mods'][$cat_num][$mod]['info'];
										$mod_conds=$arr['mods'][$cat_num][$mod]['modules_cons'];
										$mod_links=$arr['mods'][$cat_num][$mod]['modules_links'];
										$code=$mod;
										$title=$mod_data['title_'.$lg];
										$progs=$mod_data['progs'];
										$exFile=$mod_data['exFile'];
										$progs_used=$mod_data['progs_used'];
										$lk_tables=$mod_data['lk_tables'];
										$count_used_pro=$count_ex_file=$count_event=0;
										$req_tables=$lt_tables_arr=[];
										$used_pro_txt=$ex_file_txt=$event_txt=$condsTxt=$linksTxt='-';
										if($progs_used && $progs_used!=''){
											$progs_used=explode(',',$progs_used);
											$count_used_pro=count($progs_used);
											$used_pro_txt='( <ff>'.$count_used_pro.'</ff> ) '.k_program;
										}
										if($exFile!=''){
											$exFiles=explode(',',$exFile);
											$count_ex_file=count($exFiles);
											$ex_file_txt='( <ff>'.$count_ex_file.'</ff> ) '.k_file2;
										}
										$progTxt='-';
										if($progs && $progs!=''){
											$isExist=get_val_con('_programs','id',"code='$progs'");
											$clr='clr6'; $cbg='cbg6'; $ic='&#10003;'; $t='';
											if(!$isExist){
												$clr='clr5'; $cbg='cbg5'; $ic='+';  $t=' onclick="exp_prog_add(\''.$progs.'\','.$file.')" ';
											}
											$progTxt='
                                                <div class="exp_bord '.$clr.' c_cont">
                                                    <div icon '.$t.' class="'.$cbg.'">'.$ic.'</div>
                                                    <div t >'.strtoupper($progs).'</div>
                                                </div>';
										}
				
										$clr_mod=$clr666;
										$isExist_mod=get_val_con($tables[$cat_num],'code',"code='$mod'");
										if(!$isExist_mod){$clr_mod=$clr555;}

										?>

										<tr mod="<?=$mod?>" cat_num="<?=$cat_num?>" style="background-color: <?=$clr_mod?>">	
											<td width="30">
												<input name="sel[<?=$cat_num?>][]" type="checkbox" par="grd_chek" value="<?=$mod?>" />
											</td>
											<td txt><?=$title?> (<?=$cat_title?>)
											<td width="100" txt><?=$progTxt?></td>				
											<td width="150"><?
												if($count_used_pro!=0){?>
													<? foreach($progs_used as $prog){
														$isExist=get_val_con('_programs','id',"code='$prog'");
														$clr='clr6'; $cbg='cbg6'; $ic='&#10003;'; $t='';
														if(!$isExist){
															$clr='clr5'; $cbg='cbg5'; $ic='+';  $t=' onclick="exp_prog_add(\''.$prog.'\','.$file.')" ';
														}?>
														<div class="exp_bord fl <?=$clr?>">
															<div icon <?=$t?> class="<?=$cbg?>"><?=$ic?></div>
															<div t><?=strtoupper(splitNo($prog))?></div>
														</div>
													 <?}?>
								                <?}?>
											</td>
											<td txt><?
											if($count_ex_file!=0){?>
												<div id="ex_files" class="MultiBlc cb so"  chM="ex_<?=$mod?>" n="<?=$mod?>">
													<input type="hidden" name="ex_<?=$mod?>" id="mlt_ex_<?=$mod?>" value="<?=$exFile?>"  n="<?=$mod?>" >
												<? foreach($exFiles as $ex_file){
														$file_name=$arr['ex_files'][$ex_file]['file'];
														$isExist=get_val_con('_modules_files_pro','id',"code='$ex_file'");
														$state_file='exist'; 
														if(!$isExist){ $state_file='not_exist';}?>

														<div id="dd" class="cMul" v="<?=$ex_file?>" ch="on" n="<?=$mod?>" set cc="<?=$state_file?>" ><?=splitNo($file_name)?></div>
												 <?}?>
												</div>
											<?}?>
											</td>
											<td txt><?
												if($cat_num==1){
													$mod_file=$mod_data['file'];
													$file_name=$arr['mod_files'][$mod_file]['file'];
													$isExist=get_val_con('_modules_files','id',"code='$mod_file'");
													$state_file='exist'; 
													if(!$isExist){ $state_file='not_exist'; }?>
													<div id="mod_file" class="MultiBlc cb so"  chM="mod_file_<?=$mod?>" n="m_f">
														<input type="hidden" name="mod_file_<?=$mod?>" id="mlt_mod_file_<?=$mod?>" value="<?=$mod_file?>"  n="m_f" >
															<div class="cMul" v="<?=$mod_file?>" ch="on" n="m_f" set cc="<?=$state_file?>"><?=splitNo($file_name)?></div>
													</div>
												<?}?>
											</td>
											<td><?
												if($cat_num==0){
													$req_tables[0]=$mod_data['table'];
													if($lk_tables!=''){
														$lk_tables.=','.$mod_data['table'];
													}
													else{
														 $lk_tables=$mod_data['table'];
													}
												}
												if($lk_tables&&$lk_tables!=''){
													$req_tables=array_unique(explode(',',$lk_tables));
												}

												?>
												<div id="lk_tables" class="MultiBlc cb so"  chM="lk_<?=$mod?>" n="lk_<?=$mod?>">
													<input type="hidden" name="lk_<?=$mod?>" id="mlt_lk_<?=$mod?>" value="<?=$lk_tables?>"  n="lk_<?=$mod?>" >
												<? foreach($req_tables as $table){
														$state_table='exist';
														$r=mysql_q("SHOW TABLES LIKE '.$table.' ;");	
														if(!mysql_f($r)){																
															$state_table='not_exist';															
														}?>
														<div id="dd" class="cMul" v="<?=$table?>" ch="on" n="lk_<?=$mod?>"  cc="<?=$state_table?>" set ><?=splitNo($table)?></div>
												 <?}?>
												</div>
											</td>
											<td width="40">					
												<div class="ic40 icc1 ic40_download" title="<?=k_import?>" onclick="exp_mod_import_do_confirm(<?=$cat_num?>,'<?=$mod?>')"></div>
											</td>
										</tr><?
									}
								}?>
							</tbody>
						</table>
						</form>
						<? echo '^ <span class="lh50 fs18 f1 clr1">'.k_file_conts_chos_import.':</span>';
					}
				}else echo "^ ".k_err_file_open_or_perm;
			}else{
				echo '^ '.k_err_fle_import;
			}
		}
	}
	
}?>
