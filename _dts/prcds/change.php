<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$r=getRec('dts_x_dates',$id);	
	if($r['r']){
		$p=$r['patient'];
		$dts_date=$r['d_start'];
		$dts_d_end=$r['d_end'];
		$p_type=$r['p_type'];
		$clinic=$r['clinic'];
		$type=$r['type'];
		$change=0;
		if($p_type==1 && $type==1){
			$table=$visXTables[$type];
			$date=get_val_con($table,'d_start'," patient='$p' and clinic='$clinic' and status=2 ",' order by d_start DESC');
			if($date){
				$time=$dts_date-$date;
				if($time<(8*86400)){$change=1;}
			}
		
			$min=($dts_d_end-$dts_date)/60;?>
			<div class="win_body">
			<div class="form_header so lh40 clr1 f1 fs18"><?=get_p_name($p)?>
			<div class="ic40 icc1 fr  ic40_ref" onclick="dateAsReview(<?=$id?>)"></div>
			</div>
			<div class="form_body so"><? 
			if($change){?>
				<div class="f1 fs16  clr1 lh40">تاريخ أخر زيارة <ff dir="ltr"><?=date('Y-m-d',$date)?></ff>
				<span class="fs16 lh30 clr1111"> | منذ <?=dateToTimeS($now-$date)?></span>
				</div>
				<div class="f1 fs16 clr1 lh30 uLine clr1111">مدة الموعد <ff><?=$min?></ff> دقيقة</div>
				<div class="f1 fs16 clr5 lh30">يعتبر هذا الموعد مراجعة يمكن تخفيض زمن الموعد لتوفير وقت الطبيب اختر زمن الموعد الجديد </div>
				<select id="dtsNewTime"><?
					for($i=$min;$i>0;$i=$i-5){echo '<option value="'.$i.'">'.$i.'</option>';}?>
				</select><?			
			}else{
				echo script("win('close','#m_info');dateINfo(".$id.")");
				//echo script("alert(111222".$id.")");
			}?>
			</div>
			<div class="form_fot fr">
				<div class="bu bu_t3 fl" onclick="dateAsReviewSave(<?=$id?>);"><?=k_save?></div>
				<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>
			</div>
			</div><?
		}else{
				echo script("win('close','#m_info');dateINfo(".$id.")");
		}
	}
}?>