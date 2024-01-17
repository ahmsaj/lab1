<? include("ajax_header.php");
if($chPer[0]){
if(isset($_POST['mod'])){
	$mod=pp($_POST['mod'],'s');
	$ms=pp($_POST['ms'],'s');
	$msd=pp($_POST['msd'],'s');
	$sptl=pp($_POST['sptl'],'s');	
	$mod_data=loadModulData($mod);
	$cData=getColumesData($mod,0,0,'`show`=1');
	$delEvent=checkMDelEev($mod_data[17]);
	$cData_id=getColumesData($mod,1);
	$cDaTotal=count($cData);
	$co_title='';
	if($sptl!='^'){
		$sptl=Decode($sptl,_pro_id);
		$co_title=getCondetionTilte($mod_data['c'],$sptl);
	}
	$sort_data=check_Sort($ms,$msd,$mod_data[3],$mod_data[4]);	
	$sort=str_replace('(L)',$lg,$sort_data[0]);
	$sort_dir=$sort_data[1];
	$sort_text='';
	if($sort){$sort_text= " order by `$sort` $sort_dir ";}
	if($cDaTotal>0){
		$fil=pp($_POST['fil'],'s');
		$condtion=sqlFilterCondtions($mod,$fil);
		$condtion.=sqlModuleCondtions($sptl,$condtion);
		//echo '((('.$mod_condtion.')))';
		if(isset($_POST['p'])){		
			$p=pp($_POST['p']);
			//pagging------------------	
			$pagination=pagination($mod_data[1],$condtion,$mod_data[5]);			
			$page_view=$pagination[0];
			$q_limit=$pagination[1];	
			$all_rows=$pagination[2];
			$addTasks=get_aadtions_tasks($mod_data['c']);
			echo ' '.number_format($all_rows).' <!--***-->';
			if($fil!='')echo '<div class=" fil_rest_in fl ff" onclick="ser_reset(0);"></div><div class="sarTap fl">'.serDataViwe($mod,$fil).'</div><div class="cb"></div>';
            if($condtion)$condtion=' where '.$condtion;
			$table=$mod_data[1];
			//------------------------------------------------------------------------------------------------
			$sql="select * from $table $condtion $sort_text $q_limit ";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($co_title){echo '<div>'.$co_title.'</div>';}?><!--***--><?
			if($rows>0){
				$ordRec='';
				$ordHead='';
				if($mod_data[12] && $sort==$mod_data[3]){
					$ordCl="g_ord";
					$ordHead='<th width="20" class="reSoHoldH" tilte="'.k_rank_possib.'"></th>';
					$ordRec='<td width="20" class="reSoHold"><div></div></td>';
				}?>
                <form name="co_list" id="co_list_for" action="<?=$f_path.'S/sys_delRec_do.php'?>" method="post"
                cb="delBack([1]);" bv="a">
                <input type="hidden" name="mod" value="<?=$mod?>" />
				<div class="hh10"></div>
				<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH <?=$ordCl?>" t_ord="" c_ord="">
                <thead>
				<tr><?=$ordHead?>
				<? if($mod_data[11]){?><th width="30"><input type="checkbox" par="check_all" name="ti_del" /></th><? }
				$so_act='';$so_dir='so_up';				
				if($sort=='id'){$so_act='so_act';if($sort_dir=='DESC'){$so_dir='so_down';}} 
				if($mod_data[14]==1){?><th width="25" so_no="id" <?=$so_dir.' '.$so_act?> >#</th>
				<? }
				///----Table header-----------------------							
				for($i=0;$i<$cDaTotal;$i++){
					if($cData[$i][6] && $cData[$i][3]!=12 && $cData[$i][3]!=13 
					&& !($cData[$i][1]==$mod_data[3] && $mod_data[12]==1)){//show 
						$wid='';
						//------Sort-------------
						$so_act='';$so_dir='';$sort_no='';				
						$sort_files=0;
						if(in_array($cData[$i][3],array(1,2,3,4,5,6,7,9,11))){
							$so_dir='so_up';						
							if($sort==str_replace('(L)','',$cData[$i][1])){$so_act='so_act';if($sort_dir=='DESC')$so_dir='so_down';}
							$sort_no=' title="'.k_press_sort.'" so_no="'.$cData[$i][0].'';
							$sort_files=1;
						}
						if($cData[$i][3]==3){$wid=' width="50" ';}
						if(($cData[$i][3]==1 || $cData[$i][3]==7 )&& $cData[$i][9]){
							$col_l=str_replace('(L)','',$cData[$i][1]);
							if($col_l=='_'){
								for($ll=0;$ll<count($lg_s);$ll++){
									$addLangText='';if(count($lg_s)>1)$addLangText='<b>('.$lg_n[$ll].')</b> ';
									if($sort_files){
										$so_dir='so_up';$so_act='so_act';if($sort_dir=='DESC')$so_dir='so_down';
									}else{
										$so_dir='so_up';$so_act='';
									}							
									echo '<th '.$wid.' '.$sort_no.'_'.$lg_s[$ll].'" '.$so_dir.' '.$so_act.' >
									'.get_key($cData[$i][2]).' '.$addLangText.'</th>';
								}
							}else{
								echo '<th '.$wid.' '.$sort_no.'_'.$lg_s[$lg].'" '.$so_dir.' '.$so_act.' >'.get_key($cData[$i][2]).'</th>';
							}
						}else{
							echo '<th '.$wid.' '.$sort_no.'" '.$so_dir.' '.$so_act.'>'.get_key($cData[$i][2]).'</th>';
						}
					}
				}
				if($chPer['c'] || $addTasks){?>
				<th  width="30"></th>
				<? }?>
				</tr>
				</thead><tbody><?
				/// Table rows -----------------------
				$sort_color_class='td_sort_act';			
				//$r=0;
				$static_per='';
				while($r=mysql_f($res)){
					$l_id=$r['id'];
					$total=$r[$total_par[3]];
					?>
					<tr <? if($mod_data[12]){ echo 'row_id="'.$l_id.'" row_ord="'.$r[$mod_data[3]].'"';}?> >
					<?=$ordRec?>
					<? if($mod_data[11]){?>
					<td><?
					$delAct=1;
					//if($all_rows<200){$delAct=co_isDeletebl($mod_data,$l_id);}
					if($mod_data[11] && $delAct){?>
					<input name="rec[]" type="checkbox" par="grd_chek" value="<?=$l_id?>" /><? }else{echo'<div class="form_checkBox"></div>';}?></td>             
					<? }?>
					<? if($total_opr==1){?><td><?=getTotal($total_par[1],$total_par[2],$total)?></td><? }?>
					<? if($mod_data[14]==1){
						if($sort=='id'){$sort_color=$sort_color_class;}else{$sort_color='';}?><td class="<?=$sort_color?>"><?=$l_id;?></td><? 
					} 
					for($i=0;$i<$cDaTotal;$i++){
						$sort_color='';
						$vall='';
						if($sort==$cData[$i][1]){$sort_color=$sort_color_class;}
						if($cData[$i][6] && $cData[$i][3]!=12 && $cData[$i][3]!=13 
						&& !($cData[$i][1]==$mod_data[3] && $mod_data[12]==1)){//show
							if($cData[$i][9]){//lang						
								if($col_l=='_'){
									if($cData[$i][3]==14){
										$cName=str_replace('(L)',$lg,$cData[$i][1]);
										$vall=$r[$cName];
										echo '<td class="'.$sort_color.'">'.co_list($cData[$i],$vall,$l_id).'</td>';
									}else{
										for($ll=0;$ll<count($lg_s);$ll++){								
											$cName=str_replace('(L)',$lg_s[$ll],$cData[$i][1]);
											$vall=$r[$cName];
											if($sort==str_replace('(L)',$lg_s[$ll],$cData[$i][1])){
											$sort_color=$sort_color_class;}else{$sort_color='';}
											echo '<td class=" f1 '.$sort_color.'">'.co_list($cData[$i],$vall,$l_id).'</td>';
										}
									}
								}else{
									$cName=str_replace('(L)',$lg,$cData[$i][1]);						
									$vall=$r[$cName];							
									echo '<td class="'.$sort_color.'">'.co_list($cData[$i],$vall,$l_id).'</td>';
								}					
							}elseif($cData[$i][3]==15){
								echo '<td class="'.$sort_color.'">'.getCustomFiled_m($l_id,$cData[$i][5],$r).'</td>';
							}else{
								if($cData[$i][3]==10){
									$vall=get_key($cData[$i][1]);
								}else{
									$vall=$r[$cData[$i][1]];
								}
								echo '<td class="f1 '.$sort_color.'">'.get_key(co_list($cData[$i],$vall,$l_id)).'</td>';
							}
						}
					}
					if($chPer['c'] || $addTasks){
					?><td>
						<div class="gTools fr"><?						
						if($mod_data[13]){
							echo '<div class="fr ic40w icc11 ic40_info"  onclick="co_ViewRec('.$l_id.')" title="'.k_view_record.'"></div>';
						}
						if($mod_data[9]){
							if($mod_data[10]){
								$e_customAction=str_replace('[id]',$l_id,$mod_data[10]);
								$e_customAction=str_replace('js:','',$e_customAction);
								//************************
								$i=0;
								for($i=0;$i<$cDaTotal;$i++){
									$colType= $cData[$i][3];
									if(!in_array($colType,array(7,8,10,12,13,15))){
										$vall='';
										if($cData[$i][9]){//lang						
											for($ll=0;$ll<count($lg_s);$ll++){							
												$cName=str_replace('(L)',$lg_s[$ll],$cData[$i][1]);	$e_customAction=str_replace('['.$cName.']',$r[$cName],$e_customAction);
											}
										}else{
											$e_customAction=str_replace('['.$cData[$i][1].']',$r[$cData[$i][1]],$e_customAction);
										}
									}  
								}
								//************************
								echo'<div class="fr ic40w icc33 ic40_edit" onclick="'.$e_customAction.'" title="'.k_edit.'"></div>';                                
							}else{							
								echo'<div class="fr ic40w icc33 ic40_edit" onclick="co_loadForm('.$l_id.','.$mod_data[6].',0)" title="'.k_edit.'"></div>';
                                
							}
						}
                        if($mod_data[77]){
                            echo'<div class="fr ic40w icc1 ic40_note" onclick="co_loadForm('.$l_id.',11,0)" title="'.k_add_copy.'"></div>';
                        }
						if($mod_data[11] && $delAct){
							if($delEvent){$delAction='co_del_rec_e('.$l_id.')';}else{$delAction='co_del_rec('.$l_id.')';}
							echo '<div class="fr ic40w icc22 ic40_del" title="'.k_delete.'"  onclick="'.$delAction.'" ></div>';
						}
						//echo get_aadtions_tasks($mod_data['c'],$l_id);
						echo str_replace('[id]',$l_id,$addTasks);?>            
						</div>			
					</td><? 
					}?>
					</tr><?
					//$r++;
				}?>
				</tbody>        
				</table>            
				</form>
		<? }
			else{ echo '<div class="warn_msg f1 cb">'.k_no_results.'</div>';}
			echo '<!--***-->'.$page_view;
		}
	}
}
}else{out();}?>