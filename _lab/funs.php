<?/***LAB***/
function get_ser_lab_cats($clinic=''){	
	global $lg,$clr1;	
	$sql="select * from lab_m_services_cats order by name_$lg ASC";
	$out='';	
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){		
		$out.='<div class="ana_list_cat">';
		$out.='<div class="actCat" cat_num="0">'.k_all_test.'</div>';		
		while($r=mysql_f($res)){
			$id=$r['id'];
			$catname=$r['name_'.$lg];
			$out.='<div class="norCat" cat_num="'.$id.'">'.$catname.'</div>';
		}
		$out.='</div>';
	}
	return $out;
}
function get_ser_lab($vis,$act=1){
	global $lg,$clr1;
	$nameTypes=array('','short_name','name_en','name_ar');
	$out='';
	$q=$q2='';
	if($vis){
		$q=" id NOT IN (SELECT service from lab_x_visits_services where visit_id='$vis') ";
		if($act){$q2.=" AND ";}
	}
	if($act){$q2.=" act=1 ";}
	$sql=" SELECT * from lab_m_services where $q $q2 order by ord ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$out.='<div class="ana_list_mdc">';
		while($r=mysql_f($res)){
			$id=$r['id'];
			$code=$r['code'];
			
			$short_name=$r[$nameTypes[_set_yj870gpuyy]];
			$short_name2=$short_name;
			if(_set_yj870gpuyy!=3){
				$short_name2=strtolower($short_name);
			}
			//$name=$r['name_'.$lg];
			$cat=$r['cat'];
			$unit=$r['unit'];			
			$price=$unit*_set_x6kmh3k9mh;
			$cus_unit_price=$r['cus_unit_price'];
			if($cus_unit_price){$price=$unit*$cus_unit_price;}
			$out.='<div class="norCat " cat_mdc="'.$cat.'" s="0"  code="'.strtolower($code).'" mdc="'.$id.'" name="'.$short_name2.'" del="0" price="'.$price.'">'.splitNo($short_name2).'</div>';
		}
		
		$out.='</div>';			
	}
	return $out;
}
function get_samlpViewC($id,$s,$style=0,$no=''){
	global $lg;
	$out='';
	if($s){
		$sql="select * from lab_m_samples_packages where id IN($s)";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			while($r=mysql_f($res)){
				$s_id=$r['id'];
				$name=$r['name_'.$lg];
				$color=$r['color'];
				if($id){
					if($id=='x'){
						$out.='<div style="background-color:'.$color.'" class="smpIcon fl"></div>';
					}else{
						$out.='<div style="background-color:'.$color.'" class="smpIcon siOver fl cur" title="'.$name.'" >
						<div>
							<div a class="fl" onclick="addPkg('.$id.','.$s_id.',1)" title="'.k_same_tube.'"></div>
							<div b class="fl" onclick="addPkg('.$id.','.$s_id.',3)" title="'.k_additional_tube.'"></div>
						</div>
						</div>';
					}
				}else{
					if($style==0){
					$out.='<div style="background-color:'.$color.'" class="smpIcon fl fl"></div> <div class="fl f1 lh50 fs12">'.$name.'</div>';
					}
					if($style==1){
					$out.='<div style="border-bottom:4px '.$color.' solid"  class="smpBg fl f1 lh20 fs12"><ff class="fs12">'.$no.'</ff> - '.$name.'</div>';
					}
					if($style==2){
					$out.='<div style="background-color:'.$color.'" class="smpIcon2 fl"></div> 
					<div class="fl f1 ">'.$name.'<br><span class="ff B">'.$no.'</span></div>';
					}
					if($style==3){
					$title=$name.' '.$no;
					$out.='<div style="background-color:'.$color.'" title="'.$title.'" class="smpIcon3 fl Over"></div> 
					';
					}
					if($style==4){
					$out.='<div class="cur" onclick="veiwSamplInfo('.$no.')">
					<div style="background-color:'.$color.'"  class="smpIcon2 fl fl"></div>
					<div class="fl f1 lh20">'.$name.'<br><span class="ff B">'.$no.'</span></div></div>';
					}
				}
			}
		}
	}
	return $out;
}
function labSstatus($vis){
	/*$a0=getTotalCO('lab_x_visits_services'," visit_id='$vis' and status not IN(2,3,4)");
	$a2=getTotalCO('lab_x_visits_services'," visit_id='$vis' and ( status =1 or status > 4 )");
	$a=$a0-$a2;
	if($a>0){
		$out='<div class="f1 fs12">'.k_tests.' : <span class="ff B fs14">( '.$a0.' )</span></div>
		<div class="f1 fs12 clr5">'.k_tests_selt_sams.' <span>('.$a.')</span></div>';
	}else{
		$a=getTotalCO('lab_x_visits_samlpes'," visit_id='$vis' ");
		$a0=getTotalCO('lab_x_visits_samlpes'," visit_id='$vis' and status=0 ");
		$a1=getTotalCO('lab_x_visits_samlpes'," visit_id='$vis' and status=1 ");
		$a2=getTotalCO('lab_x_visits_samlpes'," visit_id='$vis' and status in(2,3) ");
		$out='<div class="f1 fs12">'.k_sampels.' : <span class="ff B fs14">( '.$a.' )</span></div>';
		if($a2==$a){
			if($a2==0){				
				$b0=getTotalCO('lab_x_visits_services'," visit_id='$vis' ");
				$b2=getTotalCO('lab_x_visits_services'," visit_id='$vis' and status=3");
				if($b0==$b2){
					mysql_q("UPDATE lab_x_visits set status=3  where id= '$vis' ");
					mysql_q("DELETE from  gnr_x_roles where vis= '$vis' and mood=2");
				}				
			}
			$out.='<div class="f1 fs12 clr6">'.k_samples_recieved.'</div>';
			//mysql_q("UPDATE gnr_x_roles set status=4  where vis= '$vis' and mood=2 ");
		}else{
			if($a0>0){
				$out.='<div class="f1 fs12 clr5">'.k_sams_numbrd.' <span>( '.$a0.' )</span></div>';
			}else{
				$out.='<div class="f1 fs12 clr1">'.k_received.' <span>( '.($a.'/'.$a2).' )</span></div>';
			}
		}		
	}
	return $out;	*/
}
function autoAddSample($vis){	
	$sql="select * from lab_x_visits_services where visit_id='$vis' and sample_link=0";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$id=$r['id'];
			$service=$r['service'];
			$fast=$r['fast'];
			$patient=$r['patient'];
			list($tube,$full_tube)=get_val('lab_m_services','tube,full_tube',$service);
			addSerToSample($id,$vis,$patient,$tube,$full_tube,$fast);
		}
	}
}
function addSerToSample($srv,$vis,$pat,$tube,$full_tube,$fast){
	global $thisUser,$now;
	$addNew=0;
	$out=0;
	if($full_tube){
		$addNew=1;
	}else{
		if(getTotalCO('lab_x_visits_samlpes'," visit_id='$vis' and pkg_id='$tube' and full_tube=0 " )==0){
			$addNew=1;
		}
	}
	if($addNew){
		if(mysql_q("INSERT INTO lab_x_visits_samlpes (`visit_id`,`pkg_id`,`services`,`user`,`date`,`patient`,`fast`,`take_date`,`full_tube`)values('$vis','$tube','$srv','$thisUser','$now','$pat','$fast','$now','$full_tube')")){
			$sample=last_id();
		}
		
	}else{
		list($sample,$services)=get_val_con('lab_x_visits_samlpes','id,services'," visit_id='$vis' and pkg_id='$tube' and full_tube=0 ");
		$n_services=$srv;
		if($services){$n_services=$services.','.$srv;}
		$q='';		
		if($fast){$q=" , fast= 1 ";}
		mysql_q("UPDATE lab_x_visits_samlpes set services='$n_services' $q where id='$sample' limit 1");
	}
	if($sample){		
		mysql_q("UPDATE lab_x_visits_services set status=5 , sample_link='$sample' where id='$srv' ");
		endLabVist($vis);
		$out=1;
	}
	return $out;
}
/*
function samAutoNum($tube){
	$c= 1;
	while($c>0){
		$n=rand(10000000,90000000);
		$c=getTotalCO('lab_x_visits_samlpes',"no='$n'");
	}
	$res=mysql_q("UPDATE lab_x_visits_samlpes SET no='$n' , status=1 where  id='$tube' and (no is NULL OR no='') and status <2 ");
	if(mysql_a()){return $n;}
}*/
// function samAutoNum($tube){
// 	$c= 1;
// 	$x=0;
// 	while($c>0 && $x<50){
// 		$x++;
// 		$n=rand(200000000,9000000000);
// 		$c=getTotalCO('lab_x_visits_samlpes',"no='$n'");	
// 		$res=mysql_q("UPDATE lab_x_visits_samlpes SET no='$n' , status=1 where  id='$tube' and (`no` is NULL OR `no`='') and status <2 ");	
// 		if(mysql_a()){return $n; }
// 	}
// }
function samAutoNum($tube){
	$n=getMaxMin('max','lab_x_visits_samlpes','no')+1;
	$res=mysql_q("UPDATE lab_x_visits_samlpes SET no='$n' , status=1 where  id='$tube' and (`no` is NULL OR `no`='') and status <2 ");	
	if(mysql_a()){return $n; }
}
function get_samlpViewAll($vis,$ids){
	global $lg;	
	$out='';
	$sql="select * from lab_m_samples_packages where id IN( $ids )";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$s_id=$r['id'];
			$name=$r['name_'.$lg];
			$color=$r['color'];
			$out.='<div style="background-color:'.$color.'" class="smpIcon fl cur" title="'.$name.'" onclick="addPkg('.$vis.','.$s_id.',2)"></div>';
		}
	}
	
	return $out;
}
function LabAddSample($srv,$id,$type,$p,$sample=''){	
	global $thisUser,$now;
	$q2='';
	list($vis,$fast)=get_val('lab_x_visits_services','visit_id,fast',$srv);	
	if($type==4 && $sample){
		$services=get_val('lab_x_visits_samlpes','services',$sample);		
		$n_services=$services.','.$srv;
		$q='';
		$fast=checkFastVal($n_services);
		if($fast){$q=" , fast= 1 ";}		
		if(mysql_q("UPDATE lab_x_visits_samlpes set services='$n_services' $q where id='$sample' limit 1")){
			mysql_q("UPDATE lab_x_visits_services set status=5 , sample_link='$sample' $q2 where id='$srv'");
			endLabVist($vis);
			return 1;
		}
	}else{
		if(getTotalCO('lab_x_visits_samlpes'," visit_id='$vis' and pkg_id='$id' " )==0 || $type==3){	
			$old=getTotalCO("lab_x_visits_samlpes"," visit_id='$vis' and FIND_IN_SET('$srv',`services`)> 0 ");		
			if(!$old){
				if(mysql_q("INSERT INTO lab_x_visits_samlpes (`visit_id`,`pkg_id`,`services`,`user`,`date`,`patient`,`fast`,`take_date`)values('$vis','$id','$srv','$thisUser','$now','$p','$fast','$now')")){
					$sample_link=last_id();
					mysql_q("UPDATE lab_x_visits_services set status=5 , sample_link='$sample_link' where id='$srv'");
					endLabVist($vis);
					return 1;
				}
			}
		}else{			
			list($services,$sample_link)=get_val_con('lab_x_visits_samlpes','services,id',"visit_id='$vis' and pkg_id='$id'");		
			$n_services=$services.','.$srv;
			$q='';
			$fast=checkFastVal($n_services);
			if($fast){$q=" , fast= 1 ";}
			$res=mysql_q("UPDATE lab_x_visits_samlpes set services='$n_services' $q where visit_id='$vis' and pkg_id='$id' order by no ASC limit 1");			
			if($res){
				$q2='';if($sample){$q2=" , sample='$sample' ";}
				mysql_q("UPDATE lab_x_visits_services set status=5 , sample_link='$sample_link' $q2 where id='$srv'");
				endLabVist($vis);				
				return 1;
			}
		}
	}
}
function LabAddSampleAll($vis,$pkj){
	$out=1;
	$pa=get_val('lab_x_visits','patient',$vis);
	$sql="select id,service from lab_x_visits_services where visit_id='$vis' and status=0";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$id=$r['id'];
			$service=$r['service'];
			$sample=get_val('lab_m_services','sample_type',$service);
			$packge=get_val('lab_m_samples','pg',$sample);	
			$pck_arr=explode(',',$packge);
			if(in_array($pkj,$pck_arr)){
				$o=LabAddSample($id,$pkj,2,$pa);
				if($o==0){$out=0;}
			}
		}
	}
	endLabVist($vis);
	return $out;
}
function checkFastVal($ids){
	$out=0;
	if($ids){$out=getTotalCO('lab_x_visits_services'," id IN($ids) and fast =1 ");}
	return $out;
}
function LabDelAna($srv,$id){
	$serviecs=get_val('lab_x_visits_samlpes','services',$id);
	if('a'.$serviecs=='a'.$srv){
		if(mysql_q("DELETE from lab_x_visits_samlpes where id ='$id'  OR (sub_s='$id' && services='' )")){
			mysql_q("UPDATE lab_x_visits_services set status=0 where id='$srv'");
			return 1;
		}
	}else{
		$n_services='';
		$s=explode(',',$serviecs);
		foreach($s as $ss){
			if($ss!=$srv){
				if($n_services){$n_services.=',';}
				$n_services.=$ss;
			}
		}
		$q=' , fast= 0';
		$fast=checkFastVal($n_services);
		if($fast){$q=" , fast= 1 ";}
		if(mysql_q("UPDATE lab_x_visits_samlpes set services='$n_services' $q where id='$id'")){
			mysql_q("UPDATE lab_x_visits_services set status=0 where id='$srv'");
			return 1;
		}
	}
}
function getLinkedAna($status,$id,$s,$t=1){
	global $lg;
	if($t==1){$out='';}
	if($t==2 || $t==3){$out=array();}
	if($s){
		$sql="select * , x.id as x_id , z.id as z_id , x.fast as x_fast from lab_x_visits_services x , lab_m_services z where x.service=z.id and  x.id IN($s)";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$i=0;
			while($r=mysql_f($res)){
				$s_id=$r['x_id'];
				$cat=$r['z_id'];
				$name=$r['short_name'];
				$outlab=$r['outlab'];
				$code=$r['code'];
				$units=$r['units'];
				$fast=$r['x_fast'];
				$sample_type=$r['sample_type'];
				$pkg=get_val('lab_m_samples','pg',$sample_type);				
				$pp=explode(',',$pkg);
				if($t==1){
					if($status==0 && count($pp)>1){
						$out.='<div class="ff fs12 B lh30 cur delText" title="'.k_delete_test.'" onclick="delAnaFromSPkg('.$id.','.$s_id.')">'.($i+1).' - '.$name.'</div>';
					}else{
						$out.='<div class="ff fs12 B lh30">'.($i+1).' - '.$name.'</div>';
					}
				}
				if($t==2){
					$sty='';
					
					if($code==''){$code=$name;}
					$color=get_val('lab_m_services_cats','color',$cat);
					if($color==''){$color="#000";}
					
					if($units>=14){$sty='p_Hprice pd5';}
					if($fast){$sty='p_emrg pd5 clrw';$color="#fff";}
					array_push($out,'<span style="color:'.$color.'" class="ff fs18 B '.$sty.'">'.$code.'</span>');
				}
				if($t==3){
					if($code==''){$code=$name;}
					$color=get_val('lab_m_services_cats','color',$cat);
					if($color==''){$color="#000";}
					array_push($out,$outlab.',<span style="color:'.$color.'" class="ff fs18 B">'.$code.'</span>,'.$cat); 
				}
				$i++;
			}
		}
	}
	return $out;
}
function get_anl_names($id){
	$out='';
	$sql="select * from lab_x_visits_services x , lab_m_services z where x.service=z.id and  x.visit_id='$id' and x.status not IN(2,3)";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	$time_r=0;
	if($rows>0){
		while($r=mysql_f($res)){
			$name=$r['short_name'];
			$code=$r['code'];
			$time_req=$r['time_req'];
			$time_r=max(array($time_req,$time_r));
			if($code==''){$code=$name;}
			$out.='<div class="fll uLine fs16 B">'.$code.'│</div>';
		}
	}
	return array($time_r,$out);
}
function getPkgForAna($vis,$ser_id){
	$sql="SELECT pkg_id from lab_x_visits_samlpes where visit_id='$vis' and FIND_IN_SET('$ser_id',`services`)> 0 ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){$r=mysql_f($res);return $r['pkg_id'];}
}
function get_max_resTime($vis){
	$sql="select max(`time_req`)c from lab_m_services where id IN(select service from lab_x_visits_services where visit_id='$vis')";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){$r=mysql_f($res);return $r['c'];}
}
function get_lab_con($con,$s=' | '){
	global $lg;
	$out='';				
	$sql="select * from lab_m_services_condition where id IN($con)";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$cons='';		
		while($r=mysql_f($res)){
			$name=$r['name_'.$lg];
			if($cons!='')$cons.=$s;
			$cons.=$name;
		}
		$out.='<div class="fa  f1 fs14 clr5 lh30">'.k_conditions.' : '.$cons.'</div>';
	}
	return $out;
}

