<? include("../../__sys/prcds/ajax_header.php");
//include("../__sys/excel/func.php");
if(isset($_POST['id_process'],$_POST['state'])){
	$id_process=pp($_POST['id_process']);
	$state=pp($_POST['state'],'s');
	if($state=='down'){
		$template=pp($_POST['template']);
		list($cols,$header)=get_vals('exc_templates','cols,header_row',"id=$template");
		$prev_cols=get_val('exc_import_processes','cols',$id_process);
		
		
		if($cols){
			if($prev_cols!=$cols){
				$sql="update `exc_import_processes` set `cols`='$cols', `header_row`='$header' where id=$id_process";
				mysql_q($sql);
				if(mysql_a()>0){ echo $id_process;}
			}else{
				echo $id_process;
			}
		}
		
	}elseif(isset($_POST['name_template'])){
		$name=pp($_POST['name_template'],'s');
		if($state=='test_repeat_name'){
			$n=get_val_con('exc_templates','id',"name='$name'");
			if($n){echo "error";}
		}elseif($state=='up'){ echo templateSave($id_process,$name);}
	}
	
	
}?>