<div class="centerSideInFull of fxg" fxg="gtc:300px 1fr" >
	<div class="r_bord pd10 cbg444" langSncOpr>
        <div class="f1 fs16 lh50 uLine TC"><?=$def_title?></div>
        <div a="startSenc" class="icc4 clrw lh40 pd10 f1 fs14 mg10v br5 TC"><?=k_st_syc?></div>
        <? if(_set_ccluftee8m){?>
            <div a="startSenc2" class="icc2 clrw lh40 pd10 f1 fs14 mg10v br5 TC"><?=k_st_syc?> ( <?=k_sys_spe?> )</div>
            <div a="startSenc3" class="icc2 clrw lh40 pd10 f1 fs14 mg10v br5 TC"><?=k_st_syc?> ( <?=k_super?> )</div>
        <? }?>
        <div a="k_exp" class="icc1 clrw lh40 pd10 f1 fs14 mg10v br5 TC"><?=k_lang_keys_export?></div>
		<div a="k_imp" class="icc1 clrw lh40 pd10 f1 fs14 mg10v br5 TC" ><?=k_lang_keys_import?></div> 
	</div>
    <div class="pd20f">
        <!------------------------------------------------------->
        <div class="loadeText langLoader hide"><?=k_loading?></div>
        <!--import view-->
        <div id="k_import" class="hide"  style="padding:10px;"></div>
        <!--senc view-->
        <div id="snc2Bloc" class="hide pd10"><table  cellpadding="4" width="100%"></table></div>
        <div id="done_senc" class="hide pd10" >
            <div class="f1 fs14 lh30"><?=k_number_synced_files?> ( <ff id="num1" class="clr1"></ff> )</div>
            <div class="f1 fs14 lh30"><?=k_generated_keys_number?> ( <ff id="num2" class="clr1"></ff> )</div>
            <table style="margin-top:10px"  class="grad_s" width="50%" cellpadding="4" cellspacing="0" type="static">
            <tr><th><?=k_lang?></th><th><?=k_file?></th><th><?=k_langs_keys?></th></tr>
            <tbody id="table"></tbody></table>
        </div>
    </div>
	
</div>
<script>$(document).ready(function(e){ lang_process_view_fix(); });</script>