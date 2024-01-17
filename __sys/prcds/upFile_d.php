<? include("ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$r=getRec('_files',$id);	
	?>
	<div class="win_body">
	<div class="form_header">
	<div class="lh30 clr1 f1 fs14"><?=get_p_name($id)?></div>
	<div class="lh40 clr5 f1 fs18"><?=$r2['name_'.$lg]?></div>
	</div>
	<div class="form_body so"><? 
		if($r['r']){?>
			<table class="fTable" cellpadding="0" cellspacing="0" border="0">
				<tr><td n><?=k_file?>: </td><td class="fs18"><?=$r['name']?></td></tr>
				<tr><td n><?=k_type?>: </td><td i><ff><?=strtoupper($r['ex'])?></ff></td></tr>
				<tr><td n><?=k_size?>: </td><td i><ff><?=getFileSize($r['size'])?></ff></td></tr>
				<tr><td n><?=k_upload_date?>: </td><td i><ff><?=date('Y-m-d A h:i',$r['date'])?></ff></td></tr>

			</table><? 
		}?>
    </div>
    <div class="form_fot fr">
        <div class="bu bu_t3 fl" onclick="delUpFile(<?=$id?>);"><?=k_delete?></div>
		<div class="bu bu_t2 fr" onclick="win('close','#m_info5');"><?=k_close?></div> 
    </div>
    </div><?
}?>