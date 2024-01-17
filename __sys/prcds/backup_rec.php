<? include("ajax_header.php");?>
<div class="win_body">
	<div class="form_body so">
    <div class="win_inside_con">
    
    <div class="f1 winOprNote_err"><?=k_restor_warn?></div>
    <?=upFile('bk','',1)?>
    </div>
    </div>
    <div class="form_fot fr">
        <div class="bu bu_t2 fr" onclick="win('close','#m_info')"><?=k_cancel?></div>
        <div class="bu bu_t1 fr" onclick="save_recav()"><?=k_recovery?></div>
    </div> 
</div>