<?
//-------------prescription------------
function presc_set_not_exist_drug($drug,$isExist){
	if(!$isExist){
		$sql="INSERT INTO `gnr_x_prescription_x_medic`(`medic`) VALUES ('$drug')";
	}else{
		$sql="delete from `gnr_x_prescription_x_medic` where medic='$drug'";
	}
	if(mysql_q($sql)){return 1;}
	return 0;
}

function presc_set_price($drug,$price){
	$sql="update gnr_m_medicines set price='$price' where id='$drug'";
	if(mysql_q($sql))return 1;
	return 0;
}

function presc_printed_page($p_sex_word1,$id,$p_id,$thisCode,$doc,$v_id,$p_note){
	global $f_path,$lg;
	$address=_info_477lvyxqhi;//f
	$mailBox=_info_sozi33uok5;//nf
	$fax=_info_1gw3l8c7m3;//nf
	$website=_info_npjhwjnbsh;//nf
	$email=_info_lktpmrxb64;//nf
	$phone=_info_r9a7vy4d6n;///f
	$head_ph=_set_f4uxc868xc;///nf
	$patient_name=get_p_name($p_id);
	$res=presc_getMdcList($id);
	$prescs=$res['out'];
	$rows=$res['rows'];
	$info_doc=presc_info_doctor($doc);
	
	//print_r($rows);
	//print_r($prescs);
	$max=0; $sheetTxt=[]; $sheetNum=0;
	$sheetTxt[0]='';
	for($i=1;$i<=count($prescs);$i++){
		if(($max+$rows[$i])<=24){
			$sheetTxt[$sheetNum].=$prescs[$i];
			$max+=$rows[$i];
		}else{
			//echo $sheetNum.':'.$max.' <br>----<br> ';
			$max=$rows[$i]; $sheetNum++;
			$sheetTxt[$sheetNum]=$prescs[$i];
		}
		//if($sheetNum==5){echo '<br>'.$i.'->'.$rows[$i].'-<br>';}
	}

	$out=''; 
	//$photo=viewImage($head_ph,1,550,140,'img',0);
	foreach($sheetTxt as $sheet){
		$diagnosis=get_vals('cln_x_prv_diagnosis','opr_id',"visit=$v_id");
		if($diagnosis){
			$diagTxt=get_vals('cln_m_prv_diagnosis','name_'.$lg,"id in ($diagnosis)");
		}
		$out.='
			<div class="p_header2_presc ">&nbsp;</div>
			<div class="info11_presc">
				<div class="v_num2 fr2 ff">36-'.convTolongNo($id,5).'</div>
				<div class="fr2 pat_name" style="width:240px;" dir="rtl">	                       
					<div class="i12">'.$p_sex_word1.getPatAge($p_id).'</div>
					<div class="i13 fff">'.$patient_name.'</div>
				</div>
				<div class="fl2 baarcode34" fix="w:20"><img src="'.$f_path.'bc/'.$thisCode.'"/></div>
				<div class="fl2 p_date ff B">'.date('Y-n-j').'</div>
			</div>';
			if($diagnosis){
				$out.='<div class="info22_presc" dir="rtl">
					<div class="fr2 fs14 f1 mg10">'.k_diag.':</div>
					<div in class="fr2 fs14" >'.$diagTxt.'</div>
				</div>';
			}
			$out.='<div class="p_body_presc ">
				<div style="padding-top:0.1cm">
					<table width="100%" cellspacing="4">'.$sheet.'</table>
				</div>';
				if($p_note){
					$out.='<div in class="fr2 fs14 pd10v lh30" >'.nl2br($p_note).'</div>';
				}
				$out.='<div class="lh40 w100 ">&nbsp;</div>
				<div class="fl2 fs14 f1 lh10 pd20f TC mg10v">
					'.$info_doc['name'].'<br>'.
					 '<span class="f1 fs12 TC" dir="rtl">'.nl2br($info_doc['specialization']).'</span><br>'.
					 '<ff class="fs12 TC">'.$info_doc['mobile'].'</ff>
				</div>
			</div>';
			if(_set_rsl9opwx0x){
				$footData=array();
				array_push($footData,_info_7dvjz4qg9g);
				if($address){array_push($footData,k_address.': '.$address);}
				if($mailBox){array_push($footData,k_mailbox.': '.$mailBox);}
				if($phone){array_push($footData,k_phone.': '.$phone);} 
				if($fax){array_push($footData,k_fax.': '.$fax);}
				if($email){array_push($footData,k_email.': '.$email);}
				if($website){array_push($footData,k_website.': '.$website);}
				$out.='<div class="p_footer_presc cb fs14 TC lh20 fs14" sheet_foot >
				'.implode(' - ',$footData).'</div>';					
			}
	}
	return $out;
}