function getThisSamples($s){
	global $lg;
	$out='';
	if($s){
		$sql="select * from lab_m_samples where id IN($s)";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			while($r=mysql_f($res)){
				$out.='<div class="f1 fs12 lh20">'.$r['name_'.$lg].'</div>';
			}
		}
	}	
	return $out;
}
function equations($id){
	$t='n';
	$out='';
	$total=getTotalCO('lab_m_services_equations'," ana_no ='$id' ");
	if($total>0){$t='t';}
	$out.='<div class="child_link fl" onclick="anaEqu('.$id.')">
	<div '.$t.'>'.$total.'</div>'.k_equations.'</div>';
	return $out;
}
function lab_vis($id){
	$out='';
	$total=getTotalCO('lab_x_visits'," patient ='$id' ");
	if($total==0){
		$out='<div class="f1 fs14 clr5">'.k_no_past_visits.'</div>';
	}else{
		$out.='<div class="child_link fl" onclick="viwLabVis('.$id.')">
		<div t>'.$total.'</div>'.k_vw_lb_vis.'</div>';
	}
	return $out;
}
function OlabPrice($id){
	$out='';
	$total=getTotalCO('lab_m_external_Labs_price'," lab ='$id' ");
	$t='n';
	if($total>0){$t='t';}
	$out.='<div class="child_link fl" onclick="labPrices('.$id.')">
	<div '.$t.'>'.$total.'</div>'.k_ana_prices.'</div>';
	return $out;
}
function report_de($id,$opr,$filed,$val){
	$out='';
	if($opr=='list' || $opr=='view'){	
		$t=0;
		if($val){$v=explode('|',$val);$t=count($v);}
		$s='t';
		if($t==0){$s='n';}
		
		$out.='<div class="child_link fl" onclick="reportDesign('.$id.')" ><div '.$s.'>'.$t.'</div>'.k_design_report.'</div>';
	}
	if($opr=='add' || $opr=='edit'){
		$out='<div class="f1">'.k_enter_report_after_ana_set.'</div>
		<input type="hidden" name="'.$filed.'" value="'.$val.'"></input>';
	}
	return $out;
}
function rack_xy($id,$opr,$filed,$val){
	$out='';
	if($opr=='list' || $opr=='view'){	
		$t='';
		if($val){$t='act';}
		$out.=k_dimensions;
	}
	if($opr=='add' || $opr=='edit'){
		$out='
		<table width="100%">
		<tr><td></td><td align="center">X</td><td align="center">Y</td><td align="center">'.k_num_angle.'</td></tr>
		<tr><td align="center">'.k_type.'</td>
		<td><select style="width:80px;"><option>1,2,3 ....</option><option>A,B,C ....</option></select></td>		
		<td><select style="width:80px;"><option>1,2,3 ....</option><option>A,B,C ....</option></select></td></tr>
		<tr><td>'.k_num_fields.'</td>
		<td><input style="width:80px;" type="number"/></td>		
		<td><input style="width:80px;" type="number"/></td></tr>
		</table>';
	}
	return $out;
}
function lab_avr_set($id){
	$t='n';
	$out='';
	list($type,$report_type)=get_val('lab_m_services_items','type,report_type',$id);	
	if($type==2){
		if(!in_array($report_type,array(6,8,9))){
			$total=getTotalCO('lab_m_services_items_normal'," ana_no ='$id' ");
			if($total>0){$t='t';}
			$out.='<div class="child_link fl" onclick="anaParts('.$id.')">
			<div '.$t.'>'.$total.'</div>'.k_norl_rates.'</div>';
		}
	}else{$out='<div class="titleLine"></div>
	<script>$(".titleLine").closest("tr").css("background-color","#ccf");</script>';}

	return $out;
}
function getaQNames($t,$q){
	global $lg,$Q_sin;
	$out='';
	if($t==2 || $t==3){
		if($q){
			$sql="select name_$lg from lab_m_services_items where  id IN($q)";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				while($r=mysql_f($res)){
					$name=$r['name_'.$lg];
					if($out){$out.=' | ';}
					$out.=$name;
				}
			}
		}
	}
	if($t==1){
		if($q){
			$qq=explode(',',$q);
			foreach($qq as $qqq){
				$v=explode(':',$qqq);
				if($v[0]=='o'){$out.=$Q_sin[$v[1]];}
				if($v[0]=='v'){$out.='['.$v[1].']';}
				if($v[0]=='n'){$out.=$v[1];}
			}
		}
	}
	return $out;
}
function getQGraphic($q){
	global $lg,$Q_sin;
	$out='';
	if($q){
		$qq=explode(',',$q);
		foreach($qq as $qqq){
			$v=explode(':',$qqq);
			if($v[0]=='o'){$out.='<div class="fl" o val="'.$v[1].'" type="o" t="o">'.$Q_sin[$v[1]].'</div>';}
			if($v[0]=='a'){$out.='<div class="fl" a val="'.$v[1].'" type="o" t="a">'.$Q_sin[$v[1]].'</div>';}
			if($v[0]=='v'){$out.='<div class="fl" title="'.get_val('lab_m_services_items','name_'.$lg,$v[1]).'" v val="'.$v[1].'" type="v" t="v">['.$v[1].']</div>';}
			if($v[0]=='n'){$out.='<div class="fl" n val="'.$v[1].'" type="v" t="n">'.$v[1].'</div>';}
		}
	}
	return $out;
}
function get_sel_rd($txt,$type){
	$out=array();
	$a=explode('|',$txt);
	foreach($a as $b){
		$c=explode('^',$b);
		$d=explode(',',$c[1]);
		foreach($d as $e){
			$f=explode('.',$e);
			foreach($f as $g){
				$h=explode(':',$g);
				$t=$h[0];
				$id=$h[1];
				if($t==1 && $type==1){array_push($out,$id);}
				if(($t==2 || $t==3 ) && $type==2){array_push($out,$id);}
			}
		}
	}
	return $out;
}
function drow_edit_rd($txt){
	global $lg;	
	if($txt!=''){
		$out='';
		$a=explode('|',$txt);
		foreach($a as $b){
			$c=explode('^',$b);
			$rows_n=$c[0];
			$ran=rand(10000,99000);
			$out.='<div r="r'.$rows_n.'" class="fl" id="r'.$ran.'"><div class="rd_mover fl"></div>';
			$d=explode(',',$c[1]);		
			foreach($d as $e){
				$out.='<div class="fl " fil new>';
				$f=explode('.',$e);
				foreach($f as $g){
					$h=explode(':',$g);
					$t=$h[0];
					$id=$h[1];
					if($t==1){
						$type=get_val('lab_m_services_items','type',$id);
						$name=get_val('lab_m_services_items','name_'.$lg,$id);
						$t='';if($type==1)$t='ok';
						$out.='<div selit="'.$id.'" new title="'.k_press_delete.'" del="1" '.$t.'>'.$name.'</div>';
					}
					if($t==2 || $t==3){
						$q=get_val('lab_m_services_equations','equations',$id);
						$type=get_val('lab_m_services_equations','type',$id);						
						$img='';						
						if($type==2){$img='<img src="../images/nti2.png"/><br>';}
						if($type==3){$img='<img src="../images/nti3.png"/><br>';}
						
						$q_txt=getaQNames($type,$q);
						$out.='<div selit="'.$id.'" new title="'.k_press_delete.'" del="'.$type.'" >'.$img.$q_txt.'</div>';						
					}
				}
				$out.='</div>';
			}
			$out.='<div class="rdr_del fl" onclick="delRow_rd('.$ran.');"></div></div>';
		}
		return $out;
	}
}
/*
function enter_l_report($ser_id,$txt,$sex,$age,$sample,$xVales=array()){
	global $lg,$tCol;
	$out='';
	$statusCol=1;
	if($txt!=''){
		$a=explode('|',$txt);
		//$out.='<table class="grad_s_lab" width="100%" cellspacing="5" cellpadding="4">';
		foreach($a as $b){
			//$out.='<tr>';
			$c=explode('^',$b);
			$rows_n=$c[0];
			$td_p=' width="50%" ';
			if($rows_n==1){$td_p='colspan="2"';}
			
			$d=explode(',',$c[1]);		
			foreach($d as $e){
				$out.='<tr>';
				//$out.='<td '.$td_p.' valign="top">';
				$f=explode('.',$e);
				foreach($f as $g){
					$h=explode(':',$g);
					$t=$h[0];
					$id=$h[1];
					if($t==1){
						$rec=getRec('lab_m_services_items',$id);
						$rows=mysql_n($res);
						if($rec['r']){
							$type=$rec['type'];
							$name=$rec['name_'.$lg];
							$unit=$rec['unit'];
							$normal_code=$rec['normal_code'];
							$report_type=$rec['report_type'];
							if($type==1){
								$out.='<td colspan="'.$tCol.'" t class="f1 fs16 ">---'.splitNo($name).'</td>';
								$statusCol=0;
							}else{
								list($r_id,$val,$vsr_id)=get_LR_res($ser_id,$id);
								$bgB='s';
								if($val=='xXx'){$bgB='n';$val='';}
								if(in_array($id,$xVales)){
									$out.='<div class="xv_msg"><div class="f1 clrw tit lh30 TC">----
									'.k_result_intercepted.'</div>';
									$bgB='n';
								}
								list($code_txt,$unitTxt)=get_val('lab_m_services_units','code,name_'.$lg,$unit);
								list($norV,$addVals,$nor_d,$nor_d2,$nor_note)=get_LreportNormalVal($report_type,$id,$sex,$age,$sample);
								//$out.='<div b >
								$out.='<td class="f1 fs14 clr1"></td>';
								$out.='<td class="f1 fs14 clr1">'.splitNo($name).'</td>';
								
								//if($code_txt){
									
								//}
								/*
								$nor_val=show_LreportNormalVal($report_type,$id,$sex,$age,$sample,$val,$unit);
								$nor_val[6];
								$out.=get_LreportInput($report_type,$id,$sex,$age,$val,$norV);
								
								if($norV){$out.=$nor_val[2];}else{$out.='<div class="lh30">&nbsp;</div>';}*/
							/*	$out.='<td class="f1 fs14 clr1 " >'.$ser_id.get_LreportInput($report_type,$id,0,$sex,$age,$val,$addVals).'</td>';
								$out.='<td class="ff B fs14 clr5" title="'.$unitTxt.'">'.$code_txt.'</td>';								
								$out.='<td class="ff B clr1" >
								<div>'.$nor_d.'</div>
								<div>'.$nor_d2.'</dv></td>';
								//$out.='<td class="ff B clr1 fs16" >'.$nor_d2.'</td>';
								//$out.='<td class="f1 fs14 clr10">';
								//if($norV){$out.=$norV;}else{$out.='<div class="lh30">&nbsp;</div>';}
								//$out.='</td>';
								//$out.='</div>';
								//if(in_array($id,$xVales)){ $out.='</div>';}
							}
						}
					}
					if($t==2 || $t==3){
						$q=get_val('lab_m_services_equations','equations',$id);
						$type=get_val('lab_m_services_equations','type',$id);						
						$img='<img src="../images/nti'.$type.'.png"/>';					
						$q_txt=getaQNames($type,$q);
						$out.='<div b selit'.$t.'="'.$id.'" <div b class="TC" >'.$img.'</div>';					
					}
				}
				//$out.='</td>';
				//$out.='</tr>';
			}
			//if($statusCol){$out.='<td>----</td>';}
			$out.='</tr>';
		}
		//$out.='</table>';
	}
	return $out; 
}
*/
function get_LreportInput($type,$id,$vis_id,$sex='',$age='',$val='',$addVals){
	global $anT3_types;
	$out='<div class="" part="input" no="'.$id.'_'.$vis_id.'" rt="'.$type.'">';
	switch ($type){
		case 1:$out.='<input type="number" name="lrp_'.$id.'_'.$vis_id.'" value="'.$val.'" /> ';break;
		case 2:$out.='<input type="number" name="lrp_'.$id.'_'.$vis_id.'" value="'.$val.'"/>';break;
		case 3:
		$ch1='';if($val=='p'){$ch1=' checked ';}
		$ch2='';if($val=='n'){$ch2=' checked ';}
		$p_Val=$anT3_types[1];
		$n_Val=$anT3_types[0];
		if($addVals){
			$ap=explode(',',$addVals);
			if(count($ap)==2){
				$p_Val=$ap[1];
				$n_Val=$ap[0];
			}
		}
		$out.='
		<div class="radioBlc">
		<input type="radio" name="lrp_'.$id.'_'.$vis_id.'" value="p" '.$ch1.' par="p"/><label>'.$p_Val.'</label>
		<input type="radio" name="lrp_'.$id.'_'.$vis_id.'" value="n" '.$ch2.' par="n"/><label>'.$n_Val.'</label>
		</div>';
		break;
		case 4:$out.='<input type="number" name="lrp_'.$id.'_'.$vis_id.'" value="'.$val.'"/>';break;
		case 5:$out.=getLROptions($type,$id,$vis_id,$sex,$age,$val);break;
		case 6:
		//if(!$val){$val=get_val('lab_m_services_items','def_value',$id);}
		$out.='<textarea name="lrp_'.$id.'_'.$vis_id.'" style="width:100%">'.$val.'</textarea>';break;
		case 7:$out.='<input type="number" name="lrp_'.$id.'_'.$vis_id.'" value="'.$val.'"/>';break;
		case 8:$out.='<input type="number" name="lrp_'.$id.'_'.$vis_id.'" value="'.$val.'"/>adad';break;
	}
	$out.='</div>';
	return $out;
}
// function show_l_report($ser_id,$txt,$sex,$age,$sample,$status,$type,$s_type){
// 	global $lg,$lab_res_CS_types,$lab_res_CS_level,$lab_res_fmf_Stypes,$lab_res_fmf_types;
// 	$revData='';
// 	if($type==1 || $type==4){
// 		$sql3="select * from lab_m_services_items where serv='$ser_id' and type!=1 order by ord ASC  ";
// 		$res3=mysql_q($sql3);
// 		$rows3=mysql_n($res3);
// 		if($rows3>1){							
// 			//$revData.='<tr><td class="f1 fs16 cbg4"></td><td colspan="'.$tCol.'" class="f1 fs16 cbg44">'.splitNo($name).'</td></tr>';
// 		}
// 		$i=0;
// 		while($r3=mysql_f($res3)){
// 			$i++;			
// 			$xSrv_id=$r3['id'];
// 			$s_type=$r3['type'];
// 			$name=$r3['name_'.$lg];
// 			$unit=$r3['unit'];
// 			$normal_code=$r3['normal_code'];
// 			$report_type=$r3['report_type'];
			
// 			$last='';
// 			if($i==$rows3 && $rows3>1){$last='last';}
// 			$revData.='<tr b '.$last.'>';
// 			if($hide==0){
// 				if($type==1){
// 					$revData.='<div class="f1 fs14" bt>'.$name.'</div>';
// 				}else{
// 					list($r_id,$val,$vsr_id)=get_LR_res($ser_id,$id);
// 					if($val=='xXx'){
// 						$revData.='<div bb no="'.$vsr_id.'">
// 						<div class="f1 clr1">'.$name.' :   
// 							<span class="f1" style="color:#f00">'.k_resutl_not_enter.'</span>
// 						</div>
// 						</div>';
// 					}else{
// 						$rrv=0;
// 						if($status==10){
// 							$rrv=getTotalCO('lab_x_visits_services_results_x'," x_id='$r_id' ");
// 						}
// 						$nor_val=show_LreportNormalVal($report_type,$id,$sex,$age,$sample,$val,$unit,$normal_code);
// 						$new_val=$nor_val[3];
// 						list($unit_code,$unit_txt,$dec_point)=get_val('lab_m_services_units','code,name_'.$lg.',dec_point',$unit);
// 						if($s_type){
// 							$x_sVal='';
// 							if($status==6 || $status==7 || $status==10){$x_sVal='x_val';}
// 							$revData.='<div bb no="'.$vsr_id.'" sw="off">
// 							<div class="'.$x_sVal.' f1 fr" title="'.k_refuse_report.'"></div>';
// 						}
// 						if($rrv){
// 							$revData.='<div class="ic40 icc2 ic40_det l_Reslr" title=
// 							"'.k_previous_results.'" onclick="x_result('.$r_id.')"></div>';			
// 						}
// 						$revData.=drowReport(1,$report_type,$name,$unit_txt,$unit_code,$dec_point,$nor_val);		
// 						$revData.='</div>';
// 					}
// 				}
// 			}	
// 			if($t==2 || $t==3){
// 				list($q,$sType)=get_val('lab_m_services_equations','equations,item',$id);
// 				//$q_txt=getaQNames($type,$q);
// 				$revData.='<div  bb class="TC" >'.getChartLRR($ser_id,$t,$q,$sType).'</div>';
// 			}
// 			$revData.='</tr>';
// 		}
// 		//$out.='</table>';
// 	}
// 	if($type==2 || $type==3 ){
// 		$rec=getRec('lab_x_visits_services_result_cs',$ser_id,'serv_id');
// 		if($rec['r']){
// 			$ss_val=$rec['val'];
// 			$ss_sample_type=$rec['sample_type'];
// 			$ss_colonies=$rec['colonies'];
// 			$ss_level=$rec['level'];
// 			$ss_bacteria=$rec['bacteria'];
// 			$ss_wbc=$rec['wbc'];
// 			$ss_rbc=$rec['rbc'];					
// 			$ss_note=$rec['note'];
// 			$ss_status=$rec['status'];					
// 		}
// 		if($ss_val==1){$out='<div class="f1 fs14 clr6 ">'.$lab_res_CS_types[$ss_val].'</div>';}
// 		if($ss_val==2){$out='<div class="f1 fs14 clr5 ">'.$lab_res_CS_types[$ss_val].'</div>';}
// 		if($ss_val==3){
// 			$service_id=get_val('lab_x_visits_services','service',$ser_id);
// 			$out.='<div class="lh30 fl_d cb">
// 			<div class="clr1 cb TC f1 fs20 pd5 B">'.get_val('lab_m_services','name_'.$lg,$service_id).'</div> 
// 			<div class="clr1 fll fs14 pd5">'.$lab_res_CS_level[$ss_level].'</div> 
// 			<div class=" fll fs14"> Result
// </div>
// 			<div class="clr5 fll fs14 pd5"> '.get_val('lab_m_test_bacterias','name',$ss_bacteria).'</div>
// 			</div>';			
// 			$out.='<div class="lh30 fl_d cb">';
// 			if($ss_colonies){$out.='<div class="fl f1 fs14 pd5">'.k_num_colons.' : <ff  class="clr1">'.number_format($ss_colonies).'</ff> | </div>';}	
// 			if($ss_wbc){$out.='<div class="fl f1 fs14 pd5">W.B.C : <ff class="clr1">'.$ss_wbc.'</ff> |</div>';}
// 			if($ss_rbc){$out.='<div class="fl f1 fs14 pd5">R.B.C : <ff class="clr1">'.$ss_rbc.'</ff> |</div>';}
// 			$out.='</div>';	
// 			if($ss_note){$out.='<div class="cb f1 fs16 pd5 lh30">'.k_notes.' : <span class="clr1 fs14 f1">'.$ss_note.'</span> </div>';}
			
