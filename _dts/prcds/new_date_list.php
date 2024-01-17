<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] , $_POST['n'],$_POST['d'])){
	$id=pp($_POST['id']);
	$n=pp($_POST['n']);
	$doctor=pp($_POST['d']);
	list($clinic,$same_users)=get_val('_users','subgrp,same_users',$doctor);
	$daysPerPage=_set_zb4taa12sn;
	$s_now=$now-($now%(60*_set_pn68gsh6dj))+(60*_set_pn68gsh6dj);
	$sql="select * from dts_x_dates where id='$id' and status<2 ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	//if($rows>0){
		$r=mysql_f($res);
		$patient=$r['patient'];
		$c_type=$r['type'];
		if(!$clinic || $c_type==3){$clinic=$r['clinic'];}
		$date=$r['date'];
		$d_start=$r['d_start'];
		$d_finish=$r['d_finish'];
		$status=$r['status'];
		
		$srvs=get_vals('dts_x_dates_services','service',"dts_id='$id'");
		
		if($c_type==4){
			$timeN=get_val_c('dts_x_dates_services','ser_time',$id,'dts_id' );
			$price=0;
		}else{
			list($timeN,$price)=get_docTimePrice($doctor,$srvs,$c_type);
		}		
		list($days,$type,$data)=get_val('gnr_m_users_times','days,type,data',$doctor);
		$days_arr=explode(',',$days);
		$days_arr_data=array();
		if($type==1){
			$d=explode(',',$data);
			$sDay=$d[0];
			$eDay=max($d[1],$d[3]);			
			$dayLength=($eDay-$sDay);
			$dayLengthHours=$dayLength/3600;
			$dayPer=100/$dayLengthHours;
			
			foreach($days_arr as $i){			
				$days_arr_data[$i]['s']=$d[0];
				$days_arr_data[$i]['e']=$d[1];
				$days_arr_data[$i]['s2']=$d[2];
				$days_arr_data[$i]['e2']=$d[3];
			}
		}
		if($type==2){
			$sDay=0;
			$eDay=0;
			$d1=explode('|',$data);
			$i=0;
			foreach($d1 as $d2){
				$d=explode(',',$d2);
				$TsDay=$d[0];
				$TeDay=$d[1];
				if($d[3]!=0){$TeDay=$d[3];}				
				if($TsDay<$sDay || $sDay==0){$sDay=$TsDay;}
				if($TeDay>$eDay || $eDay==0){$eDay=$TeDay;}			
				$days_arr_data[$days_arr[$i]]['s']=$d[0];
				$days_arr_data[$days_arr[$i]]['e']=$d[1];
				$days_arr_data[$days_arr[$i]]['s2']=$d[2];
				$days_arr_data[$days_arr[$i]]['e2']=$d[3];
				$i++;
			}
			$dayLength=($eDay-$sDay);
			$dayLengthHours=($dayLength/3600);
			$dayPer=100/$dayLengthHours;		
		}
		if($n==0){
			$thisH=$sDay;
			while($thisH<$eDay){
				$thh=($thisH/3600);
				$pbh=$dayPer;
				$thisH+=3600;
				if($thisH%3600!=0 || ($thisH-$eDay)==1800){
					$thisH-=1800;
					$pbh=$dayPer/2;
				}
				echo '<div class="fl bord" style="width:'.$pbh.'%">'.clockSty($thh).'</div>';
			}echo '^';
		}?>
		<div class="dt_lines" fix="wp:5"><?			
			$lastDates=array();
			$days_length=count($days_arr);
			if($n==0){$sx_date=$ss_day;}else{$sx_date=$n;}
			$ex_date=$sx_date+(86400*((intval($daysPerPage/$days_length)+1)*7));
			if($sx_date<$s_now){$sx_date=$s_now;}
			$q2='';			
			if($same_users){$q2=" OR doctor in($same_users)";}
			$sql="select id,d_start,d_end,doctor,clinic from dts_x_dates where 
			((d_start>=$sx_date and d_start<=$ex_date) OR (d_end>=$sx_date and d_end<=$ex_date))  and status!=5 and id!='$id' and ( clinic='$clinic' $q2) and status!=9 order by d_start ASC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				$i=0;
				while($r=mysql_f($res)){
					$sameClinc=1;
					if($r['clinic']!=$clinic){$sameClinc=0;}
					$lastDates[$i]['id']=$r['id'];
					$lastDates[$i]['s']=$r['d_start'];
					$lastDates[$i]['e']=$r['d_end'];
					$lastDates[$i]['doc']=$r['doctor'];
					$lastDates[$i]['vaca']=0;
					$lastDates[$i]['sClin']=$sameClinc;	
					if($lastDates[$i]['s']<$s_now){$lastDates[$i]['s']=$s_now;}
					if($lastDates[$i]['e']<$lastDates[$i]['s']){$lastDates[$i]['e']=$lastDates[$i]['s'];}
					$i++;
				}
			}
			//echo date('Y-m-d Ah:i:s',$sx_date);
			$sx_dateV=$sx_date-($sx_date%86400);
			$sql3="select * from gnr_x_vacations where type=2 and emp='$doctor' and (s_date>=$sx_dateV and s_date<=$ex_date) order by s_date ASC";
			$res3=mysql_q($sql3);
			$rows3=mysql_n($res3);
			if($rows3>0){
				while($r=mysql_f($res3)){
					$v_s_date=$r['s_date']+$r['s_hour'];
					$v_e_date=$r['s_date']+$r['e_hour'];
					$lastDates[$i]['id']=$r['id'];
					$lastDates[$i]['s']=$v_s_date;
					$lastDates[$i]['e']=$v_e_date;
					$lastDates[$i]['doc']=$r['emp'];
					$lastDates[$i]['vaca']=1;
					$lastDates[$i]['sClin']=0;	
					if($lastDates[$i]['s']<$s_now){$lastDates[$i]['s']=$s_now;}
					if($lastDates[$i]['e']<$lastDates[$i]['s']){$lastDates[$i]['e']=$lastDates[$i]['s'];}
					$i++;
				}
			}
			
			$allDays=0;
			$thisDay=$n;
			while($allDays<$daysPerPage){
				if($thisDay==0){$thisDay=$ss_day;}else{$thisDay+=86400;}
				$thisDayNo=date('w',$thisDay);
				if(in_array($thisDayNo,$days_arr)){
					if(noVacation($doctor,$thisDay)){
						$blucks='';
						$s=$days_arr_data[$thisDayNo]['s'];if($s+$thisDay < $s_now && $s!=0){$s=$s_now-$thisDay;}
						$e=$days_arr_data[$thisDayNo]['e'];if($e+$thisDay < $s_now && $e!=0){$s=$e_now-$thisDay;}
						$s2=$days_arr_data[$thisDayNo]['s2'];if($s2+$thisDay < $s_now && $s2!=0){$s2=$s_now-$thisDay;}
						$e2=$days_arr_data[$thisDayNo]['e2'];if($e2+$thisDay < $s_now && $e2!=0){$e2=$s_now-$thisDay;}
						if($s_now < $e+$thisDay  || $s_now<$e2+$thisDay){
							/**************************************************/				
							$timePointer=$s;					
							if($sDay<$timePointer){
								$blcWidth=($timePointer-$sDay)*100/$dayLength;
								$blucks.='<div class="fl dblc dblc_s1" style="width:'.$blcWidth.'%"></div>';
							}
							if($s>0){
								/*********shift 1*****************************************/					
								foreach($lastDates as $d){
									if($d['sClin']){
										$sameDoc='0';
										if($doctor==$d['doc']){$sameDoc='1';}
										$short_s=$d['s']-$thisDay;
										$short_e=$d['e']-$thisDay;
										if($d['s']>=($s+$thisDay) &&  $d['e']<=($e+$thisDay)){	
											if($timePointer!=$short_s){
												$blcWidth=($short_s-$timePointer)*100/$dayLength;
												$sty='dblc_1';
												if(($short_s-$timePointer)/60<$timeN){$sty='dblc_2';$action='';}

												foreach($lastDates as $dd){
													if($dd['sClin']==0){
														$ss=$dd['s'];
														$ee=$dd['e'];
														//if( $thisDay+$short_ss>=$ee){echo 'xxx';}
														if(
														($ss >=$thisDay+$timePointer && $ss <$thisDay+$short_s) || 
														($ee >=$thisDay+$timePointer && $ee <$thisDay+$short_s)
														)
														{
														//echo '('.date('h:i',$thisDay+$timePointer).'<='.date('h:i',$ee).'&& '.date('h:i',$thisDay+$short_ss).'>='.date('h:i',$ee).')<br>';

															$short_ss=$dd['s']-$thisDay;
															$short_ee=$dd['e']-$thisDay;
															if($short_ss<$timePointer){$short_ss=$timePointer;}
															if($short_ee>$short_s){$short_ee=$short_s;}

															if($short_ss>$timePointer){
																$sty='dblc_1';
																$blcWidth=($short_ss-$timePointer)*100/$dayLength;
																if(($short_ss-$timePointer)/60<$timeN){$sty='dblc_2';$action='';}
																$blucks.='<div class="fl dblc '.$sty.'" 
																style="width:'.$blcWidth.'%" set="0" 
																s="'.($thisDay+$timePointer).'" 
																e="'.($thisDay+$short_ss).'" 
																title="'.clockStye_per($timePointer/3600).'-'.clockStye_per($short_ss/3600).'"></div>';
																$timePointer=$short_ss;
															}
															$blcWidth=($short_ee-$short_ss)*100/$dayLength;
															if($blcWidth){
																$vacaSty='dblc_3';
																$vacaTitle='';
																if($dd['vaca']){$vacaSty='dblc_4';$vacaTitle='إجازة';}
																$blucks.='<div class="fl dblc '.$vacaSty.'" 
																style="width:'.$blcWidth.'%" set="0" title="'.$vacaTitle.'"></div>';
															}
															$timePointer=$short_ee;
														}
													}
												}

												if($timePointer!=$short_s){
													$sty='dblc_1';
													/**************************/
													foreach($lastDates as $dd){
														if($dd['sClin']==0){
															$sss=$dd['s'];$eee=$dd['e'];
															//echo $dd['id'].'-('.date('h:m',$sss) .'<='.date('h:m',$thisDay+$timePointer).' && '.date('h:m',$thisDay+$short_ss).'<='.date('h:m',$eee).')';
															//echo $dd['id'].'-('.date('h:m',$sss) .'<='.date('h:m',$eee).')';
															if($sss <=$thisDay+$timePointer && $thisDay+$short_ss<=$eee && 
															$sss <= $s && $eee<=$e
															){
																$sty='dblc_3';
															}

														}
													}
													/**************************/

													$blcWidth=($short_s-$timePointer)*100/$dayLength;

													if(($short_s-$timePointer)/60<$timeN){$sty='dblc_2';$action='';}
													$blucks.='<div class="fl dblc '.$sty.'" style="width:'.$blcWidth.'%" set="0" 
													s="'.($thisDay+$timePointer).'" 
													e="'.($thisDay+$short_s).'" 
													title="'.clockStye_per($timePointer/3600).'-'.clockStye_per($short_s/3600).'"></div>';
												}
												$timePointer=$short_s;
											}
											$blcWidth=($short_e-$short_s)*100/$dayLength;
											if($blcWidth){
												$blucks.='<div class="fl dblc dblc_basy Over sDoc'.$sameDoc.'" style="width:'.$blcWidth.'%" set="0" onclick="dateINfo('.$d['id'].');" ></div>';
											}
											$timePointer=$short_e;
										}
									}
								}
								if($timePointer<$e){
									$blcWidth=($e-$timePointer)*100/$dayLength;
									$sty='dblc_1';
									if(($e-$timePointer)/60<$timeN){$sty='dblc_2';}								
									foreach($lastDates as $dd){
										if($dd['sClin']==0){
											$ss=$dd['s'];
											$ee=$dd['e'];
											if(($ss >=$thisDay+$timePointer && $ss <=$thisDay+$e) || 
											($ee >=$thisDay+$timePointer && $ee <=$thisDay+$e)){
												$short_ss=$dd['s']-$thisDay;
												$short_ee=$dd['e']-$thisDay;
												if($short_ss<$timePointer){$short_ss=$timePointer;}
												if($short_ee>$e){$short_ee=$e;}

												if($short_ss>$timePointer){
													$blcWidth=($short_ss-$timePointer)*100/$dayLength;
													$sty='dblc_1';
													if(($short_ss-$timePointer)/60<$timeN){$sty='dblc_2';$action='';}
													$blucks.='<div class="fl dblc '.$sty.'" 
													style="width:'.$blcWidth.'%" set="0" 
													s="'.($thisDay+$timePointer).'" 
													e="'.($thisDay+$short_ss).'" 
													title="'.clockStye_per($timePointer/3600).'-'.clockStye_per($short_s/3600).'"></div>';
													$timePointer=$short_ss;
												}
												$blcWidth=($short_ee-$short_ss)*100/$dayLength;
												if($blcWidth){
													$vacaSty='dblc_3 Over';
													$action='onclick="dateINfo('.$dd['id'].');"';
													$vacaTitle='';
													if($dd['vaca']){$vacaSty='dblc_4';$vacaTitle='إجازة';$action='';}
													$blucks.='<div '.$action.' class="fl dblc '.$vacaSty.' " title="'.$vacaTitle.'"  										style="width:'.$blcWidth.'%" set="0"></div>';
												}
												$timePointer=$short_ee;
											}
										}
									}
									if($timePointer!=$e){
										$blcWidth=($e-$timePointer)*100/$dayLength;
										$sty='dblc_1';
										if(($e-$timePointer)/60<$timeN){$sty='dblc_2';$action='';}
										$blucks.='<div class="fl dblc '.$sty.'" style="width:'.$blcWidth.'%" set="0" s="'.($thisDay+$timePointer).'" e="'.($thisDay+$e).'"
										title="'.clockStye_per($timePointer/3600).'-'.clockStye_per($e/3600).'"></div>';
									}
									$timePointer=$e;
								}
							}
							/*********shift 2*******************/						
							if($s2){
								if($timePointer<0){$timePointer=$sDay;}
								$blcWidth=($s2-$timePointer)*100/$dayLength;
								$blucks.='<div class="fl dblc dblc_s1" style="width:'.$blcWidth.'%" ></div>';

								$timePointer=$s2;
								foreach($lastDates as $d){
									if($d['sClin']){
										if($doctor==$d['doc']){$sameDoc='1';}
										$short_s=$d['s']-$thisDay;
										$short_e=$d['e']-$thisDay;
										if($d['s']>=($s2+$thisDay) &&  $d['e']<=($e2+$thisDay)){	
											if($timePointer!=$short_s){
												$blcWidth=($short_s-$timePointer)*100/$dayLength;
												$sty='dblc_1';
												if(($short_s-$timePointer)/60<$timeN){$sty='dblc_2';$action='';}

												foreach($lastDates as $dd){
													if($dd['sClin']==0){
														$ss=$dd['s'];
														$ee=$dd['e'];													
														if(($ss >=$thisDay+$timePointer && $ss <=$thisDay+$short_s) || 
														($ee >=$thisDay+$timePointer && $ee <=$thisDay+$short_s)){
															$short_ss=$dd['s']-$thisDay;
															$short_ee=$dd['e']-$thisDay;
															if($short_ss<$timePointer){$short_ss=$timePointer;}
															if($short_ee>$short_s){$short_ee=$short_s;}
															if($short_ss>$timePointer){
																$sty='dblc_1';
																$blcWidth=($short_ss-$timePointer)*100/$dayLength;
																if(($short_ss-$timePointer)/60<$timeN){$sty='dblc_2';$action='';}
																$blucks.='<div class="fl dblc '.$sty.'" 
																style="width:'.$blcWidth.'%" set="0" 
																s="'.($thisDay+$timePointer).'" 
																e="'.($thisDay+$short_ss).'" 
																title="'.clockStye_per($timePointer/3600).'-'.clockStye_per($short_ss/3600).'"></div>';
																$timePointer=$short_ss;
															}
															$blcWidth=($short_ee-$short_ss)*100/$dayLength;
															if($blcWidth){
																$blucks.='<div class="fl dblc dblc_3" 
																style="width:'.$blcWidth.'%" set="0"></div>';
															}
															$timePointer=$short_ee;
														}
													}
												}
												if($timePointer!=$short_s){
													$sty='dblc_1';
													$blcWidth=($short_s-$timePointer)*100/$dayLength;
													if(($short_s-$timePointer)/60<$timeN){$sty='dblc_2';$action='';}
													$blucks.='<div class="fl dblc '.$sty.'" style="width:'.$blcWidth.'%" set="0" 
													s="'.($thisDay+$timePointer).'" 
													e="'.($thisDay+$short_s).'"
													title="'.clockStye_per($timePointer/3600).'-'.clockStye_per($short_s/3600).'"></div>';
												}
												$timePointer=$short_s;
											}
											$blcWidth=($short_e-$short_s)*100/$dayLength;
											if($blcWidth){
												$blucks.='<div class="fl dblc dblc_basy Over sDoc'.$sameDoc.'" style="width:'.$blcWidth.'%" set="0" onclick="dateINfo('.$d['id'].')" ></div>';
											}
											$timePointer=$short_e;
										}
									}
								}
								if($timePointer<$e2){
									$blcWidth=($e2-$timePointer)*100/$dayLength;								
									$sty='dblc_1';
									if(($e2-$timePointer)/60<$timeN){$sty='dblc_2';}								
									foreach($lastDates as $dd){
										if($dd['sClin']==0){
											$ss=$dd['s'];
											$ee=$dd['e'];
											if(($ss >=$thisDay+$timePointer && $ss <$thisDay+$e2) || 
											($ee >=$thisDay+$timePointer && $ee <$thisDay+$e2)){
												$short_ss=$dd['s']-$thisDay;
												$short_ee=$dd['e']-$thisDay;
												if($short_ss<$timePointer){$short_ss=$timePointer;}
												if($short_ee>$e2){$short_ee=$e2;}

												if($short_ss>$timePointer){
													$blcWidth=($short_ss-$timePointer)*100/$dayLength;
													$sty='dblc_1';
													if(($short_ss-$timePointer)/60<$timeN){$sty='dblc_2';$action='';}				
													$blucks.='<div class="fl dblc '.$sty.'" 
													style="width:'.$blcWidth.'%" set="0" 
													s="'.($thisDay+$timePointer).'" 
													e="'.($thisDay+$short_ss).'" 
													title="'.clockStye_per($timePointer/3600).'-'.clockStye_per($short_s/3600).'"></div>';
													$timePointer=$short_ss;
												}
												$blcWidth=($short_ee-$short_ss)*100/$dayLength;
												if($blcWidth){
													$blucks.='<div class="fl dblc dblc_3" 											style="width:'.$blcWidth.'%" set="0"></div>';
												}
												$timePointer=$short_ee;
											}
										}
									}
									if($timePointer!=$e2){
										$sty='dblc_1';
										$blcWidth=($e2-$timePointer)*100/$dayLength;									
										if(($e2-$timePointer)/60<$timeN){$sty='dblc_2';$action='';}
										$blucks.='<div class="fl dblc '.$sty.'" style="width:'.$blcWidth.'%" set="0" s="'.($thisDay+$timePointer).'" e="'.($thisDay+$e2).'"
										title="'.clockStye_per($timePointer/3600).'-'.clockStye_per($e2/3600).'"></div>';
									}
									$timePointer=$e2;
								}
							}				
							/**************************************************/
							$ee=max($e,$e2);
							if($eDay>$ee){
								$blcWidth=($eDay-$ee)*100/$dayLength;
								$blucks.='<div class="fl dblc dblc_s1" style="width:'.$blcWidth.'%" ></div>';
							}
							/**************************************************/
							echo '<div class="fl"  fix="wp:0">
							<div t class="fl f1" style="background-color:'.$wakeeDaysClr[$thisDayNo].'"><ff>'.date('m-d',$thisDay).'</ff><br>'.$wakeeDays[$thisDayNo].' </div>
							<div c class="fl" fix="wp:100">'.$blucks.'</div>
							</div>';
						}
						$allDays++;
					}else{
						echo '<div class="fl"  fix="wp:0">
						<div t class="fl f1 clrb" style="background-color:'.$wakeeDaysClr[$thisDayNo].'"><ff>'.date('m-d',$thisDay).'</ff><br>'.$wakeeDays[$thisDayNo].' </div>
						<div c class="fl" fix="wp:100">
						<div class="fl dblc dblc_4" style="width:100%" title="إجازة"></div>
						</div>
						</div>';					
					}
				}
			}?>
		</div>
		<?
	//}?><div class="cb" id="dts_dt_load"><div class="bu2 bu_t1 fl" onclick="loadDaSc(<?=$thisDay?>)">عرض المزيد</div></div>
	<?
}?>