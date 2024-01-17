<? include("../../__sys/prcds/ajax_header.php");?>
	<div class="win_body">
	<div class="form_header so lh40 clr1 f1 fs18"><?=k_tests?></div>
	<div class="form_body so">	
		<div class="listDataSelCon">
			<div class="fl listDataSel" fix="wp:0">
				<input type="text" id="serListR" onkeyup="view_list_SerR()" placeholder=""/>
			</div>		
		</div> 
		<div class="proTab_in fl" fix="wp:0|hp:0">      
			<div class="listData fl">                   
				<div class=" list_option so" id="list_optionR"><?=getTestsR2()?></div>
			</div> 
			<div  class="option_selected so fl" fix="wp:300" id="sel_optionR"></div>
		</div>
    </div>
    <div class="form_fot fr">
        <div class="bu bu_t2 fr" onclick="win('close','#m_info');loadModule('z3cg5ohzw1');"><?=k_end?></div>
    </div>
    </div>
<style>
.op_list > div:hover{
	cursor:pointer;
	color:#fff;
	background:url('') #999 no-repeat <?=$align?> 5px;
	text-indent:0px;
}
</style>