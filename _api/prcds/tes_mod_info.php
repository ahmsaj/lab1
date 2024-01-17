<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['mod'])){
	$mod=pp($_POST['mod'],'s');
    $r=getRecCon('api_module'," code='$mod'");
	$r=getRecCon('api_module'," code='$mod'");
	if($r['r']){
		$module=$r['module'];
		$type=$r['type'];
		$sub_type=$r['sub_type'];
		$need_reg=$r['need_reg'];
		$need_reg_temp=$r['need_reg_temp'];
		$title=$r['title_ar'];
		$ref_col=$r['ref_col'];
		$mod_id=$r['id'];
		?>
		<div id="api_data">
            <div class="f1 fs16 clr5 b_bord lh40"><?=k_inputs?></div><?
            if($need_reg || $need_reg_temp){?>
            <div class="lh30 f1"><?=k_token?> <span class="clr5 fs18">*</span></div>
                <div><input type="text" name="token" value="<?=$_SESSION['Token']?>"/></div>
                <!--<div class="f1 lh30 clr5">يحتاج هذا القسم لربط المريض</div>--><?
            }?>
            <div class="lh30 f1"><?=k_user_name?> <span class="clr5 fs18">*</span></div>
            <div><input type="text" name="user" value="<?=get_val('_users','un',$thisUser)?>"/></div>
            <div class="lh30 f1"><?=k_user_code?> <span class="clr5 fs18">*</span></div>
            <div><input type="text" name="uCode" value="<?=$thisUserCode?>"/></div>
            <div class="lh30 f1"><?=k_procedure_code?> <span class="clr5 fs18">*</span></div>
            <div><input type="text" name="mod" value="<?=$mod?>"/></div>
            <div class="lh30 f1"><?=k_request_no?> <span class="clr5 fs18"></span></div>
            <div><input type="text" name="req_no" value="" /></div>
            <div class="f1 fs16 clr5 b_bord lh40"><?=k_additional_inputs?></div><?
            if($sub_type==4){?>
                <div class="lh30 f1"><?=k_page_no?></div>
                <div><input type="number" name="page" value="1"/></div>
                <?
            }
            //if(($sub_type==2) || ($sub_type==3 && ($need_reg==0 || ($need_reg==1 && $ref_col!='id')))){            
            if($sub_type==3 || $sub_type==2){
                if(
                    (
                    ($need_reg==0 && $need_reg_temp==0) || 
                    (($need_reg==1 || $need_reg_temp==1) && $ref_col!='id') 
                    )
                    || in_array($mod,array('mfyu182xlj','bgal4vsx9h'))
                  ){?>
                    <div class="lh30 f1 fs14" ><?=k_record_number?><span class="clr5 fs18">*</span></div>
                    <div><input type="number" name="rec_id" value=""/></div>
                    <?
                }
            }
            $res_set=mysql_q("select * from api_modules_items_in where mod_id='$mod_id' and `act`=1 order by ord ASC");
            $rows_set=mysql_n($res_set);			
            if($rows_set){	
                while($r=mysql_f($res_set)){
                    $name=get_key($r['name_'.$lg]);
                    $note=get_key($r['note_'.$lg]);
                    $inName=$r['in_name'];
                    $colum=$r['colum'];
                    $star='';
                    if($r['requerd']){$star='*';}
                    echo '<div class="lh30 f1 fs14" >'.$name.'<span class="clr5 fs18">'.$star.'</span></div>
                    <div><input type="text" name="'.$inName.'" value=""/></div>
                    <div class="f1 clr5 lh20">'.$note.'</div>';
                }
            }
		?></div><?
	}
}?>