function presc_getMdcList($presc){
	global $lg;
	$out=[]; $rows=[];	
	$sql="select 
				m.id as mad_id , 
				m.name as name , 
				m.type as type , 
				x.dose as dose, 				
				x.dose_s as dose_s, 
				x.num as num, 
				x.duration as dur, 
				m.cat as cat,
				x.presc_quantity as quantity, m.price as price ,x.note as note
				from `gnr_x_prescription_itemes` as x inner join gnr_m_medicines as m on x.mad_id = m.id where x.presc_id='$presc' group by x.mad_id";
	$res=mysql_q($sql);
	$r=mysql_n($res);
	$i=1;
	$presc_note=get_val('gnr_x_prescription','note',$presc);
	if($r>0){
		while($r=mysql_f($res)){
			$addWay=k_dosage;
			$id=$r['mad_id'];
			$name=$r['name'];
			$dose=$r['dose'];
			$dose_s=$r['dose_s'];
			$note=$r['note'];
			$quantity=$r['quantity'];
			$num=$r['num'];
			$duration=$r['dur'];	
			$size_name=$size_mdesDet=$size_note=0;
			$status=get_val_con('gnr_x_prescription_itemes','status',"pres='$presc' and medic='$id'");
			$dose_t=$num_t=$duration_t=$dose_sName=$quantityTxt='';$mark='&nbsp';
			if($dose){$dose_t=get_val('gnr_m_medicines_doses','name_ar',$dose);}
			if($dose_s && $dose_s!=''){
				$dose_sName=get_val('gnr_m_medicines_doses_status','name_ar',$dose_s);
			}
			if($num){$num_t=get_val('gnr_m_medicines_times','name_ar',$num);}
			if($quantity && $quantity!=''){ $quantityTxt=" ( ".k_nums." $quantity ) ";}
			if($duration){
				$duration_t=get_val('gnr_m_medicines_duration','name_ar',$duration);
			}
			if($status==1){$mark='&#10004;';}
			$mdesDet=$dose_t;
			$noteTxt='';
			$b_bord1='b_bord_e'; $b_bord2='';
			$pd1='style="padding-bottom:10px;"'; $pd2='';
			if($num_t){
				if($mdesDet){$mdesDet.=' | ';}
				$mdesDet.=$num_t;
			}
			if($dose_s && $dose_sName!=''){
				if($mdesDet){$mdesDet.=' | ';}
				$mdesDet.=$dose_sName;
			}
			if($duration_t){
				if($mdesDet){$mdesDet.=' | ';}
				$mdesDet.=k_for.': '.$duration_t;
			}
			if($note && $note!=''){
				$size_note=count(str_split_unicode(trim($note),'utf-8'));
				$noteTxt.='<div class="">'.$note.'</div>';
			}
			if($mdesDet && $mdesDet!=''){
				$size_mdesDet=count(str_split_unicode(trim($mdesDet),'utf-8'));
				$mdesDet='<div dir="rtl">'.$mdesDet.'</div>';
			}
			if(($mdesDet && $mdesDet!='')||($noteTxt && $noteTxt!='') ){
				
				$mdesDet=$mdesDet.$noteTxt;
				$b_bord2='b_bord_e'; $b_bord1='';
				$pd2='style="padding-bottom:10px;"'; $pd1='';
				$mdesDet='
				<tr>
					<td></td>
					<td  class="fs12 clr7 '.$b_bord2.'" '.$pd2.'>
						<bdi>'.$mdesDet.'</bdi>
					</td>
				</tr>';
			}
			$size_name=count(str_split_unicode(trim("$mark $i - $name $quantityTxt"),'utf-8'));
			$out[$i]='
				<tr>
					<td class="fs20 clr55">'.$mark.'</td>
					<td class="'.$b_bord1.'" '.$pd1.'>
						<ff class="fl2">'.$i.' - </ff>
						<div class="fl2" style="font-size:16px;">'.$name.'</div>
						<div class="fs30 fl2 lh20 pd10"> '.$quantityTxt.' </div>
					</td>
				</tr>'.$mdesDet;
			$rowName=ceil($size_name/68);
			$rowMdes=ceil($size_mdesDet/68);
			$rowNote=ceil($size_note/68);
			$rows[$i]=$rowName+$rowMdes+$rowNote+1;
			/*if($i==26){
				echo $rowName; echo '-';
				echo $rowMdes; echo '-';
				echo $rowNote; echo '<br>';
			}*/
			$i++;
		}	
		
	}
	//$presc_note=get_val('cln_x_visits','presc_note',$v_id);
	if($presc_note && $presc_note!=''){
		$size_presc_note=count(str_split_unicode(trim($presc_note),'utf-8'));
		$rows[$i]=ceil($size_presc_note/68)+2;
		$out[$i]='
			<tr><td colspan="2"></td></tr>
			<tr dir="rtl">
				<td colspan="2" class="fs14x f1 cbg777 pd10" >'.k_note_doctor.':</td>
			</tr>
			<tr dir="rtl">
				<td colspan="2"  class="fs12 pd10">
					'.$presc_note.'
				</td>
			</tr>';
	}
	$res=['rows'=>$rows,'out'=>$out];
	return $res;
}

