<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
    $id=pp($_POST['id']);
    $mod=pp($_POST['mod'],'s');
    if($id){
        $r=getRec('_modules_links',$id);
        if($r['r']){
            $table=$r['table'];
            $colume=$r['colume'];
            $val=$r['val'];
        }else{
            exit;
        }
    }?>
    <div class="win_body">
        <div class="form_body so" type="full">
            <form name="add_link_form" id="add_link_form" action="<?=$f_path?>M/mods_oprs_linkes_save.php" method="post" cb="modLinkes('<?=$mod?>')">
            <input type="hidden" name="id" value="<?=$id?>"/>
            <input type="hidden" name="mod" value="<?=$mod?>"/>
            <table width="100%" border="0" class="grad_s" type="static" cellspacing="0" cellpadding="4">                
                <tr><td txt><?=k_table?></td><td><?=tablesList('link_table','link_col',$table)?></td></tr>
                <tr><td txt><?=k_feld_nam?><td><div link="link_col" v link_id="link_col"><input type="text" id="link_col" value="<?=$colume?>" disabled1 /></div></td></tr>
                <tr><td txt><?=k_cmp_val?> </td><td><input type="text" value="<?=$val?>" id="link_val" name="link_val"/></td></tr>
            </table>
            </form>
        </div>
        <div class="form_fot fr">
            <div class="fl ic40 ic40_save icc22 ic40Txt mg10f br0" onclick="sub('add_link_form')"><?=k_save?></div> 
            <div class="fr ic40 ic40_x icc3 ic40Txt mg10v br0" onclick="win('close','#m_info2');"><?=k_cancel?></div> 
        </div>
    </div><?
}?>