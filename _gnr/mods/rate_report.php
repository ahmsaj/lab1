<? include("../../__sys/mods/protected.php");?>
<script src="<?=$m_path?>library/highstock/js/highstock.js"></script> 
<script src="<?=$m_path?>library/highstock/js/modules/exporting.js"></script>
<script src="<?=$m_path?>library/highstock/js/highcharts-more.js"></script>

<div class="centerSideInFull of fxg" fxg="gtc:240px 1fr">
<div class="fl r_bord ofx so pd10 cbg444" id="wr_input">
	<div class="f1 fs16 clr2 lh50 TC uLine"><?=$def_title?></div>
	
	<div class="f1 clr1111 lh40 fs14"><?=k_deprts?> :</div>
	<select name="mood" t><?
		foreach($clinicTypes as $k => $p){
			if(!$p){$p=k_all_deps;}
			echo '<option value="'.$k.'">'.$p.'</option>';
		}?>
	</select>	
	
    <div class="f1 clr1111 lh40 fs14">الأطباء :</div>    
	<?=make_Combo_box('_users','name_'.$lg,'id',"where grp_code IN ($docsGrpStr)",'doc',0,'','t','كافة الأطباء');?>
    
    
    <div class="f1 clr1111 lh40 fs14">القائم بالتقيم :</div>
	<?=make_Combo_box('_users','name_'.$lg,'id',"where act=1 and grp_code='pfx33zco65' ",'user',0,'','t','كافة المستخدمين');?> 
    
    <div class="f1 clr1111 lh40 fs14">التقييم :</div>
	<select name="rate" ><?
        echo '<option value="0">كافة التقييمات</option>';
		for($c=5;$c>0;$c--){			
			echo '<option value="'.$c.'">'.$c.'</option>';
		}?>
	</select> 
    
    <div class="f1 clr1111 lh40 fs14">نوع التقرير :</div>
	<select name="time" t onChange="viewActTimeSec(this.value)">
		<option value="1">يومي</option>
		<option value="2">شهري</option>
        <option value="3">سنوي</option>
        <option value="4">شهري أطباء</option>
	</select>
    <div class="mg5v" rTab="1"><input type="text" class="Date" name="day" value="<?=date('Y-m-d',$now)?>"/></div>
    <div class="mg5v hide" rTab="2"><?=monthSelect('gnr_x_acc_payments','date','month')?></div>
    <div class="mg5v hide" rTab="3"><?=yearsSelect('gnr_x_acc_payments','date','year')?></div>
    
    
    <div class="hide">
        <div class="fl " fix="wp%:50">
            <div class="f1 clr1111 lh40 fs14"><?=k_frm_dte?> :</div>
            <input type="text" value="<?=$satrtDate?>" name="ds" class="Date" fix=""/>
        </div>
        <div class="fr" fix="wp%:50">
            <div class="f1 clr1111 lh40 fs14"><?=k_tdate?> :</div>
            <input type="text" value="<?=$endDate?>" name="de"  class="Date"/>
        </div>
    </div>
	
	<div class="ic40 icc2 ic40Txt ic40_send mg10v" sendEpData onclick="rate_report_send()"><?=k_res_rev?></div>
</div>
<div class="fl ofx so pd10" id="epay_rep_data"></div>
</div>