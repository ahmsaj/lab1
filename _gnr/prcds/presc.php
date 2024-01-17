<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['t'],$_POST['v_id'],$_POST['p_id'],$_POST['act_pre'])){
	$t=pp($_POST['t']);
	$v_id=pp($_POST['v_id']);
	$p_id=pp($_POST['p_id']);
	$act_pre=pp($_POST['act_pre']);
	if(getTotalCO($visXTables[$t],"id='$v_id' and patient='$p_id'")){
		$sql="select * from gnr_x_prescription where patient='$p_id' and status=1 order by date DESC";
		$res=mysql_q($sql);
		$rows=mysql_n($res);?>
		<div class="win_body">
			<div class="form_body of" type="full_pd0">
                <div class="fxg h100 " fxg="gtc:300px 1fr|gtr:52px 1fr">
                    <div class="fs18 f1 lh40 b_bord ti40 ti40_pres r_bord pd5f">
                        <div class="fr ic40x icc1 ic40_add" title="<?=k_new_presc?>" add_pares></div>
                        <?=k_prescs_list?> <ff>[ <?=$rows?> ]</ff>
                    </div>
                    <div class="fs18 f1 lh40 b_bord ti40 ti40_list pd5f">
                        <div class="fr hide" id="preOpr">
                            <div class="fr ic40 icc1 ic40_edit" pOprEdit title="<?=k_edit?>"></div>
                            <div class="fr ic40 icc2 ic40_del"  pOprDel title="<?=k_delete?>"></div>
                            <? if(intval(_set_8g9zjll9cm)==0){?>
                                <div class="fr ic40 icc4 ic40_print" onclick="printPrescr(<?=_set_sidakua36b?>)" title="<?=k_print?>"></div>
                            <? }?>                            
                        </div>
                        <?=k_prescription_details?> 
                    </div>
                    
                    <div class="r_bord pd10f ofx so allPrescs" actButt="actPerLis"><?
                        if($rows){
                                while($r=mysql_f($res)){
                                    $id=$r['id'];
                                    $clinicTxt=get_val_arr('gnr_m_clinics','name_'.$lg,$r['clinic'],'cl');
                                    $docTxt=get_val_arr('_users','name_'.$lg,$r['doc'],'doc');
                                    $sel='';
                                    if($act_pre==$id){$sel='actPerLis';}
                                    echo '<div class="bord cbg44" '.$sel.' pre="'.$id.'">
                                        <div class="pd10 lh30 b_bord"><ff>'.date('Y-m-d',$r['date']).'</ff></div>
                                        <div class="f1 fs14 lh40 pd10">'.$docTxt.' ( '.$clinicTxt.' )</div>
                                    </div>';
                                }
                            }?>                        
                    </div>
                    <div class="pd10 h100 ofx so" id="preDtl">
                        <div class="f1 fs16 lh40 clr1"><?=k_view_prev_presc_or_add_new?></div>                        
                    </div>
                </div>
			</div>
			<div class="form_fot fr">
				<div class="bu bu_t2 fr" onclick="prvClnoprCount('prc');win('close','#m_info');" ><?=k_close?></div>
			</div>
		</div><?
	}
}?>
