<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['status'])){
	$id=pp($_POST['id']);
	$status=pp($_POST['status'],'s');
	if($status=='view'){
		$r=getRec('gnr_x_prescription',$id);
		//print_r($r);
		if($r['r']){
			$date=$r['date'];
			$clinic=$r['clinic'];
			$doc=$r['doc'];
			$visit=$r['visit'];
			$p_note=$r['note'];
			$patient=$r['patient'];
			$status=$r['status'];
			$done=$r['done'];
			$medic=$r['medic'];
			$total_price=0;
			$sql="select 
				m.id as mad_id , m.name as name , m.type as type , 
				x.dose as dose, 
				x.dose_s as dose_s, 
				x.num as num, 
				x.duration as dur, 
				m.cat as cat,
				x.presc_quantity as quantity, m.price as price ,x.note as note
				from `gnr_x_prescription_itemes` as x inner join gnr_m_medicines as m on x.mad_id = m.id where x.presc_id='$id' and m.id not in (select altr from gnr_x_prescription_itemes where presc_id='$id') group by x.mad_id";
			$res=mysql_q($sql);
			$items=mysql_n($res);
			//$items=count(explode(',',$medic));?>
			<div class="win_body" >
			<div class="form_header so"  >
				<div class="ic40  presc_info fl"></div>
				<div class="lh50 f1 fs18 fl pd5" ><?=k_pres_items?>
					<ff class="pd10 clr55 fs20 cbg555" dir="ltr"><?=$items?></ff>
				:</div>
				<div class="lh40 fs18 cbg55 fr clrw TC mg10" dir="ltr" fix="w:100"><ff class="clrw" tot_price></ff> &pound;</div>
			</div>
			<div class="form_body ofx so" type="full">
			<?
			if($items){?>
				<div fix="hp:0" class="ofx so">
					<form id="presc_exchange" name="presc_exchange" method="post" action="<?=$f_path?>X/phr_medical_prescription_info.php" bv="a" cb="presc_callBack_process(<?=$id?>,'[1]')">
						<table id="presc_table" width="100%" class="grad_s" cellpadding="4" cellspacing="4" type="static" over="0">
							<tr>
								<th width="40">
									<input type="checkbox" par="check_all" name="ti_bak" value="on" checked/>
								</th>
								<th colspan="2" ><?=k_medicine?></th>
								<th><?=k_status?></th>
								<th><?=k_presc_quan?></th>
								<th><?=k_quan_spent?></th>
								<th width="80"><?=k_req_quan?></th>
								<th width="150"><?=k_sample_price?></th>
								<th width="40"><?=k_avl?></th>
								<th width="40"><?=k_sub?></th>
							</tr>
					<?
					while($r=mysql_f($res)){
						$id_drug=$r['mad_id'];
						$name=$r['name'];
						$dose=$r['dose'];
						$dose_s=$r['dose_s'];
						$num=$r['num'];
						$duration=$r['dur'];
						$cat=$r['cat'];
						$price=$r['price'];
						$quantity=$r['quantity'];
						$note=$r['note'];
						$type=$r['type'];
						$mdesDet=$dose_t=$num_t=$duration_t=$dose_s_t=$quantityTxt='';$mark='&nbsp';
						if($dose){
							$dose_t=get_val('gnr_m_medicines_doses','name_'.$lg,$dose);
						}
						if($dose_s && $dose_s!=''){
							$dose_s_t=get_val('gnr_m_medicines_doses_status','name_'.$lg,$dose_s);
						}
						if($num){
							$num_t=get_val('gnr_m_medicines_times','name_'.$lg,$num);
						}
						if($quantity && $quantity!=''){
							$quantityTxt=" ( ".k_nums." $quantity ) ";
						}
						if($duration){
							$duration_t=get_val('gnr_m_medicines_duration','name_'.$lg,$duration);
						}
						if($dose && $dose_t!=''){
							if($mdesDet){$mdesDet.=' | ';}$mdesDet.=$dose_t;
						}
						if($num_t){
							if($mdesDet){$mdesDet.=' | ';}$mdesDet.=$num_t;
						}
						if($dose_s && $dose_s_t!=''){
							if($mdesDet){$mdesDet.=' | ';}$mdesDet.=$dose_s_t;
						}
						if($duration_t){
							if($mdesDet){$mdesDet.=' | ';}
							$mdesDet.=k_for.': '.$duration_t;
						}
						if($note && $note!=''){
							$size_note=count(str_split_unicode(trim($note),'utf-8'));
							$noteTxt.='<div class="">'.$note.'</div>';
						}


						$noteTxt=$evn_altr=$statusTxt=$co=$clr=$typeName='';
						$exchanged_quantity=$altr=$exchanged_all=$exchanged_altr=0; 
						$s=2;//لم يصرف
						//$statusTxt=$presc_statusTxt[$s];
						if($note && $note!=''){$noteTxt=''.$note.'';}
						//اخر سطر للدواء الاساسي
						$rec_items=getRecCon('gnr_x_prescription_itemes',"mad_id=$id_drug and presc_id='$id' ORDER BY `altr` DESC");

						if($rec_items['r']){
							$altr=$rec_items['altr'];
							/********حساب الكمية المصروفة من الدواء وبديله********/
							$f='req_quantity'; $t='gnr_x_prescription_itemes';
							//المصروف من الاساسي
							$exchanged_quantity=presc_sum_sql($t,$f,"where mad_id='$id_drug' and presc_id='$id'");
							//المصروف من البديل
							if($altr){	
								$exchanged_altr=presc_sum_sql($t,$f,"where mad_id='$altr' and presc_id='$id'");
								$statusTxt='<br>('.k_with_alt_ex.')';
							}
							//المصروف من البديل والأساسي
							$exchanged_all=$exchanged_quantity+$exchanged_altr;//كل الصرف
							/****تحديد حالة الدواء حسب المصروف من الاساسي و البديل معاً**/
							if($exchanged_all>=$quantity){ $s=1;}
							elseif($exchanged_all!=0){$s=3;}
							//echo "---".$s;
							$statusTxt=$presc_statusTxt[$s].$statusTxt;
						}							

						/*****حساب الكمية المطلوبة المفترضة******/	
						$t=$quantity-$exchanged_all;
						$req_quantity=($t>0)?$t:1; 
						/****/
						//الموصوف
						if(!$quantity || $quantity==''){$quantity='-';}

						if($type && $type!=''){
							$typeName=get_val('gnr_m_medicines_doses_type','name_'.$lg,$type);
						}
						$exist_status=get_val_con('gnr_x_prescription_x_medic','id',"medic='$id_drug'");
						/***تنسيق الستايلات حسب حالة الدواء**/
						if($exist_status){//الدواء غير موجود
							$exist_status=0; $act="not_active"; $ch=$cbg=''; $comp=0;
							$ic_altr="icc1"; 
							$evn_altr="";
						}else{//الدواء موجود
							$exist_status=1; $comp=0;$act='';$ch='checked';$cbg='cbg44'; $ic_altr="cbg4"; $evn_altr="no_event";
							if($s==1){
								$comp='1'; $ch=''; $clr='clr5'; $cbg='cbg_pink'; 
							}


						}
						if($ch=='checked'){$total_price+=($price*$req_quantity);}

					?>
						<tr class="<?=$act?> <?=$cbg?>" complete="<?=$comp?>" old>
							<td ch>
								<input name="sel[]" type="checkbox" par="grd_chek" value="<?=$id_drug?>" <?=$ch?>/>
							</td>
							<td colspan="2"  >
								<div class="clr1 fs16 TL lh30"><?=$name?> (<?=$typeName?>)</div>
								<div class="TL"><?=$mdesDet?></div>
								<? if($noteTxt){echo '<div class="lh20 fs10 clr5 TL">'.$noteTxt.'</div>';}?>
							</td>
							<td><?=$statusTxt?></td>

							<td><ff class="<?=$clr?>"><?=$quantity?></ff></td>
							<td><ff class="<?=$clr?>"><?=$exchanged_quantity?></ff></td>
							<td req_qantity>
								<input type="number" name="req_quantity[<?=$id_drug?>]" class="lh50" req_qantity value="<?=$req_quantity?>"/>
							</td>
							<td class="Over <?=$evn?>" edit>
								<input fix="wp:40" type="number" presc_price class="hide no_event lh50" r="<?=$id_drug?>" value="<?=$price?>"  />
								<ff presc_price><?=$price?></ff>

								<div id="presc_edit" class="fl ic_edit_tit lh50" onclick="presc_price_edit(this)" title="<?=k_edit_price?>"></div>
							</td>
							<td>
								<?=makeSwitch('exist_drug',$id_drug,$exist_status,1)?>
							</td>
							<td class="<?=$evn_altr?>" add_altr>
								<div class="ic40 <?=$ic_altr?> ic40_add" title="<?=k_add_alt?>" onclick="presc_add_alter_view(<?=$id?>,<?=$id_drug?>,this)" id="add_altr<?=$id_drug?>"></div>
							</td>
						</tr>
						<input type="hidden" name="presc_quantity[<?=$id_drug?>]" class="lh50" value="<?=$quantity?>"/>

					<?
						/*****في حال وجود بديل للدواء يتم انشاء سطر له*******/
						if($altr){echo presc_alter_view($altr,$id_drug,$id,'old');}
					}
					?>
					</table>
					<? if($p_note){
						echo '<div class="f1 fs14 clr55 lh30 pd10v">'.nl2br($p_note).'</div>';
					}?>

					<input type="hidden" name="status" value="process_presc"/>
					<input type="hidden" name="id" value="<?=$id?>"/>
					<input type="hidden" name="visit" value="<?=$visit?>"/>
				</form>
				</div>
			<?
			}
			?>
			</div>
			<div class="form_fot fr">
				<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>
				<div>
					<div class="bu bu_t1 fl" onclick="presc_exchange_do()">
						<?=k_proc_req?>
						<div class="fl ic40x ic40_print presc_process" ></div>
					</div>  
				</div>
			</div>
			</div><?
		}else{
			echo '<div class="f1 fs16 clr5 pd10">'.k_no_med.'..</div>';
		}
		echo '^'.$total_price;
	}
	
	elseif($status=='process_presc'){
		$errs=[];
		$prevent_limit_presc=_set_psrin9e5ua;
		$done_presc=1; //تمت معالجة الوصفة 
		$status_presc=1; //الوصفة  صرفت كاملةً
		$ok=1;
		$exchanged_drugs=[];
		if(isset($_POST['id'],$_POST['sel'],$_POST['req_quantity'],$_POST['presc_quantity'])){
			$alters=[];
			if(isset($_POST['alters'])){$alters=$_POST['alters'];}
			//print_r($alters);
			$exchanged_drugs=$_POST['sel'];//الادوية المراد صرفها
			$req_quantities=$_POST['req_quantity'];//الكميات المطلوبة عند الصرف 
			$presc_quantities=$_POST['presc_quantity'];//الكميات المحددة في الوصفة
			//$visit=pp($_POST['visit'],'s');
			$presc=pp($_POST['id']);
			$notExists=get_vals('gnr_x_prescription_x_medic','medic',"1=1");
			$notExists=explode(',',$notExists);
			/********تحديد حالة الأدوية ضمن الوصفة***********/
			$sql="select * from gnr_x_prescription_itemes where presc_id='$id' group by mad_id";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows){
				while($r=mysql_f($res)){
					$id_drug=$r['mad_id'];
					$s_item=$rec_alter=$is_alter=$origin=$id_alter=0;
					$presc_quantity=$presc_quantities[$id_drug];
					$day_ex_quantity=$all_ex_quantity=0;
					mysql_q("update gnr_x_prescription_itemes set process_date='$now' where mad_id='$id_drug' and presc_id='$id' and process_date='' ");
					// ريكورد الصرف من الدواء الاساسي في هذا اليوم
					$rec_items=getRecCon('gnr_x_prescription_itemes',"mad_id=$id_drug and presc_id='$id' and process_date>='$ss_day' and process_date<='$ee_day'");
					//print_r($rec_items);
					if($rec_items['r']){
						$s_item=$rec_items['status'];
						$alter=$rec_items['altr'];
						if($alter){
							$co=" || mad_id='$alter'";
							// ريكورد الصرف من الدواء البديل في هذا اليوم
							$rec_alter=getRecCon('gnr_x_prescription_itemes',"mad_id='$alter' and presc_id='$id' and process_date>='$ss_day' and process_date<='$ee_day'");		
						}
						
					}
					$t='gnr_x_prescription_itemes'; $f='req_quantity'; 					
				
					$status_drug=4;// الدواء غير مووجود 
					if(isset($alters[$id_drug])){//في حال كان مطلوب بديل له
						$id_alter=$alters[$id_drug];
						$is_alter=!in_array($id_alter,$notExists);
					}
					if(!in_array($id_drug,$notExists) || $is_alter){//في حال الدواء أو بديله موجود
						if($is_alter){$origin=$id_drug; $id_drug=$id_alter;}
						$status_drug=2; //الدواء لم يصرف
						if(in_array($id_drug,$exchanged_drugs)){
							/*****تحديد المصروف من الدواء الاساسي والبديل*****/
							//المصروف من الدواء الاساسي أو البديل  في هذا اليوم فقط 
							if($is_alter && $rec_alter['r']){
								$day_ex_quantity=$rec_alter['req_quantity'];
							}elseif($rec_items['r']){
								$day_ex_quantity=$rec_items['req_quantity'];
							}
							$day_ex_quantity+=$req_quantities[$id_drug];
							//المصروف من الدواء الاساسي والبديل في كل الايام
							$all_ex_quantity=presc_sum_sql($t,$f,"where (mad_id='$id_drug' $co) and presc_id='$id'");
							$all_ex_quantity+=$req_quantities[$id_drug];
							/*********تحديد حالة صرف الدواء********/
							if($all_ex_quantity<$presc_quantity){
								$status_drug=3; //الدواء صرف بشكل جزئي
							}else{
								if($prevent_limit_presc && $all_ex_quantity>$presc_quantity){
									array_push($errs,$id_drug);
								}else{
									$status_drug=1; //الدواء صرف بشكل كامل
									$presc_quantity=$all_ex_quantity;
								}
						  }
						}
					}
					/***********تحديد حالة صرف الوصفة**********/
					//في حال هناك دواء لم يصرف أو دواء صرف جزئيا فهذا يعني الوصفة لم تصرف بشكل كامل
					if($status_drug!=1 && $s_item!=1){
						$status_presc=3;//الوصفة صرفت بشكل جزئي
					}
					/*******تخزين البيانات في الداتا بيز*******/
					if(empty($errs)){
						$sql=0;
						//الدواء أو بديله له ريكورد في هذا اليوم
						$done_drug=(!$is_alter && $rec_items['r'])||($is_alter&&$rec_alter['r']);
						$done_presc_prev=get_val_con('gnr_x_prescription_itemes','id',"presc_id ='$id' and mad_id='$id_drug' and process_date<'$ss_day'");// سابق الدواء ليس له ريكورد اليوم و له ريكورد في يوم سابق
						
						if(in_array($id_drug,$exchanged_drugs)){
							if($done_drug){//الدواءاو بديله له ريكورد في هذا اليوم
								$sql="update `gnr_x_prescription_itemes` set `status`='$status_drug',`req_quantity`='$day_ex_quantity',`presc_quantity`='$presc_quantity',process_date='$now' where presc_id ='$id' and mad_id='$id_drug' and process_date>='$ss_day' and process_date<='$ee_day'"; 
							}elseif($done_presc_prev || $is_alter){ //الدواء له ريكورد في يوم سابق فقط أو هو بديل وليس له ريكورد ابدا
								//$insert=1;
								 $sql="INSERT INTO `gnr_x_prescription_itemes`(`presc_id`, `mad_id`, `process_date`, `status`,`req_quantity`,`presc_quantity`) VALUES ('$id','$id_drug','$now','$status_drug','$day_ex_quantity','$presc_quantity')";
							}
						}//elseif(!$done_presc_prev){$first_process=1;}//فقط من أجل أو مرة 
						
						/*if($insert){
							
							$sql="update `gnr_x_prescription_itemes` set `status`='$status_drug',`req_quantity`='$day_ex_quantity',`presc_quantity`='$presc_quantity',`process_date`='$now' where presc_id ='$id' and mad_id='$id_drug'";
						}*/
						if($sql){
							//echo $sql.'<br>';
							if(!mysql_q($sql)){$ok=0; break;}
							else{
								//في حال أخ	 أدوية اكثر مما هو مصروف فيجب تعديل قيمة الادوية الموصوفة في كل الريكوردات المرتبطة لتبقى الاحصائية صحيحة
								mysql_q("update `gnr_x_prescription_itemes` set `presc_quantity`='$presc_quantity' where presc_id ='$id' and (mad_id='$id_drug' $co)");
								if($is_alter){
									$done_origin=get_val_con('gnr_x_prescription_itemes','id',"presc_id ='$id' and mad_id='$origin' and (process_date>='$ss_day' and process_date<='$ee_day' || process_date='')");
									if($done_origin){
										$sql="update `gnr_x_prescription_itemes` set `presc_quantity`='$presc_quantity',altr='$id_drug', status=4 where presc_id ='$id' and mad_id='$origin'";
										mysql_q($sql);
									}else{ 
										$sql="INSERT INTO `gnr_x_prescription_itemes`(`presc_id`, `mad_id`, `process_date`, `status`,`req_quantity`,`presc_quantity`,`altr`) VALUES ('$id','$origin','$now','4','0','$presc_quantity','$id_drug')";
										mysql_q($sql);
									}
								
									
								}
							}
						}
					}
				}
			}
		}elseif(empty($exchanged_drugs)){
				$status_presc=2;//الوصفة لم تصرف
		}
		if(empty($errs)){
			$sql="update gnr_x_prescription set done='$done_presc',process_status='$status_presc' where id='$id'";
			if($ok){if(mysql_q($sql)){echo 1;}}
		}else{
			echo 'err-'.implode('-',$errs);
		}
		
	}
	
	elseif($status=='process_exist'){
		if(isset($_POST['exist'])){
			$isExist=pp($_POST['exist']);
			echo presc_set_not_exist_drug($id,$isExist);
		}
	}
	
	elseif($status=='process_change_price'){
		if(isset($_POST['price'])){
			$price=pp($_POST['price']);
			echo presc_set_price($id,$price);
		}
	}
}


?>