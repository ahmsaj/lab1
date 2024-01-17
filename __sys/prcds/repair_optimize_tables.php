<? include("ajax_header.php");
if(isset($_POST['status'])){
	$status=pp($_POST['status'],'s');
	$sql="select * from information_schema.TABLES where TABLE_SCHEMA='"._database."'";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
 	$txtStatus=['repair'=>k_repair,'optimize'=>k_improve];
	if($rows){
		$tables='';
		while($r=mysql_f($res)){
			$table=$r['TABLE_NAME'];
			if($tables!=''){$tables.=',';}
			$tables.="`$table`";
		}
	}
	$sql="$status table $tables";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	$tr='';
	$problem=0;
	if($rows){
		while($r=mysql_f($res)){
			$table=$r['Table'];
			$msg_type=$r['Msg_type'];
			$msg_text=$r['Msg_text'];
			if($msg_type!='status'){
				$problem++;
				$tr.='<tr>
				<td>'.$table.'</td>
				<td>'.$msg_type.'</td>
				<td>'.$msg_text.'</td>
				</tr>';
			}
			//print_r($r);
		}
		if($problem){
			$tr='<div class="ofx so" fix="hp:0|wp:200">
					<table class="grad_s" width="100%" cellpadding="2" cellspacing="2" type="static">
					<tr>
						<th>'.k_table.'</th>
						<th>'.k_notif_type.'</th>
						<th>'.k_notification.'</th>
					</tr>'.$tr.'
					</table>
				  </div>';
		}
		$out='<div class="clr5 f1 fs18 lh40"> '.$txtStatus[$status].' '.k_finish.'.. '.k_detailed_result.':</div>
			<div class="f1 fs16 lh30">'.k_all_tables.':
				<ff class="pd10 lh30 cbg555">'.$rows.'</ff>
			</div>
			<div class="f1 fs16 lh30">'.k_tables_not.' '.$txtStatus[$status].':
				<ff class="pd10 lh30 cbg555">'.$problem.'</ff>';
		 if($problem){$out.='<span>'.k_expln_below.'</span>';}
		 
 	$out.='</div>
			'.$tr;
	}
	echo $out;
}?>