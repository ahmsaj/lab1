<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'] , $_POST['val'])){
	$id=$_POST['id'];
	$val=$_POST['val'];
    $prams=explode('|',$val);
    $type=$prams[0];
    $ex=$prams[1];
    $w=$prams[2];
    $h=$prams[3];
?><div class="win_body">
	<div class="form_body so" >
        <table width="100%" border="0" cellspacing="0" type="static" cellpadding="4" class="grad_s">
            <tr>                
                <td txt width="160"><?=k_type?> :</td>
                <td>
                    <select id="ph_type" t>
                    <option value="0" selected ><?=k_one_photo?></option>
                    <? $s='';if($type==1){$s=' selected ';}?>
                    <option value="1" <?=$s?> ><?=k_many_photo?></option>
                    </select>
                </td>                
            </tr>
            <tr>                
                <td txt><?=k_extensions?> :</td>
                <td>
                    <input id="ph_ex" type="text" value="<?=$ex?>"/>
                    <span class="clr5 lh20"><?=k_default?> <ff14>(jpg,jpeg,png,gif,svg)</ff14></span>
                </td>
            </tr>
            <tr>                
                <td txt><?=k_max_width?> :</td>
                <td>
                    <input id="ph_w" type="number" value="<?=$w?>"/>
                    <span class="clr5 lh20"><?=k_default?> <ff14>1000</ff14></span>
                </td> 
            </tr>
            <tr>                
                <td txtS><?=k_max_height?> :</td>
                <td>
                    <input id="ph_h" type="number" value="<?=$h?>"/>
                    <span class="clr5 lh20"><?=k_default?> <ff14>1000</ff14></span>
                </td> 
            </tr>            
        </table>
	</div>
	<div class="form_fot fr">		
		<div class="ic40 ic40_x ic40Txt icc3 fr mg10v" onclick="win('close','#m_info')"><?=k_close?></div>
        <div class="ic40 ic40_done ic40Txt icc4 fl mg10f" onclick="savePhotoVals()"><?=k_end?></div>
	</div>
</div>  <?
}?>    