// 			$sql="select * from lab_x_visits_services_result_cs_sub where p_id='$ser_id' order by id ASC";
// 			$res=mysql_q($sql);
// 			$rows=mysql_n($res);
// 			if($rows>0){
// 				$out.='<table width="100%"  cellspacing="0" cellpadding="0" class="grad_s " type="static" dir="ltr">
// 				<tr><th rowspan="2">ANTIMICROBIAL<br>AGENTS</th><th colspan="3">Zone Diameter ( MM )</th><th rowspan="2">COMMERCIAL<br>NAME</th></tr>
// 				<tr><th width="100">Results ( MM )</th><th width="100">R ( Below )</th><th width="100"> ( Over )</th></tr>';
// 				while($r=mysql_f($res)){
// 					$antibiotics=$r['antibiotics'];
// 					$val=$r['val'];
// 					$n_id=$r['id'];
// 					$code=$r['code'];				
// 					$min_val=$r['min_val'];
// 					$max_val=$r['max_val'];	list($n_name,$trad_name)=get_val('lab_m_test_antibiotics','name,trad_name',$antibiotics);
// 					$out.= '<tr><td><ff>'.$n_name.'</ff></td>
// 					<td><ff class="clr1">'.$code.'</ff><ff> ( '.$val.' ) </ff></td>
// 					<td><ff>'.$min_val.'</ff></td>
// 					<td><ff>'.$max_val.'</ff></td>
// 					<td><ff>'.$trad_name.'</ff></td>
// 					</tr>';
// 				}							
// 				$out.= '</table>';
// 			}	
// 		}
// 	};
// 	if($type==5){			
// 		$editVal=get_val_c('lab_x_visits_services_results','value',$ser_id,'serv_id');			
// 		$sql="select * from lab_m_test_mutations where act=1 order by name ASC";
// 		$res=mysql_q($sql);
// 		$rows=mysql_n($res);
// 		if($rows>0){
// 			$antiEditVal=getAntiEditVal2($editVal);
// 			$out.='<div class="fl_d ff fs22 TC B lh30 pd10">Assay for the Identication of MEFV geng mutatione <br> Based on real time polymerase chain reaction ( real time PCR ) </div>';
// 			$out.='<div class="fl_d ff fs18 pd10 lh30">Mutations detected with this test, potentially leading to a FMF phenotype , are  as follws :  </div><div class="fl_d pd10">';
// 			$out.='<table width=""  cellspacing="0" cellpadding="6" class="grad_s " dir="ltr" type="static" >';
// 			$c=0;
// 			while($r=mysql_f($res)){
// 				$n_id=$r['id'];
// 				$n_name=$r['name'];				
// 				$t1='<ff class="clr5">'.$lab_res_fmf_types[0].'</ff>';
// 				$t2='';
// 				if($editVal){
// 					if($antiEditVal[$n_id]){
// 						$c++;
// 						$v1=$antiEditVal[$n_id]['v1'];
// 						$v2=$antiEditVal[$n_id]['v2'];
// 						if($v1==1){
// 							$t1='<ff class="clr6">'.$lab_res_fmf_types[1].'</ff>';
// 							if($v2==1){$t2=' - '.$lab_res_fmf_Stypes[1];}if($v2==2){$t2=' - '.$lab_res_fmf_Stypes[2];}
// 						}	
// 						$out.= '<tr><td width="30"><ff>'.$c.'</ff></td><td><ff>'.$n_name.'</ff></td><td>'.$t1.' <ff> '.$t2.'</ff></td></tr>';
// 					}
// 				}
// 			}							
// 			$out.='</table></div>';
// 		}
// 	};
// 	return $revData;
// } 
function drowReport($type,$report_type,$name,$unit_txt,$unit_code,$dec_point,$nor_val){
	$new_val=$nor_val[3];
	$out='';
	if($report_type==1){$new_val=limitDec($new_val,$dec_point);	}
	$out.='<td class=" pd10 fs16" style="color:'.$nor_val[0].'" >'.$new_val.'</td>';
	$out.='<td class="fs14 ff B pd10" title="'.$unit_txt.'" >'.$unit_code.'</td>';
	$out.='<td class="cb lh20 clr6">'.$nor_val[2].'</td>';
	//$out.='<td class="lh30">--'.$nor_val[1].'</td>';
	
	return $out;
}
function print_l_report($ser_id,$txt,$sex,$age,$sample,$status,$type,$oneRow=0,$hisRes=0){
	global $lg,$lab_res_CS_types,$lab_res_CS_level,$lab_res_fmf_Stypes,$lab_res_fmf_types,$hisResNo,
	$lastAnaDate,$lastAnaVal,$lastAnaclr;
	$note='';
	if($type==1 || $type==4){
		if($oneRow){
			$sql="select * from lab_m_services_items where serv='$oneRow' ";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				$r=mysql_f($res);
				$ss_id=$r['id'];
				$s_type=$r['type'];
				$report_type=$r['report_type'];
				$name=$r['name_'.$lg];
				$unit=$r['unit'];
				$hide=$r['hide'];
				$normal_code=$r['normal_code'];
				$show_last=$r['show_last'];
				if($hide==0 ){
					list($r_id,$val,$vsr_id)=get_LR_res($ser_id,$ss_id);
					$rrv=0;
					if($status==10){$rrv=getTotalCO('lab_x_visits_services_results_x'," x_id='$r_id' ");}
					//if($report_type==3){$report_type=2;}					
					$nor_val=show_LreportNormalVal($report_type,$ss_id,$sex,$age,$sample,$val,$unit,$normal_code,1);
					$new_val=$nor_val[3];						
					list($unit_code,$unit_txt,$dec_point)=get_val('lab_m_services_units','code,name_'.$lg.',dec_point',$unit);
					$anlRes=drowReportPrint2($report_type,$dec_point,$nor_val);	
					if($hisRes==0){
						$out='<tr>';
						if($s_type!=1){
							if($report_type==6){
								$out.='
								<td>'.$name.'</td>
								<td  colspan="4">'.$anlRes.'</td>';
								
							}else{
								$out.='
								<td>'.$name.'</td>
								<td>'.$anlRes.'</td>
								<td>'.$unit_code.'</td>
								<td class="" style="color:'.$nor_val[0].'">'.$nor_val[2].'</td>';
							}
							$cc=0;
							if($show_last){	list($vis,$pat,$service,$note)=get_val('lab_x_visits_services','visit_id,patient,service,note',$ser_id);
								$sql2="select * from lab_x_visits_services where patient='$pat' and service='$service' and id <$ser_id and status IN(1,7,8,10) order by d_start DESC limit $hisResNo ";
								$res2=mysql_q($sql2);
								$rows2=mysql_n($res2);								
								while($r2=mysql_f($res2)){
									//echo '('.$r2['id'].')';
									$date_enter=$r2['date_enter'];
									$date_enter=$r2['d_start'];	$out.='<td>'.print_l_report($r2['id'],$txt,$sex,$age,$sample,$status,$type,$oneRow,1).'
									'.date('Y-m-d',$date_enter).'</td>';
									$cc++;
								}
							}
							for($i=$cc; $i<$hisResNo ; $i++){
								if($report_type!=6){
									$out.='<td>-</td>';
								}
							}
						}
						$out.='</tr>';
						if($note){
							$out.='<tr>
							<td colspan="5"><div class="lh30 frr B f1 clr55">'.$note.'</div></td></tr>';
						}
					}else{
						$out=drowReportPrint2($report_type,$dec_point,$nor_val);
					}
				}
			}			
		}else{
			if($txt!=''){
			$out='';
			if($status==10){}
			$a=explode('|',$txt);
			$out.='<table class="grad_s_lab" border="0" width="100%" cellspacing="0" cellpadding="0">';
			foreach($a as $b){
				$c=explode('^',$b);
				$rows_n=$c[0];
				$td_p='';
				
				if($rows_n==1){$td_p='colspan="2" ';}
				$out.='<tr>';
				$d=explode(',',$c[1]);
				$d_Counter=0;
				foreach($d as $e){					
					$out.='<td '.$td_p.'  style="border-bottom:1px #eee solid" valign="top" >';
					$f=explode('.',$e);
					foreach($f as $g){
						$h=explode(':',$g);
						$t=$h[0];
						$id=$h[1];
						if($t==1){
							$sql="select * from lab_m_services_items where id='$id'";
							$res=mysql_q($sql);
							$rows=mysql_n($res);
							if($rows>0){
								$r=mysql_f($res);
								$ss_id=$r['id'];
								$s_type=$r['type'];
								$report_type=$r['report_type'];
								$name=$r['name_'.$lg];
								$unit=$r['unit'];
								$hide=$r['hide'];
								$normal_code=$r['normal_code'];
								$show_last=$r['show_last'];
								if($hide==0){ 
									if($s_type==1){
										$out.='<div class="f1 anaTitleSub2 fs16 pd10 ">'.$name.'</div>';
									}else{
										list($r_id,$val,$vsr_id)=get_LR_res($ser_id,$id);									
										$rrv=0;
										if($status==10){$rrv=getTotalCO('lab_x_visits_services_results_x'," x_id='$r_id' ");}
										//echo '('.$normal_code.')';
										$nor_val=show_LreportNormalVal($report_type,$id,$sex,$age,$sample,$val,$unit,$normal_code,1);
										$new_val=$nor_val[3];
										list($unit_code,$unit_txt,$dec_point)=get_val('lab_m_services_units','code,name_'.$lg.',dec_point',$unit);
										/*********************************************/
										$lastAnaDate='';
										$lastAnaVal='';
										$lastAnaclr='';
										if($show_last){
											list($vis,$pat,$service,$note)=get_val('lab_x_visits_services','visit_id,patient,service,note',$ser_id);											
											$sql2="select * from lab_x_visits_services where patient='$pat' and service='$service' and id <$ser_id order by date_enter DESC limit 1 ";
											$res2=mysql_q($sql2);
											$rows2=mysql_n($res2);
											if($rows2){
												$r2=mysql_f($res2);	list($r_id_lst,$val_lst,$vv)=get_LR_res($r2['id'],$id);	$nor_val_last=show_LreportNormalVal($report_type,$id,$sex,$age,$sample,$val_lst,$unit,$normal_code,1);
												$lastAnaDate=$r2['date_enter'];
												$lastAnaVal=$nor_val_last[3];
												$lastAnaclr=$nor_val_last[0];
											}
										}
										/*************************************************/
										$out.=drowReportPrint(1,$report_type,$name,$unit_txt,$unit_code,$dec_point,$nor_val);
										$out.='</div>';									
									}
								}
							}
						}
						if($t==2 || $t==3){
							list($q,$sType)=get_val('lab_m_services_equations','equations,item',$id);
							$out.='<div  bb class="TC" >'.getChartLRR($ser_id,$t,$q,$sType).'</div>';					
						}
					}
					$out.='</td>';
					$d_Counter++;
				}
				
				$out.='</tr>';
			}
			if($note){
				$out.='<tr>
				<td colspan="5"><div class="lh30 frr B f1 clr55">'.$note.'</div></td></tr>';
			}
			$out.='</table>';
			}
		}
	}
	if($type==2 || $type==3 ){ 
		$rec=getRec('lab_x_visits_services_result_cs',$ser_id,'serv_id');
		if($rec['r']){			
			$ss_val=$rec['val'];
			$ss_sample_type=$rec['sample_type'];
			$ss_colonies=$rec['colonies'];
			$ss_level=$rec['level'];
			$ss_bacteria=$rec['bacteria'];
			$ss_wbc=$rec['wbc'];
			$ss_rbc=$rec['rbc'];					
			$ss_note=$rec['note'];
			$ss_status=$rec['status'];					
		}
		$service_id=get_val('lab_x_visits_services','service',$ser_id);
		if($ss_val==1){
			$out='<div class="f1 fs12 clr6 bord">
				<div class="fl clr1 cb  f1 fs12 pd5 ">'.get_val('lab_m_services','name_'.$lg,$service_id).': </div>
				'.$lab_res_CS_types[$ss_val].'
			</div>';
		}
		if($ss_val==2){
			$out='<div class="f1 fs12 clr5 bord">
				<div class="fl clr1 cb f1 fs12 pd5 ">'.get_val('lab_m_services','name_'.$lg,$service_id).': </div>
				'.$lab_res_CS_types[$ss_val].'
			</div>';
		}
		
		if($ss_val==3){			
			$out.='<div class="lh30 fl_d cb">
			<div class="cb">
				<div class="fl clr1 cb TC f1 fs16 pd5 B">'.get_val('lab_m_services','name_'.$lg,$service_id).'</div> 
				<div class="fr">
					<table><tr>
						<td align="center" height="" class="fs10">( S ) : Susceptible</td>
						<td align="center"  class="fs10 pd10">( I ) : Intermediate</td>
						<td align="center"  class="fs10">( R ) : Resistant</td>
					</tr></table>
				</div>
			</div>
			<div class="cb clr1 fll fs12 pd5">'.$lab_res_CS_level[$ss_level].'</div> 
			
			<div class="clr5 fll fs12 pd5"> '.get_val('lab_m_test_bacterias','name',$ss_bacteria).'</div>
			</div>';
			$out.='<div class="lh30 fll cb">';
			if($ss_colonies){$out.='<div class="fl f1 fs14 pd5">'.k_num_colons.' : <ff  class="clr1">'.number_format($ss_colonies).'</ff> | </div>';}	
			if($ss_wbc){$out.='<div class="fl f1 fs12 pd5">W.B.C : <ff class="clr1">'.$ss_wbc.'</ff> |</div>';}
			if($ss_rbc){$out.='<div class="fl f1 fs12 pd5">R.B.C : <ff class="clr1">'.$ss_rbc.'</ff> |</div>';}
			$out.='</div>';	
			if($ss_note){$out.='<div class="cb f1 fs16 pd5 lh30">'.k_notes.' : <span class="clr1 fs14 f1">'.$ss_note.'</span> </div>';}
			
			$sql="select * from lab_x_visits_services_result_cs_sub where p_id='$ser_id' order by id ASC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				$out.='<table width="100%"  cellspacing="0" cellpadding="0" class="grad_m " type="static" dir="ltr">
				<tr bgcolor="#eee" style="height:24px"><th rowspan="2">ANTIMICROBIAL<br>AGENTS</th><th colspan="3"  style="height:24px">Zone Diameter ( MM )</th><th rowspan="2">COMMERCIAL<br>NAME</th></tr>
				<tr bgcolor="#eee" style="height:24px">
					<th width="100" style="height:24px">Results ( MM )</th>
					<th width="100" style="height:24px">R ( Below )</th>
					<th width="100" style="height:24px">S ( Over )</th>
				</tr>';
				while($r=mysql_f($res)){
					$antibiotics=$r['antibiotics'];
					$val=$r['val'];
					$n_id=$r['id'];
					$code=$r['code'];				
					$min_val=$r['min_val'];
					$max_val=$r['max_val'];
					list($n_name,$trad_name)=get_val('lab_m_test_antibiotics','name,trad_name',$antibiotics);
					
					$out.= '<tr><td class="ff fs12 B">'.$n_name.'</td>
					<td class="ff fs10 B"><span class="ff fs12 B clr1">'.$code.'</span> ( '.$val.' ) </td>
					<td class="ff fs10 B">'.$min_val.'</td>
					<td class="ff fs10 B">'.$max_val.'</td>
					<td class="ff fs10 B">'.$trad_name.'</td>
					</tr>';
				}							
				$out.= '</table>
				';
			}	
		}
	};	
	if($type==5){		
		$editVal=get_val_c('lab_x_visits_services_results','value',$ser_id,'serv_id');			
		$sql="select * from lab_m_test_mutations where act=1 order by name ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$antiEditVal=getAntiEditVal2($editVal);
			$out.='<div class="fl_d ff fs16 TC B lh30 pd10">Assay for the Identication of MEFV geng mutatione <br> Based on real time polymerase chain reaction ( real time PCR ) </div>';
			$out.='<div class="fl_d ff fs12 pd10 lh30">Mutations detected with this test, potentially leading to a FMF phenotype , are  as follws :  </div><div class="fl_d pd10">';
			$out.='<table  cellspacing="0" cellpadding="2" width="100%" class="grad_m" dir="ltr" type="static" >';
			$c=0;
			while($r=mysql_f($res)){
				$n_id=$r['id'];
				$n_name=$r['name'];				
				$t1='<ff class="ff fs12 B clr5">'.$lab_res_fmf_types[0].'</ff>';
				$t2='';
				if($editVal){
					if($antiEditVal[$n_id]){
						$c++;
						$v1=$antiEditVal[$n_id]['v1'];
						$v2=$antiEditVal[$n_id]['v2'];
						if($v1==1){
							$t1='<span class="ff fs12 B clr6">'.$lab_res_fmf_types[1].'</span>';
							if($v2==1){$t2=' - '.$lab_res_fmf_Stypes[1];}if($v2==2){$t2=' - '.$lab_res_fmf_Stypes[2];}
						}	
						$out.= '<tr>
						<td width="30" class="ff fs12 B">'.$c.'</td>
						<td class="ff fs12 B">'.$n_name.'</td>
						<td>'.$t1.' <span class="ff fs12 B"> '.$t2.'</span></td>
						</tr>';
					}
				}
			}							
			$out.='</table></div>';
		}
	};
	return $out;
}
function drowReportPrint($type,$report_type,$name,$unit_txt,$unit_code,$dec_point,$nor_val){
	global $lastAnaDate,$lastAnaVal,$lastAnaclr;
	$new_val=$nor_val[3];
	$norCode=$nor_val[7];
	$NCode='';
	if($norCode==1){$NCode='&nbsp;&nbsp;'.$nor_val[5];}
	$out='<div class="reporPrnRow cb">';
	if($name){$out.='<div class="rprName fl ">'.splitNo($name).'</div>';}
	switch ($report_type){
		case 1:
			if($dec_point>9){$fin_val=limitDec($new_val,$dec_point);}else{$fin_val=numFor($new_val,$dec_point);}			
			$out.='<div class="fl rprVal TC" style="color:'.$nor_val[0].'">'.$fin_val.$NCode.'</div>';
			//$out.='<div class="fl rprVal TC" style="color:'.$nor_val[0].'">'.$fin_val.'</div>';
			$out.='<div class="fl RPC_ rprUnit" title="'.$unit_txt.'" >';
			if($unit_code){$out.=$unit_code;}
			$out.='&nbsp;</div>';		
		break;
		case 2:
			if($dec_point>9){$fin_val=limitDec($new_val,$dec_point);}else{$fin_val=numFor($new_val,$dec_point);}
			$out.='<div class="fl rprVal" style="color:'.$nor_val[0].'">'.$fin_val.'</div>';
			$out.='<div class="fl ff B clr1111 rprUnit" title="'.$unit_txt.'" > ';
				if($unit_code){$out.=$unit_code;}
			$out.='</div>';
		break;
		case 3:
			$out.='<div class="fl rprVal2" style="color:'.$nor_val[0].'">'.$new_val.'</div>';
			if($nor_val[4]){$out.='<div class="fl rprVal3 fs12 pd5 " style="color:'.$nor_val[0].'">'.$nor_val[4].'</div>';}
		break;
		case 4: 
			$out.='<div class="fl rprVal2" style="color:'.$nor_val[0].'">'.$new_val.'</div>';
			if($nor_val[4]){$out.='<div class="fl rprVal3 pd5 " style="color:'.$nor_val[0].'">'.$nor_val[4].'</div>';}
		break;
		case 5: 			
			$out.='<div class="fl rprVal3 cbg4 pd5 " style="color:'.$nor_val[0].'">'.$new_val.'</div>';
		break;
		case 6:$out.='<div class="rprVal5 fl f1" style="color:'.$nor_val[0].'" >'.$new_val.'</div>';break;
		//case 7:$out.='<div class="rprVal fl f1 pd5 fs14" style="color:'.$nor_val[0].'" >7-&nbsp;'.$new_val.'</div>';break;
		case 7:
			$out.='<div class="fl rprVal2  TC" style="color:'.$nor_val[0].'">'.$new_val.'</div>';
			if($nor_val[4]){$out.='<div class="fl rprVal3 pd5 " style="color:'.$nor_val[0].'">'.$nor_val[4].'</div>';}
		break;
	}
	$norValA='&nbsp;';
	if($nor_val[2]){$norValA=$nor_val[2];}
	if($type==1 && $report_type!=3){$out.='<div class="fl rprNor" >'.$norValA.'</div>';}
	
	
	if($lastAnaVal!=''){
		if($dec_point>9){$fin_val=limitDec($lastAnaVal,$dec_point);}else{$fin_val=numFor($lastAnaVal,$dec_point);}
		$out.='<div class="fl rprVall">
			<div class="fl rprVal100 TC" style="color:'.$lastAnaclr.'">'.$fin_val.'</div>
			<div class="cb fs12 TC" style="font-size:9.6px">'.date('Y-m-d',$lastAnaDate).'</div>
		</div>';
	}
	$out.='<div class="lh1 cb">&nbsp;</div></div>';
	return $out;
}
function drowReportPrint2($report_type,$dec_point,$nor_val){
	$out='';	
	$new_val=$nor_val[3];
	switch ($report_type){	
		case 1:
			$out.='<div class="fl rprVal1row cb" style="color:'.$nor_val[0].'">
			<div class="fl">'.limitDec($new_val,$dec_point).'</div><div class="fr">'.$nor_val[5].'</div>&nbsp;</div>';
		break;
		case 2:
			$out.='<div class="fl rprVal1row cb" style="color:'.$nor_val[0].'">
			<div class="fl">'.$new_val.'</div><div class="fr">'.$nor_val[5].'</div>&nbsp;</div>';		
		break;
		case 3: 
			$out.='<div class="fl  rprVal1row  TC" style="color:'.$nor_val[0].'">'.$new_val.'</div>';			
		break;
		case 4: 
			$out.='<div class="fl rprVal1row cb" style="color:'.$nor_val[0].'">
			<div class="fl">'.$new_val.'</div><div class="fr">'.$nor_val[5].'</div>&nbsp;</div>';		
		break;
		case 5: 			
			$out.='<div class="fl pd5 " style="color:'.$nor_val[0].'">'.$new_val.'</div>';
		break;
		case 6:$out.='<div class="f1 fs10" style="color:'.$nor_val[0].'" >'.$new_val.'</div>';break;
		case 7:
			$out.='<div class="fl rprVal1row cb" style="color:'.$nor_val[0].'">
			<div class="fl">'.$new_val.'</div><div class="fr">'.$nor_val[5].'</div>&nbsp;</div>';
		break;
	}
	
	//if($report_type!=3){$out.=$nor_val[2];}	
	
	return $out;
}
function get_LreportS($type,$val=''){
	$out='';
	switch ($type){
		case 1:$out.=$val;break;
		case 2:$out.=$val;break;
		case 3:if($val=='p'){$out.=' '.k_positive.' ';}if($val=='n'){$out.=' '.k_negative.' ';}break;
		case 4:$out.=$val;break;
		case 5:
		$txt=get_val('lab_m_services_items_normal','add_pars',$val);
		$st=get_val('lab_m_services_items_normal','value',$val);
		$out.=  '<div '.$st.'>'.$txt.'</div>';
		break;
		case 6:$out.=$val;break;
		case 7:$out.=$val;break;
	}
	$out.='';
	return $out;
}
function get_LR_res($ser_id,$id){
	$out=array('xXx','');
	$sql="SELECT id,value from lab_x_visits_services_results where serv_id='$ser_id' and serv_val_id='$id'";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		//$id=$r['id'];
		$val=$r['value'];
		if($val==''){$val='xXx';}
		$out[0]=$id;
		$out[1]=$val;
		$out[2]=$r['id'];
	}
	return $out;
	
}
function getLROptions($type,$id,$vis_id,$sex,$p_age,$val){
	global $anT5_types,$anT5_types_col,$anT5_types_id;
	$out='<select name="lrp_'.$id.'_'.$vis_id.'" lrNo="'.$id.'"><option value="0">'.k_select_result.'</option>';
	$sql="select * from lab_m_services_items_normal where ana_no='$id' and sex IN($sex,0) order by sex DESC , age DESC ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$id=$r['id'];
			$age=$r['age'];
			$sex=$r['sex'];
			$add_pars=$r['add_pars'];
			$value=$r['value'];
			$sel='';
			$selNor=0;
			if($val){
				if($val==$id){$sel=' selected ';}
			}else{
				if($value=='n' && $selNor==0){$sel=' selected ';$selNor=1;}
			}
			$addS='';
			$t5arrNo=array_search($value,$anT5_types_id);
			if($t5arrNo!='0'){							
				$addS=' ['.$anT5_types[$t5arrNo].']';
			}
			$ch=checkAgeValue($p_age,$age);
			if($ch){$out.='<option value="'.$id.'" '.$sel.' style="color:'.$anT5_types_col[$t5arrNo].'" c="'.$t5arrNo.'">'.$add_pars.$addS.'</option>';}
		}
		
	}
	$out.='</select>';
	return $out;
	
}
// function get_LreportNormalById($id){
// 	global $age_types,$sex_types,$anT2_types,$anT3_types,$lg;
// 	$sql="select * from lab_m_services_items_normal where ana_no='$id' ";
// 	$res=mysql_q($sql);
// 	$rows=mysql_n($res);
// 	$data='';
// 	if($rows>0){		
// 		$r=mysql_f($res);
// 		$s_id=$r['id'];
// 		$age=$r['age'];
// 		$sex=$r['sex'];
// 		$type=$r['type'];
// 		$sample=$r['sample'];
// 		$add_pars=$r['add_pars'];
// 		$value=$r['value']; 
// 		$SA='';
// 		if($sample){$SA.=get_val('lab_m_samples','name_'.$lg,$sample);}
// 		if($sex){
// 			if($SA){$SA.=' - ';}
// 			$SA.=$sex_types[$sex];
// 		}
// 		if($age!=''){
// 			if($SA){$SA.=' - ';}
// 			$ag=explode(',',$age);
// 			$SA.=k_from.' '.$ag[1].' '.k_to.' '.$ag[2].' '.$age_types[$ag[0]];
// 		}
					
