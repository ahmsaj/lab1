<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['code'])){
	$code=pp($_POST['code'],'s');
	$r=getRecCon('_help',"code='$code'");
	if($r['r']){
		$type=$r['type'];
		if($type){
			$mod=$r['mod'];
			$table=$modTable[$type];
			$name=get_val_c($table,'title_'.$lg,$mod,'code');
		}else{
			$name=k_home_page;
		}?>
		<div class="win_body">
			<div class="form_header f1 fs18 lh40 clr1" >
			<div class="fr ic40x ic40_add br0 icc4" onclick="addHVid('<?=$code?>')"></div>
			<?=$name?></div>
			<div class="form_body so" type="full">				
				<table width="100%" border="0" id="tab_cons"  class="grad_s holdH g_ord" type="static" cellspacing="0" cellpadding="4" t_ord="_help_videos" c_ord="ord">
				<tr>
					<th width="40"></th>
					<th><?=k_title?></th>
					<th><?=k_video_link?></th>
					<th><?=k_youtube_link?></th>
					<th><?=k_active?></th>
					<th width="100"></th>
				</tr><?
				$sql="select * from _help_videos where h_code='$code' order by ord ASC";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				$i=0;
				while($r=mysql_f($res)){
					$id=$r['id'];
					$ord=$r['ord'];
					$tiltle=$r['title_'.$lg];
					$video=$r['video_'.$lg];
					$youtube=$r['youtube'.$lg];
					$act=$r['act'];
					echo '<tr row_id="'.$id.'" row_ord="'.$ord.'">
					<td class="reSoHold"><div></div></td>
					<td>'.$tiltle.'</td>
					<td>'.$video.'</td>
					<td>'.$youtube.'</td>
					<td><div class="act_'.$act.' c_cont"></div></td>
					<td>
						<div class="fr ic40 ic40_edit icc11" onclick="addHVid(\''.$code.'\','.$id.')" title="'.k_edit.'"></div>
						<div class="fr ic40 ic40_del icc22" onclick="delHV(\''.$code.'\','.$id.')" title="'.k_delete.'"></div>
					</td>
					</tr>';
					$i++;
				}?>
				</table>		
			</div>
			<div class="form_fot fr">
				<div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_cancel?></div>
			</div>
    	</div><?
	}
}?>