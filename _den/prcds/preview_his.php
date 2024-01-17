<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$vis=pp($_POST['vis']);
	if(isset($_POST['type'])){
		$type=pp($_POST['type']);
		$sub_id=pp($_POST['vis']);
		if($type==1){
			$oprsArr=array();
			$sql="select * from den_x_visits_services where patient ='$id'  order by d_start DESC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows){
				$out.='<div class="oprDen">';
				while($r=mysql_f($res)){
					$s_id=$r['id'];
					$service=$r['service'];
					$d_start=$r['d_start'];
					$status=$r['status'];
					$teeth=$r['teeth'];
					$doctor=$r['doc'];
					$end_percet=$r['end_percet'];
					$serviceTxt=get_val_arr('den_m_services','name_'.$lg,$service,'srv');
					if($doctor){
						$doctorTxt='<div class="f1 fs14 lh30 clr66 pd5 b_bord">'.k_dr.' : '.get_val_arr('_users','name_'.$lg,$doctor,'doc').'</div>';
					}
					$oprsArr[$s_id]=$r;
					$oprsArr[$s_id]['srvName']=$serviceTxt;
					$teethTxt='';
					if($teeth){
						$tt=explode(',',$teeth);
						$teethTxt.='<div t class="pd10">';
						foreach($tt as $ttt){$teethTxt.='<div>'.$ttt.'</div>';}
						$teethTxt.='</div>';
					}
					$priceButt='';
					if($doctor==$thisUser && $status==0 && $PER_ID=='afoxbse28f'){ 
						$priceButt='<div class="fr i30 i30_price" title="'.k_edit_price.'" onclick="changeDenPrice('.$s_id.')"></div>';
					}
					$end_percet_txt='';
					if($end_percet){$end_percet_txt.='<div class="fr ff B fs14 cbg66 pd5 clrw">%'.$end_percet.'</div>';}
					list($s_ids,$subServ,$percet)=get_vals('den_m_services_levels','id,name_'.$lg.',percet'," service=$service",'arr');
					$out.='<div  onclick="loadHisMood('.$type.','.$s_id.')" style="background-color:'.$denSrvSCol[$status].'">';						
						$out.='<div s>'.splitNo($serviceTxt).'</div>'.$doctorTxt.'
						<div><div d>'.date('Y-m-d',$d_start).'</div>'.$teethTxt.'</div>
						<div class="b_bord lh1 cb"></div>
						<div class="fl  w100 lh30 "> 
						<div class="fl f1 lh30 pd10">'.$denSrvS[$status].'</div>'.$priceButt.$end_percet_txt.'</div>
						<div class="b_bord lh1 cb"></div>
					</div>';
				}
				$out.='</div>';
			}else{$out.='<div class="f1 fs14 lh40">'.k_no_ctin.'</div>';}
			echo $out;
			echo '^';
			$q='';
			if($sub_id){$q=" and x_srv='$sub_id'" ;}
			$sql="select * from den_x_visits_services_levels where patient='$id' $q order by date ASC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			$levelsArr=array();
			while($r=mysql_f($res)){
				$l_id=$r['id'];
				$levelsArr[$l_id]=$r;
			}			
			foreach($oprsArr as $k=>$o){
				$teethTxt='';
				if($sub_id==$k || $sub_id==0){
					$teeth=$o['teeth'];	
					$status=$o['status'];
					$srv_doc=$o['doc'];
					if($teeth){
						$selTeeth=$teeth;
						$tt=explode(',',$teeth);
						$teethTxt.='<div class="fr lh30 r_bord ">';
						foreach($tt as $ttt){$teethTxt.='<div class="fr l_bord pd10 fs14 ff B ">'.$ttt.'</div>';}
						$teethTxt.='&nbsp;</div>';
					}
					?>
					<div class="fl w100 pd10v">
					<div class="lh30 fs18 f1 "><ff>#<?=$k?> | </ff><?=splitNo($o['srvName'])?></div>
					<? if($srv_doc){?>
						<div class="lh30 fs14 f1 clr66 "><?=k_dr.' : '.get_val_arr('_users','name_'.$lg,$srv_doc,'doc')?></div>
					<?}?>
					</div>
					<div class="fl w100 bord b_bord3">
						<div class="fl f1 fs16 " fix="wp:0">
							<div class="fl w100 cbg4">
								<?=$teethTxt?>
								<div class="fr lh30 B fs14 ff pd10"><?=date('Y-m-d',$o['d_start'])?></div>
								<div class="fl cbg2 lh30 pd10 clrw ff fs14 B" dir="ltr" title="<?=k_price_serv?> ">£ <?=number_format($o['total_pay'])?></div>
								<div class="fl cbg66 lh30 pd10 clrw ff fs14" title="<?=k_complete_percent
?>">%<?=$o['end_percet']?></div>				
								<div class="fl f1 pd10 fs12 lh30" style="background-color:<?=$denSrvSCol[$status]?>"><?=$denSrvS[$status]?></div>
							</div>
						</div>
						<div class="fl w100  pd10f"><?
							foreach($levelsArr as $kk=>$l){
								if($l['x_srv']==$k){
									$l_status=$l['status'];
									$l_date_e=$l['date_e'];
									$dateS=0;
									if($l_status==2){$dateS=$l_date_e;}
									if($dateS){$dateS=' <ff dir="ltr" class="fs12"> (  '.date('Y-m-d',$dateS). ')</ff>';}
									$levName=get_val_arr('den_m_services_levels','name_'.$lg,$l['lev'],'ln');
									list($levo,$lDate)=get_vals('den_x_visits_services_levels_w','val,date',"x_lev='$kk'",'arr',0);?>
									<div class="ofx pd10v w100 b_bord">
										<div class="fl w100 lh30 pd10 ">
											<div class="fl lh30 f1 fs16 "><?=splitNo($levName)?>
												<div class="cb">										
												<div class="f1 fs12 pd5 lh20 fl" style="background-color:<?=$denSrvSCol[$l_status]?>"><?=$denlevS[$l_status].$dateS?></div>
												</div>
											</div>								
										</div><? 
										foreach($levo as $lk=>$ll){
											$desTxt=get_val_arr('den_m_services_levels_text','des',$ll);
											?><div class="fl mg10f pd5 levDes" fix="wp:0">
												<div class="lh30 b_bord w100" fix="h:30">
													<div class="fl clr1 ff fs16 B "><?=date('Y-m-d',$lDate[$lk])?></div>
												</div>
												<div class="cb f1 fs12x lh30 pd5v"><?=nl2br($desTxt)?></div>
											</div><?
										}?>							
									</div><?
								}
							}?>
						</div>						
					</div><?
				}
			}
		}
		if($type==2){
			$oprsArr=array();
			$sql="select * from den_x_visits where patient ='$id'  order by d_start DESC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows){
				$out.='<div>';
				while($r=mysql_f($res)){
					$s_id=$r['id'];					
					$d_start=$r['d_start'];
					$doctor=$r['doctor'];
					$docName=get_val_arr('_users','name_'.$lg,$r['doctor'],'dl');
					$cls='cbg444';
					if($sub_id==$s_id){$cls='cbg666';}
					$out.='<div class="'.$cls.' bord uLine Over"  onclick="loadHisMood('.$type.','.$s_id.')">
						<div class="lh40 f1 fs16 pd10 b_bord"><ff>#'.$r['id'].' | </ff>'.$docName.'</div>
						<div class="fs16 ff B lh30 pd10">'.date('Y-m-d',$d_start).'</div>
					</div>';
					$oprsArr[$s_id]=$r;
				}
				$out.='</div>';
			}else{$out.='<div class="f1 fs14 lh40">'.k_no_ctin.' </div>';}
			echo $out;
			echo '^';
			$q='';
			if($sub_id){$q=" and vis='$sub_id'" ;}
			$sql="select * from den_x_visits_services_levels_w where patient='$id' $q order by date DESC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			$levelsArr=array();
			while($r=mysql_f($res)){
				$l_id=$r['id'];
				$levelsArr[$l_id]=$r;
			}
			foreach($oprsArr as $k=>$o){
				if($sub_id==$k || $sub_id==0){					
					if($o['doctor']){$docName=get_val_arr('_users','name_'.$lg,$o['doctor'],'dl');}				
					echo '
					<div class="f1 fs18 lh40 "><ff>'.$k.' | </ff>'.$docName.' <ff dir="ltr" class=""> ( '.date('Y-m-d',$o['d_start']).' ) </ff></div>
					<div class="fl w100 bord b_bord3 pd10">
					';
					foreach($levelsArr as $kk=>$l){ 
						if($l['vis']==$k){
							$levName=get_val_arr('den_m_services_levels','name_'.$lg,$l['lev'],'ln');
							$srvName=get_val_arr('den_m_services','name_'.$lg,$l['srv'],'sn');
							$levwork=get_val_arr('den_m_services_levels_text','des',$l['val'],'lw');
							
							echo '<div class="f1 fs14 clr1111 lh40">'.$srvName.' <span class="f1 fs14 clr111 lh30"> ( '.$levName.' )</span></div>
							
							';
							
							?><div class="fl mg10vf pd5 levDes" fix="wp:0">
								<div class="cb f1 fs12x lh30 pd5v"><?=nl2br($levwork)?></div>
							</div><?
						}
					}?>
					
					<?
					echo '&nbsp;</div>';
				}
			}
		}
	}else{?>
		<div class="win_body">
		<div class="winButts"><div class="wB_x fr" onclick="win('close','#full_win1');"></div></div>
		<div class="form_header lh40 clr1 f1 fs18"><?=get_p_name($id)?></div>
		<div class="form_body of" type="pd0">
			<div class="fl r_bord of" fix="wp%:40|hp:0">
				<div class="lh50 pd10v pd10 b_bord cbg44">
					<select t id="dHisType" onChange="loadHisMood(this.value,0)">
						<option value="1"><?=k_srt_by_proc?>  </option>
						<option value="2"><?=k_srt_by_visit?>  </option>
					</select>
				</div>
				<div class="ofx so pd10f" fix="hp:70" id="hisList"></div>
			</div>
			<div class="fl ofx so pd10f" fix="wp%:60|hp:0" id="hisDes"></div>
		</div>
		<div class="form_fot fr">
			<? $doctor=get_val('den_x_visits','doctor',$vis);			
			if($doctor==$thisUser && $PER_ID=='hj0wkb3z83'){
                $denPrv='_Preview-Den.'.$vis;
                if(_set_7h5mip7t6n){$denPrv='_Preview-Den-new.'.$vis;}?>
				<div class="bu bu_t1 fl" onclick="loc('<?=$denPrv?>');"><?=k_edit?></div>
			<? }
			if($thisGrp=='hrwgtql5wk' && $chPer[3]){?>
				<div class="bu bu_t3 fl" onclick="delVisAcc(<?=$vis?>,4,0);"><?=k_delete?></div>
			<? }?>
			<div class="bu bu_t2 fr" onclick="win('close','#full_win1');"><?=k_close?></div>
		</div>
		</div><?
	}
}?>