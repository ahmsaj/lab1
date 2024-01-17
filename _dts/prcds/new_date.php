<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	?><div class="win_body">
	<div class="winButts"><div class="wB_x fr" onclick="win('close','#full_win1');"></div></div><?
	$id=pp($_POST['id']);
	$sql="select * from dts_x_dates where id='$id' and status in (0,1,9) ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$doctor=$r['doctor'];
		$patient=$r['patient'];
		$clinic=$r['clinic'];
		$date=$r['date'];
		$d_start=$r['d_start'];
		$d_end=$r['d_end'];
		$c_type=$r['type'];
		$doctor=$r['doctor'];
		$status=$r['status'];
		if($status>1 && $status!=9){echo script('dateINfo('.$id.')');exit;}?>	
		<div class="dt_he1 fl ofx so "  fix="hp:110" >
			<div class="f1 fs18 clr1 lh30"><?=get_val('gnr_m_clinics','name_'.$lg,$clinic)?></div>
			<div class="uLine lh1"> </div><?	
			list($c_name,$photo)=get_val('gnr_m_clinics','name_'.$lg.',photo',$clinic);
			$ph_src=viewImage($photo,1,40,40,'img','clinic.png');
			$srvs=get_vals('dts_x_dates_services','service',"dts_id='$id'");
			$q='';
			if($thisGrp=='7htoys03le' || $thisGrp=='fk590v9lvl' || $thisGrp=='nlh8spit9q'){
				$q=" and id= '$thisUser' ";
			}
			if($c_type==4){$q=" and id= '$doctor' ";}
			if($c_type==1){$q2=" ='7htoys03le' ";}
			if($c_type==3){$q2=" IN('1ceddvqi3g','nlh8spit9q') ";}
			if($c_type==4){$q2=" ='fk590v9lvl' ";}
			if($c_type==5){$q2=" ='9yjlzayzp' ";}
			if($c_type==6){$q2=" ='66hd2fomwt' ";}
			if($c_type==7){$q2=" ='9k0a1zy2ww' ";}
			$docQ='';	
			if(in_array($thisGrp,array('fk590v9lvl','1ceddvqi3g','nlh8spit9q','fk590v9lvl','9yjlzayzp','66hd2fomwt','9k0a1zy2ww'))){$docQ=" and id='$thisUser' ";}
			if($c_type==4){
				$sql="select * from _users where act=1  and grp_code  $q2 $docQ order by name_$lg ASC";
			}else{
				$selClnc=getAllLikedClinics($clinic);
				$sql="select * from _users where act=1  and grp_code  $q2 $docQ $q and CONCAT(',', `subgrp`, ',') REGEXP ',($selClnc),' order by name_$lg ASC";
			}
			$res=mysql_q($sql);
			$rows=mysql_n($res);			
			if($rows>0){
				$i=0;
				while($r=mysql_f($res)){
					//$date=$r['date'];
					$u_id=$r['id'];
					//--------------------------------
					$srvs=get_vals('cln_m_services','id'," clinic='$clinic' and def='1'");
					list($time,$price)=get_docTimePrice($u_id,$srvs,$c_type);
					//--------------------------------
					$date=get_docBestDate($u_id,$time);
					if($date){
						if($c_type==4){
							$time=get_val_c('dts_x_dates_services','ser_time',$id,'dts_id' );
							$price=0;
						}else{
							list($time,$price)=get_docTimePrice($u_id,$srvs,$c_type);
						}
						$docs[$date.'-'.$i]['id']=$u_id;
						$docs[$date.'-'.$i]['photo']=$r['photo'];
						$docs[$date.'-'.$i]['clinic']=$r['subgrp'];
						$docs[$date.'-'.$i]['name']=$r['name_'.$lg];
						$docs[$date.'-'.$i]['sex']=$r['sex'];						
						$docs[$date.'-'.$i]['price']=$price;
						$docs[$date.'-'.$i]['time']=$time;
					}
					$i++;
				}
			}			
			ksort($docs);
			$i=1;
			foreach($docs as $k => $d){
				$da=explode('-',$k);
				$date=$da[0];
				$s_h=date('A h:i',$date);
				$act='';
				$doc=$d['id'];
				if($doctor==$doc || ($i==1 && $doctor==0)){
					$act=' act '; 					
					echo script('actSelDoc='.$doc);
					if($doctor==0){mysql_q("UPDATE dts_x_dates SET doctor='$thisUser' where id='$id'");}
				}
				$ph_src=viewImage($d['photo'],1,30,40,'img','nophoto'.$d['sex'].'.png');
				echo '
				<div class="fl dat_list " '.$act.' fix="wp:10" Dtxt="'.$name.'" no="'.$doc.'">
					<div class="fs16 clr11 f1 lh30 " >'.$d['name'].'</div>';
					if($c_type==4){
						$clnicName=get_val_arr('gnr_m_clinics','name_'.$lg,$d['clinic'],'cl');
						echo '<div class="fs14 clr5 f1 lh20 " >العيادة :  '.$clnicName.'</div>';
					}
					echo '<div class="cb f1 fs12 clr2 lh20">
					'.$wakeeDays[date('w',$date)].' - <ff class="fs14">'.date('d',$date).'</ff> - '.$monthsNames[date('n',$date)].' - <ff class="fs14">'.date('Y',$date).'</ff>
					</div>
					<div class="cb f1 fs12 clr2 lh20">
					 الساعة : <ff class="fs14">'.$s_h.'</ff>
					</div>
					<div class="f1 fs12 clr1111 lh20 clr5">المدة : <ff class="fs14">'.$d['time'].'</ff> '.k_min.' </div>
					<div class="f1 fs12 clr1111 lh20">السعر : <ff class="fs14">'.number_format($d['price']).'</ff> '.k_sp.'</div>
				</div>';
				$i++;
			}?>
		</div>
		<div class="fl" fix="wp:200|hp:130">
		<div class=" dt_point fl" fix="wp:5"></div>
		<div class="fl dt_bd ofx so" fix="wp:0|hp:20" style="background-color: #fff" >
			<div id="dts_dt_load"><div class="f1 lh30"><?=k_loading?></div></div>
		</div>
		</div>
	<? }?>
	<div class="uLine lh1 cb"></div>
	<div class="lh60 cb">
		<div class="bu bu_t2 fr" onclick="win('close','#full_win1');"><?=k_close?></div>		
		<div class="bu bu_t1 fl" onclick="dtsBachTosrvs(<?=$id?>);"><?=k_back?></div>
		<? if($patient==0){?>
		<div class="bu bu_t3 fl" onclick="dtsDel(<?=$id?>);"><?=k_delete?></div>		
		<? }?>
	</div>
    </div><?
}?>  