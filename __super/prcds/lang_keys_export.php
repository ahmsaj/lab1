<?
include("../library/ex_reader.php");
include('../ajax/_ajax_head_cFile.php');
if($thisGrp=='s'){include("../funs.php");}
$name='exported_keys'.$count_mod.'_'.date('Ymdhis',$now).'.xls';
header("Content-Type: text/csv; charset=UTF-8");			
header("Content-disposition:attachment; filename= $name ");
$output = fopen('php://output', 'w');
fputs($output, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));

$sql="SELECT * FROM `_langs`";
$res=mysql_q($sql);
$rows=mysql_n($res);
$row=1;
if($rows){
	while($r=mysql_f($res)){
		$lang=$r['lang'];
		$lang_name=$r['lang_name'];
		$langs[$lang]=$lang_name;
	}
	$sql="select * from _lang_keys";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	$row=1;
	$xls=[];
	$xls[0][0]='id';
	if($rows){
		while($r=mysql_f($res)){
			$id=$r['id'];
			$xls[$row][0]=$id;
			$col=1;
			foreach($langs as $lang=>$lang_name){
				if($row==1){$xls[0][$col]=$lang;}
				$val=$r['_'.$lang];
				if($val){$xls[$row][$col]=$val;}				
				$col++;
			}
			$row++;
		}
	}
	foreach($xls as $row){
		fputcsv($output,$row);		
	}	
}
