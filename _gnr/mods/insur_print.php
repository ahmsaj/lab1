<? include("../../__sys/mods/protected.php");?>
<?=header_sec($def_title,'');?>
<div class="centerSideInHeader lh50"></div>
<div class="centerSideIn so">
	<?
	$t1=getTotalCO('cln_m_services','act=1');
	$t2=getTotalCO('lab_m_services','act=1');
    $t3=getTotalCO('xry_m_services','act=1');
	$t4=getTotalCO('den_m_services','act=1');
	$tt=$t1+$t2+$t3+$t4;	
	?>
	<table border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static">
	<tr>
		<th width="200"><?=k_department?></th>		
		<th><?=k_clinics?></th>
		<th><?=k_thlab?></th>
        <th><?=k_xray?></th>
		<th><?=k_thdental?></th>		
		<th><?=k_totla?></th>
	</tr>
	<tr>
		<td txt><?=k_tol_srv?> </td>		
		<td><ff><?=number_format($t1)?></ff></td>
		<td><ff><?=number_format($t2)?></ff></td>
		<td><ff><?=number_format($t3)?></ff></td>
        <td><ff><?=number_format($t4)?></ff></td>
		<td><ff><?=number_format($tt)?></ff></td>		
	</tr>
	<?
	$sql="select * from gnr_m_insurance_prov order by name_$lg ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){		
		while($r=mysql_f($res)){
			$insur=$r['id'];
			$name=$r['name_'.$lg];?>
			<tr>
				<td class="f1 fs16"><?=$name?></td>
				<td>
					<div class="fl ic40 icc1 ic40_print" onclick="printSercInsurList(1,<?=$insur?>,1)"></div>
					<div class="fl ic40 icc4 ic40_excel" onclick="printSercInsurList(1,<?=$insur?>,2)"></div>
				</td>
				<td>
					<div class="fl ic40 icc1 ic40_print" onclick="printSercInsurList(2,<?=$insur?>,1)"></div>
					<div class="fl ic40 icc4 ic40_excel" onclick="printSercInsurList(2,<?=$insur?>,2)"></div>
				</td>
                <td>
					<div class="fl ic40 icc1 ic40_print" onclick="printSercInsurList(3,<?=$insur?>,1)"></div>
					<div class="fl ic40 icc4 ic40_excel" onclick="printSercInsurList(3,<?=$insur?>,2)"></div>
				</td>
				<td>
					<div class="fl ic40 icc1 ic40_print" onclick="printSercInsurList(4,<?=$insur?>,1)"></div>
					<div class="fl ic40 icc4 ic40_excel" onclick="printSercInsurList(4,<?=$insur?>,2)"></div>
				</td>
				<td class="f1 fs16"></td>				
			</tr><?
		}		
	}?>
	
	</table>
</div>
<?
//genInsPrices();
function genInsPrices(){
	//mysql_q("TRUNCATE `gnr_m_insurance_prices`");
	$insurCompanies=array(5);
	$sql="select * from gnr_m_insurance_prov ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	//if($rows){while($r=mysql_f($res)){array_push($insurCompanies,$r['id']);}}
	/*********************/
	$type=1;
	$sql="select * from cln_m_services where act=1 ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows){
		while($r=mysql_f($res)){
			$s_id=$r['id'];
			$hos_part=$r['hos_part'];
			$doc_part=$r['doc_part'];
			$cat=$r['clinic'];
			$price=$hos_part+$doc_part;
			$f_price=$price/((100-_set_1foqr1nql3)/100);
			$f_price=roundNo($f_price,500);
			foreach($insurCompanies as $c){
				mysql_q("INSERT INTO gnr_m_insurance_prices (`insur`,`type`,`cat`,`service`,`price`)
				values('$c','$type','$cat','$s_id','$f_price')");
			}
		}	
	}
	/**********************/
	$type=2;
	$sql="select * from lab_m_services where act=1 ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows){
		while($r=mysql_f($res)){
			$s_id=$r['id'];
			$cat=$r['cat'];
			$unit=$r['unit'];
			$price=$unit*_set_x6kmh3k9mh;
			$f_price=$price/((100-_set_1foqr1nql3)/100);
			$f_price=roundNo($f_price,500);
			foreach($insurCompanies as $c){
				mysql_q("INSERT INTO gnr_m_insurance_prices (`insur`,`type`,`cat`,`service`,`price`)
				values('$c','$type','$cat','$s_id','$f_price')");
			}
		}
	}
	/**********************/
	$type=4;
	$sql="select * from den_m_services where act=1 ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows){
		while($r=mysql_f($res)){
			$s_id=$r['id'];
			$cat=$r['cat'];
			$hos_part=$r['hos_part'];
			$doc_part=$r['doc_part'];
			$price=$hos_part+$doc_part;			
			$f_price=$price/((100-_set_1foqr1nql3)/100);
			$f_price=roundNo($f_price,500);
			foreach($insurCompanies as $c){
				mysql_q("INSERT INTO gnr_m_insurance_prices (`insur`,`type`,`cat`,`service`,`price`)
				values('$c','$type','$cat','$s_id','$f_price')");
			}
		}		
	}
	/**********************/
	$type=3;
	$sql="select * from xry_m_services where act=1 ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows){
		while($r=mysql_f($res)){
			$s_id=$r['id'];
			$cat=$r['cat'];
			$hos_part=$r['hos_part'];
			$doc_part=$r['doc_part'];
			$price=$hos_part+$doc_part;			
			$f_price=$price/((100-_set_1foqr1nql3)/100);
			$f_price=roundNo($f_price,500);
			foreach($insurCompanies as $c){
				mysql_q("INSERT INTO gnr_m_insurance_prices (`insur`,`type`,`cat`,`service`,`price`)
				values('$c','$type','$cat','$s_id','$f_price')");
			}
		}		
	}	
}

//genInsPricesFromTo(3,5);
function genInsPricesFromTo($from,$to){
    echo getTotalCo('gnr_m_insurance_prices',"insur=$to");
    if(getTotalCo('gnr_m_insurance_prices',"insur=$to")==0){
        $sql="select * from gnr_m_insurance_prices where insur='$from' ";
        $res=mysql_q($sql);
        $rows=mysql_n($res);
        if($rows){
            while($r=mysql_f($res)){            
                echo $type=$r['type'];
                $cat=$r['cat'];
                $clinic=$r['clinic'];
                $service=$r['service'];
                $price=$r['price'];
                mysql_q("INSERT INTO gnr_m_insurance_prices (`insur`,`type`,`cat`,`service`,`price`)
                values('$to','$type','$cat','$service','$price')");			
            }
        }
    }
}
?>
<script>//sezPage='';$(document).ready(function(e){f(1);});</script>