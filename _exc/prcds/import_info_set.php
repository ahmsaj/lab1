<? include("../../__sys/prcds/ajax_header.php");

$out=0;
if(isset($_POST['process'])&& $_POST['process']=='del'){
	if(isset($_POST['id'])){
		$id=$_POST['id'];
		$file=get_val('exc_import_processes','file_id',$id);
		if(mysql_q("delete from `exc_import_processes` where id=$id;")){
			if(mysql_q("delete from `exc_import_process_fields` where process=$id;")){
				//(mysql_a()>0){
				deleteFiles($file);
				$out=1;
				//}
			}
		}
	}
}else
if(isset($_POST['level'])){
	$lev=$_POST['level'];
	if($lev==1){
		if(isset($_POST['file'])){
			$file=$_POST['file'];
			$sql="INSERT INTO `exc_import_processes`(`level`,`file_id`,`p_start_date`) VALUES ('$lev','$file',$now)";
			if(mysql_q($sql)){$out=last_id();}
		}
	}
	elseif($lev==2){
		if(isset($_POST['process_id'],$_POST['countRows'])){
		    $id_process=$_POST['process_id'];
			$end=$_POST['countRows'];
			$header=0;
			if(isset($_POST['header_line'])){$header=pp($_POST['header_line']); $start=$header+1;}
			$cols="";
			$err=0;
			if(isset($_POST['colsCount'])){
				$colCounts=pp($_POST['colsCount']); //$int = (int)$num;
				$isFieldSel=0;
				for($i=1;$i<=$colCounts;$i++){
					if(isset($_POST["selCol_$i"])){
						if(!$isFieldSel){$isFieldSel=1;}
						if(isset($_POST["col_$i"])){
							//cols=rank_field,name_field|rankfield,name_field...
							$nameCol=pp($_POST["col_$i"],'s');
							if($nameCol==''){
								$nameCol=k_column.' ('.$i.')'; }//المسافة ضرورية لاتحذفيها من أجل أن يأخذ المفتاح
								if($cols!=""){$cols.=",";}
								$cols.=$i.":".$nameCol;	
							}
						}
				}

				if(!$isFieldSel){$err=1;/*error not sel cols*/}
				if(!$err){
					$sql="update`exc_import_processes` set `level`=$lev, `cols`='$cols', `header_row`='$header', `start_line`=$start ,`end_line`=$end,`count_rows`=$end,`imported_end`=0 where id=$id_process";
					if(mysql_q($sql)){$out=$id_process;}
				}
			}
		}
	}if(isset($_POST['name_template'])){
				$name=pp($_POST['name_template'],'s');
				if($state=='test_repeat_name'){
					$n=get_val_con('exc_templates','id',"name='$name'");
					if($n){echo "error";}
				}elseif(isset($_POST['id_process'])){
					$id=pp($_POST['id_process']);
					echo templateSave($id,$name);
				}
			}
	elseif($lev==3){
		$dataArr=[];
		if(isset($_POST['start_row'],$_POST['end_row'],$_POST['emptyFields'],$_POST['selModule'],$_POST['id_process'])){
			
			$start=pp($_POST['start_row']);
			$end=pp($_POST['end_row']);
			$fields_empty=pp($_POST['emptyFields'],'s');
			$module=pp($_POST['selModule'],'s');
			$file=get_val("exc_import_processes","file_id",$id_process);
			$id_process=pp($_POST['id_process']);
			$out=setDataLevel_3($module,$fields_empty,'exc_import_processes','exc_import_process_fields',$id_process,$start,$end);

			
		}
		
		
		
	}
	
}
echo $out;