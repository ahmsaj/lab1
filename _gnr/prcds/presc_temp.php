<? include("../../__sys/prcds/ajax_header.php");
?><div class="win_body"> 
    <div class="form_body so">        
    	<div class="f1 blc_win_title bwt_icon7"><?=k_new_form?></div>           
 		<div class="winOprNote f1"><?=k_m_save_form_prescription?></div>
        <table width="100%" border="0"  class="grad_s g_info" type="static" cellspacing="0" cellpadding="4">
                <tr>                	
            	<td class="f1" width="100"><?=k_form_name?>:</td>        
            	<td><input type="text" id="pre_tamp"  style="font-size:16px;" /></td>
            </tr>
        </table> 
    </div>
    <div class="form_fot fr">
        <div class="bu bu_t2 fr" onclick="win('close','#m_info3');"><?=k_cancel?></div>
        <div class="bu bu_t3 fl" onclick="saveTamp();"><?=k_save?></div>        
    </div>

</div>