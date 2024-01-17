<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$mod_code=$_POST['id'];
	$events=get_val_c('_modules','events',$mod_code,'code');
	$e=explode('|',$events);
	$e_arr=array();
	foreach($e as $ee){
		$eee=explode(':',$ee);
		$e_arr[$eee[0]]=$eee[1];
	}
	
	?>
    <div class="win_body">
    <form name="add_evnt_form" id="add_evnt_form" action="<?=$f_path?>M/mods_oprs_events_save.php" method="post">
    <input type="hidden" name="mod_code" value="<?=$mod_code?>"/>  
    <div class="form_body so">    
    <table width="100%" border="0" id="tab_cons"  class="grad_s" type="static" cellspacing="0" cellpadding="4">
    <tr><th></th><th><?=k_bfor?></th><th><?=k_aftr?></th></tr>
    <tr><td txt><?=k_tadd?></td>
    <td><ff class="lh40">#1</ff><input type="text" name="e1" value="<?=$e_arr[1]?>"/></td>
    <td><ff class="lh40">#2</ff><input type="text" name="e2" value="<?=$e_arr[2]?>"/></td></tr>
    <tr><td txt><?=k_tedit?></td>
    <td><ff class="lh40">#3</ff><input type="text" name="e3" value="<?=$e_arr[3]?>"/></td>
    <td><ff class="lh40">#4</ff><input type="text" name="e4" value="<?=$e_arr[4]?>"/></td></tr>
    <tr><td txt><?=k_tdelte?></td>
    <td><ff class="lh40">#5</ff><input type="text" name="e5" value="<?=$e_arr[5]?>"/></td>
    <td><ff class="lh40">#6</ff><input type="text" name="e6" value="<?=$e_arr[6]?>"/></td></tr>
    
    </table>    
    </div>
    <div class="form_fot fr">
        <div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_cancel?></div>
        <div class="bu bu_t3 fl" onclick="sub('add_evnt_form')"><?=k_save?></div>                        
    </div>    
    </form>
    </div>
    <?
	
}
?>