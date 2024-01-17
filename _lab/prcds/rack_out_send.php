<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['l'] , $_POST['r'])){
$l=pp($_POST['l']);
$r=pp($_POST['r']);
$sendetOut=get_val('lab_m_racks','out_lab',$r);
if($sendetOut==0){
$x=0;
if(getTotalCO('lab_m_racks'," id='$l'")>0){	
	$out='';
	$sql="select * from lab_x_visits_samlpes where rack='$r_id' order by rack_pos ASC ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$i=0;
		$out.='<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static">';
		$thisP=0;
		$outX=0;
		$x_array=array();
		while($r=mysql_f($res)){			
			$services=$r['services'];			
			$serv=getLinkedAna(2,0,$services,3);
			$cspan=count($serv);
			for($s=0;$s<$cspan;$s++){
				$sss=explode(',',$serv[$s]);
				$price=checkPrice($l,$sss[2]);
				if($price==0 && !in_array($sss[2],$x_array)){
					$x=1;
					array_push($x_array,$sss[2]);
					$out.='<tr><td bgcolor="'.$coll.'">'.$sss[1].'</td></tr>';
				}				
			}	
		}
		$out.='</table>';
	}
}
echo $x.'^';
if($x==0){
	if($rows>0){
		while($r=mysql_f($res)){
			$services=$r['services'];
			$sam_id=$r['id'];
			mysql_q("UPDATE lab_x_visits_samlpes set out_lab='$l' where id='$sam_id' ");
			$sql2="select * from lab_x_visits_services where id IN ($services) ";
			$res2=mysql_q($sql2);
			$rows2=mysql_n($res2);
			if($rows2>0){				
				while($r2=mysql_f($res2)){
					$ser_id=$r2['id'];
					$sample=$r2['sample'];
					$service=$r2['service'];
					$price=checkPrice($l,$service);
					mysql_q("INSERT INTO lab_x_visits_services_outlabs (`id`,`price`,`date_send`) values ('$ser_id','$price','$now')");
				}				
			}		
		}
		mysql_q("UPDATE lab_x_visits_services set out_lab='$l' where id='$ser_id' ");
		mysql_q("UPDATE lab_m_racks set out_lab='$l' where no='$r' ");		
	}
}else{?>
<div class="win_body">
<div class="form_header lh40 f1 fs18 clr5"> <?=k_serv_priced_lab?>  ( <?=get_val('lab_m_external_Labs','name_'.$lg,$l)?> )</div>
<div class="form_body so" ><?=$out?></div>
<div class="form_fot fr">
	<div class="bu bu_t2 fr" onclick="win('close','#m_info4');"><?=k_close?></div></div>
</div>
<? }
}
}?>