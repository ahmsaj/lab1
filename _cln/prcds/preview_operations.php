<? include("../../__sys/prcds/ajax_header.php");
?><div class="win_body"><?
if(isset($_POST['p_id'] , $_POST['v_id'])){
	$p_id=pp($_POST['p_id']);
	$v_id=pp($_POST['doc']);	
	if($t2=getTotalCO('gnr_m_patients'," id='$p_id' ")>0){?> 
    <div class="form_body so" type="full">
    	<div class="win_inside_con">
	        <div class="win_m3_1 fl">
            <div class="f1 blc_win_title bwt_icon8"><?=k_operations_table?>
                <div class="fr">[ <?=getTotalCO('cln_x_pro_x_operations',"p_id='$p_id' and doc='$thisUser'");?> ]</div>
            </div>
            <div class="blc_win_list so">
           		<div class="cb ic40 ic40Txt icc1 ic40_add " style="width:auto;" onclick="new_operation(0)" ><?=k_add_oper?></div>
                	<? $sql="select * from cln_x_pro_x_operations where p_id='$p_id' and doc='$thisUser' order by id DESC";
					$res=mysql_q($sql);
					$rows=mysql_n($res);
					if($rows>0){
						while($r=mysql_f($res)){
							$a_id=$r['id'];
							$v_id=$r['v_id'];
							$view=$r['status'];
							$opration=$r['opration'];
							$opration_name=get_val('cln_m_pro_operations','name_'.$lg,$opration);
							$c='norCat';
							if($view)$c='actCat';							
							echo '
							<div class="opr_ls '.$c.'" a_id="'.$a_id.'">
								<div class="fl w_li_num"></div>
								<div class="fl w_li_date f1 ws">'.$opration_name.'</div>
							</div>';
						}
					}?>
            </div>                
            </div>
         	<div class="blc_win_content fl" fix="wp:241">
            	<div class="f1 blc_win_title  bwt_icon0" ><?=k_oper_det?>
                    <div class="blc_win_title_icons fr hide"  id="bwtto">
                        <div class="fr delToList" onclick="delOperation()" title="<?=k_delete?>"></div> 
                        <div class="fr editToList" onclick="edit_opration()" title="<?=k_edit?>"></div>
                        <div class="fr printToList" onclick="print_operation()" title="<?=k_print?>"></div>
                    </div> 
                </div>
                <div class="blc_win_content_in so" id="part_detail" fix="hp:41">
                	<div class="f1 winOprNote"><? 
					if($rows>0){echo k_vew_oper_det;}else{
						echo k_no_opers_add_one;}?></div>
                </div>
        </div>
        </div>
    </div>
    <div class="form_fot fr">
        <div class="bu bu_t2 fr" onclick="prvClnoprCount('opr');win('close','#m_info');" ><?=k_close?></div>               
    </div>        
		<?
	}
	
}?>
</div>