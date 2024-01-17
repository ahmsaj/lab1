<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);?>
	<div class="win_body">
	<div class="form_header so lh40 clr1 f1 fs18"></div>
	<div class="form_body so"><?
	$sql="select * from gnr_x_insurance_rec where id='$id' ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){?>
		<?		
		while($r=mysql_f($res)){
			$c_id=$r['company'];
			$insur_no=$r['insur_no'];
			$patient=$r['patient'];
			$doc=$r['doc'];
			$mood=$r['mood'];
			$visit=$r['visit'];
			$service_x=$r['service_x'];
			$service=$r['service'];
			$price=$r['price'];
			$in_price=$r['in_price'];
			$in_price_includ=$r['in_price_includ'];
			$in_cost=$r['in_cost'];
			$s_date=$r['s_date'];
			$r_date=$r['r_date'];
			$user=$r['user'];
			$res_status=$r['res_status'];
			$ref_no=$r['ref_no'];
			$company=$r['company'];
			$userName=get_val('_users','name_'.$lg,$user);
			$docName=get_val('_users','name_'.$lg,$doc);
			if($mood==1){$serName=get_val('cln_m_services','name_'.$lg,$service);}
			if($mood==2){$serName=get_val('lab_m_services','name_'.$lg,$service);}
			if($mood==3){$serName=get_val('xry_m_services','name_'.$lg,$service);}
			if($mood==4){$serName=get_val('den_m_services','name_'.$lg,$service);}
			if($mood==5){$serName=get_val('bty_m_services','name_'.$lg,$service);}
			$all_pi+=$in_price;
			$all_pii+=$in_price_includ;
			$prisX=0;
			if($res_status==1){
				$prisX=$in_price-$in_price_includ;
				$all_pix+=$prisX;
			}
			echo '
			<table width="100%" border="0" cellspacing="0" cellpadding="0" class="grad_s " type="static">
			<tr><td txt >'.k_patient.'</td><td txt>'.get_p_name($patient).'</td></tr>
			<tr><td txt>'.k_insurance_no.'</td><td txt >'.get_val('gnr_m_insurance_prov','name_'.$lg,$company).'<br><ff>'.$insur_no.'</ff></td></tr>			
			<tr><td txt>'.k_doctor.'</td><td txt>'.$docName.'</td></tr>					
			<tr><td txt>'.k_department.'</td><td txt>'.$clinicTypes[$mood].'</td></tr>
			<tr><td txt>'.k_thvisit.'</td><td><ff>#'.$mood.'-'.$visit.'</ff></td></tr>
			<tr><td txt>'.k_service.'</td><td txt>'.$serName.'</td></tr>
			<tr><td txt>'.k_inpt.'</td><td txt>'.$userName.'</td></tr>
			<tr><td txt>'.k_price_serv.'</td><td><ff>'.number_format($price).'</ff></td></tr>
			<tr><td txt>'.k_insure_price.'</td><td><ff class="clr1">'.number_format($in_price).'</ff></td></tr>
			<tr><td txt>'.k_includ.'</td><td><ff class="clr6">'.number_format($in_price_includ).'</ff></td></tr>
			<tr><td txt>'.k_uncovered_amount.'</td><td><ff class="clr5">'.number_format($prisX).'</ff></td></tr>
			<tr><td txt>'.k_bill_number.'</td><td><ff>'.$ref_no.'</ff></td></tr>
			<tr><td txt>'.k_status.'</td><td  txt><span class="f1 '.$insurStatusColArr[$res_status].'">'.$reqStatusArr[$res_status].'</span></td></tr>			
			</table>';

			}
		
		}?>
    </div>
    <div class="form_fot fr">
		<? if($thisGrp=='hrwgtql5wk'){?>
		<div class="bu bu_t1 fl" onclick="editInsur(<?=$id?>);"><?=k_edit?></div> 
		<div class="bu bu_t3 fl" onclick="delInsur(<?=$id?>);"><?=k_delete?></div> 
		<? }?>
        <div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>     
    </div>
    </div><?
}?>