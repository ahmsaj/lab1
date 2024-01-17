<? include("../../__sys/prcds/ajax_header.php");
$sql="select count(service) as c,service from lab_x_visits_services  where w_table=0 and status in(5) group by service";
$res=mysql_q($sql);
$rows=mysql_n($res);
$all=0;
$recs='';
if($rows){	
	while($r=mysql_f($res)){
		$c=$r['c'];
		$service=$r['service'];
		list($srvTxt,$addTable)=get_val('lab_m_services','short_name,add_to_table',$service);
		if($addTable){
			$all+=$c;
			$recs.='<div class="fl w100 cbgw bord   lh50 uLine" wt_srv="'.$service.'">
				<div class="fll i30 i30_del mg5f" wt_srvDel></div>
				<div class="ff B fs16x lh40  fll">'.$srvTxt.' <ff class="clr1">('.$c.')</ff></div>
				<div class="frr i30 i30_add mg5f" wt_srvAdd title="'.k_add_ana_table.'"></div>
			</div>';
		}else{
			mysql_q("UPDATE lab_x_visits_services SET w_table='-1' where w_table=0 and status in(5) and service='$service' ");
		}
	}
	echo '( '.$all.' )^'.$recs;
}else{
	echo '^<div class="f1 fs14 clr5">'.k_knowledge_tables.'</div>';
}

?>