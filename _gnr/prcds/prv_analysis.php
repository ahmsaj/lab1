<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['p_id'])&&isset($_POST['v_id'])){
	$p_id=pp($_POST['p_id']);
	$v_id=pp($_POST['v_id']);
    $act_id=pp($_POST['id']);
	if($t2=getTotalCO('gnr_m_patients'," id='$p_id' ")>0){	
        if(_set_9jfawiejb9==1){
            $addAction='LabNewAnalysis(0)';
            $total=getTotalCO('lab_x_visits_requested',"patient='$p_id'");
        }else{
            $addAction='newAnalysis(0)';
            $total=getTotalCO('cln_x_pro_analy',"p_id='$p_id'");
        }?>
        <div class="fl w100 h100 fxg t_bord" fxg="gtc:300px 1fr">
            <div class="of cbg4 r_bord fxg " fxg="gtr:50px 1fr">
                <div class="f1 fs14 lh50  b_bord pd10">
                    <div class="fr i30 i30_add mg10v" title="<?=k_tst_req?>" onclick="<?=$addAction?>"></div>
                    <?=k_pre_tests_list?> <ff14>( <?=$total?> )</ff14>
                </div>
                <div class="of">
                    <div class="pd10f ofx so pd10 anaLis h100" actButt="act"><?
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
                                $c='';                                
                                if($act_id==$a_id){$c='act';}
                                echo '
                                <div class=" cbgw p mg10v pd10f Over2 br2"  a_id="'.$a_id.'" '.$c.' style="background-color:'.$an_requst_col[$status].'">
                                    <ff14>'.dateToTimeS3($date,1).'</ff14>
                                    <span class="lh20 pd10 f1 fs12"> | '.$an_requst[$status].'</span>
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
            </div>         
            <div class="of fxg" fxg="gtr:50px 1fr">
                <div class="f1 fs14 lh50 b_bord pd10">
                    <?=k_test_details?>
                    <div class="fr ic30x icc1 ic30_ref mg10v" onclick="AnalysisN(0,1)" title="<?=k_refresh?>"></div>
                    <!--<div class=" fr hide"  id="bwtto">
                        <div class="fr ic40 icc2 ic40_del" onclick="delAnalysis(1)" title="<?=k_delete?>"></div> 
                        <div class="fr ic40 icc1 ic40_edit" onclick="editAnalysis()" title="<?=k_edit?>"></div>
                        <div class="fr ic40 icc4 ic40_print" onclick="printAnalysis2()" title="<?=k_export?>"></div>
                    </div> -->
                </div>
                <div class="of" anaDet>
                    <div class="f1 fs14 clr5 pd20f"><? 
                    if($rows>0){echo k_you_can_see_the_details_of_the_test ;}else{echo k_m_there_is_no_previous_tests;}?>
                    </div>
                </div>
            </div> 
        </div><?
	}
}?>
