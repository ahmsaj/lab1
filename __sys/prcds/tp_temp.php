<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['data'])){
	$data=$_POST['data'];
    if($data){$data=str_replace('\n\n','\n',$data);}
    if($data){$data=str_replace('\n\n','\n',$data);}?>
	<div class="win_body">
	<div class="form_header so lh40 clr1 f1 fs18">اكتب اسم النموذج
        <div class="mg10v"><input type="text" id="tpTempName"/></div>
    </div>
	<div class="form_body so">        
        <div class="tpEditorRowsTemp">
	        <?=showTpBlcsTemp($data)?>
        </div>
    </div>
    <div class="form_fot fr">        
        <div class="fl ic40 ic40_save icc22 ic40Txt mg10f br0" tpTempDo><?=k_save?></div>		    	
        <div class="fr ic40 ic40_x icc3 ic40Txt mg10v br0" onclick="win('close','#m_info5');"><?=k_close?></div>
    </div>
    </div><?
}?>