<?
$but="action:".k_export.":ti_res hide:exp_get_enc_code()";
?>
<div class="centerSideInFull of" type="static">
    <div class="fxg w100 h100 cbg11111" fxg="gtr:50px 1fr|gtc:360px 1fr">
        <div class="fs16 f1 lh50 b_bord r_bord pd10 cbg4"><?=$def_title?></div>
        <div class="fs16 f1 lh50 b_bord pd10 cbg444">
            <div class="fr ic30x icc4 ic30_done mg10v" expDo title="<?=k_export?>"></div><?=k_chosen_mods?></div>
        <div class="of r_bord cbg4 fxg" fxg="gtr:60px 1fr">
            <div class="pd10f">
                <input type="text" id="ser_prescr" onkeyup="serModEx"  placeholder="<?=k_search?>" />
            </div>            
            <div class="ofx so w100">			
                <div class="fl ofx so pd10 w100" id="modsList"><?
                    $sql="select * from _modules";
                    $res=mysql_q($sql);
                    while($r=mysql_f($res)){
                       $mode_code=$r['code'];
                       $mode_title=$r['title_'.$lg];
                       $mod_ord=$r['ord'];
                       $mod_link=$r['module'];
                       echo '<div class=" cbgw pd10f mg10v f1 Over2 bord" sel="0" mTitle="'.$mode_title.'" mod="'.$mode_code.'">'.$mode_title.'   |   '.$mod_link.'</div>';
                     }
                    $sql="select * from _modules_";
                    $res=mysql_q($sql);
                    while($r=mysql_f($res)){
                       $mode_code=$r['code'];
                       $mode_title=$r['title_'.$lg];
                       $mod_ord=$r['ord'];
                       $mod_link=$r['module'];
                       echo '<div class=" cbgw pd10f mg10v f1 Over2" sel="0" mTitle="'.$mode_title.'" mod="'.$mode_code.'"  >'.$mode_title.'   |   '.$mod_link.' (+)</div>';
                     }
                    ?>
                </div>
            </div>
            
        </div>
        <div class="ofx so cbg444 pd10f">
            <form id="form_lib_exp" name="form_lib_exp" method="post" target="_blank" action="<?=$f_path?>M/exp_export_do.php" cb="loader_msg(0,'',0);">
                <div class="f1 fs14 lh50"><?=k_enc_code?> : <input type="text" name="enc_code" fix="w:200"/></div>
                <table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" type="static" id="exModTab" >
                    <tr><th><?=k_module?></th><th width="75"><?=k_xp_dat?></th><th width="75"></th></tr>
                </table>
            </form>
        </div>
    </div>
</div>
<script>
$(document).ready(function(){
	exp_fix_choose_mod();
	//exp_fix_add_view();
});

</script>