function str_split_unicode($str, $l = 0) {
    if ($l > 0) {
        $ret = array();
        $len = str_split_unicode($str, "UTF-8");
        for ($i = 0; $i < $len; $i += $l) {
            $ret[] = mb_substr($str, $i, $l, "UTF-8");
        }
        return $ret;
    }
    return preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
}

function presc_alter_view($drug,$origin_drug,$presc,$js){
	$out='';
	global $presc_statusTxt,$lg;
	$quantity=0; 
	//$visit=get_val('gnr_x_prescription','visit',$presc);
	$rec_origin_drug=getRecCon("gnr_x_prescription_itemes","mad_id='$origin_drug' and presc_id='$presc'");
	if($rec_origin_drug['r']){
		$quantity=$rec_origin_drug['presc_quantity'];
	}
	$sql="select * from gnr_m_medicines  where  id='$drug' order by name ASC";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows==1){
		$rr=mysql_f($res);
		$name=$rr['name'];
		$cat=$rr['cat'];
		$price=$rr['price'];
		$note=$rr['note'];
		$type=$rr['type'];
		$noteTxt=$evn_altr='';
		if($note && $note!=''){$noteTxt=''.$note.'';}
		$req_quantity=$exchanged_main=$exchanged_altr=$exchanged_all=0; $input='';

		$rec_items=getRecCon('gnr_x_prescription_itemes',"mad_id='$drug' and presc_id='$presc'","order by id desc");
		$s_item=$exchanged_quantity=0; 
		if($rec_items['r']){ 
			$s_item=$rec_items['status'];
			//المصروف
			$sum_res=mysql_q("select sum(req_quantity)as s from gnr_x_prescription_itemes where mad_id='$drug' and presc_id='$presc'");
			$exchanged_altr=mysql_f($sum_res)['s'];//المصروف من البديل
			
			$sum_res=mysql_q("select sum(req_quantity)as s from gnr_x_prescription_itemes where  mad_id='$origin_drug' and presc_id='$presc'");
			$exchanged_main=mysql_f($sum_res)['s'];//المصروف من الاساسي
			$exchanged_all=$exchanged_altr+$exchanged_main;
		}
		
		//المطلوب
		$t=$quantity-$exchanged_all;
		$req_quantity=($t>0)?$t:1;
		

		$exist_status=get_val_con('gnr_x_prescription_x_medic','id',"medic='$drug'");
		if($exist_status){//الدواء غير موجود
			$exist_status=0; $act="not_active"; $ch=$cbg=''; 
		}else{//الدواء موجود
			$exist_status=1; $comp=0;$act='';$ch='checked';$cbg='cbg44';
			if($exchanged_all>=$quantity){
				$comp='1'; $ch=''; $clr='clr5'; $cbg='cbg_pink'; 
			}
			//$input='<input type="hidden" name="alters['.$origin_drug.']" value="'.$drug.'" />';

		}

		$typeName=get_val('gnr_m_medicines_doses_type','name_'.$lg,$type);

		$out='<tr class="'.$act.' '.$cbg.'" complete="'.$comp.'" origin="'.$origin_drug.'" child   '.$js.'>
			<td width="40">
				<div class="ic40  arrow_symbol" >	</div>
			</td>
			<td ch width="40">
				<input name="sel[]" type="checkbox" par="grd_chek" value="'.$drug.'" '.$ch.' />
			</td>
			<td colspan="1">
				<div class="clr55">
					<span class="lh10 fs14" >'.$name.'</span>
					-
					<span class="lh20 fs14 pd10" dir="ltr" >'.$typeName.'</span>
				</div>
				<div class="lh10 fs10 cb">'.$noteTxt.'</div>
			</td>
			<td><span class="fs20 clr55">&#8593;</span></td>
			<td><span class="fs20 clr55">&#8593;</span></td>
			<td><ff class="'.$clr.'">'.$exchanged_altr.'</ff></td>
			<td req_qantity>
				<input type="number" name="req_quantity['.$drug.']" class="lh50" req_qantity value="'.$req_quantity.'" />
			</td>
			<td class="Over " edit>
				<input fix="wp:40" type="number" presc_price class="hide no_event lh50" r="'.$drug.'" value="'.$price.'" />
				<ff presc_price>'.$price.'</ff>

				<div id="presc_edit" class="fl ic_edit_tit lh50" onclick="presc_price_edit(this)" title="'.k_edit_price.'"></div>
			</td>
			<td>
				'.makeSwitch('exist_drug',$drug,$exist_status,1).'
			</td>
			<td><div class="ic40 icc2 ic40_del" title="'.k_delete.'" onclick="presc_del_altr(this,'.$origin_drug.')"></div>
			</td>
			
		</tr>';
	}
	return $out;
}

