<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] , $_POST['t'])){
	$id=pp($_POST['id']);
	$type=pp($_POST['t']);
	$sql="select * from dts_x_dates where id='$id' and status in (0,1,9)";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$doctor=$r['doctor'];
		$patient=$r['patient'];
		if($patient && $type==1){
			mysql_q("UPDATE dts_x_dates SET status=1 where id='$id' and status in(0,9)");
            datesTempUp($id);
			vacaConflictAlert();
			echo script('dateINfo('.$id.')');exit;
		}
		$clinic=$r['clinic'];
		$date=$r['date'];
		$d_start=$r['d_start'];
		$d_end=$r['d_end'];
		$status=$r['status'];
		if($d_start==0){echo script('win("close","#m_info");selDate('.$id.');');exit;}
		$timeN=($d_end-$d_start)/60;//this block time by mints
		$timeA=	($e-$s)/60;//total time by mints
		$timeH=$s%86400;//block time statr by secunds		
		$s_val=$s%86400;
		$e_val=$s_val+($timeN*60);
		$d_val=$s-($s%86400);
		?>
		<div class="win_body">
		<div class="form_header so lh40 clr1 f1 fs18">
			<? if($type==2){?>
			<div class="cb f1 fs18 clr1111 lh40">تثبيت سجل المريض : <?=get_p_dts_name($patient,2)?></div><?}?>
			<div class="fl f1 fs16 clr1 lh40"><?=k_clinic.' : '.get_val('gnr_m_clinics','name_'.$lg,$clinic)?> |</div>
			<div class="fl f1 fs16 clr1 lh40 pd10"><?= k_dr.' : '.get_val('_users','name_'.$lg,$doctor)?> |</div>
			<div class="fl f1 fs16 clr5 lh40"><?='<ff>'.$timeN.'</ff> '.k_minute?></div>
			
		</div>
		<div class="form_body so" type="static">
			<div class="fl dt_pat_list ofx so" fix="hp:0">

				<div class="lh30 f1 clr1 fs14">رقم المريض</div>
				<div><input type="number" ser_p="p1" /></div>

				<div class="lh30 f1 clr1 fs14">الاسم</div>
				<div><input type="text" ser_p="p2" focus/></div>
				
				<div class="lh30 f1 clr1 fs14">الكنية</div>
				<div><input type="text" ser_p="p3" /></div>

				<div class="lh30 f1 clr1 fs14">اسم الاب</div>
				<div><input type="text" ser_p="p4" /></div>

				

				<div class="lh30 f1 clr1 fs14">الموبايل</div>
				<div><input type="text" ser_p="p5" /></div>

			</div>
			<div class="fl dt_pat_list_r ofx so" fix="hp:0|wp:210" id="daPatList">
			<div class="loadeText"><?=k_loading?></div>
			</div>
		</div>
		<div class="form_fot fr">
			<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div> 
			<? if($type==1){?><div class="bu bu_t1 fl" onclick="selDate(<?=$id?>);"><?=k_back?></div><? }
			if($patient==0){?>
			<div class="bu bu_t3 fl" onclick="dtsDel(<?=$id?>);">حذف الموعد</div>
			<? }?>
		</div>
		</div><?
	}
}?>