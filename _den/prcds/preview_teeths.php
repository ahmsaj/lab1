<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'],$_POST['t'],$_POST['s'])){	
	$vis=pp($_POST['vis']);
	$tType=pp($_POST['t']);
	$s=pp($_POST['s']);
	$patient=get_val('den_x_visits','patient',$vis);
	if($s){		
		$oprDataArr=array();
		$sql="select * from den_m_set_teeth where act =1 order by ord ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows){			
			while($r=mysql_f($res)){
				$id=$r['id'];
				$oprDataArr[$id]['icon']=$r['icon'];
				$oprDataArr[$id]['name']=$r['name_'.$lg];
				$oprDataArr[$id]['color']=$r['color'];
				$oprDataArr[$id]['opr_type']=$r['opr_type'];
				$oprDataArr[$id]['opr_type']=$r['opr_type'];
			}
		}
		$rootDataArr=array();
		$sql="select * from den_m_set_roots where act =1 order by ord ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows){			
			while($r=mysql_f($res)){
				$id=$r['id'];
				$rootDataArr[$id]['icon']=$r['icon'];
				$rootDataArr[$id]['name']=$r['name_'.$lg];
				$rootDataArr[$id]['color']=$r['color'];
			}
		}
        
		$teethStatus=array();
		$tsfc=array();
		$sql="SELECT * FROM den_x_opr_teeth WHERE patient = '$patient' and last_opr=1";
		$res=mysql_q($sql);
		while($r=mysql_f($res)){
			$no=$r['teeth_no'];
			$teeth_part=$r['teeth_part'];
			$opr_sub=$r['teeth_part_sub'];
			$last_opr=$r['last_opr'];
			if($last_opr){
				$tsfc[$teeth_part.'-'.$no][$opr_sub]=$r;
			}
			if($teeth_part==1){
				$teethStatus[$no]=$r;
			}else{
				$rootStatus[$no][$opr_sub]=$r;
				$rootStatus[$no]['c']=$r['opr_type'];
			}
		}

		$tt1=12.8;$tt2=12.8;$tt3=12;$tt4=12;	
		$teethWidth=array(0,$tt4,$tt4,$tt3,$tt2,$tt2,$tt1,$tt1,$tt1);
		$tun=array();
		$trno=array();
		$cavsArr=array();
		$sql="select * from den_m_teeth where type='$tType' order by no_unv";
		$res=mysql_q($sql);
		while($r=mysql_f($res)){
			$no=$r['no'];
			$t_type=$r['t_type'];
			$no_unv=$r['no_unv'];
			$root_no=$r['root_no'];
			$t_code=$r['code'];		
			$tun[$no]=$no_unv;
			$trno[$no_unv]=$root_no;
			$cavities=$r['cavities'];
			$cavsArr[$no]=$cavities;
		}

		if($tType==1){
			$side_s=1;
			$side_e=4;
			$side_n=8;
		}
		if($tType==2){
			$side_s=5;
			$side_e=8;
			$side_n=5;
		}?>
		<div class="teethCont" dir="ltr"><? 
			for($p=$side_s ;$p<=$side_e;$p++){
				$TheethNo='';
				$TheethBoxs='';
				$TheethRoots='';
				$TheethPart='<tr><td colspan="8" tpn'.$p.' class="fs24 ff" >'.$p.'</td></tr>';			
				for($i=1 ;$i<=$side_n;$i++){$TheethNo.='<td class="ff TtNO" style="padding:2px;">'.$tun[$p.$i].'</td>';}
				for($i=1 ;$i<=$side_n;$i++){
					$bg=$bg2=$t_status='';
					$oprType=0;
					if($tsfc['1-'.$p.$i]){
						$tsArr=$tsfc['1-'.$p.$i];
						$tfStyles='';
						foreach($tsArr as $k => $ts){
							$oprType=$tsArr[$k]['opr_type'];
							$oprType_o=$tsArr[$k]['opr'];							
							if($oprType==1){								
								$bgColr=' background-color:'.$oprDataArr[$oprType_o]['color'].';';
								$t_status=$oprDataArr[$oprType_o]['name'];
								$bg=$bgColr;
							}
							if($oprType==2){
								$oprSub_o=$tsArr[$k]['teeth_part_sub'];
								if($oprSub_o==1 || $oprSub_o==2){
									$tfStyles.=' background-color:'.$oprDataArr[$oprType_o]['color'].';color:#fff;';
								}else{									
									$borDir=selTDir($p,$i,$oprSub_o);
									$tfStyles.='border-'.$borDir.'-color:'.$oprDataArr[$oprType_o]['color'].';';
								}
							}
						}
						if($tfStyles){$bodrColr='style="'.$tfStyles.'"';}						
					}
                    $t_statusTxt='';
                    if($t_status){
                       $t_statusTxt=' title="'.$t_status.'"';
                    }
					$TheethBoxs.='<td width="'.$teethWidth[$i].'%" '.$t_statusTxt.' tdno="'.$p.$i.'">';
					if($oprType){
						if($oprType==1){
							$TheethBoxs.='
							<div class="fl w100 Over lh50" TNO="'.$p.$i.'" tBor'.$p.' style="'.$bg.'">
								<ff class="clrw">'.$p.$i.'</ff>
							</div>
							';
						}
						if($oprType==2){
							$TheethBoxs.='
							<div class="fl w100 Over" TNO="'.$p.$i.'" tBor'.$p.'>
								<div '.$bodrColr.'><ff>'.$p.$i.'</ff></div>
							</div>
							';
						}
					}else{
						$TheethBoxs.='
							<div class="fl w100 Over" TNO="'.$p.$i.'" tBor'.$p.'>
								<div><ff>'.$p.$i.'</ff></div>						
							</div>';
					}
					$TheethBoxs.='</td>';
				}
				for($i=1 ;$i<=$side_n;$i++){
					$roNo=$trno[$tun[$p.$i]];
					$TheethRoots.='<td class="Troot Over" RNO="'.$p.$i.'" tdno="'.$p.$i.'">
					<div class="c_cont w100 lh50" '.$bgColr.'>';
					if($tsfc['2-'.$p.$i]){
						$tsArr=$tsfc['2-'.$p.$i];
						$tfStyles='';						
						$rpc=0;
						foreach($tsArr as $k => $ts){
							$oprType=$tsArr[$k]['opr_type'];
							$oprType_o=$tsArr[$k]['opr'];
							$rpc=$tsArr[$k]['cav_no'];
							$part_sub=$tsArr[$k]['teeth_part_sub'];
							$opr=$tsArr[$k]['opr'];
							$rName=$rootDataArr[$opr]['name'];
							$rColor=$rootDataArr[$opr]['color'];
							if($oprType==1){								
								//$bgColr=' background-color:'.$oprDataArr[$oprType_o]['color'].';';
								//$t_status=$oprDataArr[$oprType_o]['name'];
								//$bg=$bgColr;
								$rIc='style="background-color:'.$rColor.'" title="'.$rName.'"';
							}
							if($oprType==2){							
								$rIc='style="background-color:'.$rColor.'" title="'.strtoupper($cavCodes[$part_sub]).'-'.$rName.'"';
							}
							$TheethRoots.='<div class="fl lh40" '.$rIc.'></div>';
						}						
						if($rpc>count($tsArr)){
							for($ii=count($tsArr);$ii<$rpc;$ii++){
								if($oprType==1){
									$TheethRoots.='<div class="fl lh40" '.$rIc.'></div>';
								}else{
									$TheethRoots.='<div class="fl lh40"></div>';
								}
							}
						}
						if($tfStyles){$bodrColr='style="'.$tfStyles.'"';}						
					}else{
						for($r=1;$r<=$roNo;$r++){	
							$TheethRoots.='<div class="fl lh40"></div>';
						}
					}					
					$TheethRoots.='</div></td>';
				}?>
				<div class="<?=$teethFl[$p]?>"  tp tp<?=$p?> >
				<table border="0" width="100%" class="teethTable" cellpadding="4" cellspacing="0" dir="<?=$teethDir[$p]?>"><?
				if(in_array($p,array(1,2,5,6))){
					echo '<tr>'.$TheethPart.'</tr><tr root>'.$TheethRoots.'</tr><tr box>'.$TheethBoxs.'</tr><tr>'.$TheethNo.'</tr>';
				}else{
					echo '<tr>'.$TheethNo.'</tr><tr box>'.$TheethBoxs.'</tr><tr root>'.$TheethRoots.'</tr><tr>'.$TheethPart.'</tr>';
				}?>
				</table>
				</div>
			<? }?>
		</div><?
	}else{?>
		<div class="fl lh60 w100 b_bord cbg4">
						
			<div class="fl">				
				<div class="fr ofy lh40 w100 " fix="h:40|w:40">
					<div class="fr ic40x icc4 tt_icon_c br0" title="<?=k_goto_deciduous_teeth?>"></div>
					<div class="fr ic40x icc4 tt_icon_a br0" title="<?=k_goto_permanent_teeth?>" ></div>
				</div>
			</div>
			<div class="fl lh40 f1 fs18 pd10"><?=k_dental_anatomy?></div>
		</div>
		<div class="ofx so pd10f" fix="hp:40|wp:0" id="teethData"></div><?
	}
}
?>
