<? include("ajax_header.php");
?><div class="win_body"><?
if(isset($_POST['type']) && ( isset($_POST['id']) || isset($_POST['code'])) ){
	if(isset($_POST['code'])){
		$code=pp($_POST['code'],'s');
		$type=pp($_POST['type']);
		if($type==1){$table='_modules';}
		if($type==2){$table='_modules_';}
		$module_name=get_val_c($table,'title_'.$lg,$code,'code');
		$modCode=get_val_con('_modules_list','code',"mod_code='$code' and type='$type'");?>
		<div class="form_header f1 fs18 clr1 lh40"><?=get_key($module_name)?> 
		<div class="fr ic40x icc1 ic40_ref" onclick="cusPer('<?=$code?>',<?=$type?>)"></div>
		</div>
		<div class="form_body so" type="pd0"><?
		/***********************************************/
		$mods1Arr=array();
		$sql="SELECT * from $table where code='$code' ";
		$res=mysql_q($sql);
		$r=getRecCon($table,"code='$code'");
		if($r['r']){
			$this_id=$r['code'];
			$module=$r['module'];
			$p_add=$r['opr_add'];
			$p_edit=$r['opr_edit'];
			$p_del=$r['opr_del'];
			$p_view=$r['opr_view'];

			$savePar=array();
			$sql="select * from _perm where m_code='$modCode' ";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				while($r=mysql_f($res)){
					$m_id=$r['g_code'];
					$savePar[$m_id]=$r;					
				}		
			}?>
			<form name="per_el" id="per_el" method="post" action="<?=$f_path?>S/sys_per_save.php">
				<input type="hidden" name="code" value="<?=$code?>" />
				<input type="hidden" name="type" class="text_f" value="<?=$type?>"/>
				<table class="grad_s holdH"  width="100%" cellpadding="4" cellspacing="0" type="static">  
				<tr>				
				<th><input type="checkbox" value="1"name="sAll" par="per_all"/></th>
				<th><?=k_module?></th>
				<th width="50"><?=k_show?></th>
				<th width="50"><?=k_add?></th>
				<th width="50"><?=k_edit?></th>
				<th width="50"><?=k_delete?></th>
				<th width="50"><?=k_view?></th>
				</tr>
				<?
				$hideIds='';
				$sql="select * from _groups order by name_$lg ASC ";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				$data_arr=array();
				if($rows>0){
					$i=0;
					while($r=mysql_f($res)){
						$g_id=$r['id'];
						$name=$r['name_'.$lg];
						$g_code=$r['code'];
						$addM='';
						$ch='';$ch0='';$ch1='';$ch2='';$ch3='';$ch4='';$trBg='';
						
						if($savePar[$g_code]){							
							$ch=' checked ';$trBg='#eee';							
							if($savePar[$g_code]['p0'])$ch0=' checked ';
							if($savePar[$g_code]['p1'])$ch1=' checked ';
							if($savePar[$g_code]['p2'])$ch2=' checked ';
							if($savePar[$g_code]['p3'])$ch3=' checked ';
							if($savePar[$g_code]['p4'])$ch4=' checked ';
						}else{if($hideIds!=''){$hideIds.=',';} $hideIds.=$g_code;}

						$inp1=$inp2=$inp3=$inp4='-';
						if($p_add){$inp1='<input type="checkbox" name="per_'.$g_code.'_1" value="1" par="per_in_'.$g_code.'" '.$ch1.'/>';}			
						if($p_edit){$inp2='<input type="checkbox" name="per_'.$g_code.'_2" value="1" par="per_in_'.$g_code.'" '.$ch2.'/>';}				
						if($p_del){$inp3='<input type="checkbox" name="per_'.$g_code.'_3" value="1" par="per_in_'.$g_code.'" '.$ch3.'/>';}		
						if($p_view){$inp4='<input type="checkbox" name="per_'.$g_code.'_4" value="1" par="per_in_'.$g_code.'" '.$ch4.'/>';}
						
						echo '<tr style="background-color:'.$trBg.';">						
						<td no="'.$data['code'].'" width="30" >
						<input type="checkbox" name="per_'.$g_code.'" value="'.$g_code.'"  par="per_sel_" '.$ch.'/></td>
						<td class="f1 fs14" style="text-align:'.k_align.'">'.$name.'</td>						
						<td><input type="checkbox" name="per_'.$g_code.'_0" value="1" par="per_in_'.$g_code.'" '.$ch0.'/></td>
						<td>'.$inp1.'</td>
						<td>'.$inp2.'</td>
						<td>'.$inp3.'</td>
						<td>'.$inp4.'</td>							
						</tr></tr>';
					}
				}?>        
				</table>            
				</form>
			<?=script('hIds="'.$hideIds.'";');
			?></div><?
		}
	}else{
		$q='';
		//echo $proActStr;
		$b='';
		$modX1=get_vals('_modules','code'," progs not IN($proActStr) and progs!=''","','");
		$modX2=get_vals('_modules_','code'," progs not IN($proActStr) and progs!=''","','");
		if($modX1 && $modX2){$b=',';}		
		if($modX1 && $modX2){
			if($modX1){$modX1="'$modX1'";}
			if($modX2){$modX2="'$modX2'";}
			$q.=" and mod_code not IN($modX1 $b $modX2)";
		}
		$title='';
		if($thisGrp!='s'){$q.=" and sys=0 ";}
		$id=pp($_POST['id'],'s');
		$id2=$id;
		$type=pp($_POST['type']);
		$type2=$type;
		if($type==2){
			$x=getTotalCO('_perm'," type='$type' and g_code='$id'");
			if($x==0){$type2=1; $id2=get_val_c('_users','grp_code',$id,'code');}
			$title=get_val_c('_users','name_'.$lg,$id,'code');
		}else{
			$title=get_val_c('_groups','name_'.$lg,$id,'code');
		}?>
		<div class="form_header f1 fs18 clr1 lh40"><?=$title?> 
		<!---<div class="fr ic40x icc1 ic40_ref" onclick="cusPer('<?=$code?>',<?=$type?>)"></div>-->
		</div>
		<div class="form_body so" type="pd0"><?
		/***********************************************/
		$mods1Arr=array();
		$sql="SELECT * from _modules";
		$res=mysql_q($sql);$rows=mysql_n($res);			
		if($rows>0){
			while($r=mysql_f($res)){
				$this_id=$r['code'];
				$mods1Arr[$this_id]['module']=$r['module'];
				$mods1Arr[$this_id]['add']=$r['opr_add'];
				$mods1Arr[$this_id]['edit']=$r['opr_edit'];
				$mods1Arr[$this_id]['del']=$r['opr_del'];
				$mods1Arr[$this_id]['view']=$r['opr_view'];
			}
		}
		$mods2Arr=array();
		$sql="SELECT * from _modules_";
		$res=mysql_q($sql);
		$rows=mysql_n($res);			
		if($rows>0){
			while($r=mysql_f($res)){
				$this_id=$r['code'];
				$mods2Arr[$this_id]['module']=$r['module'];
				$mods2Arr[$this_id]['add']=$r['add'];
				$mods2Arr[$this_id]['edit']=$r['edit'];
				$mods2Arr[$this_id]['del']=$r['delete'];
				$mods2Arr[$this_id]['view']=$r['view'];
			}
		}	
		/***********************************************/
		$savePar=array();
		$sql="select * from _perm where type='$type2' and g_code='$id2'";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			while($r=mysql_f($res)){
				$m_id=$r['m_code'];
				$savePar[$m_id]=$r;
			}		
		}
		/***********************************************/
		$sql="select * from _modules_list where act=1 $q order by ord ASC ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		$data_arr=array();
		if($rows>0){
			$i=0;
			while($r=mysql_f($res)){			
				$data_arr[$i]['code']=$r['code'];	
				$data_arr[$i]['mod_code']=$r['mod_code'];				
				$data_arr[$i]['title']=$r['title_'.$lg];
				$data_arr[$i]['icon']=$r['icon'];
				$data_arr[$i]['type']=$r['type'];
				$data_arr[$i]['p_code']=$r['p_code'];
				$data_arr[$i]['act']=$r['act'];
				$i++;
			}?>
			<form name="per_el" id="per_el" method="post" action="<?=$f_path?>S/sys_per_save.php">
			<input type="hidden" name="id" value="<?=$id?>" />
			<input type="hidden" name="type" class="text_f" value="<?=$type?>"/>
			<table class="grad_s holdH"  width="100%" cellpadding="4" cellspacing="0" type="static">  
			<tr>
			<th width="40"></th>
			<th><input type="checkbox" value="1"name="sAll" par="per_all"/></th>
			<th><?=k_module?></th>
			<th width="50"><?=k_show?></th>
			<th width="50"><?=k_add?></th>
			<th width="50"><?=k_edit?></th>
			<th width="50"><?=k_delete?></th>
			<th width="50"><?=k_view?></th>
			</tr>
			<?
			$hideIds='';
			foreach($data_arr as $data){
				$module_name='';
				if($data['p_code']=='0'){
					$p_code=$data['code'];				
					$module_name='';												
					if($data['type']==3){
						echo '<tr><td colspan="8" class="cbg44 f1 fs20 clrw" no="'.$data['code'].'" >'.$data['title'].'</td></tr>';
					}else{
						if($data['type']==0){
							echo '<tr>
							<td></td>
							<td no="'.$data['code'].'" width="30" ><input type="checkbox" value="'.$data['code'].'" par="per_mm"/></td>
							<td  colspan="6" class="f1 fs20" style="text-align:'.k_align.'">'.$data['title'].' '.$module_name.'</td>
							</tr>';
						}else{
							$addM='';
							if($data['type']==1){//$module_name=' ('.$mods1Arr[$data['mod_code']]['module'].' )';
							}
							if($data['type']==2){//$module_name=' ('.$mods2Arr[$data['mod_code']]['module'].' )';$addM=' * ';
							}
							$ch=$ch0=$ch1=$ch2=$ch3=$ch4=$trBg='';
							if($savePar[$data['code']]){
								$ch=' checked ';$trBg='#eee';							
								if($savePar[$data['code']]['p0'])$ch0=' checked ';
								if($savePar[$data['code']]['p1'])$ch1=' checked ';
								if($savePar[$data['code']]['p2'])$ch2=' checked ';
								if($savePar[$data['code']]['p3'])$ch3=' checked ';
								if($savePar[$data['code']]['p4'])$ch4=' checked ';							
							}else{if($hideIds!=''){$hideIds.=',';} $hideIds.=$data['code'];}
							$inp1=$inp2=$inp3=$inp4='-';
							if(${'mods'.$data['type'].'Arr'}[$data['mod_code']]['add']){					
								$inp1='<input type="checkbox" name="per_'.$data['code'].'_1" value="1" par="per_in_'.$data['code'].'" '.$ch1.'/>';
							}							
							if(${'mods'.$data['type'].'Arr'}[$data['mod_code']]['edit']){
								$inp2='<input type="checkbox" name="per_'.$data['code'].'_2" value="1" par="per_in_'.$data['code'].'" '.$ch2.'/>';
							}							
							if(${'mods'.$data['type'].'Arr'}[$data['mod_code']]['del']){
								$inp3='<input type="checkbox" name="per_'.$data['code'].'_3" value="1" par="per_in_'.$data['code'].'" '.$ch3.'/>';
							}							
							if(${'mods'.$data['type'].'Arr'}[$data['mod_code']]['view']){
								$inp4='<input type="checkbox" name="per_'.$data['code'].'_4" value="1" par="per_in_'.$data['code'].'" '.$ch4.'/>';
							}

							echo '<tr style="background-color:'.$trBg.';">
							<td><div class="ic40x icc1 ic40_set" onclick="cusPer(\''.$data['mod_code'].'\','.$data['type'].')"></div></td>
							<td no="'.$data['code'].'" width="30" >
								<input type="checkbox" name="per_'.$data['code'].'" value="'.$data['code'].'"  par="per_sel_" '.$ch.'/>
							</td>
							<td class="f1 fs14" style="text-align:'.k_align.'">'.$addM.$data['title'].$module_name.'</td>						
							<td><input type="checkbox" name="per_'.$data['code'].'_0" value="1" par="per_in_'.$data['code'].'" '.$ch0.'/></td>
							<td>'.$inp1.'</td>
							<td>'.$inp2.'</td>
							<td>'.$inp3.'</td>
							<td>'.$inp4.'</td>							
							</tr></tr>';
						}
					}
					if($data['type']==0){
						foreach($data_arr as $data2){
							$addM='';
							if($data2['p_code']==$p_code){
								if($data2['type']==1){//$module_name=' ('.$mods1Arr[$data2['mod_code']]['module'].' )';
								}
								if($data2['type']==2){//$module_name=' ('.$mods2Arr[$data2['mod_code']]['module'].' )';$addM=' * ';
								}
								$ch='';$ch0='';$ch1='';$ch2='';$ch3='';$ch4='';
								if($savePar[$data2['code']]){
									$ch=' checked ';							
									if($savePar[$data2['code']]['p0']){$ch0=' checked ';}
									if($savePar[$data2['code']]['p1']){$ch1=' checked ';}
									if($savePar[$data2['code']]['p2']){$ch2=' checked ';}
									if($savePar[$data2['code']]['p3']){$ch3=' checked ';}
									if($savePar[$data2['code']]['p4']){$ch4=' checked ';}							
								}else{
									if($hideIds!=''){$hideIds.=',';} $hideIds.=$data2['code'];
								}
								$inp1=$inp2=$inp3=$inp4='-';							
								if(${'mods'.$data2['type'].'Arr'}[$data2['mod_code']]['add']){
									$inp1='<input type="checkbox" name="per_'.$data2['code'].'_1" value="1" par="per_in_'.$data2['code'].'" '.$ch1.'/>';
								}							
								if(${'mods'.$data2['type'].'Arr'}[$data2['mod_code']]['edit']){
									$inp2='<input type="checkbox" name="per_'.$data2['code'].'_2" value="1" par="per_in_'.$data2['code'].'" '.$ch2.'/>';
								}							
								if(${'mods'.$data2['type'].'Arr'}[$data2['mod_code']]['del']){
									$inp3='<input type="checkbox" name="per_'.$data2['code'].'_3" value="1" par="per_in_'.$data2['code'].'" '.$ch3.'/>';
								}							
								if(${'mods'.$data2['type'].'Arr'}[$data2['mod_code']]['view']){
									$inp4='<input type="checkbox" name="per_'.$data2['code'].'_4" value="1" par="per_in_'.$data2['code'].'" '.$ch4.'/>';
								}							
								echo '
								<tr>
								<td><div class="ic40x icc1 ic40_set" onclick="cusPer(\''.$data2['mod_code'].'\','.$data2['type'].')"></div></td>
								<td></td>
								<td no="'.$data2['code'].'" class="f1 fs14 lh40" style="text-align:'.k_align.'">
								<input type="checkbox" name="per_'.$data2['code'].'" value="'.$data2['code'].'" par="per_sel_'.$data['code'].'" '.$ch.'/>
								'.$addM.get_key($data2['title']).$module_name.'</td>';
								echo '<td><input type="checkbox" name="per_'.$data2['code'].'_0" value="1" par="per_in_'.$data2['code'].'" '.$ch0.'/></td>
								<td>'.$inp1.'</td>
								<td>'.$inp2.'</td>
								<td>'.$inp3.'</td>
								<td>'.$inp4.'</td>							
								</tr>';						
							}
						}
					}
				}
			}?>        
			</table>            
			</form>
			<?=script('hIds="'.$hideIds.'";');
		}?>
		</div> 
		<? 
	}?>
    <div class="form_fot fr">
        <div class="bu bu_t2 fr" onclick="$('#m_info4').dialog('close')"><?=k_cancel?></div>
        <div class="bu bu_t1 fl" onclick="sub('per_el')"><?=k_save?></div>
    </div>
        
<? }?>
</div>