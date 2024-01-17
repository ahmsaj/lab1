<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
    $id=pp($_POST['id']);
    $mod=pp($_POST['mod'],'s');
    $table=get_val_c('_modules','table',$mod,'code');
    if($id){
        $r=getRec('_modules_cons',$id);
        if($r['r']){
            $colume=$r['colume'];
            $type=$r['type'];
            $val=$r['val'];
        }else{
            exit;
        }
    }?>
    <div class="win_body">
        <div class="form_body so">
            <form name="add_cons_form" id="add_cons_form" action="<?=$f_path?>M/mods_oprs_cons_save.php" method="post" cb="modCons('<?=$mod?>')">
                <input type="hidden" name="id" value="<?=$id?>"/>
                <input type="hidden" name="mod" value="<?=$mod?>"/>
                <table width="100%" border="0" class="grad_s" type="static" cellspacing="0" cellpadding="4">
                <tr><td txt><?=k_feld_nam?></td><td><?=columeList($table,$colume,'con_colume')?></td></tr>
                <tr><td txt><?=k_con_typ?></td><td dir="ltr"><?=selectFromArray('con_type',$t_array,1,1,$type)?></td></tr>
                <tr><td txt><?=k_val?></td><td><input type="text" name="con_val" id="con_val" value="<?=$val?>" /></td></tr>
                </table>
            </form>
        </div>
        <div class="form_fot fr">            
            <div class="fl ic40 ic40_save icc22 ic40Txt mg10f br0" onclick="sub('add_cons_form')"><?=k_save?></div> 
            <div class="fr ic40 ic40_x icc3 ic40Txt mg10v br0" onclick="win('close','#m_info2');"><?=k_cancel?></div>
        </div>
    </div>
    <?
}?>
    