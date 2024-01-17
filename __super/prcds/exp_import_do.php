<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['exp_file'],$_POST['sel'])){
	$sel_mods=$_POST['sel'];
	$exp_file=pp($_POST['exp_file']);
	$upFile=getUpFiles($exp_file)[0];
	$path='../../sFile/'.$upFile['folder'].$upFile['file'];
	if(file_exists($path)){
		$content_raw=trim(file_get_contents($path));
		$encoding=intval($content_raw[0]);
		$content=substr($content_raw,1);
		if($encoding){
			$content=Decode($content,_pro_id);
		}
		$arr=json_decode($content,true);
		if(count($arr['mods'])>0){
			//$sys_langs=get_vals('_langs','lang',"1=1",'arr');
			$imp_langs=$arr['langs'];
			$req_ex_files=[]; $done=0;
			$req_tables=$is_content_tables=[]; 
			$m=$m_=$t_data=$t_struct=$f=$m_f_no=$m_f_all_no=0;
			foreach($sel_mods as $cat_num=>$mods){
				foreach($mods as $mod){
					$mod_data=$arr['mods'][$cat_num][$mod];
					$mod_info=$mod_data['info'];
					$mod_lists=$mod_data['modules_list'];
					if(isset($_POST['ex_'.$mod])){
						$ex=pp($_POST['ex_'.$mod],'s');
						if($ex && $ex !=''){
							$req_ex_files=array_unique(array_merge($req_ex_files,explode(',',$ex)));
						}
					}
					if($mod_info['lk_tables']!=''){ // الجداول المرتبطة بهذا الموديول الموديول والمراد إنشاؤها
						$te=$mod_info['lk_tables'];
						if($te && $te !=''){
							$req_tables=array_unique(array_merge($req_tables,explode(',',$te)));
						}
					}

					if(isset($_POST['lk_'.$mod])){// الجداول المراد استيراد محتواها
						$te=pp($_POST['lk_'.$mod],'s');
						if($te && $te !=''){
							$is_content_tables=array_unique(array_merge($is_content_tables,explode(',',$te)));
						}
					}
					if($cat_num==0){
						$mod_conds=$mod_data['modules_cons'];
						$mod_links=$mod_data['modules_links'];
						$mod_items=$mod_data['modules_items'];
						$mod_butts=$mod_data['modules_butts'];
						if(count($mod_info)>0){
							$done=0;
							if($mod_info['table'] && $mod_info['table']!=''){	
								array_push($req_tables,$mod_info['table']);
								$req_tables=array_unique($req_tables);
							}
							$ord=get_val_con('_modules','ord',"code='$mod'");
							if($ord){
								$mod_info['ord']=$ord;
							}else{
								$max_order=getMaxMin('max','_modules','ord');
								$mod_info['ord']=$max_order+1;
							}
							$titleLang='';
							exp_fixTitleLang($titleLang,$mod_info,$imp_langs,$lg_s);
							$str_data="'".implode("','",$mod_info)."'";
                            $str_data="
                            '".$mod_info['code']."',
                            '".$mod_info['progs']."',
                            '".$mod_info['progs_used']."',
                            '".$mod_info['module']."',
                            '".$mod_info['table']."',
                            '".$mod_info['order']."',
                            '".$mod_info['order_dir']."',
                            '".$mod_info['rpp']."',
                            '".$mod_info['opr_type']."',
                            '".$mod_info['opr_add']."',
                            '".$mod_info['add_page']."',
                            '".$mod_info['opr_edit']."',
                            '".$mod_info['edit_page']."',
                            '".$mod_info['opr_del']."',
                            '".$mod_info['opr_copy']."',
                            '".$mod_info['opr_order']."',
                            '".$mod_info['opr_export']."',
                            '".$mod_info['act']."',
                            '".$mod_info['exFile']."',
                            '".$mod_info['opr_show_id']."',
                            '".$mod_info['ord']."',
                            '".$mod_info['opr_view']."',
                            '".$mod_info['sys']."',
                            '".$mod_info['icon']."',
                            '".$mod_info['ids_set']."',
                            '".$mod_info['events']."',
                            '".$mod_info['lk_tables']."',                            
                            ";
                            foreach($lg_s as $l){
                                if(in_array($l,$imp_langs)){
                                    $str_data.="'".$mod_info['title_'.$l]."',";
                                }
                            }
                            $str_data=rtrim($str_data, ',');
							if(mysql_q("delete from `_modules` where code='$mod'")&&
							 mysql_q("delete from `_modules_cons` where mod_code='$mod'")&&
							 mysql_q("delete from `_modules_links` where mod_code='$mod'")&&
							 mysql_q("delete from `_modules_items` where mod_code='$mod'")&&
							 mysql_q("delete from `_modules_butts` where mod_code='$mod'")){
							 $sql="INSERT INTO `_modules`(`code`, `progs`, `progs_used`, `module`,`table`, `order`, `order_dir`, `rpp`, `opr_type`, `opr_add`, `add_page`, `opr_edit`, `edit_page`, `opr_del`,`opr_copy`,`opr_order`, `opr_export`, `act`, `exFile`, `opr_show_id`, `ord`, `opr_view`, `sys`, `icon`, `ids_set`, `events` ,`lk_tables` $titleLang) VALUES ($str_data)"; 
							 if(mysql_q($sql)){$done=1;}
							}
						}
						
						if(is_array($mod_conds) && $done){						
							$str_data=''; $done=0;
							foreach($mod_conds as $mod_cond){
								if($str_data!=''){$str_data.=',';}
								$str_data.="('".implode("','",$mod_cond)."')";
							}
							$sql="INSERT INTO `_modules_cons`(`mod_code`, `colume`, `type`, `val`) VALUES $str_data";
							if(mysql_q($sql)) $done=1; 
						}
						if(is_array($mod_links) && $done){
							$str_data=''; $done=0;
							foreach($mod_links as $mod_link){
								if($str_data!=''){$str_data.=',';}
								$str_data.="('".implode("','",$mod_link)."')";
							}
							$sql="INSERT INTO `_modules_links`(`mod_code`, `table`, `colume`, `val`) VALUES $str_data";
							if(mysql_q($sql)) $done=1;
						}
						if(is_array($mod_items) && $done){
							$str_data=''; $done=0;
							foreach($mod_items as $mod_item){
								if($str_data!=''){$str_data.=',';}
								$str_data.="('".implode("','",$mod_item)."')";
							}
							$sql="INSERT INTO `_modules_items`(`code`, `mod_code`, `colum`, `title`, `type`, `validit`, `prams`, `show`, `requerd`, `ord`, `defult`, `lang`, `note`, `filter`, `link`, `act`) VALUES $str_data";
							if(mysql_q($sql)) $done=1;
						}
						if(is_array($mod_butts) && $done){
							$str_data=''; $done=0;
							foreach($mod_butts as $mod_butt){
								if($str_data!=''){$str_data.=',';}
								$str_data.="('".implode("','",$mod_butt)."')";
							}
							$sql="INSERT INTO `_modules_butts`(`mod_code`, `title`, `function`, `style`) VALUES $str_data";
							if(mysql_q($sql)){$done=1;}
						}

					}elseif($cat_num==1){
						if(count($mod_info)>0){
							$done=0;
							$ord=get_val_con('_modules_','ord',"code='$mod'");
							if($ord){
								$mod_info['ord']=$ord;
							}else{
								$max_order=getMaxMin('max','_modules_','ord');
								$mod_info['ord']=$max_order+1;
							}
							$titleLang='';
							exp_fixTitleLang($titleLang,$mod_info,$imp_langs,$lg_s);
							$str_data="'".implode("','",$mod_info)."'";
							if(mysql_q("delete from `_modules_` where code='$mod'")){
								$sql="INSERT INTO `_modules_`(`code`, `progs`, `progs_used`, `module`,`file`, `exFile`, `icon`, `sys`, `add`, `edit`, `delete`, `view`, `ord` ,`lk_tables`,`act` $titleLang) VALUES ($str_data)";
								if(mysql_q($sql)){ $done=1;}
								if(isset($_POST['mod_file_'.$mod])){
									$m_f=pp($_POST['mod_file_'.$mod],'s');
									$mod_file=$mod_info['file'];
									if($m_f==$mod_file){
										$done=0;
										$m_f_all_no++;
										$mod_file_req=$arr['mod_files'][$mod_file];
										$data=$mod_file_req['data'];
                                        $fileName=$mod_file_req['file'];
                                        $prog=$mod_file_req['prog'];
                                        $file_type=$mod_file_req['type'];
                                        $file_code=$mod_file_req['code'];
                                        $need_per=$mod_file_req['need_per'];                                        
                                        $folder=getModFolder($prog);
                                        $name_mode_file=$folder.'mods/'.$fileName.'.php';
										//$name_mode_file='../../_'.$prog.'.$mod_file_req['file'].'.php';
										file_put_contents($name_mode_file,$data);
										if($mod_file_req){
											//$mod_file_req['data']='';
											//$str_data="'".implode("','",$mod_file_req)."'";
											if(mysql_q("delete from `_modules_files` where code='$mod_file'")){
												$sql="INSERT INTO `_modules_files`(`code`, `file`, `type`,`prog`) VALUES ('$file_code','$fileName','$file_type','$prog')";
												if(mysql_q($sql)){ $done=1; $m_f_no++;  }
											}
										}
									}
								}
							}
						}
					}
					if(count($mod_lists)>0 && $done){
						$ord=get_val_con('_modules_list','ord',"mod_code='$mod'");
						if($ord){
							$mod_lists['ord']=$ord;
						}else{
							$max_order=getMaxMin('max','_modules_list','ord');
							$mod_lists['ord']=$max_order+1;
						}
						if(mysql_q("delete from `_modules_list` where mod_code='$mod'")){
							$p_code=$mod_lists['p_code'];
							$isExist_list=get_val_con('_modules_list','code',"code='$p_code'");
							if(!$isExist_list){ $mod_lists['p_code']=0;}
							$done=0;
							$titleLang='';
							exp_fixTitleLang($titleLang,$mod_lists,$imp_langs,$lg_s);
							$str_data="'".implode("','",$mod_lists)."'";
						    $sql="INSERT INTO `_modules_list`(`code`,`sys`, `type`, `p_code`, `mod_code`, `icon`, `ord`, `act`, `hide` $titleLang) VALUES ($str_data)";
							if(mysql_q($sql)){$done=1; if($cat_num==1){$m_++;}else{$m++;} }
						}
					}
					
				}
				
			}
			
			if(is_array($arr['ex_files']) && count($req_ex_files)>0){
				foreach($req_ex_files as $ex_file){
					if($done){
						$done=0;
						$ex_file_req=$arr['ex_files'][$ex_file];
						$data=$ex_file_req['data'];
                        
                        
                        
                        $fileName=$mod_file_req['file'];
                        $prog=$mod_file_req['prog'];
                        $file_type=$mod_file_req['type'];
                        $file_code=$mod_file_req['code']; 
                        
                        $need_per=$mod_file_req['need_per']; 
                        $info=$mod_file_req['info']; 
                        
                        
                        $folder=getModFolder($prog);
                        $name_ex_file=$folder.'prcds/'.$fileName.'.php';                        
						//$name_ex_file='../ajax/'.$ex_file_req['file'].'.php';//<-------
						file_put_contents($name_ex_file,$data);
						if($ex_file_req){
							if(mysql_q("delete from `_modules_files_pro` where code='$ex_file'")){
								$ex_file_req['data']='';
								//$str_data="'".implode("','",$ex_file_req)."'";
								$sql="INSERT INTO `_modules_files_pro`(`code`, `file`, `prog`, `info`,`need_per`,`type`) VALUES ('$file_code','$fileName','$prog','$info','$need_per','$file_type')";
								if(mysql_q($sql)){ $done=1; $f++;}
							}
						}
					}
				}
			}
			
			if($done && count($arr['tables'])>0 && count($req_tables)>0){
				foreach($req_tables as $table){
					$table_struct_data=explode('|^-^|',$arr['tables'][$table]);
					$table_struct=$table_struct_data[0];
					$table_data=$table_struct_data[1];
					if(mysql_q($table_struct)){
						if(in_array($table,$is_content_tables)){
							if(mysql_q($table_data)){$t_data++;}
						}
					}
				}
			}
		}
		
	}
if($done){
	if(isset($sel_mods[0])){
		echo $m.'-'.(count($sel_mods[0])).',';
	}else{
		echo $m.'-0,';
	}
	if(isset($sel_mods[1])){
		echo $m_.'-'.count($sel_mods[1]).'-'.$m_f_no.'-'.$m_f_all_no.',';
	}else{
		echo $m_.'-0-'.$m_f_no.'-'.$m_f_all_no.',';
	}
	if(isset($is_content_tables)){
		echo $t_data.'-'.count($is_content_tables).',';
	}else{
		echo $t_data.'-0,';
	}
	if(isset($is_content_tables)){	
		echo $f.'-'.count($is_content_tables);
	}else{
		echo $f.'-0';
	}
}else{echo 0;}
}?>