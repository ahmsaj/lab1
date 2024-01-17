<? include("../../__sys/prcds/ajax_header.php");
?><div class="win_body"><?
if(isset($_POST['p_id'])&& isset($_POST['v_id'])){
	$p_id=pp($_POST['p_id']);
	$v_id=pp($_POST['v_id']);
	$sql="select * from cln_x_visits where id='$v_id' and patient='$p_id'";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$report=$r['report'];
		$cccc='';
		if($report=='')$cccc='hide';
        ?><div class="form_header lh50">
            <div class="fl f1 fs16 lh40"><?=k_report_details?></div>
            <div class="fr ic40 ic40_print icc1 hide br0" onclick="printWindow(4,<?=$v_id?>)" id="bwtto" title="<?=k_print?>"></div>
        </div>
        <div class="form_body so " type="full_pd0"><?
            if($report==''){				
                $d_check=$r['d_check'];
                $type=$r['type'];
                $sub_type=$r['sub_type'];
                $status=$r['status'];
                $ref=$r['ref'];
                $ref_no=$r['ref_no'];
                $ref_date=$r['ref_date'];
                $patient=$r['patient'];			
                $d_check=$r['d_check'];

                $sex=get_val('gnr_m_patients','sex',$patient);
                $p_word=k_may_concern;
                if($sex==1){
                    $p_sex_word1=k_by_the_visit_m;
                    $p_sex_word2=k_he_compl;
                    $p_sex_word3=k_pre_suff_m;
                    $p_sex_word4=k_at_request;
                }else{
                    $p_sex_word1=k_by_the_visit_f;
                    $p_sex_word2=k_she_compl;
                    $p_sex_word3=k_pre_suff_f;
                    $p_sex_word4=k_at_request_f;
                }
                if($type==1){
                    if($sub_type==2){$typ_text=get_val('z_referral_co','name_'.$lg,$ref);}
                    if($sub_type==3){$typ_text=get_val('z_referral_ch','name_'.$lg,$ref);}				
                }
                $sql="select * from cln_x_prev_com  where visit='$v_id' ";
                $res=mysql_q($sql);
                $rows=mysql_n($res);
                if($rows>0){$complaints='';
                    while($r=mysql_f($res)){$complaints.='&#13;&#10; - '.$r['val'];}
                }
                $sql="select * from cln_x_prev_dia where visit='$v_id' ";
                $res=mysql_q($sql);
                $rows=mysql_n($res);
                if($rows>0){$diagnosess='';
                    while($r=mysql_f($res)){$diagnosess.='&#13;&#10; - '.$r['val'];}
                }
                $report='';
                $report.=$p_word.'&#13;&#10;';
                $report.=$p_sex_word1.' &#13;&#10;';

                if($ref_no)$report.='&#13;&#10; '.k_who_ref.' : '.$typ_text.' '.k_referral_num.' : '.$ref_no.' - '.k_b_date.' : '.$ref_date;
                if($complaints){$report.='&#13;&#10;'.$p_sex_word2.':'.$complaints;};
                if($diagnosess){$report.='&#13;&#10; &#13;&#10;'.$p_sex_word3.':'.$diagnosess;};
                $report.='&#13;&#10; &#13;&#10;'.$p_sex_word4;
            }
            echo '<textarea id="report" t class="so w100 h100 m_editor" onkeyup="$(\'#bwtto\').hide();"  >'.$report.'</textarea>';
            ?>
        </div>
		 <div class="form_fot fr">
	        <div class="bu bu_t2 fr" onclick="win('close','#m_info')"><?=k_close?></div>
            <div class="bu bu_t3 fl" onclick="saveReport()"><?=k_save?></div>            
        </div><?
	}	 
}?>
</div>