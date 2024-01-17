<? include("../../__sys/prcds/ajax_header.php");
?><div class="win_body"><?
if(isset($_POST['p_id'])&& isset($_POST['v_id'])){
	$p_id=pp($_POST['p_id']);
	$v_id=pp($_POST['v_id']);
	if($t2=getTotalCO('gnr_m_patients'," id='$p_id' ")>0){?> 
    <div class="form_body so" type="full">
        <div class="win_inside_con">
            <div class="win_m3_1 fl">
            <div class="f1 blc_win_title bwt_icon6"><?=k_pre_referrals_list?>
                <div class="fr">[ <?=getTotalCO('cln_x_pro_referral',"p_id='$p_id'");?> ]</div>
            </div> 
            <div class="blc_win_list so">
                <div class="cb ic40 ic40Txt icc1 ic40_add " style="width:auto;" onclick="newAssignment(0)" ><?=k_ref_req?></div>
				<? $sql="select * from cln_x_pro_referral where p_id='$p_id' order by date DESC";
                $res=mysql_q($sql);
                $rows=mysql_n($res);
                if($rows>0){
                    while($r=mysql_f($res)){
                        $a_id=$r['id'];
                        $v_id=$r['v_id'];
                        $date=$r['date'];
                        $type=$r['type'];
                        $hospital=$r['hospital'];
                        $doctor=$r['doctor'];
                        $opration=$r['opration'];
                        
                        if($type==1){$addtion=get_val('cln_m_pro_operations','name_'.$lg,$opration);}
                        if($type==2){$addtion=get_val('cln_m_pro_referral_doctors','name_'.$lg,$doctor);}
                        if($type==3){$addtion=get_val('cln_m_pro_referral_hospitals','name_'.$lg,$hospital);}
                        echo '
                        <div class="assi_ls norCat" a_id="'.$a_id.'" >
                            <div class="assi_ls_t1 f1">'.$assi_typs_arr[$type].'</div>
							<div class="assi_ls_t2 f1">'.$addtion.'</div>
							<div class="assi_ls_t3 ff">'.dateToTimeS3($date,1).'</div>
                        </div>';
                    }
                }?>
            </div>                
			</div>
            <div class="blc_win_content fl" fix="wp:241">
            	<div class="f1 blc_win_title  bwt_icon0" ><?=k_referral_details?>
                    <div class="blc_win_title_icons fr hide"  id="bwtto">
                        <div class="fr delToList" onclick="delassi()" title="<?=k_delete?>"></div> 
                        <div class="fr editToList" onclick="editassi()" title="<?=k_edit?>"></div>
                        <div class="fr printToList" onclick="print_assi()" title="<?=k_print?>"></div>
                    </div> 
                </div>
                <div class="blc_win_content_in so" id="part_detail"  fix="hp:41">
                	<div class="f1 winOprNote"><? if($rows>0){echo k_ref_vew;}else{echo k_no_refs;}?></div>
                </div>
        </div>            
        </div>
    </div>
    <div class="form_fot fr">
        <div class="bu bu_t2 fr" onclick="win('close','#m_info')" ><?=k_close?></div>
    </div><?
	}
	
}?>
</div>