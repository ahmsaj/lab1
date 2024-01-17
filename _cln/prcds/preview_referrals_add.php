<? include("../../__sys/prcds/ajax_header.php");
?><div class="winBody"><?
if(isset($_POST['n'] , $_POST['p_id'] , $_POST['v_id'])){?>
	<div class="formBody so"><?
	$n=pp($_POST['n']);
	$p_id=pp($_POST['p_id']);
	$v_id=pp($_POST['v_id']);
	$date111=dateToTimeS3($now,1);
	if($n!=0){
		$m='<div class="ass_no">'.k_referral_num.''.$n.'</div>';
		$sql="select * from cln_x_pro_referral where id='$n' ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$r=mysql_f($res);
			$id=$r['id'];
			$type=$r['type'];
			$p_id=$r['p_id'];
			$hospital=$r['hospital'];
			$doctor=$r['doctor'];
			$opr_date=$r['opr_date'];
			$des=$r['des'];
			$opration=$r['opration'];
			$v_id=$r['v_id'];
			$date=$r['date'];
			$date111=$opr_date;	
		}
	}?>   
    <div class="f1 blc_win_title bwt_icon6" id="ass_title"><?=k_ch_ref_type?></div> 
    <div class="b_tabs cb">    
        <div class="fl f1" n="1"><div class="btab1"></div><span><?=k_referral_to_surgery?></span></div>
        <div class="fl f1" n="2"><div class="btab2"></div><span><?=k_referral_to_dr?></span></div>
        <div class="fl f1" n="3"><div class="btab3"></div><span><?=k_referral_to_hospital?></span></div>
    </div>
    <div class="b_tabs_in  hide">
    <? $cData=getColumesData('zyy7xnbjza',1);?>
    <form name="form_assi" id="form_assi" action="<?=$f_path?>X/cln_preview_referrals_save.php" method="post" cb="assi_save([1]);" bv="id">
    	<input type="hidden" value="<?=$n?>" name="id"/>
        <input type="hidden" value="<?=$type?>" name="type" id="assi_type"/>
        <input type="hidden" value="<?=$p_id?>" name="p_id"/>
        <input type="hidden" value="<?=$v_id?>" name="v_id"/>
        <table class="fTable" cellpadding="0" cellspacing="0" border="0">
	        <div class="bt_blbs btc1 btc3"><?=co_getFormInput(0,$cData['8kbf0kv9on'],$hospital,1);?></div>
	        <span class="bt_blbs btc1 btc2"><?=co_getFormInput(0,$cData['wiilprmlc'],$doctor,1);?></span>
	        <span class="bt_blbs btc1"><?=co_getFormInput(0,$cData['drvx6e5xwl'],$opration,1);?></span>   
            <tr class="bt_blbs btc1"><td n><?=k_date_of_operation?>:</td>
            <td i><input name="opr_date" type="text" class="Date" value="<?=$date111?>" /></td></tr>
            
            <tr class="bt_blbs btc1 btc2 btc3"><td n><?=k_details?>:</td>
            <td i><textarea name="des_"><?=$des?></textarea></td></tr>
                                                
        </table>
         </form> 
        </div>   
	</div>    
	<? if($n!=0){echo script('changebTab('.$type.')');} ?> 
    <div class="form_fot fr">
        <div class="bu bu_t2 fr" onclick="win('close','#m_info2')"><?=k_cancel?></div>
        <div class="bu bu_t3 fl hide" id="assiSave" onclick="sub('form_assi')"><?=k_save?></div>        
    </div>
<? }?>
</div>