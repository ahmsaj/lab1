<? include("../../__sys/mods/protected.php");?>
<div class="centerSideInFull of fxg" fxg="gtc:240px 1fr">
<div class="fl r_bord ofx so pd10 cbg444" id="wr_input">
	<div class="f1 fs16 clr2 lh50 TC uLine"><?=$def_title?></div>
	
	
    <div>
        <div>
            <div class="f1 clr1111 lh40 fs14"><?=k_frm_dte?> :</div>
            <input type="text" value="<?=$satrtDate?>" name="ds" class="Date" fix=""/>
        </div>
        <div>
            <div class="f1 clr1111 lh40 fs14"><?=k_tdate?> :</div>
            <input type="text" value="<?=$endDate?>" name="de"  class="Date"/>
        </div>
    </div>
	
	
    <div class="f1 clr1111 lh40 fs14">عدد أيام المهلة :</div>
	<input type="number" value="10" name="days" />
    
    
    <div class="f1 clr1111 lh40 fs14">الطبيب :</div>
	<?=make_Combo_box('_users','name_'.$lg,'id',"where act=1 and grp_code='fk590v9lvl' ",'user',0,'','t','كافة الأطباء');?>
	<div class="ic40 icc2 ic40Txt ic40_send mg10v" sendCpData onclick="coDos_send()"><?=k_res_rev?></div>
</div>
<div class="fl ofx so pd10" id="coDos_data"></div>
</div>