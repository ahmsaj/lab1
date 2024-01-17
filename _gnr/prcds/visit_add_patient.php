<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['c'])){
	$clinic=pp($_POST['c']);
	$c_type=get_val('gnr_m_clinics','type',$clinic);
	$dayNo=date('w');
	$h_time=get_host_Time();
	$h_realTime=$h_time[1]-$h_time[0];
	$x_doctor=array();
	$date=date('Y-m-d');

	$sta_txt=array('',k_lft_doc_attend,k_rst_cln,k_cln_end,'');
	$sta_color=array('',$clr6,$clr1,$clr5,'');
	$sta_txt2=array('',k_avl_time,k_dely);
	$sta_color2=array('',$clr6,$clr1);
	/********************************************************************************/
	if($c_type!=4){
		$sql="select doc from gnr_x_arc_stop_doc where `date`='$date' ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			while($r=mysql_f($res)){
				$doc=$r['doc'];
				array_push($x_doctor,$doc);
			}
		}
	}
	$x_doctor_str=implode(',',$x_doctor);
	/*********************************************************************************/
	$selClnc=getAllLikedClinics($clinic);
	$q=" CONCAT(',', `subgrp`, ',') REGEXP ',($selClnc),' ";
	if($c_type==4){$q=" u.grp_code='fk590v9lvl' ";}
	$sql="select * , u.id as uid from _users u , gnr_m_users_times d where u.id=d.id and u.act=1 and $q  ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	$docs_data=array();
	if($rows>0){
		$i=0;
		while($r=mysql_f($res)){
			$docs_data[$i]['doc']=$r['uid'];
			$docs_data[$i]['name']=$r['name_'.$lg];
			$docs_data[$i]['subgrp']=$r['subgrp'];
			$docs_data[$i]['days']=$r['days'];
			$docs_data[$i]['type']=$r['type'];
			$docs_data[$i]['data']=$r['data'];
			$i++;
		}
	}
	$other_blc='';
	$q=" id='$clinic' ";
	if($c_type==4){$q=" type=4 ";}
	$sql="select * from gnr_m_clinics where act=1 and $q limit 1";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$i=0;
		$r=mysql_f($res);
		$c_id=$r['id'];
		$name=$r['name_'.$lg];
		$photo=$r['photo'];
		$type=$r['type'];
		$ph_src=viewImage($photo,1,30,30,'img','clinic.png');
		if($c_type==4){$name=k_dentistry;}
		$min_time=0;$max_time=0;
		foreach($docs_data as $data){
			if($data['subgrp']==$c_id){					
				if(in_array($dayNo,explode(',',$data['days']))){
					$d_time=get_doc_Time($data['type'],$data['data'],$data['days']);					
					$d_realTime=$d_time[1]-$d_time[0];
					if(!in_array($data['doc'],$x_doctor)){
						if($d_time[0]<$min_time || $min_time==0)$min_time=$d_time[0];
						if($d_time[1]>$max_time || $max_time==0)$max_time=$d_time[1];					
					}					
					$status=1;
					if(in_array($data['doc'],$x_doctor)){$status=2;}					
				}
			}			
		}
		$d_realTime=$max_time-$min_time;
		if($d_realTime){
			$bar_width=($d_realTime*100)/$h_realTime;
			if($d_time[0]-$h_time[0]==0){$bar_margin=0;}else{$bar_margin=($min_time-$h_time[0])*100/$h_realTime;}
			$poinerTime=($now%86400);
			$pointer_margin=($poinerTime-$h_time[0])*100/$h_realTime;		

			$sta=0;
			$sta_time=0;
			if($poinerTime<$min_time){
				$sta=1;
				$sta_time=$min_time-$poinerTime;
			}else{
				if($poinerTime<$max_time){
					$sta=2;
					$sta_time=$max_time-$poinerTime;
				}else{
					$sta=3;
					$sta_time=$poinerTime-$max_time;
				}		
			}
			/*-----------*/
			$sta2=0;
			$sta_time2=0;
			$actVisClinic=0;
			$actVisClinic=getActVisClinc($c_id);
			$busy_width=$actVisClinic*100/$h_realTime;

			$w_time='';
			if($actVisClinic){
				$w_pa=getTotalCO('gnr_x_roles'," clic='$c_id' and status<3");
				if($w_pa){
					$w_time='
					<div class="uLine cb"> </div>				
					<div class="fl f1 fs14 lh30"> 
					'.k_expc_watime.' : '.splitNo(dateToTimeS($actVisClinic,0)).' |  
					'.k_pat_wating.' : <ff> '.$w_pa.' </ff>
					</div>';
				}
			}
			if($actVisClinic){
				if(($poinerTime+$actVisClinic)<$max_time){
					$sta2=1;
					$sta_time2=$max_time-($poinerTime+$actVisClinic);
				}else{
					$sta2=2;
					$sta_time2=($poinerTime+$actVisClinic)-$max_time;
				}
			}
			$blc='
			<div class="fr clicINfIco" onclick="dateSc('.$c_id.',\''.$name.'\')"></div>
			<div class="fl cli_icon">'.$ph_src.'</div>
			<div class="fl "><div class="fs18 f1 clr1 lh40">'.$name.'</div></div>';
			if($c_type!=4){
				$blc.='<div class="fs12 f1 cdoc_name cb lh30 TC"  style="color:'.$sta_color[$sta].'">'.$sta_txt[$sta].'
				<span class="ff fs14 B"> ( '.dateToTimeS2($sta_time).' )</span></div>';
			}
			if($actVisClinic>0){
				$blc.='<div class="fs12 f1 cdoc_name2 cb lh20 TC cs2_t'.$sta2.'">'.$sta_txt2[$sta2].'
				<span class="ff fs14 B"> ( '.dateToTimeS2($sta_time2).' )</span></div>';
			}
		}else{
			/**************/
			$blc='
			<div class="fr clicINfIco" onclick="dateSc('.$c_id.',\''.$name.'\')"></div>
			<div class="fl cli_icon">'.$ph_src.'</div>
			<div class="fl "><div class="fs18 f1 clr1 lh40">'.$name.' <span class="clr5 f1 fs14">'.k_clin_dnt_work_tdy.'</span></div></div>';
		}?>
		<div class="win_body">
		<div class="form_header">
		<? 
		echo $blc;
		
		?></div>
		<div class="form_body so" type="static">
			<div class="fl vis_pat_list ofx so" fix="hp:0">
				<? 
				$selDocArr=explode(',',_set_anonjaukgo);
				$selDocArrReq=explode(',',_set_8i5cy9v6t);
				$thisClinicCode=$clinicCode[$c_type];
				if(!in_array($thisClinicCode,$selDocArr)){
					echo '<input type="hidden" name="doc" id="ri_doc" req="0" value="0">';
				}else{
					$req=0;
					if(in_array($thisClinicCode,$selDocArrReq)){$req=1;}
					echo '<div class="lh30 f1 clr5 fs14">'.k_doctor.'</div><div>
					<select t  name="doc" id="ri_doc" id="ri_doc" req="'.$req.'">					
					<option value="0" > '.k_doc_choos.'</option>';
					
					foreach($docs_data as $data){
						if(in_array($dayNo,explode(',',$data['days']))){
							$d_time=get_doc_Time($data['type'],$data['data'],$data['days']);
							$d_realTime=$d_time[1]-$d_time[0];
							$docStatus=k_navailble;
							$sel='';
							if(in_array($data['doc'],$x_doctor)){$docStatus=k_dnt_attnd;}
							if(getTotalCO('_log'," user='".$data['doc']."'")){
								$docStatus=k_available;
								//if(_set_8i5cy9v6t){ $sel=' selected ';}
							}
							$doctor=$data['name'];							
							echo '<option value="'.$data['doc'].'" '.$sel.'>
							'.$data['name'].' | '.$docStatus.'				
							</option>';
							if(!in_array($data['doc'],$x_doctor)){
								if($d_time[0]<$min_time || $min_time==0)$min_time=$d_time[0];
								if($d_time[1]>$max_time || $max_time==0)$max_time=$d_time[1];
							}
						}
					}
					foreach($docs_data as $data){
						if(!in_array($dayNo,explode(',',$data['days']))){							
							echo '<option value="'.$data['doc'].'" class="clr5">
							'.$data['name'].' |  '.k_tday_dnt_word.'				
							</option>';
						}
					}
					echo '</select></div>';
				}?>
				

				<div class="lh30 f1 clr1 fs14"><?=k_name?></div>
				<div><input type="text" ser_p="p2" focus/></div>
				
				<div class="lh30 f1 clr1 fs14"><?=k_l_name?></div>
				<div><input type="text" ser_p="p3" /></div>

				<div class="lh30 f1 clr1 fs14"><?=k_fth_name?> </div>
				<div><input type="text" ser_p="p4" /></div>

				<div class="lh30 f1 clr1 fs14"> <?=k_mothr_name?></div>
				<div><input type="text" ser_p="p6" /></div>

				<div class="lh30 f1 clr1 fs14"><?=k_mobile?></div>
				<div><input type="text" ser_p="p5" /></div>
				
				<div class="lh30 f1 clr55 fs14"> <?=k_pat_num?></div>
				<div><input type="number" ser_p="p1" /></div>

			</div>
			<div class="fl vis_pat_list_r ofx so" fix="hp:0|wp:210" id="visPatList">
				<div class="loadeText"><?=k_loading?></div>
			</div>
		
	
		</div>
		<div class="form_fot fr">
			<div class="bu bu_t2 fr" onclick="win('close','#full_win1');win('close','#m_info');"><?=k_close?></div> 
		</div>
		</div><?
	}

}?>