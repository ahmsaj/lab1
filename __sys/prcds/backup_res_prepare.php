<? include("../../__sys/prcds/ajax_header.php");
$id=pp($_POST['id'],'s');
$type=pp($_POST['type'],'s');
$sel_table=$_POST['tables'];	
$newTable=[];
$err=0;
$msg='';

$dir= $folderBack.'.backup/'.$id.'/';
$info =$dir.'_info.php';
$tables = $dir.'_tables.php';
$tables_res=$dir.'_tables_res.php';
if(!file_exists($tables_res)){
	$rows=0;
	$size=0;
	include($dir.'_tables.php');
	$tables_list=json_decode($BU_tables,true);
	foreach($tables_list as $id=>$table){
		if(in_array($id,$sel_table)){
			$table['status']=0;
			foreach($table['oprations'] as $k=>$oprations){				
				$table['oprations'][$k]['status']=0;
			}
			$newTable[$id]=$table;
			$rows+=$table['rows'];
			$size+=$table['size'];			
		}
	}
	$file=$dir.'_tables_res.php';
	$content='<? $BU_tables=\''.json_encode($newTable).'\';?>';
	if(!file_exists($file)){fopen($file, "w");}								
	file_put_contents($file,$content);
	//fclose($file);

	$file=$dir.'_info_res.php';
	include($dir.'_info.php');
	$info=json_decode($BU_info,true);
	$info['type']=$type;
	$info['date']=$now;
	$info['rows']=$rows;
	$info['size']=$size;
	$info['finshed_row']=0;
	$info['status']=0;
	$content='<? $BU_info=\''.json_encode($info).'\';?>';
	if(!file_exists($file)){fopen($file, "w");}								
	file_put_contents($file,$content);
	//fclose($file);
	
}else{	
	$err=1;
	$msg='تم انشاء';
}

$out=[
	'id'=>$id,
	'err'=>$err,
	'msg'=>$msg,	
];
echo json_encode($out);