// 		switch ($type){
// 			case 1:
// 			$data.=$SA;
// 			if($value){					
// 				$v=explode(',',$value);				
// 				if($v[0]){$data.=$v[0];}
// 				$data.=' [ '.$v[1].' - '.$v[2].' ] ';
// 				if($v[3]){$data.=$v[3];}				
// 			}
// 			break;
//             case 2:
//             $data.=$SA;
//             if($value){					
//                 $v=explode(',',$value);					
//                 $data.=$anT2_types[$v[0]].' [ '.$v[1].' ] ';				
//             }
//             break;
//             case 3:
//             if($value!=''){
//                 $dp=explode(',',$d_add_pars);
//                 $dNorVl=$anT3_types[$value];
//                 if(count($dp)==2){
//                     $dNorVl=$dp[$value];						
//                 }
//                 $data.=k_natural_value.' : [ '.$dNorVl.' ] ';					
//             }
//             break;
//             case 4:
//             $data.=$SA;
//             if($value){					
//                 $v=explode(',',$value);
//                 $data.=$anT3_types[$v[0]].' : '.$anT2_types[$v[1]].' [ '.$v[2].' ] ';
//             }
//             break;
//             case 5:
//             break;
//             case 7:				
//             if($value){					
//                 $v=explode(',',$value);
//                 $data.=' [ '.$v[0].' - '.$v[1].' ] ';

//             }
//             break;				
//         }			
// 	}
// 	if($nots){$data.=' - '.nl2br(splitNo($nots));}
// 	return addslashes($data);
	
// }
function get_LreportNormalVal($type,$id,$vis_id,$p_sex,$p_age,$sample,$outType=0){
	global $age_types,$sex_types,$anT2_types,$anT3_types,$lg;
	$out='';
	$pars='';
	$sql="select * from lab_m_services_items_normal where ana_no='$id' and sex IN($p_sex,0) and  sample IN($sample,0) order by 
	type ASC , sample DESC , sex DESC , age DESC ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){		
		$ch=0;
		$nots='';
		$d_id=0;
		$d_sample=0;
		$d_age='';
		$d_sex=0;
		$d_value='';
		$d_add_pars='';
		while($r=mysql_f($res)){
			$s_id=$r['id'];
			$age=$r['age'];
			$sex=$r['sex'];
			$q_type=$r['type'];
			$sample=$r['sample'];
			$add_pars=$r['add_pars'];
			$value=$r['value']; 
			if($ch==0){
				$ch=checkAgeValue($p_age,$age);			
				if($q_type==1){$d_id=$s_id;$d_sample=$sample;$d_age=$age;$d_sex=$sex;$d_value=$value;$d_add_pars=$add_pars;}
			}
			if($q_type==2){$nots.='<div>'.$value.'</div>';}
		}
		if($ch){
			$value=$d_value;
			if($outType){return array($d_id,$d_value,$d_add_pars);}
			$SA='<div class="">';
			if($d_sample){$SA.='<span class="f1 clr1111">'.get_val('lab_m_samples','name_'.$lg,$d_sample).'</span> ';}
			if($d_sex){$SA.='<span class="f1">'.$sex_types[$d_sex].'</span> ';}
			if($d_age!=''){
				$ag=explode(',',$d_age);
				$SA.='<span  class="f1">'.k_from.'</span> <span class="f1 B fs12">'.$ag[1].'</span> 
				<span class="f1">'.k_to.'</span> <span class="f1 B fs12">'.$ag[2].'</span> 
				<span class="f1">'.$age_types[$ag[0]].'</span>';
			}
			$SA.='</div>';

			$data='';
			switch ($type){
				case 1:
				//$data.=$SA;
				if($value){					
					$v=explode(',',$value);
					$pars=' min="'.$v[1].'" max="'.$v[2].'" ';
					//$data.='<div class="fr mg10">';
					if($v[0]){$data.='<span class="ff B fs14 clr5">'.$v[0].'</span>';}
					$data.='<span class="ff B fs12 clr6"> [ '.$v[1].' - '.$v[2].' ] </span>';
					if($v[3]){$data.='<span class="ff B fs14 clr5">'.$v[3].'</span>';}
					//$data.='</div>';
				}
				break;
				case 2:
				//$data.=$SA;
				if($value){					
					$v=explode(',',$value);
					$pars=' opr="'.$v[0].'" opr_v="'.$v[1].'" ';
					//$data.='<div class="fr mg10">';
					$data.='<span class="f1 fs12 clr6">'.$anT2_types[$v[0]].'</span>';
					$data.='<span class="ff B fs14 clr6"> [ '.$v[1].' ] </span>';					
					//$data.='</div>';
				}
				break;
				case 3:
				if($value!=''){
					$dp=explode(',',$d_add_pars);
					$dNorVl=$anT3_types[$value];
					if(count($dp)==2){
							$dNorVl=$dp[$value];						
					}
					$pars=' def="'.$value.'" ';
					//$data.='<div class="fl mg10">';
					$data.='<span class="f1 fs12 ">'.k_natural_value.' : </span>
					<span class="f1 fs12 clr6">[ '.$dNorVl.' ]</span>';					
					//$data.='</div>';
				}
				break;
				case 4:
				//$data.=$SA;
				if($value!=''){					
					$v=explode(',',$value);
					$pars=' opr="'.$v[1].'" opr_v="'.$v[2].'" ';
					//$data.='<div class="fr mg10">';
					$data.='<span class="f1 fs12 clr1">'.$anT3_types[$v[0]].' : </span>';
					$data.='<span class="f1 fs12 clr6">'.$anT2_types[$v[1]].'</span>';
					$data.='<span class="ff B fs14 clr6"> [ '.$v[2].' ] </span>';					
					//$data.='</div>';
				}
				break;
				case 5:
				break;
				case 7:				
				if($value){					
					$v=explode(',',$value);
					$pars=' min="'.$v[0].'" max="'.$v[1].'" ';					
					$data.='<span class="ff B fs14 clr6"> [ '.$v[0].' - '.$v[1].' ] </span>';
				}
				break;				
			}			
		}
		//if($nots){$data.='<div class="repLNote cb mg10">'.nl2br(splitNo($nots)).'</div>';}
		
		if($data){
			$data='<div part="norval" class="lh30" no="'.$id.'_'.$vis_id.'" rt="'.$type.'" '.$pars.'>'.$data.'</div>';
			$out.='<div part="norval" class="lh30" no="'.$id.'_'.$vis_id.'" rt="'.$type.'" '.$pars.'>'.$data.'<div class="cb lh1">&nbsp;</div></div>';
		}else{
			$out.='<div part="norval" class="lh30" no="'.$id.'_'.$vis_id.'" rt="0">&nbsp;</div>';
		}
	}else{
		$out.='<div part="norval" class="lh30" no="'.$id.'_'.$vis_id.'" rt="0" '.$pars.'>&nbsp;</div>';
	}
	//if($outType){return 0;}
	return array($out,$d_add_pars,$data,$SA,$nots);
}
function show_LreportNormalVal($type,$id,$p_sex,$p_age,$sample,$val,$unit,$normal_code,$short=0){
	$out=array('#000','','',$val,'','','',$normal_code);
	global $age_types,$sex_types,$anT2_types,$anT3_types,$anT2_typesCode,$lg,$anT3_typesC,$clr6,$clr5,$clr1,$RPC_N,$RPC_X,$RPC_,$anT5_types;
	$sql="select * from lab_m_services_items_normal where ana_no='$id' and sex IN($p_sex,0) and  sample IN($sample,0) order by 
	type ASC , sample DESC , sex DESC , age DESC ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$ch=0;
		$nots='';
		$d_sample=0;
		$d_age='';
		$d_sex=0;
		$d_add_pars='';
		$d_value='';		
		while($r=mysql_f($res)){
			$s_id=$r['id'];
			$age=$r['age'];
			$sex=$r['sex'];
			$q_type=$r['type'];
			$sample=$r['sample'];
			$add_pars=$r['add_pars'];
			$value=$r['value'];
			if($ch==0){				
				$ch=checkAgeValue($p_age,$age);			
				if($ch && $q_type==1){
					$d_sample=$sample;
					$d_age=$age;
					$d_sex=$sex;
					$d_value=$value;
					$d_add_pars=$add_pars;					
				}
			}
			if($q_type==2){$nots.='<div>'.$value.'</div>';}
		}
		$out[6]=$d_add_pars;
		$SSA='';
		if($ch){
			$value=$d_value;
			if($short==0){
				//$SSA.='<div class="">';	
				if($d_sample){$SSA.='<span class="f1 clr1111">'.get_val('lab_m_samples','name_'.$lg,$d_sample).'</span> ';}
				if($d_sex){$SSA.='<span class="f1 clr1 fs14">'.$sex_types[$d_sex].'</span> ';}
				if($d_age!=''){
					$ag=explode(',',$d_age);
					$SSA.='<span  class="f1">'.k_from.'</span> <span class="ff B fs14 clr1">'.$ag[1].'</span> 
					<span class="f1">'.k_to.'</span> <span class="ff B fs14">'.$ag[2].'</span> 
					<span class="f1">'.$age_types[$ag[0]].'</span>';
				}
				//$SSA.='</div>';
			}
			$data='';
			switch ($type){ 
				case 1:				
				if($value!=''){
					$v=explode(',',$value);
					if($val){
						if($val <=$v[2] && $val >=$v[1]){
							$out[0]=$RPC_N;
							$out[5]='';
						}else{
							$out[0]=$RPC_X;
							if($val <$v[2]){$out[5]='L';}
							if($val >$v[1]){$out[5]='H';}
						}
					}					
					if($d_add_pars){
						$dp=explode(',',$d_add_pars);
						if($dp[1]==1){$out[3]=($val-$dp[0]).'~'.($val+$dp[0]);}
						if($dp[1]==2){
							$vper=$val*$dp[0]/100;
							$dec_point=get_val('lab_m_services_units','dec_point',$unit);
							$out[3]=number_format($val-$vper,2).'~'.number_format($val+$vper,2);
						}
					}
					if($short==0){
						//$data.='<div>';
						if($v[0]){$data.='<span class="ff B fs12 RPC_X">'.$v[0].'</span>';}
						$data.='<span class="ff B fs12 RPC_N"> [ '.$v[1].' - '.$v[2].' ] </span>';
						if($v[3]){$data.='<span class="ff B fs12 RPC_X">'.$v[3].'</span>';}
						//$data.='</div>';
					}else{
						$data.='<span class="RPC_N">'.$v[1].' - '.$v[2].'</span>';
					}
				}
				break;
				case 2:
				if($value!=''){			
					if($short==0){
						if($d_add_pars){
							$dp=explode(',',$d_add_pars);
							if($val=='p'){$out[3]=$dp[1];}
							if($val=='n'){$out[3]=$dp[0];}
						}
						if($val){
							if($val=='p'){$out[3].=' ( '.$anT3_types[1].' )';}
							if($val=='n'){$out[3].=' ( '.$anT3_types[0].' )';}
						}
						if(($value==0 && $val=='n') || ($value==1 && $val=='p')){$out[0]=$RPC_N;}else{$out[0]=$RPC_X;}					
						$data.='<div><span class="f1 fs12 ">'.k_natural_value.' : </span>
						<span class="f1 fs12 RPC_N">[ '.$anT3_types[$value].' ]</span></div>';
					}else{				
						$v=explode(',',$value);
						if($v[0]==0){if($val>$v[1]){$out[0]=$RPC_N;}else{$out[0]=$RPC_X;}}
						if($v[0]==1){if($val<$v[1]){$out[0]=$RPC_N;}else{$out[0]=$RPC_X;$out[5]='H';}}
						if($v[0]==2){if($val>=$v[1]){$out[0]=$RPC_N;}else{$out[0]=$RPC_X;}}
						if($v[0]==3){if($val<=$v[1]){$out[0]=$RPC_N;}else{$out[0]=$RPC_X;$out[5]='H';}}
						if($v[0]==4){if($val==$v[1]){$out[0]=$RPC_N;}else{$out[0]=$RPC_X;}}
						if($v[0]==5){if($val!=$v[1]){$out[0]=$RPC_N;}else{$out[0]=$RPC_X;}}
						
						$pars=' opr="'.$v[0].'" opr_v="'.$v[1].'" ';
						$data.='<div>';
						$data.='<span class="f1  RPC_N">'.$anT2_typesCode[$v[0]].'</span>';
						$data.='<span class="ff B  RPC_N"> '.numFor($v[1],5).' </span>';	
						$data.='</div>';
						
					}
				}else{
					if($val){
						if($val=='p'){$out[3]='Positive';}
						if($val=='n'){$out[3]='Negative';}
					}
				}
				break;
				case 3:
				if($value!=''){
					$dp=explode(',',$d_add_pars);
					if($short==0){	
						if($val){
							if($val=='p'){$out[3]=' ( '.$anT3_types[1].' )';}
							if($val=='n'){$out[3]=' ( '.$anT3_types[0].' )';}
							if(count($dp)==2){							
								if($val=='p'){$out[3]=' ( '.$dp[1].' )';}
								if($val=='n'){$out[3]=' ( '.$dp[0].' )';}
							}
						}
						if(($value==0 && $val=='n') || ($value==1 && $val=='p')){$out[0]=$RPC_N;}else{$out[0]=$RPC_X;}
						
						$dNorVl=$anT3_types[$value];
						if(count($dp)==2){
							$dNorVl=$dp[$value];						
						}
						$data.='<div><span class="f1 fs12 ">'.k_natural_value.' : </span>
						<span class="f1 fs12 RPC_N">[ '.$dNorVl.' ]</span></div>';
					}else{ 
						if($val){
							if($val=='p'){$out[3]='Positive';}
							if($val=='n'){$out[3]='Negative';}
						}
						if($val){
							if($val=='p'){$out[3]=$anT3_types[1];}
							if($val=='n'){$out[3]=$anT3_types[0];}
							if(count($dp)==2){							
								if($val=='p'){$out[3]=$dp[1];}
								if($val=='n'){$out[3]=$dp[0];}
							}
						}
						
						if(($value==0 && $val=='n') || ($value==1 && $val=='p')){$out[0]=$RPC_N;}else{$out[0]=$RPC_X;}
						if($d_add_pars){						
							$dp=explode(',',$d_add_pars);
							if($val=='p'){$out[4]=$dp[1];}
							if($val=='n'){$out[4]=$dp[0];}							
						}
						$dNorVl=$anT3_types[$value];
						if(count($dp)==2){
							$dNorVl=$dp[$value];						
						}
						$data.='<span class="RPC_N">'.$dNorVl.'</span>';
					}
				}else{
					if($val){
						if($val=='p'){$out[3]='Positive';}
						if($val=='n'){$out[3]='Negative';}
					}
				}
				break;
				case 4:
				if($value!=''){					
					$v=explode(',',$value);
					$nVal=$v[0];
					$itisNor=0;
					$N='N';
					$N='';
					if($val){ //echo '('.$v[2].')';
						if($v[1]==0){if($val >  $v[2]){$out[0]=$RPC_N;$itisNor=1;$out[5]=$N;}else{$out[0]=$RPC_X;$out[5]='L';}}
						if($v[1]==1){if($val <  $v[2]){$out[0]=$RPC_N;$itisNor=1;$out[5]=$N;}else{$out[0]=$RPC_X;$out[5]='H';}}
						if($v[1]==2){if($val >= $v[2]){$out[0]=$RPC_N;$itisNor=1;$out[5]=$N;}else{$out[0]=$RPC_X;$out[5]='L';}}
						if($v[1]==3){if($val <= $v[2]){$out[0]=$RPC_N;$itisNor=1;$out[5]=$N;}else{$out[0]=$RPC_X;$out[5]='H';}}
						if($v[1]==4){if($val == $v[2]){$out[0]=$RPC_N;$itisNor=1;$out[5]=$N;}else{$out[0]=$RPC_X;if($val <$v[1]){$out[5]='L';}if($val >$v[1]){$out[5]='H';}}}
						if($v[1]==5){if($val != $v[2]){$out[0]=$RPC_N;$itisNor=1;$out[5]=$N;}else{$out[0]=$RPC_X;}}
					}
					if($short==0){
						$out[3]='<span class="ff B">'.$val.'</span> ';
						if($d_add_pars){
							$dp=explode(',',$d_add_pars);
							if(($itisNor && $nVal==1) || ($itisNor==0 && $nVal==0)){$out[3].=$dp[1];}
							if(($itisNor && $nVal==0) || ($itisNor==0 && $nVal==1)){$out[3].=$dp[0];}
						}
						if($itisNor){
							$out[3].=' ( '.$anT3_types[$nVal].' ) ';
						}else{
							if($nVal==0){$out[3].=' ( '.$anT3_types[1].' ) ';}else{$out[3].=' ( '.$anT3_types[0].' ) ';}
						}
					
						$data.='<div >'; 
						$data.='<span class="f1 fs12 RPC_">'.$anT3_types[$v[0]].' : </span>';
						$data.='<span class="f1 fs12 RPC_N">'.$anT2_types[$v[1]].'</span>';
						$data.='<span class="ff B fs14 RPC_N"> [ '.$v[2].' ] </span>';					
						$data.='</div>';
					}else{						
						if($d_add_pars){
							$dp=explode(',',$d_add_pars);
							if(($itisNor && $nVal==1) || ($itisNor==0 && $nVal==0)){$out[4].=$dp[1];}
							if(($itisNor && $nVal==0) || ($itisNor==0 && $nVal==1)){$out[4].=$dp[0];}
						}
						$out[3]=$val;
						
						if($add_pars){
							$add_parsIn=explode(',',$add_pars);
							if($itisNor){
								if($nVal==0){$out[3].=' '.$add_parsIn[0];}
								if($nVal==1){$out[3].=' '.$add_parsIn[1];}
							}else{							
								if($nVal==1){$out[3].=' '.$add_parsIn[0];}
								if($nVal==0){$out[3].=' '.$add_parsIn[1];}							
							}
						}else{
							if($itisNor){
								if($nVal==0){$out[3].=' Negative';}
								if($nVal==1){$out[3].=' Positive';}
							}else{							
								if($nVal==1){$out[3].=' Negative';}
								if($nVal==0){$out[3].=' Positive';}							
							}
						}
						
						$data.='<span class="RPC_N">'.$anT3_typesC[$v[0]].' </span>';
						$data.='<span class="RPC_N">'.$anT2_typesCode[$v[1]].'</span>';
						$data.='<span class="RPC_N">'.$v[2].'</span>';				
						
					}
				}
				break;
				case 5:
					$out[3]=get_val('lab_m_services_items_normal','add_pars',$val);
					$st=get_val('lab_m_services_items_normal','value',$val);
					if($st=='x'){$out[0]=$RPC_X;}
					if($st=='n'){$out[0]=$RPC_N;}
				break;
				case 7:
				if($value!=''){
					$v=explode(',',$value);
					$dp=explode(',',$d_add_pars);
					if($short==0){						
						$out[3]='<span class="ff B">('.$val.')</span> ';
						if($val){
							if($val < $v[0]){$out[3].=$dp[0].' ( '.$anT3_types[0].' ) ';$out[0]=$RPC_N;}
							if($val > $v[0] && $val < $v[1]){$out[3].=$dp[1].' ( '.$anT5_types[0].' ) ';$out[0]=$RPC_;}
							if($val > $v[1]){$out[3].=$dp[2].' ( '.$anT3_types[1].' ) ';$out[0]=$RPC_X;}
						}
						$data.='<div>';
						$data.='<span class="f1 fs12 RPC_">'.$anT3_types[$v[0]].'  </span>';
						$data.='<span class="f1 fs12 RPC_N">'.$anT2_types[$v[1]].'</span>';
						$data.='<span class="ff B fs14 RPC_N"> [ '.$v[0].' - '.$v[1].' ] </span>';					
						$data.='</div>';
					}else{						
						if($val){
							if($val < $v[0]){$out[3]=$val.' Negative';if($dp[0]){$out[3]=$val.' '.$dp[0];}$out[0]=$RPC_N;
							//$out[5]='L';
							}
							if($val >= $v[0] && $val <= $v[1]){$out[3]=$val.' Equivocal';if($dp[1]){$out[3]=$val.' '.$dp[1];}$out[0]=$RPC_;}
							if($val > $v[1]){$out[3]=$val.' Positive';if($dp[2]){$out[3]=$val.' '.$dp[2];};$out[0]=$RPC_X;
							//$out[5]='H';
							}
						}
						$data.='<span class="RPC_N">'.$v[0].' - '.$v[1].'</span>';
					}
				}
				break;
			}	
		}
		$data.=$SSA;
		if($nots){$data.='<div class="repLNote cb mg10">'.nl2br($nots).'</div>';}
		if($data){
			$out[2].=$data;
		}
	}
	//if($outType){return 0;}
	return $out;
}
function getR_Qu($id,$out=''){	
	$sql="select * from lab_m_services_equations where ana_no='$id' order by ord ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$id=$r['id'];
			$type=$r['type'];
			$item=$r['item'];
			$equations=$r['equations'];
			if($out!=''){$out.='^';}
			$out.=$id.'|'.$type.'|'.$item.'|'.$equations;
		}
	}
	return $out;
}
function getSam_Teker($visit_id){
	$res=mysql_q("select s_taker from lab_x_visits_samlpes where visit_id='$visit_id' and s_taker!=0 limit 1");
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		return $r['s_taker'];
	}else{return 0;}
}
function getLabAmunt($vis){
	$payIN=get_sum('gnr_x_acc_payments','amount'," vis='$vis' and mood='2' and type IN(1,2,7,11) ");
	$payOUT=get_sum('gnr_x_acc_payments','amount'," vis='$vis' and mood='2' and type IN(3,4) ");
	return $payIN-$payOUT; 
}
function AddRackPlace($rack_id,$place,$sam_id,$l_rack,$l_pos,$status,$r_ord=''){
	global $now;
	$out=0;
	$q='';
	if($status==2){$q=" , status=3 ";}
	if($status==5){$q=" , status=5 ";}
	$placCh=get_val_con('lab_x_visits_samlpes','id'," rack='$rack_id' and rack_pos='$place' ");
	if($placCh=='' || $rack_id==0){
		if(mysql_q("UPDATE lab_x_visits_samlpes SET rack='$rack_id' , rack_pos='$place' , rack_ord='$r_ord' $q where id='$sam_id'")){
			if(mysql_q("INSERT INTO lab_x_sample_moves (`r_from`,`r_from_position`,`r_to`,`r_to_position`,`sample`,`date`)
			values('$l_rack','$l_pos','$rack_id','$place','$sam_id','$now')")){$out=1;}		
		}else{$out=0;}//X mysql
	}else{$out=2;}//X place NOt Empty
	return $out;
}
function get_rs_Icon($id,$pg,$no){
	global $lg;
	$out='';
	$sql="select * from lab_m_samples_packages where id='$pg'";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$s_id=$r['id'];
		$name=$r['name_'.$lg];
		$color=$r['color'];
		$title=$name.' '.$no;
		$out.='<img src="../images/lab_samp3.png" width="100%" style="background-color:'.$color.'"/>';
	}
	return $out;
}
function getSampleAddr($rack,$rack_pos){
	global $CHL;
	$sql="select * from lab_m_racks r , lab_m_racks_cats c where r.id='$rack' and r.cat=c.id";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows){
		$r=mysql_f($res);
		$code=$r['code'];
		$no=$r['no'];
		$type=$r['type'];
		list($xx,$yy)=explode('_',$rack_pos);
		$x_type=$r['x_type'];
		$y_type=$r['y_type'];
		$Yt=$yy;if($y_type==2){$Yt=$CHL[$yy];}
		$Xt=$xx;if($x_type==2){$Xt=$CHL[$xx];}
		return $code.'-'.$no.' ( '.$Yt.'*'.$Xt.' )';
	}
}
function getSAddrXY($rack){
	$out=array(1,1);
	$sql="select * from lab_m_racks r , lab_m_racks_cats c where r.id='$rack' and r.cat=c.id";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows){
		$r=mysql_f($res);
		$out[0]=$r['c.x_type'];
		$out[1]=$r['c.y_type'];				
	}
	return $out;
}
function getSAView($rack_pos,$x,$y,$c='.'){
	global $CHL;
	list($xx,$yy)=explode('_',$rack_pos);
	$Yt=$yy;if($y==2){$Yt=$CHL[$yy];}
	$Xt=$xx;if($x==2){$Xt=$CHL[$xx];}
	return $Yt.$c.$Xt;

}
function PrintAnal($ids){
	$out='';
	if($ids){
		$sql="select * , x.fast as x_fast from lab_x_visits_services x , lab_m_services z where x.service=z.id and  x.id IN($ids)";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			while($r=mysql_f($res)){
				$code=$r['code'];
				$name=$r['short_name'];
				$outlab=$r['outlab'];
				$units=$r['units'];
				$fast=$r['x_fast'];		
				$sty='';
				if($units>=14){$sty='p_Hprice pd5';}
				if($fast){$sty='p_emrg pd5';}
		
				$li='';
				if($outlab){$li='U';}
				if($code==''){$code=$name;}
				if($out){$out.=" :: ";}
				$out.='<ff class="B '.$li.' '.$sty.'">'.$code.'</ff>';
			}
		}
	}
	return $out;
}
function getChartLRR($s,$t,$q,$sType){
	global $lg;
	$out='';
	$d='';
	if($q){
		$sql="select x.value,z.name_$lg from lab_x_visits_services_results x, lab_m_services_items z where z.id=x.serv_val_id and x.serv_id='$s' and x.serv_val_id IN($q) ORDER BY FIELD(x.serv_val_id,$q) ";	
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			while($r=mysql_f($res)){
				$value=$r['value'];
				$name=$r['name_'.$lg];
				if($t==2){
					if($d!=''){$d.=',';}
					$d.="['".$name."',".$value."]";
				}else{
					$d.="cats_c.push('".$name."');";	
					$d.='data_all.push('.$value.');';			
				}
			}

		$rr=rand(999,9999);
		if($t==2){
			$out.='
			<script type="text/javascript">
			$(document).ready(function(e){
				data=new Array('.$d.');	
				$("#rep_container'.$rr.'").highcharts({
					chart:{plotBackgroundColor: null,plotBorderWidth: 1,plotShadow: false},
					title: {text: ""},tooltip: {pointFormat:"<div><ff>%{point.percentage:.1f}</ff></div>",},
					plotOptions: {
						pie: {allowPointSelect: true,cursor: "pointer",dataLabels: {enabled: true,
							format: "<div class=\"f1 fs12\">{point.name} :</div><div> <ff>%{point.percentage:.1f}</ff></div>",
							}
						},
						series:{animation:false},
					},series: [{type: "pie",data:data,}],
				});});
			</script>';
		}else{
			if($sType==0){
				$out.='<script type="text/javascript">
				$(document).ready(function(e){
					cats_c=new Array();
					data_all=new Array();
					 '.$d.'				
					$("#rep_container'.$rr.'").highcharts({
					chart: {type: "column"},
					title: {text: ""},
					navigator : {enabled : false},
					scrollbar : {enabled : false},	
					rangeSelector : {enabled : false},	
					xAxis: {categories: cats_c,labels:{rotation:-45}},
					plotOptions: {series: {animation: false}},
					yAxis: {min: 0,title:{text: ""}},
					tooltip: {
						headerFormat: "<span style=\"font-size:12px\">{point.key}</span><table>",
						pointFormat: "<tr><td class=\"f1\" style=\"color:{series.color};padding:0\">{series.name}: </td>" +
							"<td style=\"padding:0\"><b>{point.y}</b></td></tr>",
						footerFormat: "</table>",
						shared: true,
						useHTML: true
					},				
					series: [
					{name: "'.k_val.'",data: data_all, dataLabels:{enabled: true,format: "{y}",rotation:-45,align:"left",y:-5}}, 

					]
				});});
				</script>';
			}
			if($sType==1){
				$out.='<script type="text/javascript">
				$(document).ready(function(e){
					cats_c=new Array();
					data_all=new Array();
					'.$d.'
					$("#rep_container'.$rr.'").highcharts({
					
						chart: {type:"areaspline",scrollablePlotArea:{minWidth:600,scrollPositionX:1}},
						xAxis:{categories:cats_c},
						plotOptions: {series: {animation: false}},
						title:{text:""},
						series:[{name:"'.k_val.'",data: data_all, dataLabels:{enabled: true,format:"{y}",rotation:-45,align:"left",y:-5}}],
						responsive: {
							rules: [{condition:{maxWidth:500},chartOptions:{legend:{layout:"horizontal",align:"center",verticalAlign:"bottom"}}}]
						}
					});	
				});
				</script>';
			}
		}
		$out.='<div id="rep_container'.$rr.'" style="width:100%; height:200px; direction:ltr"></div>';
			return $out;
		}else{
			//return '<img src="../images/nti'.$t.'.png"/>';
		}
	}
}
function checkPrice($lab,$srv){
	$price=get_val_con('lab_m_external_Labs_price','price'," lab='$lab' and ana='$srv' ");
	if($price==''){$price=0;}
	return $price; 
}
function ouTLabSums($lab,$type){
	/*$q='';
	if($type==2){$q=" and status=5";}
	if($type==3){$q=" and status IN(6,7)";}
	if($type==4){$q=" and status=9";}
	if($type==5){$q=" and status IN(8,10,1)";}
	if($type==6){return get_sum('lab_x_acc_out_payments','amount'," lab='$lab' ");}
	$sql="select SUM(l.price)as c from lab_x_visits_services x , lab_x_visits_services_outlabs l where x.id=l.id and out_lab='$lab' $q";
	$res=mysql_q($sql);
	$r=mysql_f($res);
	return $r['c'];*/
}
function getAntiEditVal($id){
	$out=array();
	$sql="select * from lab_x_visits_services_result_cs_sub where p_id='$id'";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$antibiotics=$r['antibiotics'];
			$val=$r['val'];
			$code=$r['code'];
			$out[$antibiotics]['val']=$val;
			$out[$antibiotics]['code']=$code;
		}		
	}
	return $out;
}
function getAntiEditVal2($data){
	$out=array();
	$d1=explode('|',$data);
	foreach($d1 as $d2){
		$dd=explode(':',$d2);
		$no=$dd[0];
		$out[$no]['v1']=$dd[1];
		$out[$no]['v2']=$dd[2];
	}
	return $out;
}
function getSrvOrdCat($id){
	$newIdes='';
	$countSybIdes=array();
	if($id){
		$sql="select x.id as x_id , count(se.id) as serCount from 
		lab_x_visits_services x,
		lab_m_services s , 
		lab_m_services_cats c , 
		lab_m_services_items se 
		where 
		x.id IN($id) AND 
		s.id=x.service AND
		c.id=s.cat AND 
		s.id=se.serv 
		GROUP BY se.serv ORDER BY c.ord ASC , s.ord ASC , serCount ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			while($r=mysql_f($res)){
				$id=$r['x_id'];
				$count=$r['serCount'];				
				$newIdes.=','.$id;				
				$countSybIdes[$id]=$count;
			}	
		}
	}
	return array($newIdes,$countSybIdes);
}
function endLabVist($visit_id){
	$sn=getTotalCO('lab_x_visits_samlpes'," visit_id='$visit_id' and status=0");
	$sn2=getTotalCO('lab_x_visits_services'," visit_id='$visit_id' and status IN(0,1,2,4)");
	if($sn==0 && $sn2==0){mysql_q("UPDATE gnr_x_roles SET status=4 where vis='$visit_id' and mood=2 ");}
	$clinic=get_val_c('gnr_m_clinics','id',2,'type');
	fixDashData($clinic,2);
}
function getPatInfoL($id){
	$out=array(0,0);
	$sql="select sex , birth_date from gnr_m_patients where id='$id'";
	$res=mysql_q($sql);
	if(mysql_n($res)){
		$r=mysql_f($res);
		$sex=$r['sex'];
		$birth=$r['birth_date'];
		$out[0]=$sex;
		$out[1]=$birth;
	}
	return $out;
}
function checkAgeValue($p_age,$age){ //$p_age='1950-01-01';
	global $now;
	if($age==''){return 1;}
	$out=0;
	$pa2=date('U',strtotime($p_age));
	$a=explode(',',$age);
	if($a[0]==0){$pa3=(($now-$pa2)/(60*60*24*365));}
	if($a[0]==1){$pa3=(($now-$pa2)/(60*60*24*30));}
	if($a[0]==2){$pa3=(($now-$pa2)/(60*60*24));}
	if($pa3>=$a[1] && $pa3<$a[2]){$out=1;}		
	return $out;
}
function getPatInfo($id,$ar=0,$date=0){
	global $sex_types,$sex_types_ar;
	$out=array();
	$sql="select * from gnr_m_patients where id='$id'";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$f_name=$r['f_name'];
		$l_name=$r['l_name'];
		$ft_name=$r['ft_name'];
		$birth_date=$r['birth_date'];
		$sex=$r['sex'];
		$out['n']=$f_name.' '.$ft_name.' '.$l_name;
		$out['s']=$sex_types[$sex];
		if($ar){
			$out['s']=$sex_types_ar[$sex];
		}
		
		$b=birthCount($birth_date,$date);
		$out['b']='<ff>'.$b[0].'</ff> <span class="f1 fs14">'.$b[1].'</span> ';
	}
	return $out;
}