function presc_sum_sql($table,$field,$co){
	//echo "select sum($field)as s from $table $co";
	$sum_res=mysql_q("select sum($field)as s from $table $co");
	return mysql_f($sum_res)['s'];
}

function presc_data_reports($start,$end){
	$sql="select sum(quantity)as presc_co from cln_x_medicines where visit in (select id from cln_x_visits where d_start>='$start' and d_start<'$end')";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	$myData=[];
	if($rows){
		$myData['presc_co']=0;
		if($r=mysql_f($res)){
			$presc_co=$r['presc_co'];
			if($presc_co){$myData['presc_co']=$presc_co;}
		}
		
	}
	//echo "<br>";
	$sql="select sum(req_quantity)as ex_co,sum(presc_quantity)as presc_co,status from cln_x_prescription_items where date>='$start' and date<='$end' group by status";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	$myData['exchange_co']['v']=$myData['notExist_co']['v']=0;
	if($rows){
		while($r=mysql_f($res)){
			$status=$r['status'];
			$ex_co=$r['ex_co'];
			$presc_co=$r['presc_co'];
			if($ex_co){ $myData['exchange_co']['v']+=$ex_co;}
			if($status==4){
				if($presc_co){
					$myData['notExist_co']['v']+=$presc_co-$ex_co;
				}
			}			
		}
	}
	
	if(!$myData['exchange_co']['v']&&!$myData['notExist_co']['v']&&!$myData['presc_co']){
		$myData=[];
	}else{
		$myData['not_exchange_co']['v']=$myData['presc_co']-$myData['exchange_co']['v'];
		if($myData['presc_co']){
			$t1=$myData['not_exchange_co']['v']*100/$myData['presc_co'];
			$t2=$myData['exchange_co']['v']*100/$myData['presc_co'];
			$t3=$myData['notExist_co']['v']*100/$myData['presc_co'];
			
			$myData['not_exchange_co']['per']=number_format($t1,2);
			$myData['exchange_co']['per']=number_format($t2,2);
			$myData['notExist_co']['per']=number_format($t3,2);
		}
	}
	return $myData;
}

