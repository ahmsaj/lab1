<?
$level=1;
$id=$template=0;
$end=0;
if(isset($_GET['m_id'])){
	$pars=explode('-',$_GET['m_id']);
	$id=intval($pars[0]);
	if(count($pars)==2){$template=intval($pars[1]);}
	$lev=get_val("exc_import_processes",'level',$id);
	if($lev){$level=$lev+1;}	
}
$but="";
$but_down="action:".k_template_download.":ti_down:templateDown($id)";
$but_up="action:".k_save_as_temp.":ti_up:templateUp($id)";
if($level==1){
	$cb='printData_checkErr(1,0)';
	$but="action:".k_add.":ti_add:getForm_file('".$cb."')|action:".k_refresh.":ti_ref:printData(1,0);";
}elseif($level==2){
	$but_save="action:".k_save.":ti_save:printData_checkErr($level,$id)";
	$but_back="action:".k_back.":ti_back:loc('_import-data')";
	$but=$but_save.'|'.$but_back;
}elseif($level==3){
	$module=0;
	$mods=['0:'.k_choose_mod];
	$sql="select `code`,`title_$lg` from `_modules`";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		while($r=mysql_f($res)){
			$modCode=$r['code'];
			$modTit=$r['title_'.$lg];
			array_push($mods,"$modCode:$modTit");
		}
	}
	list($end,$module)=get_vals('exc_import_processes','count_rows,module',"id=$id");
	if($template){$module=get_val('exc_templates','module',$template);}
	$but_import="action:".k_import.":ti_bak:printData_checkErr($level,$id,$end)";
	$but_back="action:".k_back.":ti_back:backToLevel_2($id)";

	$but=$but_import.'|'.$but_back;
	
}
echo header_sec($def_title,$but);?>
<div class="centerSideInHeader lh50 f1 clr1 fs18">
	
</div>
<div class="centerSideIn so" style="overflow-x:visible;" >
	<div id="mm" fix="wp:0"></div>
</div>
<!------------------------------------------------->
<form id="linkAdvancedSet" name="linkAdvancedSet" method="post" action="<?=$f_path?>X/exc_import_info_set.php" cb="getimportStartView(<?=$id?>)" bv="a">
	<div class="centerSideInFull hide of" >
		<div class="fl " fix="w:300|hp:0">
			<div class="f1 fs18 clr1 lh50 pd10 b_bord r_bord clr_bord TC" ><?=k_import_props?>
			</div>
			<div id="dataSett" class="pd10 ofx so r_bord clr_bord" fix="hp:50"></div>
		</div>

		<div class="fl" fix="wp:300|hp:0">
			<div class=" b_bord r_bord clr_bord" > 
				<span class="f1 fs18 clr1 lh50 pd10"><?=k_link_with_module?>:</span>
				<span>
					<div class="ic40 icc4 ic40_down2 fr" title="<?=k_template_download?>" onclick="templateDown(<?=$id?>)"></div>
					<div class="ic40 icc2 ic40_up2 fr" title="<?=k_props_save_as_template?>" onclick="templateUp(<?=$id?>)"></div>
					<?=selectFromArrayWithVal('selModule',$mods,1,0,"$module",'fix="w:200" onchange="moduleChange()"')?>
				</span>
			</div>

			<div id="dataLink" class="ofx so pd10" fix="hp:50" ></div>
		</div>
	</div>
</form>
<div class="hide" level=<?=$level?>></div>
<!--script>setUpForm("linkAdvancedSet","linkAdvancedSet");</script-->
	
	
	



<? /*echo Script("printData($level,$id)");*/?>

<script>
$( document ).ready(function() {
	printData(<?=$level?>,<?=$id?>,<?=$template?>);
	setUpForm("linkAdvancedSet","linkAdvancedSet");
	$('div[aria-describedby=m_info]').keydown( function(e){
		if(e.keyCode == 27){
			e.keyCode=0;
			return false;
			//e.preventDefault();
		}
	});
	$('div[aria-describedby=m_info]').keyup( function(e){
		if(e.keyCode == 27){
			e.keyCode=0;
			return false;
			//e.preventDefault();
		}
	});
	
//	refPage('imp',5000);	
	
});

function goLevel(id){
	loc(f_path+"_import-data."+id);
}	
</script>