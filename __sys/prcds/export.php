<? include("ajax_header.php");
if(isset($_POST['mod'])){	
	$mod=pp($_POST['mod'],'s');
	$ms=pp($_POST['ms'],'s');
	$msd=pp($_POST['msd'],'s');
	$fil=pp($_POST['fil'],'s');
	$sptl=pp($_POST['sptl'],'s');
	
	$mod_data=loadModulData($mod);
	$cData=getColumesData($mod);
	$cData_id=getColumesData($mod,1);
	$title=$mod_data[2];
	$cDaTotal=count($cData);
	$co_title='';
	if($mod_data[15]){
		?><div class="win_body">
		<div class="form_body so" type="full">
        <form name="co_export" id="co_export" method="post" action="<?=$f_path?>S/sys_export_do.php" target="_blank">
        <input type="hidden" name="mod" value="<?=$mod?>"/>
        <input type="hidden" name="fil" value="<?=$fil?>"/>
        <input type="hidden" name="ms" value="<?=$ms?>"/>
        <input type="hidden" name="msd" value="<?=$msd?>"/>
        <input type="hidden" name="sptl" value="<?=$sptl?>"/>
        <table width="100%" border="0" cellspacing="0" cellpadding="4" class="infoTable" type="static"  >
        <tr>
        <td width="25%" class="f1 fs14"><?=k_xp_typ?></td>
        <td width="75%"><div class="radioBlc so fl" name="ex_type" req="1" >
        <input type="radio" name="ex_type" checked value="1" /><label><?=k_print?></label>
        <input type="radio" name="ex_type" value="2" /><label><?=k_xcl?></label>
        </div></td></tr>
        
        <tr><td class="f1 fs14"><?=k_sh_xp_dt?></td>
        <td><input name="ex_date" value="1" type="checkbox" checked><div class="cb"></div></td></tr>
        
        <tr><td class="f1 fs14"><?=k_mn_titl?></td>
        <td><input type="text" name="ex_title" value="<?=$title?>"/></td></tr>
        
        <tr><td class="f1 fs14"><?=k_sb_titl?></td>
        <td><input type="text" name="sub_title" value="<?=serDataViwe($mod,$fil,1)?>"/></td></tr>
		
		<tr><td class="f1 fs14"><?=k_recs_num?> <span>*</span></td>
        <td><input type="text" name="ex_rec" required value=""/>
		<span><?=k_sel_recs_num_or_all?></span></td></tr>
		
        <tr><td class="f1 fs14"><?=k_fields?></td>
        <td><div class="MultiBlc so fl" chM="fileds" n="8"><?
			$vals='';
            foreach($cData_id as $data){
				$ch='off';
				if($data[6]){
					$ch='on';
					if($vals)$vals.=',';
					$vals.=$data[0];
				}
				echo '<div class="cMul" v="'.$data[0].'" ch="'.$ch.'" n="8888" set>'.get_key($data[2]).'</div>';
            }?> 
            <input  type="hidden" name="fileds" id="mlt_fileds" value="<?=$vals?>" n="8888" >
        </div></td>
        </tr>
		
		
        </table>
        </form>
        </div>
        <div class="form_fot fr">
    	  <div class="bu bu_t2 fr" onclick="win('close','#m_info2')"><?=k_cancel?></div>
          <div class="bu bu_t3 fl" onclick="sub('co_export')"><?=k_export?></div>     
    	</div>
        </div>
		<script>$('#m_info2').dialog('option', 'title','<?=k_xp_dt_sc?> ( <?=$title?> )');</script><?
	}
}?>