function presc_data_sync($start=0,$end=0){
	global $lg;
	$myData=[];
	$sql="select sum(c1.req_quantity)as ex_co,c1.presc_quantity as presc_co,c1.mad_id as medic,c1.status as status,c2.price as price ,count(c1.altr) as altr_co, group_concat(altr) as altrs from gnr_x_prescription_itemes as c1 inner join gnr_m_medicines as c2 on c2.id=c1.mad_id  where c1.process_date>='$start' and c1.process_date<='$end' group by c1.mad_id,c1.presc_id,c1.status";

	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows){
		while($r=mysql_f($res)){
			$drug=$r['medic'];
			$status=$r['status'];
			$ex_co=$r['ex_co'];
			$presc_co=$r['presc_co'];
			$price=$r['price'];
			$altr_co=$r['altr_co'];
			$altrs=$r['altrs'];
			$pres=$r['pres'];
			if($altr_co>0){
				$test='';
				if(isset($myData[$drug]['altrs'])){
					$test=$myData[$drug]['altrs'];
				}
				if($test!=''){$test.=',';}
				$test.=$altrs;
				$myData[$drug]['altrs']=presc_string_unique($test);
			}
			//price 
			$myData[$drug]['price']=$price;
			//descripred
			if(isset($myData[$drug]['presc_co'])){
				$myData[$drug]['presc_co']+=$presc_co;
			}else{
				$myData[$drug]['presc_co']=$presc_co;
			}
			//exchanged
			if($ex_co){ 
				if(isset($myData[$drug]['exchange_co']['v'])){
					$myData[$drug]['exchange_co']['v']+=$ex_co;
				}else{
					$myData[$drug]['exchange_co']['v']=$ex_co;
				}
				
			}
			//not exist
			if($status==4 && $presc_co){
				if(isset($myData[$drug]['notExist_co']['v'])){
					$myData[$drug]['notExist_co']['v']+=$presc_co-$ex_co;
				}else{
					$myData[$drug]['notExist_co']['v']=$presc_co-$ex_co;
				}
			}	
			
			//not exchanged
			if(isset($myData[$drug]['presc_co'])){
				$myData[$drug]['not_exchange_co']['v']=$myData[$drug]['presc_co'];
			}
			if(isset($myData[$drug]['exchange_co']['v'])){
				$myData[$drug]['not_exchange_co']['v']-=$myData[$drug]['exchange_co']['v'];
			}
			if(isset($myData[$drug]['notExist_co']['v'])){
				$myData[$drug]['not_exchange_co']['v']-=$myData[$drug]['notExist_co']['v'];
			}
			//----------------------
			if((!$myData[$drug]['exchange_co']['v']&&!$myData[$drug]['notExist_co']['v'])&&!$myData[$drug]['presc_co']){
				unset($myData[$drug]); 
			}
	
		}
	}
	
	
