<? include("../../__sys/prcds/ajax_header.php");
?><div class="win_body"><?
if(isset($_POST['id'] , $_POST['v_id']) ){
	?><div class="form_body so" type="full"><div class="win_inside_con"><?
	$id=pp($_POST['id']);
	$v_id=pp($_POST['v_id']);
	$p_id=get_val('cln_x_visits','patient',$v_id);
	$cancel=0;
	if($id==0){
		$cancel=1;
		$sql="INSERT INTO cln_x_pro_analy(v_id,p_id,date)values('$v_id','$p_id','$now')";
		if($res=mysql_q($sql)){
			$id=last_id();
		}
	}
	if($id){?>
        <div class="list_cat fl so">
       		<div class="f1 blc_win_title bwt_icon1"><?=k_select_the_tests_of_list?></div>
            <div class="fl ana_list ofx so" fix="hp:50"><?=get_ana_cats($id)?></div>
            <div class="fl ana_list ofx so" fix="hp:50"><?=get_ana($id)?></div>
        </div>
        <div class="anaSel fl" fix="wp:380">
       		 <div class="f1 blc_win_title bwt_icon2"><?=k_selected_tests?></div>
        	<div id="anaSelected" class="ofx so" fix="hp:50"><?=getAnaList($id)?></div>
        </div>
        </div>
        </div>
        <div class="form_fot fr">
            <? if($cancel){?><div class="bu bu_t2 fr" onclick="cancel_ana(<?=$id?>)"><?=k_cancel?></div><? }?>
            <div class="bu bu_t3 fl" onclick="end_ana(<?=$id?>)"><?=k_save?></div>
        </div>
        <script>analisisOprId=<?=$id?>;</script><?
	}	
}?>
</div>
</div></div>