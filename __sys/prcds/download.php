<? session_start();
if(isset($_GET['d'],$_GET['c'])){
	include("../dbc.php");
	include("../f_funs.php");
	$fileHead=array(
		'pdf'=>'application/pdf'
		,'xls'=>'application/vnd.ms-excel'
		,'xlsx'=>'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
	);
	$lang_data=checkLang();
	$lg=$lang_data[0];
	loginAjax();list($proAct,$proUsed)=proUsed($mod);
	$code=pp($_GET['c'],'s');
	$date=pp($_GET['d']);	
	$sql="select * from _files where date='$date' and code='$code'";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows){
		$r=mysql_f($res);
		$id=$r['id'];
		$ex=$r['ex'];
		$name=$r['name'];
		$code=$r['code'];
		$date=$r['date'];
		$file=$r['file'];
		$folder=date('y-m',$date).'/';
		$file_path='../../sFile/'.$folder.$file;
		if(file_exists($file_path)){
			$Head=$fileHead[$ex];
			header("Content-Type: $Head; charset=UTF-8");			
			header("Content-disposition: filename= $name ");			
			echo file_get_contents($file_path);
		}
	}
}?>