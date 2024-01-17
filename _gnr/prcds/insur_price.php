<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] ,$_POST['t'])){
	$id=pp($_POST['id']);
	$type=pp($_POST['t']);
	$clincTxt='';
	if($type==1){
		$cb='h6j2zt4wjp';		list($service,$clinic,$hos_part,$doc_part)=get_val('cln_m_services','name_'.$lg.',clinic,hos_part,doc_part',$id);
		$clincTxt=get_val('gnr_m_clinics','name_'.$lg,$clinic).' - ';
		$defPrice=$hos_part+$doc_part;
	}
	if($type==2){
		$cb='yccbyp432f';
		list($service,$unit)=get_val('lab_m_services','name_'.$lg.',unit',$id);
		$defPrice=$unit*_set_x6kmh3k9mh;
	}
	if($type==3){
		$cb='7cfwe6si6x';		list($service,$clinic,$hos_part,$doc_part)=get_val('xry_m_services','name_'.$lg.',clinic,hos_part,doc_part',$id);
		$clincTxt=get_val('gnr_m_clinics','name_'.$lg,$clinic).' - ';
		$defPrice=$hos_part+$doc_part;
	}
	if($type==4){
		$cb='lt4g8k05py';	list($service,$hos_part,$doc_part)=get_val('den_m_services','name_'.$lg.',hos_part,doc_part',$id);
		$defPrice=$hos_part+$doc_part;
	}
	if($type==7){
		$cb='cfvtpjrnz1';		list($service,$clinic,$hos_part,$doc_part)=get_val('osc_m_services','name_'.$lg.',clinic,hos_part,doc_part',$id);
		$clincTxt=get_val('gnr_m_clinics','name_'.$lg,$clinic).' - ';
		$defPrice=$hos_part+$doc_part;
	}
	$f_price=$defPrice/((100-_set_1foqr1nql3)/100);
	$f_price2=roundNo($f_price,500);?>
	<div class="win_body">
	<div class="form_header so lh40 clr1 f1 fs18"><?=$clinicTypes[$type].' - '.$clincTxt.$service.'<ff> ( '.$defPrice.' )</ff> </div>';?>
	<div class="form_body so"><?
	echo '<div class="f1 fs16 lh40 clr5"> '.k_norm_visit_percent.' : <ff>( '._set_1foqr1nql3.'% ) => '.intval($f_price).' => '.$f_price2.'</ff></div>';
	$saveVals=array();
	$sql="select * from gnr_m_insurance_prices where service='$id' and type='$type' ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$insur=$r['insur'];
			$price=$r['price'];
			$saveVals[$insur]['price']=$price;
		}
	}
	$sql="select * from gnr_m_insurance_prov order by name_$lg ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		echo '<form name="cst" id="cst" action="'.$f_path.'X/gnr_insur_price_save.php" method="post" cb="loadModule(\''.$cb.'\')">
		<input type="hidden" name="id" value="'.$id.'"/>
		<input type="hidden" name="t" value="'.$type.'"/>
		<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" type="static">
		<tr><th>'.k_company.'</th><th width="100">'.k_price.'</th></tr>';
		while($r=mysql_f($res)){
			$insur=$r['id'];
			$name=$r['name_'.$lg];						
			echo '<tr>
				<td class="f1 fs16">'.$name.'</td>
				<td><input type="number" name="p_'.$insur.'" value="'.$saveVals[$insur]['price'].'" /></td>
			</tr>';
		}
		echo '</table></form>';
	}?>
    </div>
    <div class="form_fot fr">
		<div class="bu bu_t3 fl" onclick="sub('cst');"><?=k_save?></div>  
        <div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>     
    </div>
    </div><?
}?>