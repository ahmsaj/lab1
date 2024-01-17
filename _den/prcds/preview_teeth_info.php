<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['n'] , $_POST['vis'] , $_POST['t'])){
	$n=pp($_POST['n']);
	$vis=pp($_POST['vis']);
	$t=pp($_POST['t']);
	$rNo=pp($_POST['r']);
	$lastCavNo=0;
	list($patient,$doctor)=get_val('den_x_visits','patient,doctor',$vis);
	if($doctor=$thisUser){	list($pos,$t_type,$no,$t_code,$cavities)=get_val_c('den_m_teeth','pos,t_type,no,t_code,cavities',$n,'no');
		$t_code=strtolower($t_code);
		$codes=str_split($t_code);
		$f_center=$codes[1];
		if($pos==1){$f_top=$codes[0];$f_right='m';$f_bot=$codes[2];$f_left='d';}
		if($pos==2){$f_top=$codes[0];$f_right='d';$f_bot=$codes[2];$f_left='m';}
		if($pos==3){$f_top=$codes[2];$f_right='d';$f_bot=$codes[0];$f_left='m';}
		if($pos==4){$f_top=$codes[2];$f_right='m';$f_bot=$codes[0];$f_left='d';}

		$cData=getColumesData('',0,'clzno1c30h');
		$type_txt=viewRecElement($cData[0],$pos);
		$cData=getColumesData('',0,'zb7ayskkvd');
		$teethName=viewRecElement($cData[0],$t_type);
		
		$oprDataArr=array();
		$last_oprArr=array();
		$sql="select * from den_m_set_teeth where act =1 order by ord ASC";		
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows){
			while($r=mysql_f($res)){				
				$id=$r['id'];
				$oprDataArr[$id.'-1']['type']=1;
				$oprDataArr[$id.'-1']['opr']=$id;				
				$oprDataArr[$id.'-1']['icon']=$r['icon'];
				$oprDataArr[$id.'-1']['name']=$r['name_'.$lg];
				$oprDataArr[$id.'-1']['color']=$r['color'];
				$oprDataArr[$id.'-1']['opr_type']=$r['opr_type'];
				$oprDataArr[$id.'-1']['use_by']=$r['use_by'];
			}
		}		
		$sql="select * from den_m_set_roots where act =1  order by ord ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows){			
			while($r=mysql_f($res)){
				$id=$r['id'];
				$oprDataArr[$id.'-2']['type']=2;
				$oprDataArr[$id.'-2']['opr']=$id;
				$oprDataArr[$id.'-2']['icon']=$r['icon'];
				$oprDataArr[$id.'-2']['name']=$r['name_'.$lg];
				$oprDataArr[$id.'-2']['color']=$r['color'];
				$oprDataArr[$id.'-2']['opr_type']=$r['opr_type'];
				$oprDataArr[$id.'-2']['use_by']=$r['use_by'];
			}
		}
		
		$sql="select * from den_x_opr_teeth where teeth_no='$n' and patient='$patient'  order by date DESC";		
		$res=mysql_q($sql);
		$oprRows=mysql_n($res);?>
		<div class="winButts"><div class="wB_x fr" onclick="actCavOrd=0;win('close','#full_win1');loadTeeth(0);"></div></div>	
		<div class="win_free">
			<div class="fl r_bord " fix="w:340|hp:0">
				<div class="f1 fs18 b_bord fl w100 cbg44 lh50" fix="h:50" ><?
					$xt=2;
					$xtitle=k_edit_roots;
					$xicone='root';
					if($t==2){
						$xt=1;
						$xtitle=k_edit_tooth;
						$xicone='teeth';
					}
					echo '<div class="fr ic40x icc2 br0 l_bord ic40_den_'.$xicone.'" 
					style="background-color:'.$teethParCol[$xt].'" fix="h:49|w:50" onclick="teethInfo('.$n.','.$xt.',1)" title="'.$xtitle.'" ></div>';?>
					<div class="f1 lh50 fs18 pd10"><ff><?=$no?>-</ff> <?=$teethName.' - '.$type_txt;?></div>
				</div>
				<div class="fl f1 fs16 lh40 uLine w100 cbg4">					
					<? if($oprRows>1){?>
						<div class="fl ic40x icc1 br0 ic40_info" title="<?=k_prev_all_proc?>" onclick="TOV_all(<?=$no?>)"></div>
					<? }?>
					<div class="fl f1 fs16 lh40 pd10" fix="wp:60"><?=k_prev_stats?></div>
				</div>
				<div class="cb ofx so teethHis" fix="hp:102"><?
					while($r=mysql_f($res)){
						$opr_id=$r['id'];
						$opr=$r['opr'];
						$opr_sub=$r['opr_sub'];
						$part_sub=$r['teeth_part_sub'];
						$opr_part=$r['opr_part'];
						$teeth_part=$r['teeth_part'];
						$doctor=$r['doctor'];
						$last_opr=$r['last_opr'];
						$cav_no=$r['cav_no'];
						if($teeth_part==2 && $rNo==0){$lastCavNo=$cav_no;}
						$bordClr=$oprDataArr[$opr.'-'.$teeth_part]['color'];
						$oprTxt=$oprDataArr[$opr.'-'.$teeth_part]['name'];
						if($last_opr && $t==$teeth_part){
							$last_oprArr[$part_sub]['color']=$bordClr;
							$last_oprArr[$part_sub]['name']=$oprTxt;
						}
						$opr_part_txt='';						
						if($opr_sub){
							if($teeth_part==1){$opr_subV=get_val_arr('den_m_set_teeth_sub','name_'.$lg,$opr_sub,'ts');}
							if($teeth_part==2){$opr_subV=get_val_arr('den_m_set_roots_sub','name_'.$lg,$opr_sub,'ts');}
							$opr_part_txt=' <span class="f1 fs16 clr1">[ '.$opr_subV.' ]</span>';
						}
						$part_subTxt='';
						if($part_sub){
							if($teeth_part==1){
								$subTxt=$facCodes[$part_sub];								
							}else{
								$subTxt=$cavCodes[$part_sub];
							}
							$part_subTxt='<ff class="fs14 uc clr5">( '.$subTxt.' ) </ff>';
						}
						echo '<div part_'.$teeth_part.' style="border-'.$align.':8px '.$teethParCol[$teeth_part].' solid;" n="'.$opr_id.'" >';
						if($doctor==$thisUser){
							echo '<div class="fr ic30x icc2 ic30_del" title="'.k_del_status.'" onclick="teethOprDel('.$opr_id.')"></div>';
						}
						echo '<div class="f1 fs14 lh30 pd5" style="border-'.$align.':8px '.$bordClr.' solid;">'.$oprTxt.' '.
							$opr_part_txt.' '.$part_subTxt.'</div>';
							echo '<div class="ff B fs14 lh20 t_bord">'.date('Y-m-d A h:i',$r['date']).'</div>
						</div>';
					}?>
				</div>				
			</div>
			<div class="fl" fix="wp:405|hp:0">				
				<? if($t==1){?>
					<div class="fl w100 pd10f" fix="hp:90|wp:0"><?
						$opeType=$firstRec['opr_type'];
						$bg2=array();
						$parSt=array();						$parSt['f']=$parSt['m']=$parSt['i']=$parSt['d']=$parSt['l']=$parSt['b']=$parSt['p']=$parSt['o']='off';
						if($opeType){
							$bgColr=' background-color:'.$oprDataArr[$firstRec['opr']]['color'].';';
							if($opeType==1){$bg=$bgColr;}
							if($opeType==2){
								$oprSub=$firstRec['opr_part'];
								if($oprSub){
									$oprSubArr=str_split($oprSub);
									foreach($oprSubArr as $osa){							
										$bg2[$osa]=$bgColr;
										$parSt[$osa]='on';
									}
								}
							}
						}?>
						<div class=" tBoxInfo cb" tBor<?=$pos?> n  fix="box:50"><?
							$t_ad=$l_ad=$r_ad=$b_ad=$b_st='';
							if($last_oprArr[0]){
								$t_st=$l_st=$r_st=$b_st=$c_st=$last_oprArr[0];
							}else{
								$t_st=$last_oprArr[getArrKey($facCodes,$f_top)];
								$l_st=$last_oprArr[getArrKey($facCodes,$f_left)];
								$r_st=$last_oprArr[getArrKey($facCodes,$f_right)];
								$b_st=$last_oprArr[getArrKey($facCodes,$f_bot)];
								$c_st=$last_oprArr[getArrKey($facCodes,$f_center)];
							}
							$styTxt='color:#fff;background-color:';
							if($t_st){$t_ad='style="'.$styTxt.$t_st['color'].'" title="'.$t_st['name'].'"';}
							if($l_st){$l_ad='style="'.$styTxt.$l_st['color'].'" title="'.$l_st['name'].'"';}
							if($r_st){$r_ad='style="'.$styTxt.$r_st['color'].'" title="'.$r_st['name'].'"';}
							if($b_st){$b_ad='style="'.$styTxt.$b_st['color'].'" title="'.$b_st['name'].'"';}
							if($c_st){$c_ad='style="'.$styTxt.$c_st['color'].'" title="'.$c_st['name'].'"';}
							?>
							<table width="100%" height="100%" border="0" class="tInfoTable" dir="ltr" style="<?=$t_ad?>">		
								<tr>
								<td width="25%" height="25%" x></td>								
								<td face="<?=$f_top?>" tsp="<?=getArrKey($facCodes,$f_top)?>" a="<?=$parSt[$f_top]?>" <?=$t_ad?>><?=$f_top?></td>
								<td width="25%" x></td>
								</tr>
								<tr>
								<td face="<?=$f_left?>" tsp="<?=getArrKey($facCodes,$f_left)?>" a="<?=$parSt[$f_left]?>" <?=$l_ad?>><?=$f_left?></td>
								<td face="<?=$f_center?>" tsp="<?=getArrKey($facCodes,$f_center)?>" class="ff B" a="<?=$parSt[$f_center]?>" <?=$c_ad?>><?=$f_center?></td>
								<td face="<?=$f_right?>" tsp="<?=getArrKey($facCodes,$f_right)?>" a="<?=$parSt[$f_right]?>" <?=$r_ad?>><?=$f_right?></td>
								</tr>
								<tr>
								<td height="25%" x></td>
								<td face="<?=$f_bot?>" tsp="<?=getArrKey($facCodes,$f_bot)?>" a="<?=$parSt[$f_bot]?>" <?=$b_ad?>><?=$f_bot?></td>
								<td x></td>
								</tr>				
							</table>						
						</div>
					</div>
				<?}else{					
					$rootStatusArr=array();
					if($last_oprArr[0]){
						$lopa=$last_oprArr[0];
						$rootFukkClr=' style="background-color:'.$lopa['color'].'" title="'.$lopa['name'].'" ';
					}else{
						foreach($last_oprArr as $k => $lopa){						
							$rootStatusArr[$k]=' style="background-color:'.$lopa['color'].'" title="'.$lopa['name'].'" ';
						}
					}?>
					<div class="fs18 fl lh50 w100 cbg44 b_bord " fix="h:50"><?					
						$rSel=$rNo;
						$actRootType='';			
						if($rNo==0 && $lastCavNo==0){$rNo=1;}
						if($cavities){
							$roots=explode('|',$cavities);
							echo '<div class="fr">';
							foreach($roots as $k=>$r){
								$rr=explode(',',$r);
								$rn=$k+1;
								$class=3;
								if(($rn==$rNo && $lastCavNo==0) || ($lastCavNo==count($rr)) ){
									$class=1;
									$actRootType=$r;									
									echo script("actCavOrd=".$rn.";");
								}
								$n=pp($_POST['n']);
								$action =' onclick="actCavOrd='.$rn.';teethInfo('.$n.',2,1)"';
								echo '<div class="fr ic40 icc'.$class.' ic40n" '.$action.'>'.count($rr).'</div>';
							}
							echo '</div>';
						}?>							
					</div>
					<div class="fl w100 pd10f" fix="hp:140">
						<div class=" tBoxInfo cb" tBor<?=$pos?> n  fix="box:50"><?
							if($actRootType){										
								$rRoot=explode(',',$actRootType);
								$rrRs=count($rRoot);
								$posN=substr($n,0,1);
								echo '<table border="0"  height="100%" class="tRoott" cellpadding="8" align="center" '.$rootFukkClr.' ><tr>';
								if($rrRs==1){
									$rn1=$rRoot[0];
									echo '<td><div class="rr" tsp="'.$rn1.'" '.$rootStatusArr[$rn1].'>'.$cavCodes[$rn1].'</div></td>';
								}							
								if($rrRs==2){
									$rn1=$rRoot[0];
									$rn2=$rRoot[1];
									$r1=$cavCodes[$rn1];
									$r2=$cavCodes[$rn2];									
									if($f_left==$r1 || $f_left==$r2){
										if($posN==1 || $posN==4){													
											$r1=$cavCodes[$rn2];
											$r2=$cavCodes[$rn1];
											$rn1=$rRoot[1];
											$rn2=$rRoot[0];
										}
										echo '
										<td><div class="rr" tsp="'.$rn2.'" '.$rootStatusArr[$rn2].'>'.$r2.'</div></td>
										<td><div class="rr" tsp="'.$rn1.'" '.$rootStatusArr[$rn1].'>'.$r1.'</div></td>';
									}else{
										echo '
										<td><div class="rr" tsp="'.$rn2.'" '.$rootStatusArr[$rn2].'>'.$r2.'</div></td></tr><tr><td><div class="rr" tsp="'.$rn1.'" '.$rootStatusArr[$rn1].'>'.$r1.'</div></td>';
									}
								}
								if($rrRs==3){
									$rn1=$rRoot[0];
									$rn2=$rRoot[1];
									$rn3=$rRoot[2];											
									$r1=$cavCodes[$rn1];
									$r2=$cavCodes[$rn2];
									$r3=$cavCodes[$rn3];
									if(($posN==2 || $posN==3) && ($f_top==$r1 || $f_bot==$r1) ){
										$rn2=$rRoot[2];
										$rn3=$rRoot[1];
										$r3=$cavCodes[$rn3];
										$r2=$cavCodes[$rn2];
									}											
									if($f_top==$r1){
										echo '
										<td colspan="2"><div class="rr" tsp="'.$rn1.'" '.$rootStatusArr[$rn1].'>'.$r1.'</div></td>
										</tr><tr>
										<td><div class="rr" tsp="'.$rn2.'" '.$rootStatusArr[$rn2].'>'.$r2.'</div></td>
										<td><div class="rr" tsp="'.$rn3.'" '.$rootStatusArr[$rn3].'>'.$r3.'</div></td>';
									}
									if($f_bot==$r1){
										echo '
										<td><div class="rr" tsp="'.$rn2.'" '.$rootStatusArr[$rn2].'>'.$r2.'</div></td>
										<td><div class="rr" tsp="'.$rn3.'" '.$rootStatusArr[$rn3].'>'.$r3.'</div></td>
										</tr><tr>
										<td colspan="2"><div class="rr" tsp="'.$rn1.'" '.$rootStatusArr[$rn1].'>'.$r1.'</div></td>';
									}											
									if($f_right==$r1){
										echo '
										<td><div class="rr" tsp="'.$rn2.'" '.$rootStatusArr[$rn2].'>'.$r2.'</div></td>
										<td rowspan="2"><div class="rr" tsp="'.$rn1.'" '.$rootStatusArr[$rn1].'>'.$r1.'</div></td>
										</tr><tr>												
										<td><div class="rr" tsp="'.$rn3.'" '.$rootStatusArr[$rn3].'>'.$r3.'</div></td>';
									}
									if($f_left==$r1){
										echo '
										<td rowspan="2"><div class="rr" tsp="'.$rn1.'">'.$r1.'</div></td>
										<td><div class="rr" tsp="'.$rn2.'" '.$rootStatusArr[$rn2].'>'.$r2.'</div></td>
										</tr><tr>
										<td><div class="rr" tsp="'.$rn3.'" '.$rootStatusArr[$rn3].'>'.$r3.'</div></td>';
									}
								}
								if($rrRs==4){
									$rn1=$rRoot[0];
									$rn2=$rRoot[1];
									$rn3=$rRoot[2];
									$rn4=$rRoot[3];
									$r1=$cavCodes[$rn1];
									$r2=$cavCodes[$rn2];
									$r3=$cavCodes[$rn3];
									$r4=$cavCodes[$rn4];
									if(strlen($r1)==1){
										if(($posN==2 || $posN==3) && ($f_top==$r1 || $f_bot==$r1) ){
											$rn2=$rRoot[2];
											$rn3=$rRoot[1];
											$r3=$cavCodes[$rn3];
											$r2=$cavCodes[$rn2];
										}
										$rr1='<div class="rr" tsp="'.$rn1.'" '.$rootStatusArr[$rn1].'>'.$r1.'</div>';
										$rr2='<div class="rr" tsp="'.$rn2.'" '.$rootStatusArr[$rn2].'>'.$r2.'</div>';
										$rr3='<div class="rr" tsp="'.$rn3.'" '.$rootStatusArr[$rn3].'>'.$r3.'</div>
										      <div class="rr" tsp="'.$rn4.'" '.$rootStatusArr[$rn4].'>'.$r4.'</div>';

										if(($posN==2 || $posN==3) && ($f_top==$r1 || $f_bot==$r1) ){
											$rr3='<div class="rr" tsp="'.$rn3.'" '.$rootStatusArr[$rn3].'>'.$r3.'</div>';
											$rr2='<div class="rr" tsp="'.$rn2.'" '.$rootStatusArr[$rn2].'>'.$r2.'</div>
											      <div class="rr" tsp="'.$rn4.'" '.$rootStatusArr[$rn4].'>'.$r4.'</div>';
										}
										if($f_top==$r1){
											echo '<td colspan="2">'.$rr1.'</td></tr>
											<tr><td>'.$rr2.'</td><td>'.$rr3.'</td>';
										}
										if($f_bot==$r1){
											echo '<td>'.$rr2.'</td><td>'.$rr3.'</td></tr>
											<tr><td colspan="2" >'.$rr1.'</td>';
										}
										if($f_right==$r1){
											echo '<td>'.$rr2.'</td><td rowspan="2">'.$rr1.'</td></tr>
											<tr><td>'.$rr3.'</td>';
										}
										if($f_left==$r1){
											echo '<td rowspan="2">'.$rr1.'</td><td>'.$rr2.'</td></tr>
											<tr><td>'.$rr3.'</td>';
										}
									}else{
										$rr1='<div class="rr" tsp="'.$rn1.'" '.$rootStatusArr[$rn1].'>'.$r1.'</div>';
										$rr2='<div class="rr" tsp="'.$rn2.'" '.$rootStatusArr[$rn2].'>'.$r2.'</div>';
										$rr3='<div class="rr" tsp="'.$rn3.'" '.$rootStatusArr[$rn3].'>'.$r3.'</div>';
										$rr4='<div class="rr" tsp="'.$rn4.'" '.$rootStatusArr[$rn4].'>'.$r4.'</div>';
										if(($posN==1 || $posN==4) ){
											$rr1='<div class="rr" tsp="'.$rn2.'" '.$rootStatusArr[$rn2].'>'.$r2.'</div>';
											$rr2='<div class="rr" tsp="'.$rn1.'" '.$rootStatusArr[$rn1].'>'.$r1.'</div>';
											$rr3='<div class="rr" tsp="'.$rn4.'" '.$rootStatusArr[$rn4].'>'.$r4.'</div>';
											$rr4='<div class="rr" tsp="'.$rn3.'" '.$rootStatusArr[$rn3].'>'.$r3.'</div>';
										}
										echo '<td>'.$rr1.'</td><td>'.$rr2.'</td></tr>
										<tr><td>'.$rr4.'</td><td>'.$rr3.'</td>';
									}
								}
								echo '</tr></table>';
							}?>
						</div>
					</div><?						
				}?>
				<div class="fl w100" fix="h:86">
					<? if($n<50){?>
						<table width="100%" border="0" class="tInfoTable2" cellpadding="0" cellspacing="0" dir="ltr"><?
						$rr=1;				
						for($i=1;$i<=2;$i++){
							echo '<tr r'.$rr.'>';
							for($ii=8;$ii>=1;$ii--){
								if($rr==1){$p=1;}else{$p=4;}
								$act='';if($n==$p.$ii){$act=' act ';}						
								echo '<td TNO2="'.$p.$ii.'" '.$act.'>'.$p.$ii.'</td>';
							}
							for($ii=1;$ii<=8;$ii++){
								$borSty='';if($ii==1){$borSty='bor';}
								if($rr==1){$p=2;}else{$p=3;}
								$act='';if($n==$p.$ii){$act=' act ';}
								echo '<td TNO2="'.$p.$ii.'" '.$act.' '.$borSty.' >'.$p.$ii.'</td>';
							}
							echo '</tr>';
							$rr++;
						}?>							
						</table>
					<? }else{?>
						<table width="100%" border="0" class="tInfoTable2" dir="ltr"><?
						$rr=1;				
						for($i=1;$i<=2;$i++){
							echo '<tr r'.$rr.'>';
							for($ii=5;$ii>=1;$ii--){
								if($rr==1){$p=5;}else{$p=8;}
								$act='';if($n==$p.$ii){$act=' act ';}						
								echo '<td TNO2="'.$p.$ii.'" '.$act.'>'.$p.$ii.'</td>';
							}
							for($ii=1;$ii<=5;$ii++){
								$borSty='';if($ii==1){$borSty='bor';}
								if($rr==1){$p=6;}else{$p=7;}
								$act='';if($n==$p.$ii){$act=' act ';}
								echo '<td TNO2="'.$p.$ii.'" '.$act.' '.$borSty.' >'.$p.$ii.'</td>';
							}
							echo '</tr>';
							$rr++;
						}?>							
						</table>
					<? }?>
				</div>				
			</div>
			<div class="fl ofx so l_bord cbg444" fix="w:65|hp:0">
				<div id="t_oprs" class="tToolI fl w100" type="<?=$t?>" ><? 
					foreach($oprDataArr as $r){				
						$icon=$r['icon'];
						$use_by=$r['use_by'];
						$type=$r['type'];
						$opr_type=$r['opr_type'];
						if($type==$t && $opr_type==1){
							$ph_src=viewImage($icon,1,50,50,'img','clinic.png');
							echo '<div class="fr" title="'.$r['name'].'" style="border-color:'.$r['color'].'" no="'.$r['opr'].'" type="'.$t.'">'.$ph_src.'</div>';
						}
					}?>
				</div>
			</div>
		</div>		
		<?
	}
}?>