<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$r=getRec('lab_m_devices',$id);
	if($r['r']){
		$name=$r['name'];
		$analysis=$r['analysis'];
		$type=$r['type'];
		$d=$r['data'];
		$vals=array();
		$data=explode(',',$d);
		foreach($data as $i){$v=explode(':',$i);$vals[$v[0]]=$v[1];}
		?>
		<div class="win_body">
		<div class="form_header so lh40 clr1 f1 fs18"><?=$name.' ( '.get_val('lab_m_services','short_name',$analysis).' ) '?></div>
		<div class="form_body so" type="pd0"><?
			$sql="select * from lab_m_services_items where serv in($analysis) order by ord ASC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows){?>
				<form id="labDev" name="labDev" method="post" action="<?=$f_path?>X/lab_divices_save.php">
				<input type="hidden" name="id" value="<?=$id?>" />
				<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" type="static" >
				<tr><th><?=k_thnum?></th><th><?=k_item?></th><th width="280"><?=k_code?></th></tr><?
				while($r=mysql_f($res)){
					$id=$r['id'];
					$name_ar=$r['name_ar'];
					$name_en=$r['name_en'];
					$serv=$r['serv'];
					$srvTxt='';
					if($type==2){
						$srvTxt='<span class="ff clr1">'.get_val('lab_m_services','name_en',$serv).' </span><br>';
					}
					?>
					<tr>
					<td><ff><?=$id?></ff></td>
					<td><ff><?=$srvTxt.$name_en?></ff></td>
					<td><input class="TC" name="i<?=$id?>" type="text" value="<?=$vals[$id]?>" dir="ltr"
					/></td>
					</tr><?
				}
				?></table>
				</form><?
			}
			?>
		</div>
		<div class="form_fot fr">
			<div class="bu bu_t2 fr" onclick="win('close','#m_info4');"><?=k_close?></div>
			<div class="bu bu_t3 fl" onclick="sub('labDev');"><?=k_save?></div>
			
		</div>
		</div><?
	}
}?>