function getAnVal($type,$value){
	global $anT2_types,$anT3_types,$anT5_types,$anT5_types_id;
	$out='';
	switch ($type) {
		case 1:
			$v=explode(',',$value);
			if($v[0]){
				$out='<ff dir="ltr">[ '.$v[0].' [ '.$v[1].'-'.$v[2].' ] '.$v[3].' ]';
			}else{
				$out='<ff dir="ltr">[ '.$v[1].'-'.$v[2].' ]</ff>';
			}
		break;
		
		case 2:
			$v=explode(',',$value);
			$out='<span class="f1">'.$anT2_types[$v[0]].'</span> <ff>'.$v[1].'</ff>';
		break;
		case 3:
			if($value==0){$out=k_natural_val_negative;}
			if($value==1){$out=k_natural_val_postive;}
		break;
		case 4:
			$v=explode(',',$value);
			$out='<span class="f1">'.$anT3_types[$v[0]].' : '.$anT2_types[$v[1]].'</span> <ff>'.$v[2].'</ff>';
		break;
		case 5:$out='<span class="f1">'.$anT5_types[array_search($value,$anT5_types_id)].'</span>';break;
		case 7:
			$v=explode(',',$value);
			$out='<ff dir="ltr">[ '.$v[0].' - '.$v[1].' ]';			
		break;
		case 8:$out=nl2br($value);break;
	}
	return $out;
}
function getAnADDVal($type,$value){
	if($value){
		global $anT2_types,$anT3_types,$anT5_types;
		$out='';
		switch ($type) {
			case 1:
			$v=explode(',',$value);
			if($v[1]==1){$vv=$v[0];}
			if($v[1]==2){$vv=$v[0].'%';}
			$out='<ff dir="ltr">'.$vv.'</ff>';break;		
			case 3:$out='<span class="f1">'.$value.'</span>';break;
			case 4:$out='<span class="f1">'.$value.'</span>';break;
			case 5:$out='<span class="f1">'.$value.'</span>';break;
			case 7:$out='<span class="f1">'.$value.'</span>';break;
		}
		return $out;
	}
}
function getLastSample($patient,$vis){	
	global $now;
	$out='';
	$d=$now-(60*60*32);
	$sql="select * from lab_x_visits_samlpes where patient='$patient' and date > $d and visit_id!='$vis' and status NOT IN(4,5)";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			if($out){$out.=',';}
			$out.=$r['pkg_id'];
		}
	}
	return $out;
}
function checkSamePak($lastSample,$sample_pg){
	if($lastSample){
		$ls=explode(',',$lastSample);
		$sp=explode(',',$sample_pg);
		foreach($ls as $l){if(in_array($l,$sp)){return 1;}}
	}	
}
function addToRackAlert($ana,$sample){
	global $now;
	list($rack,$position)=get_val('lab_x_visits_samlpes','rack,rack_pos',$sample);
	mysql_q("INSERT INTO lab_x_racks_alert (`rack`,`position`,`sample`,`ana`,`date`)
	VALUES('$rack','$position','$sample','$ana','$now')");
}
function lab_getout_ana($id){
	$out='';	
	list($code,$shortName)=get_val('lab_m_services','code,short_name',$id);
	$out='<div><ff class="clr1" dir="ltr">'.$code.' </ff> - <ff>'.$shortName.'</ff></div>';
	return $out;
}
function lab_getout_sdate($id){
	$sample_id=get_val('lab_x_visits_services','sample_link',$id);
    $sql="select date,services from lab_x_visits_samlpes where id=$sample_id ";
	$res=mysql_q($sql);
	$r=mysql_f($res);
	$date=$r['date'];
	return '<ff>'.dateToTimeS3($date,1).'</ff>';
}
function getTestsR($reciept_i_id){
	$out='<div class="bu2 bu_t1 fs14 clr1 f1" onclick="addTestsRec('.$reciept_i_id.')">'.k_tests.'</div>';
	return $out;
}
function getTestsR2($id=''){
	$out='';
	$sql="SELECT * FROM `lab_m_services` WHERE `act`=1 and `outlab`=1";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$out.= '<div class="op_list">';
		while($r=mysql_f($res)){
			$name=$r['short_name'];
			$ana_id=$r['id'];
			$out.= '<div class="" num="'.$ana_id.'" rep rec_it_id="'.$id.'" name="'.$name.'">'.$name.'</div>';
	}
		$out.= '</div>';}
		return $out;	
}
function saveTestRec($id){
	//script('saveTestRec2()');
	return '<script>saveTestRec2('.$id.')</script>';
}
function thisReceiptTest($id){
	global $lg,$clr1;
	$out='';
	$sql="select * from lab_x_receipt_items where id='$id'";
	$res=mysql_q($sql);
	$rows=mysql_n($res);	
	if($rows>0){
		$test_arr=array();
		$r=mysql_f($res);
		$tests=$r['tests'];
		$test_arr=explode(',',$tests);
		foreach($test_arr as $tr){
			$tr_Name=get_val('lab_m_services','short_name',$tr);
			$out.='<div class="listButt fl " id="R-'.$tr.'" num ="'.$tr.'" style="background-color:'.$clr1.'">';
			$out.='<div class="delTag" onclick="delOprListR('.$tr.')"></div>';
			$out.='<div class="strTag">'.$tr_Name.'</div>';
			$out.='</div>';
		}
	}	

	return $out.' <script>listButtR();</script>';
}
function outlab_test_reciept_code($type,$id){
	$out='';
	 $sql="select * from lab_x_receipt_items where id='$id'";
	$res=mysql_q($sql);
	$rows=mysql_n($res);	
	if($rows>0){
		$test_arr=array();
		$r=mysql_f($res);
		$tests=$r['tests'];
		$test_arr=explode(',',$tests);
		foreach($test_arr as $tr){
			if($type==1)$tr_code=get_val('lab_m_services','code',$tr);
			else{$tr_code=get_val('lab_m_services','short_name',$tr);}
			if($out){$out.=',';}
			$out.=''.$tr_code.'';
		}
	}
	return '<div class=" ff fs16 clr1111">'.$out.'</div>';
}
function l_get_ana_cats(){
	global $lg,$clr1;
	$out='';
	$sql="select * from lab_m_services_cats order by ord ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){		
		$out.='<div class="ana_list_cat">';
		$out.='<div class="actCat" cat_num="0">'.k_all_test.'</div>';		
		while($r=mysql_f($res)){
			$id=$r['id'];
			$catname=$r['name_'.$lg];
			$out.='<div class="norCat" cat_num="'.$id.'">'.$catname.'</div>';
		}
		$out.='</div>';
	}
	return $out;
}
function l_get_ana($id){
	global $lg,$clr1;
	$out='';
	$selected=array();
	$sql2="select mad_id from cln_x_pro_analy_items where ana_id='$id'";
	$res2=mysql_q($sql2);
	$rows2=mysql_n($res2);	
	if($rows2>0){while($r2=mysql_f($res2)){$id2=$r2['mad_id'];array_push($selected,$id2);}}
	$sql=" SELECT cln_m_pro_analysis.*, COUNT(mad_id) AS ana_count
    FROM cln_m_pro_analysis LEFT JOIN cln_x_pro_analy_items 	
    ON cln_m_pro_analysis.id = cln_x_pro_analy_items.mad_id	
	where cln_m_pro_analysis.act=1
    GROUP BY cln_m_pro_analysis.id
    ORDER BY ana_count DESC";	
	
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){				
		$out.='<div class="ana_list_mdc">';
		while($r=mysql_f($res)){
			$id=$r['id'];
			$name=$r['name_'.$lg];
			$cat=$r['cat'];
			$ana_count=$r['ana_count'];
			$del=0;
			if(in_array($id,$selected)){$del=1;}
			$out.='<div class="norCat " cat_mdc="'.$cat.'" mdc="'.$id.'" name="'.$name.'" del="'.$del.'">'.$name.'</div>';
		}
		$out.='</div>';
	}
	return $out;
}
function checkDocOrder($id,$type){
	if($type==1){
		$vis=get_val('lab_x_visits_services','visit_id',$id);
		$doc_ord=get_val('lab_x_visits','doc_ord',$vis);
        
		if($doc_ord!=0){
			mysql_q("UPDATE lab_x_visits_requested_items SET status=2 where service_id ='$id' and status=1 ");			
			if(getTotalCO('lab_x_visits_requested_items',"r_id='$doc_ord' and status=1 and action=1")==0){
                $r_id=get_val_c('lab_x_visits_requested_items','r_id',$id,'service_id');
				mysql_q("UPDATE lab_x_visits_requested SET status=3 where id='$r_id' and status=2 ");
			}
		}
	}
	if($type==2){        
        list($doc_ord,$visit_link)=get_val('lab_x_visits','doc_ord,visit_link',$id);
		if($doc_ord!=0){            
            $r_id=get_val_con('lab_x_visits_requested','id',"lab_vis='$id' and doc='$doc_ord' ");            
			mysql_q("UPDATE lab_x_visits_requested_items SET status=2 where r_id='$r_id' and status=1 and action=1 ");
			mysql_q("UPDATE lab_x_visits_requested SET status=3 where id='$r_id' and status=2 ");
		}
	}
}

