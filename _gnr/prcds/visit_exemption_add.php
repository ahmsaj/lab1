<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] , $_POST['t'])){?>
	<div class="win_body">
	
	<?
	$v_id=pp($_POST['id']);
	$cType=pp($_POST['t']);
	if($cType==1){$v_table='cln_x_visits';$v_table2='cln_x_visits_services';}
	if($cType==3){$v_table='xry_x_visits';$v_table2='xry_x_visits_services';}
	if($cType==2){$v_table='lab_x_visits';$v_table2='lab_x_visits_services';}
	$pa=get_val($v_table,'patient',$v_id);
	$cData=getColumesData('bvuuurmscw',1);
	?>
    <div class="form_header f1 fs18 lh40 clr1"><?=k_patient?> : <?=get_p_name($pa)?></div>
    <div class="form_body so">
    <form name="vexe_form" id="vexe_form" action="<?=$f_path?>X/gnr_exemption_save.php" method="post"  cb="changeVisType(<?=$v_id?>,1,<?=$cType?>);" bv="">           
    	<input type="hidden" name="v_id" value="<?=$v_id?>"/>
		<input type="hidden" name="c_type" value="<?=$cType?>"/>
		<div class="f1 fs16 lh30"><?=k_ent_reas_exmpt?></div>
        <?=co_getFormInput(0,$cData['t52jbdjyk'],'',1,1);?>         
    </table>    
    </form>
    </div>
    <div class="form_fot fr">
    	<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>
        <? if($sub_status==0){?>
        <div class="bu bu_t3 fl" id="saveButt" onclick="sub('vexe_form')"><?=k_save?></div><? }?>
		</div>
    </div><?
}?>