<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] ,$_POST['vis'])){
	$id=pp($_POST['id']);
	$vis=pp($_POST['vis']);
    $v_sataus=0;
    $diagnosis='';
    if($id){list($v_sataus,$diagnosis)=get_val('lab_x_visits_requested','status,diagnosis',$id);}
    if(!$diagnosis){
        $diagnosis=get_vals('cln_x_prev_dia','val',"visit=$vis",' , ');
    }
	$p=get_val('cln_x_visits','patient',$vis);
	$p_name=get_p_name($p);
	list($c_name,$photo)=get_val('gnr_m_clinics','name_'.$lg.',photo',$c);?>
	<div class="win_body">
        <div class="form_body of h100" type="pd0">
		<? if($v_sataus>1){
			echo '<div class="f1 fs14 pd20f clr5">'.k_request_cant_edit.'</div>';
		}else{?>
        <div class="fxg h100"  fxg="gtc:400px 1fr|gtr:100%">
			<div class="r_bord pd10 h100">
				<div class="f1 fs14 lh50 uLine" ><?=k_sel_req_tsts?></div>
				<div class="lh40"><input type="text" placeholder="<?=k_search?>" onkeyup="serServIN(this.value)" id="ssin"/></div>
                <div class="fxg h100" fxg="gtc:1fr 1fr">
                    <div class="fl ana_list ofx so" fix1="hp:110|wp%:50"><?=get_ser_lab_cats($c)?></div>
                    <div class="fl ana_list ofx so" fix1="hp:110|wp%:50"><?=get_ser_lab($vis,0)?></div>           	
                </div>
			</div>               
			<div class="fl pd10 h100">
				<div class="f1 fs14 lh50 uLine ">
                    <div class="fr" fix="w:180"><?=$out.=make_Combo_box('lab_m_services_templates','name','temp'," where doc= '$thisUser' ",'temp','0','','t docLoadATemp fix="h:30" ','-- '.k_choose_model.' --');?></div>
                    <div class="fr ic30 ic30_add icc2 ic30Txt mg10f br0" addDocATemp><?=k_add_model?></div>
                    <?=k_selected_tests?>
                </div>
				<div id="anaSelected" class="ofx so" fix="hp:60">
                    <form name="l_ana" id="l_ana" action="<?=$f_path?>X/lab_preview_analysis_save.php" method="post" cb="win('close','#m_info2');AnalysisN([1],<?=_set_9jfawiejb9?>)" bv="a">
                        <div class="f1 fs16 lh40 clr1 pd10f" inputHolder><?=k_diagnoses?> :
                            <input class="lh30 w100 pd10" type="text" name="dia" value="<?=$diagnosis?>" required/>
                        </div>

                        <input type="hidden" name="id" value="<?=$id?>">				
                        <input type="hidden" name="vis" value="<?=$vis?>">
                        <? if($v_sataus==1){ echo '<div class="f1 fs14 lh40 clr5">'.k_request_edit_resend.'</div>';}?>
                        <table width="100%" id="srvData" border="0" cellspacing="0" cellpadding="6" class="grad_s holdH" type="static">
                        <th><?=k_analysis?></th><th width="30"></th>
                        <?
                        $script='';
                        if($id){
                            $sql="select * from lab_x_visits_requested_items where r_id='$id' ";
                            $res=mysql_q($sql);
                            while($r=mysql_f($res)){
                                $a_id=$r['ana'];						
                                $script.='drowAnaRow('.$a_id.');';
                            }
                        }?>
                        </table>
                    </form>					
				</div>
			</div>
        </div><?
		}?>
		</div>
        <div class="form_fot fr">
			<div class="bu bu_t2 fr" onclick="win('close','#m_info2');"><?=k_close?></div>
			<div class="bu bu_t3 fl hide" id="saveButt" onclick="sub('l_ana');"><?=k_save?></div>
		</div>
    </div><?
	echo script($script);
}?>