function pr_anaView($vis){
	global $lab_res_fmf_types,$lab_res_fmf_Stypes,$lab_res_CS_types,$lab_res_CS_level;
	$lg='en';
	$out='';	
	$t=1;
	$sql="select * from lab_x_visits_services where visit_id='$vis' and status in(1,7,8,10) ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);	
	$revData='';		
	$actType=0;
	if($rows>0){
		while($r=mysql_f($res)){			
			$x_id=$r['id'];
			$sample=$r['sample'];
			$type=$r['type'];
			$a_id=$x_id;			
			$service=$r['service'];
			$status=$r['status'];			
			$ala_name=get_val_arr('lab_m_services','short_name',$service,'ann');			
			if($type==1 || $type==4){
				$sql3="select * from lab_x_visits_services_results where  serv_id='$x_id'  order by id ASC  ";
				$res3=mysql_q($sql3);
				$rows3=mysql_n($res3);
				if($rows3>1 ){$revData.='<tr><td class="lh30 ff B fs20 b_bord " colspan="3">'.$ala_name.'</td></tr>';}
				$i=0;
				while($r3=mysql_f($res3)){
					$i++;			
					$xSrv_id=$r3['id'];
					$serv_val_id=$r3['serv_val_id'];
					$report_type=$r3['serv_type'];
					$value=$r3['value'];
					$add_value=$r3['add_value'];
					$n_val=$r3['normal_val'];
					$unit=$r3['unit'];
					$hide=$r3['hide'];
					$anaName=get_val_arr('lab_m_services_items','name_'.$lg,$serv_val_id,'an');					
					$last='';
					if($i==$rows3 && $rows3>1){$last='';}					
					$norC='';
					if($hide==0){
						$unitTxt=get_val_arr('lab_m_services_units','code',$unit,'un');
						list($data,$aStatus,$nTxt)=show_LVal($report_type,$value,$n_val,$add_value,$unit);
						if($aStatus>0){$norC='clr66 cbg666';}
						if($aStatus<0){$norC='clr5 cbg555';}
						if($aStatus==2){$norC='clr8 cbg888';}
						$rrv=0;
						$revData.='
						<tr no="" class=" '.$last.' " >						
						<td class="ff fs18 Over" onclick="prlChart('.$xSrv_id.')">'.$anaName.'</td>
						<td class="ff fs18 B '.$norC.' ">'.$data.'</span></td>
						<td class="ff fs16 ">'.$unitTxt.'</td>
						<td class="ff fs16 ">'.$nTxt.'</td>
						</td></tr>';
						if($t==2 || $t==3){
							//list($q,$sType)=get_val('lab_m_services_equations','equations,item',$xSrv_id);		
							//$q_txt=getaQNames($type,$q);
							//$revData.='<div  bb class="TC" >'.getChartLRR($ser_id,$t,$q,$sType).'</div>';					
						}						
					}
				}			

			}
			if($type==2){
				$rec=getRec('lab_x_visits_services_result_cs',$x_id,'serv_id');
				if($rec['r']){
					$ss_val=$rec['val'];
					$ss_sample_type=$rec['sample_type'];
					$ss_colonies=$rec['colonies'];
					$ss_level=$rec['level'];
					$ss_bacteria=$rec['bacteria'];
					$ss_wbc=$rec['wbc'];
					$ss_rbc=$rec['rbc'];					
					$ss_note=$rec['note'];
					$ss_status=$rec['status'];					
				}
				if($ss_val==1){$revData='<div class="f1 fs14 clr6 ">'.$lab_res_CS_types[$ss_val].'</div>';}
				if($ss_val==2){$revData='<div class="f1 fs14 clr5 ">'.$lab_res_CS_types[$ss_val].'</div>';}
				if($ss_val==3){
					$revData.='<div class="lh30 fl_d cb">
					<div class="clr1  f1 fs16">'.k_type_sample.' : '.get_val('lab_m_test_swabs','name',$ss_sample_type).'</div> 
					<div class="clr1  fs16 pd5">'.$lab_res_CS_level[$ss_level].'</div> 					
					<div class="clr5  fs16 pd5"> '.get_val('lab_m_test_bacterias','name',$ss_bacteria).'</div>
					</div>';
					$revData.='<div class="lh30 fl_d cb">';
					if($ss_colonies){$revData.='<div class="fll f1 fs14 pd5">'.k_num_colons.' : <ff  class="clr1">'.number_format($ss_colonies).'</ff> | </div>';}	
					if($ss_wbc){$revData.='<div class="fll f1 fs14 pd5">W.B.C : <ff class="clr1">'.$ss_wbc.'</ff> |</div>';}
					if($ss_rbc){$revData.='<div class="fll f1 fs14 pd5">R.B.C : <ff class="clr1">'.$ss_rbc.'</ff> |</div>';}
					$revData.='</div>';	
					if($ss_note){$revData.='<div class="cb f1 fs16 pd5 lh30">'.k_notes.' : <span class="clr1 fs14 f1">'.$ss_note.'</span> </div>';}

					$sql="select * from lab_x_visits_services_result_cs_sub where p_id='$x_id' order by id ASC";
					$res=mysql_q($sql);
					$rows=mysql_n($res);
					if($rows>0){
						$revData.='<table width="100%"  cellspacing="0" cellpadding="0" class="grad_s " type="static" dir="ltr">
						<tr><th rowspan="2">ANTIMICROBIAL<br>AGENTS</th><th colspan="3">Zone Diameter ( MM )</th><th rowspan="2">COMMERCIAL<br>NAME</th></tr>
						<tr><th width="100">Results ( MM )</th><th width="100">R ( Below )</th><th width="100">S ( Over )</th></tr>';
						while($r=mysql_f($res)){
							$antibiotics=$r['antibiotics'];
							$val=$r['val'];
							$n_id=$r['id'];
							$code=$r['code'];				
							$min_val=$r['min_val'];
							$max_val=$r['max_val'];	list($n_name,$trad_name)=get_val('lab_m_test_antibiotics','name,trad_name',$antibiotics);
							$revData.= '<tr><td><ff class="fs14">'.$n_name.'</ff></td>
							<td><ff>( '.$val.' ) </ff><ff class="clr1">'.$code.'</ff></td>
							<td><ff>'.$min_val.'</ff></td>
							<td><ff>'.$max_val.'</ff></td>
							<td><ff class="fs14">'.$trad_name.'</ff></td>
							</tr>';
						}							
						$revData.= '</table>';
					}	
				}				
			};
			if($type==5){			
				$editVal=get_val_c('lab_x_visits_services_results','value',$x_id,'serv_id');			
				$sql="select * from lab_m_test_mutations where act=1 order by name ASC";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				if($rows>0){
					$antiEditVal=getAntiEditVal2($editVal);
					$revData.='<div class="fl_d ff fs22 TC B lh30 pd10">Assay for the Identication of MEFV geng mutatione <br> Based on real time polymerase chain reaction ( real time PCR ) </div>';
					$revData.='<div class="fl_d ff fs18 pd10 lh30">Mutations detected with this test, potentially leading to a FMF phenotype , are  as follws :  </div><div class="fl_d pd10">';
					$revData.='<table width="100%"  cellspacing="0" cellpadding="2" class="grad_s " dir="ltr" type="static" >';
					$c=0;
					while($r=mysql_f($res)){
						$n_id=$r['id'];
						$n_name=$r['name'];				
						$t1='<ff class="clr5">'.$lab_res_fmf_types[0].'</ff>';
						$t2='';
						if($editVal){
							if($antiEditVal[$n_id]){
								$c++;
								$v1=$antiEditVal[$n_id]['v1'];
								$v2=$antiEditVal[$n_id]['v2'];
								if($v1==1){
									$t1='<ff class="clr6">'.$lab_res_fmf_types[1].'</ff>';
									if($v2==1){$t2=' - '.$lab_res_fmf_Stypes[1];}if($v2==2){$t2=' - '.$lab_res_fmf_Stypes[2];}
								}	
								$revData.= '<tr><td width="30"><ff>'.$c.'</ff></td><td><ff>'.$n_name.'</ff></td><td>'.$t1.' <ff> '.$t2.'</ff></td></tr>';
							}
						}
					}							
					$revData.='</table></div>';
				}
			};
			$actType=$type;			
		}
		if($actType==1 || $actType==4){
			$revData='<table width="100%" border="0" cellspacing="0" cellpadding="0" class="fTable" >'.$revData.'</table>';
		}
	}
	return $revData;
}
function show_LVal($type,$val,$n_value,$n_add_pars,$unit){
	$out=array('#000','','',$val,'','','','');
	global $age_types,$sex_types,$anT2_types,$anT3_types,$anT2_typesCode,$lg,$anT3_typesC,$RPC_N,$RPC_X;
	$status=0;	
	$data='';	
	$nTxt='';
	if($n_value || $n_add_pars || $type==3 || $type==6){
		$data='';		
		switch ($type){ 
			case 1:	
				if($val!=''){
					$v=explode(',',$n_value);											
					if($val <=$v[2] && $val >=$v[1]){
						$oCode=$RPC_N;
						$oCode2='';
						$status=1;
					}else{
						$status=-1;
						$oCode=$RPC_X;
						if($val < $v[2]){$oCode2='<ff class="cbg5 clrw pd5">L</ff>';}
						if($val > $v[1]){$oCode2='<ff class="cbg5 clrw pd5">H</ff>';}
					}
					$nTxt='<span class="ff clr6 fs16">'.$v[1].' - '.$v[2].'</span>';
					$data=numFor($val,2).' '.$oCode2;
				}
			break;
			case 2:
				if($val!=''){	
					$v=explode(',',$n_value);
					if($v[0]==0){if($val>$v[1]){$status=1;}else{$status=-1;}}
					if($v[0]==1){if($val<$v[1]){$status=1;}else{$status=-1;$oCode2='<ff class="cbg5 clrw pd5">H</ff>';}}
					if($v[0]==2){if($val>=$v[1]){$status=1;}else{$status=-1;}}
					if($v[0]==3){if($val<=$v[1]){$status=1;}else{$status=-1;$oCode2='<ff class="cbg5 clrw pd5">H</ff>';}}
					if($v[0]==4){if($val==$v[1]){$status=1;}else{$status=-1;}}
					if($v[0]==5){if($val!=$v[1]){$status=1;}else{$status=-1;}}
					$nTxt.='<div>
					<span class="ff fs16 clr6">'.$anT2_typesCode[$v[0]].'</span>
					<span class="ff fs16 clr6"> '.numFor($v[1],5).' </span>
					</div>';
					$data=numFor($val,2).' '.$oCode2;
				}
			break;
			case 3:
				if($val!=''){
					if($n_add_pars){
						$dp=explode(',',$n_add_pars);
						if(count($dp)==2){							
							if($val=='p'){'<span class="ff fs14">'.$oCodeTxt=$dp[1].'</span>';}
							if($val=='n'){'<span class="ff fs14">'.$oCodeTxt=$dp[0].'</span>';}
						}
					}else{
						if($val=='p'){$oCodeTxt='<span class="ff fs14">'.$anT3_types[1].'</span>';}
						if($val=='n'){$oCodeTxt='<span class="ff fs14">'.$anT3_types[0].'</span>';}
					}
					if($n_value!=''){
						if(( $val=='n') || ($n_value==1 && $val=='p')){$status=1;}else{$status=-1;}
						$nTxt='<div>
						<span class="ff fs16 clr6">'.$anT3_types[$n_value].'</span>							
						</div>';
					}
					$data=$oCodeTxt;
				}
			break;
			case 4:
				if($val!=''){					
				$v=explode(',',$n_value);
				$nVal=$v[0];
				$itisNor=0;
				$N='N';
				$N='';
				if($val!=''){
					if($v[1]==0){if($val >  $v[2]){$status=1;$itisNor=1;$oCode2=$N;
					}else{$status=-1;$oCode2='<ff class="cbg5 clrw pd5">L</ff>';}}
					if($v[1]==1){if($val <  $v[2]){$status=1;$itisNor=1;$oCode2=$N;}
					else{$status=-1;$oCode2='<ff class="cbg5 clrw pd5">H</ff>';}}
					if($v[1]==2){if($val >= $v[2]){$status=1;$itisNor=1;$oCode2=$N;}
					else{$status=-1;$oCode2='<ff class="cbg5 clrw pd5">L</ff>';}}
					if($v[1]==3){if($val <= $v[2]){$status=1;$itisNor=1;$oCode2=$N;}
					else{$status=-1;$oCode2='<ff class="cbg5 clrw pd5">H</ff>';}}
					if($v[1]==4){if($val == $v[2]){$status=1;$itisNor=1;$oCode2=$N;}
					else{$status=-1;
					if($val <$v[1]){$oCode2='<ff class="cbg5 clrw pd5">L</ff>';}
					if($val >$v[1]){$oCode2='<ff class="cbg5 clrw pd5">H</ff>';}}}
					if($v[1]==5){if($val != $v[2]){$oCode=$RPC_N;$itisNor=1;$oCode2=$N;}else{$oCode=$RPC_X;}}
				}
				if($n_add_pars){
					$dp=explode(',',$n_add_pars);
					if(($itisNor && $nVal==1) || ($itisNor==0 && $nVal==0)){$out[4].=$dp[1];}
					if(($itisNor && $nVal==0) || ($itisNor==0 && $nVal==1)){$out[4].=$dp[0];}
				}
				$oCodeTxt='';
				// if($add_pars){
				// 	$add_parsIn=explode(',',$add_pars);
				// 	if($itisNor){
				// 		if($nVal==0){$oCodeTxt.=' '.$add_parsIn[0];}
				// 		if($nVal==1){$oCodeTxt.=' '.$add_parsIn[1];}
				// 	}else{							
				// 		if($nVal==1){$oCodeTxt.=' '.$add_parsIn[0];}
				// 		if($nVal==0){$oCodeTxt.=' '.$add_parsIn[1];}							
				// 	}
				// }else{
					if($itisNor){
						if($nVal==0){$oCodeTxt.=' Negative';}
						if($nVal==1){$oCodeTxt.=' Positive';}
					}else{							
						if($nVal==1){$oCodeTxt.=' Negative';}
						if($nVal==0){$oCodeTxt.=' Positive';}							
					}
				//}
				$nTxt='<span class="ff fs16 clr6">'.$anT3_typesC[$v[0]].' '.$anT2_typesCode[$v[1]].' '.$v[2].'</span>';
				$data=$val.'<span class="ff fs14 ">'.$oCodeTxt.'</span> '.$oCode2;
			}
			break;
			case 5:				
				if($val!=''){
					$st=$n_value;
					list($txt,$st)=get_val('lab_m_services_items_normal','add_pars,value',$val);
					if($st=='x'){$status=-1;}
					if($st=='n'){$status=1;}					
					//$data='<span class="ff fs14 ">'.$n_add_pars.'</span>';
					$data='<span class="ff fs14 ">'.$txt.'</span>';
				}
			break;
			case 6:				
				$data='<span class="ff fs12 ">'.nl2br($val).'</span>';
			break;
			case 7:
			if($val!=''){
				$v=explode(',',$n_value);
				$dp=explode(',',$n_add_pars);
									
				if($val){
					if($val < $v[0]){$oCodeTxt=' Negative';
					if($dp[0]){$oCodeTxt=$val.' '.$dp[0];}$status=-1;$oCode2='L';}
					if($val >= $v[0] && $val <= $v[1]){$oCodeTxt=' Equivocal';
					if($dp[1]){$oCodeTxt=$val.' '.$dp[1];}$status=2;}
					if($val > $v[1]){$oCodeTxt=' Positive';
					if($dp[2]){$oCodeTxt=$val.' '.$dp[2];};$status=1;$oCode2='H';}
				}
				$nTxt='<span class="ff fs16 clr6">'.$v[0].' - '.$v[1].'</span>';
				$data=$val.'<span class="ff fs14 ">'.$oCodeTxt.'</span> '.$oCode2;
			}
			break;
		}	
	}else{$data=$val;}
	/*$data.=$SSA;
	if($nots){$data.='<div class="repLNote cb mg10">'.nl2br($nots).'</div>';}
	if($data){
		$out[1].=$data;
	}*/
	return array($data,$status,$nTxt);
}
function labDevData($id,$opr,$filed,$val){
	$out='';
	if($opr=='list' || $opr=='view'){
		$out.='<div class="ff fs16 uc w100 B TC" dir="ltr">'.$val.'</div>
		<div class="fl f1 ic40 icc1 ic40_edit ic40Txt" onclick="setLabDev('.$id.')">'.k_analytics_links.'</div>';
	}
	return $out;
}
function get_visBal($vis){
	$res=mysql_q("select SUM(pay_net)c from lab_x_visits_services where visit_id='$vis' and status not IN(2,3)");
	$r=mysql_f($res);
	$serv=$r['c'];
	//$chrPart=get_sum('gnr_x_charities_srv','srv_covered'," vis= '$vis' ");
	//$exePart=get_sum('gnr_x_exemption_srv','srv_covered'," vis= '$vis' ");
	//$insurPart=get_sum('gnr_x_insurance_rec','in_price-in_price_includ'," visit= '$vis' ");
	$payIN=get_sum('gnr_x_acc_payments','amount'," vis='$vis' and mood='2' and type IN(1,2,7,11) ");
	$payOUT=get_sum('gnr_x_acc_payments','amount'," vis='$vis' and mood='2' and type IN(3,4) ");
	//return $serv+$payOUT-$payIN-$chrPart-$exePart-$insurPart;
	return $serv+$payOUT-$payIN;
}
function editebalAna($s){
	$out=0;
	if(
		(in_array($s,array(5,6,9,10))) || 
		(in_array($s,array(7,8)) && _set_6up2tju3gl==2) ||
		(!in_array($s,array(0,2,3,4)) && _set_6up2tju3gl==3)
	){$out=1;}
	return $out;
}
function fixWTSrvs($g){
	$s=0;
	$c=0;
	$srvs=get_vals('lab_x_visits_services','id'," w_table='$g' ");	
	if($srvs){
		$ss=explode(',',$srvs);
		$c=count($ss);
		if(!$c){$c=1;}
		$s=1;
	}
	mysql_q("UPDATE lab_x_work_table SET services='$srvs' ,status='$s' where id='$g' and status<2");
	return $c;
}
function labJson($vis,$del=0){
    if(_set_wr54mldf53==1){
        $data=array();
        $json='';
        if($del==1){
            $data[0]['delete']='1';
            $data[0]['visit_id']=$vis;
            $json=json_encode($data,JSON_UNESCAPED_UNICODE);
        }else{
            $sql="select * from lab_x_visits where id='$vis' ";
            $res=mysql_q($sql);
            $rows=mysql_n($res);
            if($rows){
                $r=mysql_f($res);
                $status=$r['status'];
                if($status==3){
                    $data[0]['delete']='1';
                    $data[0]['visit_id']=$r['id'];
                }else{
                    $data[0]['delete']='0';
                    $data[0]['visit_id']=$r['id'];
                    $data[0]['patient_id']=$r['patient'];
                    $data[0]['date']=$r['d_start'];
                    $data[0]['date']=$r['d_start'];
                    $data[0]['balance']=get_visBal($vis);
                    $pat=getRec('gnr_m_patients',$r['patient']);
                    if($pat['r']){
                        $data[0]['name']=$pat['f_name'];
                        $data[0]['l_name']=$pat['l_name'];
                        $data[0]['father_name']=$pat['ft_name'];
                        $data[0]['birth_date']=$pat['birth_date'];
                        $data[0]['sex']=$pat['sex'];
						$data[0]['mobile']=$pat['mobile'];
                        $srvs=get_arr('lab_x_visits_services','id','service',"visit_id='$vis'");
                        $i=0;
                        $srvArr=[];
                        foreach($srvs as $k=>$v){
                            $srvArr[]=array('rec_id'=>$k,'service'=>$v);
                            $i++;
                        }
                        $data[0]['sevices']=$srvArr;
                        $json=json_encode($data,JSON_UNESCAPED_UNICODE);
                    }
                }            
            }
        }
        if($json){
            if(!file_exists('../../../Visits')){mkdir('../../../Visits',0777);}
            $file='../../../Visits/'.$vis.'.txt';
            $myfile=fopen($file, "r");
            file_put_contents($file,$json);
            //fclose($myfile);
        }
    }
}
function labJsonBalUpdate($vis){
    if(_set_wr54mldf53==1){
        $data=array();
        $json='';
        $data[0]['vis']=$vis;
        $data[0]['balance']=get_visBal($vis);
        $json=json_encode($data,JSON_UNESCAPED_UNICODE);
        if($json){
            if(!file_exists('../../../Balance')){mkdir('../../../Balance',0777);}
            $file='../../../Balance/'.$vis.'.txt';
            $myfile=fopen($file, "r");
            file_put_contents($file,$json);
            //fclose($myfile);
        }
    }
}
function sncLabSrv($id,$type){
    if(_set_wr54mldf53==1){
        $data=array();
        $itemsArr=array();
        $json='';
        if($type==2){
            $id=get_val('lab_m_services_items','serv',$id);
        }
        $sql="select * from lab_m_services where id='$id'";
        $res=mysql_q($sql);
        $rows=mysql_n($res);
        if($rows){
            $r=mysql_f($res);
            $data[0]['srv_id']=$r['id'];
            $data[0]['cat']=$r['cat'];
            $data[0]['short_name']=$r['short_name'];
            $data[0]['srv_name_en']=$r['name_en'];
            $data[0]['srv_name_ar']=$r['name_ar'];
            $data[0]['unit']=$r['unit'];
            $items=get_arr('lab_m_services_items','id','name_en,name_ar,unit'," serv='$id' and type=2 and act=1");
            foreach($items as $k=>$v){
                $itemsArr[]=array('id'=>$k,'name_en'=>$v['name_en'],'name_ar'=>$v['name_ar'],'unit'=>$v['unit']);
            }
            $data[0]['items']=$itemsArr;
            $json=json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        if($json){
            if(!file_exists('../../../Services')){mkdir('../../../Services',0777);}
            $file='../../../Services/'.$id.'.txt';
            $myfile=fopen($file, "r");
            file_put_contents($file,$json);
           // fclose($myfile);
        }
    }
}
function sncAntibiotics($id){
    if(_set_wr54mldf53==1){
        $data=array();
        $itemsArr=array();
        $json='';    
        $r=getRec("lab_m_test_antibiotics",$id);
        if($r['r']){        
            $data[0]['id']=$r['id'];        
            $data[0]['name']=$r['name'];        
            $json=json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        if($json){
            if(!file_exists('../../../Antibiotics')){mkdir('../../../Antibiotics',0777);}
            $file='../../../Antibiotics/'.$id.'.txt';
            $myfile=fopen($file, "r");
            file_put_contents($file,$json);
            //fclose($myfile);
        }
    }
}
function sncbacteria($id){
    if(_set_wr54mldf53==1){
        $data=array();
        $itemsArr=array();
        $json='';    
        $r=getRec("lab_m_test_bacterias",$id);
        if($r['r']){        
            $data[0]['id']=$r['id'];        
            $data[0]['name']=$r['name'];        
            $json=json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        if($json){
            if(!file_exists('../../../Bacterias')){mkdir('../../../Bacterias',0777);}
            $file='../../../Bacterias/'.$id.'.txt';
            $myfile=fopen($file, "r");
            file_put_contents($file,$json);
            //fclose($myfile);
        }
    }
}
function sncswabs($id){
    if(_set_wr54mldf53==1){
        $data=array();
        $itemsArr=array();
        $json='';    
        $r=getRec("lab_m_test_swabs",$id);
        if($r['r']){        
            $data[0]['id']=$r['id'];        
            $data[0]['name']=$r['name'];        
            $json=json_encode($data,JSON_UNESCAPED_UNICODE);
        }
        if($json){
            if(!file_exists('../../../Swabs')){mkdir('../../../Swabs',0777);}
            $file='../../../Swabs/'.$id.'.txt';
            $myfile=fopen($file, "r");
            file_put_contents($file,$json);
            //fclose($myfile);
        }
    }
}
/*******************************************/
function get_ser_lab_catsN(){	
	global $lg,$clr1;	
	$sql="select * from lab_m_services_cats order by name_$lg ASC";
	$out='';	
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){		
		$out.='<div class="ana_list_catN" actButt="act" type="2">';
		$out.='<div act cat_num="0">'.k_all_test.'</div>';		
		while($r=mysql_f($res)){
			$id=$r['id'];
			$catname=$r['name_'.$lg];
			$out.='<div cat_num="'.$id.'">'.$catname.'</div>';
		}
		$out.='</div>';
	}
	return $out;
}
function get_ser_labN($vis,$pat,$srvs){
	global $lg,$srvTables,$srvXTables;
    $mood=2;
    $ms_table=$srvTables[$mood];
	$xs_table=$srvXTables[$mood];
	$nameTypes=array('','short_name','name_en','name_ar');    
	$out='';
    $selectedSrvs=explode(',',$srvs);
	//if($act){$q2.=" act=1 ";}
	$sql=" SELECT * from lab_m_services where act=1 order by ord ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$out.='<div class="ana_list_mdcN">';
		while($r=mysql_f($res)){
			$id=$r['id'];
			$code=$r['code'];
			$short_name=$r[$nameTypes[_set_yj870gpuyy]];
			$short_name2=$short_name;
			if(_set_yj870gpuyy!=3){$short_name2=strtolower($short_name);}			
			$cat=$r['cat'];
			$unit=$r['unit'];			
			$price=$unit*_set_x6kmh3k9mh;
			$cus_unit_price=$r['cus_unit_price'];
			if($cus_unit_price){$price=$unit*$cus_unit_price;}
            $del='0';
            $c='';
            if(in_array($id,$selectedSrvs)){
                $del='1';
                $c='class="hide"';
            }
			$out.='<div '.$c.' cat_mdc="'.$cat.'" s="0"  code="'.strtolower($code).'" mdc="'.$id.'" name="'.$short_name2.'" del="'.$del.'" price="'.$price.'">'.splitNo($short_name2).'</div>';
		}
		$out.='</div>';			
	}
	return $out;
}
function showLabSrvOffer($id,$offerSrv,$bupOffer,$price){    
    $Mprice=$Nprice=$price;    
    if($bupOffer[0]==3){
        $offerTxt='<div class="fl w100 clr66 lh30 pd5 cbg666 mg10v TC br5">'.k_gen_discount.'<ff14>%'.$bupOffer[1].'</ff14> <span class="LT clr5">('.number_format($Mprice).')</span></div>';
        $offerDisPrice=$price;
        $Nprice=($price/100)*(100-$bupOffer[1]);
    }
    if($bupOffer[0]==4){
        $offerTxt='<div class="fl w100 clr66 lh30 pd5 cbg666 mg10v TC br5">'.k_for_discount.'<ff14>%'.$bupOffer[1].'</ff14> <span class="LT clr5">('.number_format($Mprice).')</span></div>'; 
        $offerDisPrice=$price;
        $Nprice=($price/100)*(100-$bupOffer[1]);
    }
    foreach($offerSrv as $o){			
        if($o[1]==$id ){					
            if($o[0]==2){
                $offerTxt='<div class="fl w100 clr66 lh30 pd5 cbg666 mg10v TC br5">'.k_ser_descount.'<ff14>%'.$o[2].'</ff14> <span class="LT clr5">('.number_format($Mprice).')</span></div>';
                $offerDisPrice=$price;
                //$Nprice=($price/100)*(100-$o[2]);
                $Nprice=$o[4];
            }
            if($o[0]==1){
                $offerTxt='<div class="fl w100 clr66 lh30 pd5 cbg666 mg10v TC br5">'.k_patient_bou_ser.'<span class="LT clr5">('.number_format($Mprice).')</span></div>';
                $Nprice=0;						
            }
            $trClr=' cbg666 ';
        }
    }
    return array($Nprice,$offerTxt);
}
function get_edit_labN($vis,$pat,$srvs){
    global $lg,$bupOffer;
    $mood=2;
	$nameTypes=array('','short_name','name_en','name_ar');
    if(_set_9iaut3jze){
        $bupOffer=array();        
        $offersAv=offersList($mood,$pat);        
        $offerSrv=getSrvOffers($mood,$pat);
    }
	$out='';    	
    if($srvs){
        $sql=" SELECT * from lab_m_services where  act=1 and id IN($srvs) order by ord ASC";
        $res=mysql_q($sql);
        $rows=mysql_n($res);
        if($rows>0){
            while($r=mysql_f($res)){
                $id=$r['id'];
                $short_name=$r[$nameTypes[_set_yj870gpuyy]];
                $short_name2=$short_name;
                if(_set_yj870gpuyy!=3){$short_name2=strtolower($short_name);}						
                $unit=$r['unit'];
                $fast=$r['fast'];
                $cus_unit_price=$r['cus_unit_price'];
                $price=$unit*_set_x6kmh3k9mh;
                if($cus_unit_price){$price=$unit*$cus_unit_price;}              
                $offerTxt='';            
                if(_set_9iaut3jze){
                    $offerTxt=showLabSrvOffer($id,$offerSrv,$bupOffer,$price);
                    $price=$offerTxt[0];
                }
				$isFast=0;
				if($vis){
					$isFast=get_val_con('lab_x_visits_services','fast',"visit_id='$vis' and service='$id' ");
				}
                $out.=anaTempLoad($id,$price,$short_name2,$fast,$offerTxt[1],$isFast);
            }	
        }
        return $out;
    }
}
function anaTempLoad($id,$price,$short_name,$fast,$offerTxt='',$isFast=0){
    global $lg;
    $fastTxt=$consTxt='';
    if($fast){
		$ch=' ';
		if($isFast){$ch=' checked ';}
        $fastTxt='<div class="fr fs14 lh40 f1 clr5"><input type="checkbox" name="f_'.$id.'" '.$ch.'>'.k_emergency.'</div>';
    }
    $out='<div class="fl w100 bord pd10 cbgw br5 mg10v" anaSel="'.$id.'" pr="'.$price.'">
        <div class="fr i30 i30_x mg5v" delSelAna></div>
        <div class="fs16 lh40 b_bord">'.$short_name.'</div>
        <div class="fl w100 lh40">
            <div class="fr lh40"><ff class="clr6">'.number_format($price).'</ff></div>
            <div class="fl lh40">'.$fastTxt.'</div>
        </div>'.$offerTxt.'
    </div>';
    return $out;
}
function lab_selSrvs($vis,$pat,$reqOrd=0){
	global $f_path,$lg,$bupOffer,$srvXTables,$srvTables;
	$mood=2;
	$ms_table=$srvTables[$mood];
	$xs_table=$srvXTables[$mood];
    $srvs='';
    $printOrd='';
	$out='';
	if($vis){
        delOfferVis($mood,$vis);        
        $srvs=get_vals('lab_x_visits_services','service',"visit_id='$vis'");
    }else if($reqOrd){
        $srvs=get_vals('lab_x_visits_requested_items','ana',"r_id='$reqOrd'");
        $printOrd='<div class="fl br0 ic40 icc4 ic40_print ic40Txt mg10" printLabSrv="'.$reqOrd.'">'.k_print_ana_request.'</div>';
    }
    $srvsTxt='';
    if($srvs){$srvsTxt=get_edit_labN($vis,$pat,$srvs);}
	$out.='
	<div class="fl w100 lh50 b_bord cbg4 pd10f fxg" fxg="gtc:1fr auto auto auto">		
		<div class="lh40 fl">
			<input type="text" fix="h:40" placeholder="'.k_search.'" id="srvLabSrch"/>
		</div>
        <div class="ic40x br0 ic40_reload icc33 fr" labTpmLoad title="'.k_utst_tmplt.'"></div>
        <div class="ic40x br0 ic40_save icc22 fr" labTpmSave title="'.k_sv_tsamplt.'"></div>
		<div class="srvTotal fr"><ff rvTot>0</ff></div>
        <div class="winLabTmp of so"></div>
	</div>
	<div class="fl w100 of h100 fxg " fxg="gtc:220px 3fr 4fr" >
        <div class="r_bord pd5f ofx so soL1 cbg4">'.get_ser_lab_catsN().'</div>
        <div class="r_bord pd5f  ofx so soL2">'.get_ser_labN($vis,$pat,$srvs).'</div> 
        <div class="pd10 fxg of h100" fxg="gtr:50px 1fr">
            <div class="f1 fs14 b_bord lh50">'.k_selected_tests.' <ff id="countAna">( 0 )</ff></div>
            <div id="anaSelected" class="pd10 ofx so">'.$srvsTxt.'</div>
        </div>';        
	$out.='</div>
	<div class="fl w100 lh60 cbg4 pd10f t_bord">
		<div class="fl br0 ic40 icc2 ic40_save ic40Txt " saveLabSrv>'.k_save.'</div>'.$printOrd.'
	</div>';
	return $out;
}
function lab_selSrvs_save($vis_id,$pat,$emplo,$req=0){
	global $now,$thisUser,$visXTables,$srvXTables,$srvTables,$lg;
    $mood=2;
	$vTable=$visXTables[$mood];
	$sTable=$srvXTables[$mood];
	$smTable=$srvTables[$mood];
    $doc_ord=$visit_link=0;
    if($req){
        $rr=getRec('lab_x_visits_requested',$req);        
        $req_status=$rr['status'];
        $lab_vis=$rr['lab_vis'];
        if($req_status==1 || ($req_status==2 && $lab_vis==0)){
            $doc_ord=$rr['doc'];
            $visit_link=$rr['visit_id'];           
        }
    }
    if($vis_id==0){
        $new_pat=isNewPat($pat,'',$mood);
        $code=getRandString(32,3);
        $sql="INSERT INTO lab_x_visits(`patient`,`d_start`,`reg_user`,`doc_ord`,`emplo`,`new_pat`,`code`,`visit_link`)values ('$pat','$now','$thisUser','$doc_ord','$emplo','$new_pat','$code','$visit_link')";
        if(mysql_q($sql)){$vis_id=last_id();}
    }else{        
		delOfferVis($mood,$vis_id);
		mysql_q("DELETE from $sTable where `visit_id`='$vis_id' ");
        list($doc_ord,$visit_link)=get_val($vTable,'doc_ord,visit_link',$vis_id);
        if($doc_ord){
            list($req_id,$reqStatus)=get_val_con('lab_x_visits_requested','id,status',"visit_id='$visit_link' and 
            doc='$doc_ord'");
            if($reqStatus<3){
                $req=$req_id;
            }
        }
	}
    /****************************/
    if($vis_id){        
        if($req){
            mysql_q("UPDATE lab_x_visits_requested set status=3 , lab_vis ='$vis_id' where id='$req' and status in(1,2) ");
        }
        /******************************************/
        $status=0;
        //if($vis_id && _set_ruqswqrrpl==0){$status=2;}
        $isFast=0;
        $srvs=pp($_POST['srvs'],'s');
        $srvAr=explode(',',$srvs);
        $srvArr=[];        
        foreach($srvAr as $v){
            $vv=explode(':',$v);
            $srvArr[$vv[0]]=$vv[1];
        } 
        $srvTxt=implode(',',array_keys($srvArr));
        $sql="select * from lab_m_services where act=1 and id IN($srvTxt) order by ord ASC";
        $res=mysql_q($sql);
        $rows=mysql_n($res);
        if($rows>0){
            while($r=mysql_f($res)){
                $s_id=$r['id'];
                $name=$r['name_'.$lg];
                $unit=$r['unit'];
                $s_type=$r['type'];
                $s_cat=$r['cat'];		
                $sample=$r['sample'];
				$sample_type=$r['sample_type'];
                $unit_price=_set_x6kmh3k9mh;
                
                $cus_unit_price=$r['cus_unit_price'];
                $price=$unit*_set_x6kmh3k9mh;
                if($cus_unit_price){$unit_price=$cus_unit_price;}  
                
                if($emplo){
                    if(_set_fk9p1pamop){
                        $unit_price=$unit_price-($unit_price/100*_set_fk9p1pamop);
                        $unit_price=round($unit_price,-1,PHP_ROUND_HALF_DOWN);
                    }
                }
                $pay_net=$unit_price*$unit;
                $total_pay=$unit_price*$unit;
                $fast=0;
                if($srvArr[$s_id]){$fast=1;$isFast=1;}
                $code=getRandString(32,3);
                $visDate=get_val('lab_x_visits','d_start',$vis_id);
                if(mysql_q("INSERT INTO lab_x_visits_services (`visit_id`,`service`,`units`,`units_price`,`pay_net`,`sample`,`fast`,`status`,`type`,`srv_cat`,`patient`,`total_pay`,`code`,`d_start`)						
				values('$vis_id','$s_id','$unit','$unit_price','$pay_net','$sample_type','$fast','$status','$s_type','$s_cat','$pat','$total_pay','$code','$visDate')")){
                    $srv_x_id=last_id();									
                    if($req){
                        mysql_q("UPDATE lab_x_visits_requested_items set status=1 , service_id='$srv_x_id'  where r_id='$req' and action=1 and ana='$s_id' ");
                    }
                }
                if(_set_9iaut3jze){activeOffer($mood,0,0,$pat,$vis_id,$s_id,$srv_x_id);}
            }
            mysql_q("UPDATE gnr_x_roles set status=2  where vis='$vis_id' and mood=$mood and  status=4");
            endLabVist($vis_id);
        }else{return '0';}
        if($isFast){mysql_q("UPDATE lab_x_visits set fast=1 where id='$vis_id' ");}
        if($req){delTempOpr($mood,$req,7);}
        return $vis_id;
    }else{return '0';}	
}
function lab_selSrvsSta($vis){
	global $f_path,$lg,$bupOffer,$payStatusArrRec,$reqStatusArr,$insurStatusColArr;	
	$mood=2;
	$editable=1;
	$mood=2;
    $out='';
	$sql="select * from lab_x_visits where id='$vis'";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$patient=$r['patient'];
		$type=$r['type'];
		$pay_type=$r['pay_type'];
		$d_start=$r['d_start'];
		$status=$r['status'];
		$emplo=$r['emplo'];
		//if($emplo && $pay_type==0){$emploTxt=' <span class="f1 fs18 lh20 clr5 ">( موظف )</span>';}
		//$p_name=get_p_name($patient);
		$c_name=k_lab;
        $out.='<div class="fl w100 ofx so pd10">';
		$sql="select * , x.id as x_id , x.fast as x_fast from  lab_m_services z , lab_x_visits_services x where x.visit_id='$vis' and  x.service=z.id order by x.id ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
            if($pay_type==1){
			    $gm_note=get_val_con('gnr_x_exemption','note'," vis='$vis' and c_type=2 ");            
                if($gm_note){
                    $out.='<div class="f1 fs16 lh30 clr1">'.k_management_notes.'</div>
			        <div class="f1 fs12 lh20 clr5">'.$gm_note.'</div>';
                }
            }
            $out.='<table width="100%" border="0" type="static" cellspacing="0" cellpadding="4" class="grad_s holdH mg10v">';
            if($pay_type!=0){
				$out.='<tr><th>'.k_analysis.'</th>
				<th>'.k_notes.'</th>
				<th width="80">'.k_price.'</th>
				<th width="80">'.k_includ.'</th>
				<th width="80">'.k_must_be_paid.'</th>				
				</tr>';
			}else{
				$out.='<tr><th>'.k_analysis.'</th>
				<th>'.k_notes.'</th>
				<th width="80">'.k_price.'</th></tr>';
			}
            $total1=0;
            $total2=0;
			$time_max=0;
            while($r=mysql_f($res)){				
                $s_id=$r['x_id'];
                $service=$r['service'];
                $units=$r['units'];
                $units_price=$r['units_price'];
                $pay_net=$r['pay_net'];
				$sample=$r['sample'];
				$fast=$r['x_fast'];
				$name=$r['short_name'];
				$time_req=$r['time_req'];
				$con=$r['conditions'];
				$offer=$r['offer'];
				$time_max=max($time_max,$time_req);
                $price=$units_price*$units;
				if($emplo && $price){$price=_set_x6kmh3k9mh*$units;}
                $total1+=$price;
                $total2+=$pay_net;
                $netTotal=$pay_net;
				$dis=$price-$pay_net;
                
                
				$msg='';
				$cons='';
				if($con){$cons='<div class="f1 fs12">'.get_lab_con($con).'</div>';}
				$offerText=getSrvOfeerS($offer,$mood,$vis,$s_id);
				if($fast){$msg='<div class="f1 clr5">'.k_emergency.'</div>';}
                $out.='<tr>					
                <td class="f1"><ff>'.$name.$cons.'</ff></td>';
                if($pay_type==0){
                    $offerDisPriceTxt='';
                    if($offer && $pay_net!=$price){$offerDisPriceTxt='<br><ff14 class="fs12 clr5 LT">'.number_format($price).'</ff>';}
                    
				    $out.='<td class="f1">'.$msg.$offerText.'</td>
                    <td><ff>'.number_format($pay_net).$offerDisPriceTxt.'</ff></td>';
                }				
				if($pay_type!=0){
					$insurS='-';
                    if($status==0){$insurS='<span class="clr5 f1 fs14">'.k_not_included.'</span>';}
					$cancelServ='';
                    $incPerc='';
                    if($pay_type==3){
                        $sur=getRecCon('gnr_x_insurance_rec'," visit='$vis' and service_x='$s_id' and mood='$mood' ");
                        $in_status=$sur['res_status'];
                        $in_s_date=$sur['s_date'];
                        $in_r_date=$sur['r_date'];
                        $ref_no=$sur['ref_no'];
                        if($ref_no){$ref_no=' <ff14 class="lh30">('.$ref_no.')</ff14>';}
                        if($in_status==2){
                        $cancelServ='
                        <div class="fl ic30 ic30_del icc2" srvDelIn="'.$s_id.'" mood="'.$mood.'" onclick1="delServ('.$s_id.','.$mood.')" title="'.k_cncl_serv.'"></div>';
                    }					
					    if($in_status==1){
                           $incPerc=' <ff14 class="clr6"> '.number_format(($dis*100/$price),2).'%</ff14>';
                       }                    
                        if($in_status!=''){$insurS=$reqStatusArr[$in_status];}
                    }
                    $out.='<td class="f1">
                        <div class="f1 '.$insurStatusColArr[$in_status].'" > '.$reqStatusArr[$in_status].''.$incPerc.$ref_no.$cancelServ.'</div>
                    </td>
                    <td><ff>'.number_format($price).'</ff></td>
                    <td><ff>'.$dis.'</ff></td>
                    <td><ff class="clr6">'.number_format($pay_net).'</ff></td>';
                    
				}
                $out.='</tr>';
            }
            $totClr1='cbg66';
			$totClr2='cbg666';
			if($total2==0){$totClr1='cbg88';$totClr2='cbg888';}
            $out.='<tr><td class="f1 B '.$totClr2.'" colspan="2">'.k_total.'</td>';
            if($pay_type!=0){
                $out.='<td class="'.$totClr2.'"><ff>'.number_format($total1).'</ff></td>
                <td class="'.$totClr2.'"><ff>'.number_format($total1-$total2).'</ff></td>';
            }
            $out.='<td class="fs18 ff B '.$totClr1.' "><ff class="clrw">'.number_format($total2).'</ff></td></tr>';
            $showNetPay=0;
            $paymentsIN=get_sum('gnr_x_acc_payments','amount',"mood='$mood' and vis='$vis' and type IN(1,2) and pay_type=1");
            if($paymentsIN){// الدفعات السابقة
                $total2-=$paymentsIN;
                $showNetPay=1;
                $out.='<tr>					
                <td class="f1 B cbg555" colspan="2">'.k_prev_pays.'</td>';
                if($pay_type!=0){$out.='<td colspan="2" class="f1 cbg555"></td>';}
                $out.='<td class="fs18 ff B cbg55 "><ff class="clrw">'.number_format($paymentsIN).'</ff></td>';
                $out.='</tr>'; 
            }
            $paymentsOut=get_sum('gnr_x_acc_payments','amount',"mood='$mood' and vis='$vis' and type IN(3,4) and pay_type=1");
            if($paymentsOut){// الارجاعات السابقة
                $total2+=$paymentsOut;
                $showNetPay=1;
                $out.='<tr>					
                <td class="f1 B cbg666" colspan="2">'.k_pre_returns.'</td>';
                if($pay_type!=0){$out.='<td colspan="2" class="f1 cbg666"></td>';}
                $out.='<td class="fs18 ff B cbg66 "><ff class="clrw">'.number_format($paymentsOut).'</ff></td>';
                $out.='</tr>'; 
            }
            
            $cardPay=get_sum('gnr_x_acc_payments','amount',"mood='$mood' and vis='$vis' and pay_type=2");
            if($cardPay){// دفع الكتروني جزئي
                $total2-=$cardPay;
                $showNetPay=1;
                $out.='<tr>					
                <td class="f1 B cbg555" colspan="2">'.k_ele_payment.'</td>';
                if($pay_type!=0){$out.='<td colspan="2" class="f1 cbg555"></td>';}
                $out.='<td class="fs18 ff B cbg55 "><ff class="clrw">'.number_format($cardPay).'</ff></td>';
                $out.='</tr>'; 
            }            
            if($showNetPay){
                $totClr1='cbg66';
                $totClr2='cbg666';
                if($total2==0){$totClr1='cbg88';$totClr2='cbg888';}
                if($total2<0){$totClr1='cbg55';$totClr2='cbg555';}
                $out.='<tr>					
					<td class="f1 B '.$totClr2.'" colspan="2">'.k_net.'</td>';
                    if($pay_type!=0){$out.='<td colspan="2" class="f1 '.$totClr2.'"></td>';}
					$out.='<td class="fs18 ff B '.$totClr1.' "><ff class="clrw">'.number_format($total2).'</ff></td>';
					
					$out.='</tr>';
            }
            $out.='</table>';
		}        
        $out.='</div>';
        $out.=visStaPayFot($vis,$mood,$total2,$pay_type,$editable);
	}
    if($rows==0 || $status>0){
        delTempOpr($mood,$vis,'a');        
		$out.= script("closeRecWin();");
    }
	return $out;
}
function lab_ticket($r){
	global $lg,$anStatus,$srvXTables,$srvTables;	
	$mood=2;
	$out='';
    $srvTable=$srvXTables[$mood];
    $srvMTable=$srvTables[$mood];
	if($r['r']){		
        $vis=$r['id'];
		$patient=$r['patient'];
		$clinic=$r['clinic'];
		$type=$r['type'];
		$doctor=$r['doctor'];
		$dts_id=$r['dts_id'];
		$pay_type=$r['pay_type'];
		$d_start=$r['d_start'];	
		$vis_status=$r['status'];
        $pat=$r['patient'];
		$sub_status=$r['sub_status'];		
		if($vis_status==1 && _set_9iaut3jze){
            $bupOffer=array();        
            $offersAv=offersList($mood,$pat);        
            $offerSrv=getSrvOffers($mood,$pat);
        }	        
        $visChanges=getTotalCo($srvTable,"visit_id='$vis' and status IN(2,4)");
		$out.='<div class="fl w100 ofx so pd10 " >';	
		$sql="select * from $srvTable where visit_id='$vis' order by id ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
            if($pay_type==1){
                $gm_note=get_val_con('gnr_x_exemption_notes','note'," vis='$vis' and mood='$mood' "); 
                if($gm_note){ $out.='<div class="f1 fs14 lh50 clr5">'.k_management_notes.' : '.$gm_note.'  </div>';}else{$out.='<div class="hh10"></div>';}
            }
            $out.='
			<table width="100%" border="0" type="static" cellspacing="0" cellpadding="4" class="grad_s holdH mg10v" over="0">
                <tr><th>'.k_services.'</th>				
				<th width="80">'.k_price.'</th>';
			if($vis_status==1 && $visChanges){
				$out.='
				<th width="80">'.k_receive.'</th>
				<th width="80">'.k_return.'</th>';
			}
			$out.='</tr>';
			$totalPay=0;
            $totalPrice=0;
            $totalIN=0;
            $totalOut=0;
            while($r=mysql_f($res)){					
                $s_id=$r['id'];
                $service=$r['service'];	list($serviceName,$unit)=get_val($srvMTable,'name_'.$lg.',unit',$service);
				//$srvPriceOrg=$hPart+$dPart;
                $price=$unit*_set_x6kmh3k9mh;                
				$offer=$r['offer'];
                $status=$r['status'];
				$edit_priceTxt='';				
                $pay_net=$r['pay_net'];
				$rev=$r['rev'];
                $price2=$price;
                if(_set_9iaut3jze &&  $status==2 && $pay_net>0){
                    $Nprice=$price;
                    if($bupOffer[0]==3){
                        $offerTxt='<div class="f1 fs12 clr66">'.k_gen_discount.'<ff14>%'.$bupOffer[1].'</ff14></div>';
                        $offerDisPrice=$price2;
                        $Nprice=($price2/100)*(100-$bupOffer[1]);
                    }
                    if($bupOffer[0]==4){
                        $offerTxt='<div class="f1 fs12 clr66">'.k_for_discount.'<ff14>%'.$bupOffer[1].'</ff14></div>';
                        $offerDisPrice=$price2;
                        $Nprice=($price2/100)*(100-$bupOffer[1]);
                    }
                    foreach($offerSrv as $o){			
                        if($o[1]==$s_id ){					
                            if($o[0]==2){
                                $offerTxt='<div class="f1 fs12 clr66">'.k_ser_descount.'<ff14>%'.$o[2].'</ff14></div>';
                                $offerDisPrice=$price2;
                                //$Nprice=($price2/100)*(100-$o[2]);
                                $Nprice=$o[4];
                            }
                            if($o[0]==1){
                                $offerTxt='<div class="f1 fs12 clr55">'.k_patient_bou_ser.'</div>';
                                $Nprice=0;						
                            }
                            $trClr=' cbg666 ';
                        }
                    }
                    $pay_net=$Nprice;
                }
                $showPice=$pay_net;
                $showIN=0;
                $showOut=0;
                if($status==2 || $status==3){
                    $showPice=0;
                    $showIN=$pay_net;
                }else{
                    $totalPrice+=$showPice;
                }
                if($status==4){                    
                    $showOut=$pay_net;
                }
                $totalIN+=$showIN;	
                $totalOut+=$showOut;                
				
				$msg='';                
				if($rev && $pay_net==0){$msg='<div class="f1 clr5"> ( '.k_review.' )</div>';}
                
                $out.= '<tr>					
                <td class="f1 fs14">'.$serviceName.$status.'<div class="clr5 f1">'.$anStatus[$status].'  '.$msg.'</div></td>';
				$out.='<td><ff>'.number_format($showPice).'</ff></td>';
				if($vis_status==1 && $visChanges){
					$insurS='-';
					$cancelServ='';
                    $incPerc='';                    
					$out.= '
                    <td><ff class="clr6">'.number_format($showIN).'</ff></td>
                    <td><ff class="clr5">'.number_format($showOut).'</ff></td>';
				}
                $out.= '</tr>';
            }
			$totClr1='cbg66';
			$totClr2='cbg666';
			//if($total2==0){$totClr1='cbg88';$totClr2='cbg888';}
            $out.='<tr >					
            <td class="f1 fs14 cbg444" >'.k_total.'</td>
            <td class="cbg888"><ff>'.number_format($totalPrice).'</ff></td>';
            if($vis_status==1 && $visChanges){
                $out.='
                <td class="cbg666"><ff>'.number_format($totalIN).'</ff></td>
                <td class="cbg555"><ff>'.number_format($totalOut).'</ff></td>';
                $totalPay=$totalIN-$totalOut;
            }            
            $out.='</tr>';
            //****/
            $pay_in=get_sum('gnr_x_acc_payments','amount', " mood like '$mood' and vis='$vis' and type IN(1,2)");
            $pay_out=get_sum('gnr_x_acc_payments','amount'," mood like '$mood' and vis='$vis' and type IN(3,4)");
            $payments=$pay_in-$pay_out;
            $totalPay2=$totalPrice-$payments;            
            if($totalPay2){
                $visChanges=1;
                $out.='<tr>
                <td class="f1 fs14 cbg444" >'.k_payms.'</td>                
                <td class="cbg666"><ff>'.number_format($payments).'</ff></td>
                </tr>';
                $out.='<tr>
                <td class="f1 fs14 cbg444" >'.k_pre_blnc.'</td>                
                <td class="cbg555"><ff>'.number_format($totalPay2).'</ff></td>
                </tr>';
            }
            $totalPay+=$totalPay2;
            
            //*************/
            $out.='</table>';
		}
		$out.='</div>'; 
        $out.=visTicketFot($vis,$mood,$vis_status,$totalPay,$visChanges,1,$pay_type);
	}
    return $out;
}
function lab_ticket_cancel($r){
	global $lg,$payArry;	
	$mood=2;
	$out='';
	if($r['r']){		
        $vis=$r['id'];
		$pay_type=$r['pay_type'];
		$vis_status=$r['status'];
		$out.='<div class="fl w100 ofx so pd10 " >';	
		$sql="select * from gnr_x_acc_payments where vis='$vis' and mood='$mood' and type NOT IN(6,9,10) order by date ASC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){            
            $out.='
			<table width="100%" border="0" type="static" cellspacing="0" cellpadding="4" class="grad_s holdH mg10v" over="0">
            <tr><th>'.k_paym_type.'</th>				
            <th width="80">'.k_receive.'</th>
            <th width="80">'.k_return.'</th>
            </tr>';
			            
            $totalIN=0;
            $totalOut=0;
            while($r=mysql_f($res)){
                $payType=$r['type'];
				$amount=$r['amount'];
                $showIN=$showOut=0;
                if(in_array($payType,array(1,2,5,7))){
                    $showIN=$amount;
                }elseif(in_array($payType,array(3,4,8))){
                    $showOut=$amount;
                }
                $totalIN+=$showIN;	
                $totalOut+=$showOut;                
				
                $out.= '<tr>					
                <td class="f1 fs12">'.$payArry[$payType].'</td>				
				<td><ff class="clr6">'.number_format($showIN).'</ff></td>
                <td><ff class="clr5">'.number_format($showOut).'</ff></td>
                </tr>';
            }
			$totClr1='cbg66';
			$totClr2='cbg666';
			//if($total2==0){$totClr1='cbg88';$totClr2='cbg888';}
            $out.='<tr >					
            <td class="f1 fs14 cbg444" >'.k_total.'</td>
            <td class="cbg666"><ff>'.number_format($totalIN).'</ff></td>
            <td class="cbg555"><ff>'.number_format($totalOut).'</ff></td>
            </tr>
            </table>';
            $totalPay=$totalIN-$totalOut;
		}
		$out.='</div>'; 
        $out.=visTicketFotCancel($vis,$mood,$totalPay);
	}
    return $out;
}
?>