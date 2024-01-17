<? include("ajax_header.php");
$colse=0;
$r=getRecCon('_sys_alerts_items',"user='$thisUser'",' order by date ASC');
if($r['r']){
	$a_id=$r['id'];
	$as=$r['sa_id'];
	$date=$r['date'];
	$r2=getRec('_sys_alerts',$as);
	if($r2['r']){
		$title=$r2['title'];
		$date=$r2['date'];
		$des=$r2['des'];?>
		<div class="win_body sysA">
			<div class="form_header so lh40 clrw cbg5 f1 fs20 TC"><?=$title?></div>
			<div class="form_body so">
			<div class="f1 fs14 clr5"><?=k_since?> <?=timeAgo($now-$date)?></div>
			<section class="contentEditor lh30" style="font-size: 16px"><?=$des?></section>
			
			</div>
			<div class="form_fot fr">
				<div class="bu bu_t2 fr" onclick="win('close','#m_info5');"><?=k_close?></div>     
			</div>
		</div><?
		
	}else{$colse=1;}
	mysql_q("delete from _sys_alerts_items where id='$a_id';");
}else{$colse=1;}
if($colse){echo script("win('close','#m_info5')");}?>