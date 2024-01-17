<? include("_ajax_head_cFile.php");
if(isset($_GET['d'])){
	$id=pp($_GET['d']);
	$sql="select * from _backup where id='$id' ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$file=$r['file'];
		$date=$r['date'];
		$date=date('Y-m-d A g:i:s ',$date);
		header('Content-type: application/sql');
		header('Content-Disposition: attachment; filename="Backup_'.$date.'.mwb"');
		readfile('../backup/'.$file);
	}
}?>