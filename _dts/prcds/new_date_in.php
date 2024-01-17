<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['d'] , $_POST['s'] , $_POST['e'] , $_POST['doc'])){
	$s=pp($_POST['s']);
	$e=pp($_POST['e']);
	$id=pp($_POST['d']);
	$doctor=pp($_POST['doc']);
	$sql="select * from dts_x_dates where id='$id' and status in (0,1,9) ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		//$doctor=$r['doctor'];
		$patient=$r['patient'];
		$clinic=$r['clinic'];
		$date=$r['date'];
		$d_start=$r['d_start'];
		$d_end=$r['d_end'];
		$status=$r['status'];
		$note=$r['note'];
		$c_type=$r['type'];
		$srvs=get_vals('dts_x_dates_services','service',"dts_id='$id'");
		if($c_type==4){
			$timeN=get_val_c('dts_x_dates_services','ser_time',$id,'dts_id' );
			$price=0;
		}else{
			list($timeN,$price)=get_docTimePrice($doctor,$srvs,$c_type);
		}
		
		$timeA=	($e-$s)/60;//total time by mints
		$timeH=$s%86400;//block time start by secunds		
		$s_val=$s%86400;
		$e_val=$s_val+($timeN*60);
		$d_val=$s-($s%86400);
		?>
		<form name="n_d_d" id="n_d_d" action="<?=$f_path?>X/dts_new_date_in_save.php" method="post"  cb="checkDateStatus('[1]',<?=$id?>,1,<?=$c_type?>);" bv="a">
		<div class="win_body">
			
			<input name="id" type="hidden" value="<?=$id?>"/>
			<input name="dd" type="hidden" value="<?=$d_val?>"/>
			<input name="ds" type="hidden" id="ds" value="<?=$s_val?>"/>
			<input name="de" type="hidden" id="de" value="<?=$e_val?>"/>
			<input name="doc" type="hidden" id="doc" value="<?=$doctor?>"/>
			<div class="form_header so lh40 clr1 f1 fs18">
				<div class="fl f1 fs14 clr1 lh30"><?=k_clinic.' : '.get_val('gnr_m_clinics','name_'.$lg,$clinic)?> |</div>
				<div class="fl f1 fs14 clr1 lh30 pd10"><?= k_dr.' : '.get_val('_users','name_'.$lg,$doctor)?> |</div>
				<div class="fl f1 fs14 clr5 lh30"><?='<ff>'.$timeN.'</ff> '.k_minute?></div>
			</div>
			<div class="form_body so">				
				<div class="f1 fs18 lh30"><?
				echo 'الوقت المتوفر : '.$wakeeDays[date('w',$s)].' - <ff>'.	date('d',$s).'</ff> - '.$monthsNames[date('n',$s)].' - <ff>'.date('Y',$s).'</ff>';
				$s_h=date('A h:i',$s);
				$e_h=date('A h:i',$e);
				$w_h=date('A h:i',$e_val);?>
				</div>
				<div class="f1 fs16 lh30 uLine"><?
				echo ' من الساعة <ff dir="ltr" class="clr5">'.$s_h.'</ff> حتى الساعة <ff dir="ltr" class="clr5">'.$e_h.'</ff>'?> 
				</div>
                <div class="cb f1 fs14 clr6 lh40"><input type="checkbox" name="other"/>موعد لشخص أخر</div>
				<div class="fl cbg44 w100">
				<div class="slidBar_t fl clr1 cb pd10" dir="<?=$lg_dir?>">
					<div class="fl"><?=$s_h?></div>
					<div class="fl pd10"> / </div>
					<div class="fl"><?=$w_h?></div>
				</div>
				<div id="slidBar" class="slidBar fl" th="<?=$timeH?>" ta="<?=$timeA?>" tn="<?=$timeN?>" ts="<?=_set_pn68gsh6dj?>"><div  id="dSlid"></div></div>	
				<div class="slidBar_b fl" >
					<div class="fl"><?=$s_h?></div>
					<div class="fr"><?=$e_h?></div>
				</div>
				</div>
				<div class="cb uLine"></div>
				<div class="cb f1 fs18 clr5 lh40">ملاحظات</div>
				<textarea name="note" class="so w100" ><?=$note?></textarea>
			</div>
			
			<div class="form_fot fr">
				<div class="fl uLine lh40 w100"><?
					$prvPayments=DTS_PayBalans($id);
					if($prvPayments){?>
						<div class="f1 fs16 clr5 pd10">المدفوعات السابقة : <ff class="clr5"><?=number_format($prvPayments)?></ff></div>
					<? } ?>
					<div class="fl f1 fs16 clr1 lh50 pd10">قيمة الخدمات : <ff class="clr5"><?=number_format($price)?></ff></div>
					<div class="fl f1 fs16 clr1 lh50 pd10">الدفعة المقدمة  : <input type="number" fix="w:100" value="0" name="dPay"/> </div>
				</div>
				<div class="bu bu_t3 fl" onclick="sub('n_d_d');"><?=k_save?></div>
				<div class="bu bu_t2 fr" onclick="win('close','#m_info2');"><?=k_close?></div>
			</div>
		</div>
		</form><?
	}
}?>