<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['p_id'])&&isset($_POST['v_id'])){
	$p_id=pp($_POST['p_id']);
	$v_id=pp($_POST['v_id']);
    $act_id=pp($_POST['id']);
	if($t2=getTotalCO('gnr_m_patients'," id='$p_id' ")>0){?> 

        <div class="fl w100 h100 fxg t_bord" fxg="gtc:300px 1fr">
            <div class="of cbg4 r_bord fxg " fxg="gtr:50px 1fr">
                <div class="f1 fs14 lh50  b_bord pd10">
                    <div class="fr i30 i30_add mg10v" title="<?=k_med_ima_request?>" onclick="new_xphoto(0,0,1,'')"></div>
                    <?=k_prev_pho_list?> ( <?=getTotalCO('xry_x_visits_requested',"patient='$p_id'");?> )
                </div>            
                <div class="of">
                    <div class="pd10f ofx so pd10 anaLis h100" actButt="act"><? 
                        $sql="select * from xry_x_visits_requested where patient='$p_id' order by date DESC";
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
                                /*echo '
                                <div class="xph_ls"  style="background-color:'.$an_requst_col[$status].'" a_id="'.$a_id.'" >
                                    <div class="lh30 pd10"><ff>'.dateToTimeS3($date,1).'</ff></div>
                                    <div class="lh30 pd10 f1 fs14">'.$an_requst[$status].'</div>
                                </div>';*/
                                echo '
                                <div class="xph_ls cbgw p mg10v pd10f Over2 br2"  a_id="'.$a_id.'" '.$c.' style="background-color:'.$an_requst_col[$status].'">
                                    <ff14>'.dateToTimeS3($date,1).'</ff14>
                                    <span class="lh20 pd10 f1 fs12"> | '.$an_requst[$status].'</span>
                                </div>';
                            }
                        }?>
                    </div>
                </div>                
            </div>
            <div class="of fxg" fxg="gtr:50px 1fr">
                <div class="f1 fs14 lh50 b_bord pd10">
                    <?=k_photo_details?>
                    <div class="fr ic30x icc1 ic30_ref mg10v" onclick="m_xphotoN(0)" title="<?=k_refresh?>"></div>
                </div>
                <div class="of" id="part_detail">
                    <div class="f1 fs14 clr5 pd20f"><?
                    if($rows>0){echo k_m_you_can_see_the_details_of_the_photo ;}else{echo k_there_is_no_precedent_photos ;}?>
                    </div>
                </div>
            </div>
        </div><?
	}
}?>
