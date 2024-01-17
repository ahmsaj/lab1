<? include("../../__sys/prcds/ajax_header.php");
?><div class="win_body"><?
if(isset($_POST['p_id'])&&isset($_POST['v_id'])){
	$p_id=pp($_POST['p_id']);
	$v_id=pp($_POST['v_id']);
	if($t2=getTotalCO('gnr_m_patients'," id='$p_id' ")>0){	
	if(_set_9jfawiejb9==1){
		$addAction='LabNewAnalysis(0)';
		$total=getTotalCO('lab_x_visits_requested',"patient='$p_id'");
	}else{
		$addAction='newAnalysis(0)';
		$total=getTotalCO('cln_x_pro_analy',"p_id='$p_id'");
	}?>
    <div class="form_body so" type="full">
    	<div class="win_inside_con">
	        <div class="win_m3_1 fl" fix="w:230">
            <div class="f1 blc_win_title bwt_icon1"><?=k_pre_tests_list?>
                <div class="fr">[ <?=$total?> ]</div>
            </div> 
            <div class="blc_win_list so">
                <div class="cb ic40 ic40Txt ic40_add icc1 mg10v" style="width:auto;" onclick="<?=$addAction?>" ><?=k_tst_req?></div><?
				if(_set_9jfawiejb9==1){
					$sql="select * from lab_x_visits_requested where patient='$p_id' order by date DESC";
					$res=mysql_q($sql);
					$rows=mysql_n($res);
					if($rows>0){
						while($r=mysql_f($res)){
							$a_id=$r['id'];
							$v_id=$r['visit_id'];
							$status=$r['status'];
							$date=$r['date'];
							$c='norCat';
							if($status==2){$c='actCat';}
							echo '
							<div class="ana_ls2 "  style="background-color:'.$an_requst_col[$status].'" a_id="'.$a_id.'" >								
								<div class="lh30 pd10"><ff>'.dateToTimeS3($date,1).'</ff></div>
								<div class="lh30 pd10 f1 fs14">'.$an_requst[$status].'</div>
							</div>';
						}
					}
				}else{
					$sql="select * from cln_x_pro_analy where p_id='$p_id' order by date DESC";
					$res=mysql_q($sql);
					$rows=mysql_n($res);
					if($rows>0){
						while($r=mysql_f($res)){
							$a_id=$r['id'];
							$v_id=$r['v_id'];
							$view=$r['view'];
							$date=$r['date'];
							$c='norCat';
							if($view)$c='actCat';				
							echo '
							<div class="ana_ls '.$c.'" a_id="'.$a_id.'" >
								<div class="fl w_li_num"></div>
								<div class="fl w_li_date ws">'.dateToTimeS3($date,1).'</div>
							</div>';
						}
					}
				}?>
            </div>                
            </div>         
	        <div class="blc_win_content fl" fix="wp:230">
            	<div class="f1 blc_win_title  bwt_icon0" >
					(<?=k_test_details?>)
					<div class="fr ic40x icc1 ic40_ref" onclick="Analysis(0,1)" title="<?=k_delete?>"></div>
                    <div class=" fr hide"  id="bwtto">
                        <div class="fr ic40 icc2 ic40_del" onclick="delAnalysis(1)" title="<?=k_delete?>"></div> 
                        <div class="fr ic40 icc1 ic40_edit" onclick="editAnalysis()" title="<?=k_edit?>"></div>
                        <div class="fr ic40 icc4 ic40_print" onclick="printAnalysis2()" title="<?=k_export?>"></div>
                    </div> 
                </div>
                <div class="blc_win_content_in ofx so" fix="hp:40" id="part_detail">
                	<div class="f1 winOprNote"><? 
					if($rows>0){echo k_you_can_see_the_details_of_the_test ;}else{echo k_m_there_is_no_previous_tests;}?>			
                    </div>
                </div>
        	</div> 
        </div>
    </div>
    <div class="form_fot fr"><div class="bu bu_t2 fr" onclick="prvClnoprCount('ana');win('close','#m_info');" ><?=k_close?></div></div><?
	}
}?>
</div>