$sql=
	"select sum(item.presc_quantity)as presc_co,item.mad_id as mad_id,med.name_$lg as name,med.price as price from
	gnr_x_prescription_itemes as item
	inner join
	gnr_x_prescription as presc
	on ((item.presc=presc.id) and (presc.date >='$start' and presc.date<'$end') and (presc.done!=1))
	inner join
	gnr_m_medicines as med
	on (item.mad_id=med.id )
	group by item.mad_id";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	
	if($rows){
		echo "0000";
		while($r=mysql_f($res)){
			$presc_co=$r['presc_co'];
			$drug=$r['mad_id'];
			$price=$r['price'];
			$myData[$drug]['price']=$price;
			if(isset($myData[$drug]['presc_co'])){
				$myData[$drug]['presc_co']+=$presc_co;	
			}else{ $myData[$drug]['presc_co']=$presc_co;}
			
			if(isset($myData[$drug]['not_exchange_co']['v'])){
				$myData[$drug]['not_exchange_co']['v']+=$presc_co; 
			}else{ $myData[$drug]['not_exchange_co']['v']=$presc_co; }
		}
	}
	return($myData);

}
function presc_data_financial_reports($start,$end){
	$co='';
	$min_max=" ,min(date) as min_d , max(date) as max_d ";
	if($start && $end){$co="where date>='$start' and date<'$end'"; $min_max='';}
	$sql="select sum(prescribed_quant*price) as presc_price, sum(exchanged_quant*price)as ex_price,sum(not_exist_quant*price)as notExist_price,sum(not_exchanged_quant*price)as notEx_price $min_max from phr_m_presc_sync $co";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	$dayData=mysql_f($res);
	if($dayData['presc_price']||$dayData['ex_price']||$dayData['notEx_price']||$dayData['notExist_price']){
		if($dayData['presc_price']){
			$t1=$dayData['ex_price']*100/$dayData['presc_price'];
			$t2=$dayData['notExist_price']*100/$dayData['presc_price'];
			$t3=$dayData['notEx_price']*100/$dayData['presc_price'];
			
			$dayData['profit_per']=number_format($t1,2);
			$dayData['loss_notExist_per']=number_format($t2,2);
			$dayData['loss_notEx_per']=number_format($t3,2);
		}
		return $dayData;
	}
	return 0;
}
function presc_data_statistical_reports($start,$end){
	$co='';
	$min_max=" ,min(date) as min_d , max(date) as max_d ";
	if($start && $end){$co="where date>='$start' and date<'$end'"; $min_max='';}
	$sql="select sum(`prescribed_quant`)as presc_co, sum(`exchanged_quant`)as ex_co, sum(`not_exchanged_quant`) as notEx_co, sum(`not_exist_quant`)as notExist_co $min_max from phr_m_presc_sync $co";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	$dayData=mysql_f($res);
	if($dayData['presc_co']||$dayData['ex_co']||$dayData['notEx_co']||$dayData['notExist_co']){
		if($dayData['presc_co']){
			$t1=$dayData['notEx_co']*100/$dayData['presc_co'];
			$t2=$dayData['ex_co']*100/$dayData['presc_co'];
			$t3=$dayData['notExist_co']*100/$dayData['presc_co'];
			
			$dayData['notEx_per']=number_format($t1,2);
			$dayData['ex_per']=number_format($t2,2);
			$dayData['notExist_per']=number_format($t3,2);
		}
		return $dayData;
	}
	return 0;
}
function presc_data_drugs_reports($start,$end){
	$co='';
	$dayData=[];
	$min_max=" ,min(date) as min_d , max(date) as max_d ";
	if($start && $end){$co="where date>='$start' and date<'$end'"; $min_max='';}
	$sql="select sum(`prescribed_quant`)as presc_co, sum(`exchanged_quant`)as ex_co, sum(`not_exchanged_quant`) as notEx_co, sum(`not_exist_quant`)as notExist_co ,drug $min_max from phr_m_presc_sync $co group by drug";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows){
		while($r=mysql_f($res)){
			$drug=$r['drug'];
			if($r['presc_co']||$r['ex_co']||$r['notEx_co']||$r['notExist_co']){
				if($r['presc_co']){
					$t1=$r['notEx_co']*100/$r['presc_co'];
					$t2=$r['ex_co']*100/$r['presc_co'];
					$t3=$r['notExist_co']*100/$r['presc_co'];

					$r['notEx_per']=number_format($t1,2);
					$r['ex_per']=number_format($t2,2);
					$r['notExist_per']=number_format($t3,2);
				}
				$dayData[$drug]=$r;
			}
		}
	}
	//print_r($dayData);
	return $dayData;
}
function presc_data_notExistDrugs_reports($start,$end,$all=0){
	$co=$sel_drug='';
	$dayData=[];
	$min_max=" ,min(date) as min_d , max(date) as max_d ";
	if($start && $end){$co="and date>='$start' and date<'$end'"; $min_max='';}
	if(!$all){$sel_drug=' ,`drug` ';}
	$sql="select sum(`prescribed_quant`)as presc_co,sum(`not_exist_quant`)as notExist_co ,group_concat(altrs) as altrs $sel_drug $min_max from phr_m_presc_sync where not_exist_quant>0 $co group by drug";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows){
		while($r=mysql_f($res)){
			if($r['presc_co']||$r['notExist_co']){
				if($r['presc_co']){
					$t3=$r['notExist_co']*100/$r['presc_co'];
					$r['notExist_per']=number_format($t3,2);
				}
				$r['altrs']=presc_string_unique($r['altrs']);
				if($all){
					$dayData=$r;
				}else{
					$drug=$r['drug'];
					$dayData[$drug]=$r;
				}
			}
		}
	}
	return $dayData;
}
function presc_data_season_reports($start,$end){
	$arr=[];
	$sum=[];
	if($start && $end){$co="where date>='$start' and date<'$end'";}
	$sql="select sum(`prescribed_quant`)as presc_co,sum(`not_exist_quant`)as notExist_co, date from phr_m_presc_sync $co  group by date having (max(date)-min(date))<86400";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	while($r=mysql_f($res)){
		if($r['presc_co']||$r['notExist_co']){
			$date=$r['date'];
			$day=intval(date('d',$date));
			$mon=intval(date('m',$date));
			$arr[$day][$mon][0]=intval($r['presc_co']);
			$arr[$day][$mon][1]=intval($r['notExist_co']);
			if($sum[$mon][0]){
				$sum[$mon][0]+=$arr[$day][$mon][0];
			}else{
				$sum[$mon][0]=$arr[$day][$mon][0];
			}
			if($sum[$mon][1]){
				$sum[$mon][1]+=$arr[$day][$mon][1];
			}else{
				$sum[$mon][1]=$arr[$day][$mon][1];
			}
		}
	}
	return [$arr,$sum];
}
function presc_doc_click_func($id){
	$m_r=getRec('cln_m_medicines',$id);
	if(!$m_r['code']){$m_r['code']=0;}
	if(!$m_r['cat']){$m_r['cat']=0;}
	if(!$m_r['dose']){$m_r['dose']=0;}
	if(!$m_r['num']){$m_r['num']=0;}
	if(!$m_r['duration']){$m_r['duration']=0;}
	if(!$m_r['dose_s']){$m_r['dose_s']=0;}
	if(!$m_r['note']){$m_r['note']=0;}
	if(!$m_r['price']){$m_r['price']=0;}
	if(!$m_r['act']){$m_r['act']=0;}
	$edit_click="co_loadForm($id,3,'38tgwuqvh|code|editMdc($id)|code:".$m_r['code'].":hh,cat:".$m_r['cat'].":hh,dose:".$m_r['dose'].":hh,num:".$m_r['num'].":hh,duration:".$m_r['duration'].":hh,dose_s:".$m_r['dose_s'].":hh,note:".$m_r['note'].":hh,price:".$m_r['price'].":hh,act:".$m_r['act'].":hh');";
	
	return $edit_click;
}
function presc_string_unique($test){
	if($test && $test!=''){
		$test2=explode(',',$test);
		$test2=array_unique($test2);
		return implode(',',$test2);
	}
	return '';
}
function presc_get_altrs_view($altrs){
	global $lg;
	$out='';
	$sql="select name_$lg from cln_m_medicines where id in ($altrs)";
	$res=mysql_q($sql);
	while($r=mysql_f($res)){
		$altr_name=SplitNo($r['name_'.$lg]);
		$out.='<div class="fs14 clr6 lh20">'.$altr_name.'</div>';
	}
	$out='<div class="so ofx TC" style="padding:5px; max-height:100px; ">'.$out.'</div>';
	return $out;
}


?>