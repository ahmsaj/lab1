<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['data'])){
	$data=pp($_POST['data'],'s');
	$arr=explode('|',$data);
	$name=pp($_POST['name'],'s');
	$data=[];
	$tables=[];
	$tables=[];
	$oprations=[];
	$rpo=50000;
	$all_rows=0;
	$all_size=0;
	$n=1;
	foreach($arr as $k=>$r){
		if($r){
			$r2=explode(',',$r);
			$table=$r2[0];
			$content=$r2[1];
			list($size,$rows)=getTableDate($table);	
			$all_rows+=$rows;
			$all_size+=$size;
			$start=0;
			$end=0;
			$column_id='id';
			if($table=='api__log'){
				$column_id='user';
			}
			if($content){				
				$start=intval(getMaxMin('min',$table,$column_id));
				$end=intval(getMaxMin('max',$table,$column_id));
			}
			$oprations=[];		
			if($content && $rows){
				$s=0;
				$e=0;
				$r=0;
				$stop=0;
				while($stop==0){
					list($s,$e,$count)=first_end_id($table,$e,$rpo,$column_id);
					if($s!=$e){
						$oprations[]=['no'=>$n,'start'=>$s,'end'=>$e,'rows'=>$count,'status'=>0];
						$r++;
						$n++;
					}else{
						if($rows==1){
							$oprations[]=['no'=>$n,'start'=>$s,'end'=>$e,'rows'=>$count,'status'=>0];
							$n++;
						}
						$stop=1;
					}				
				}
				//echo '<br>';
			}else{
				$oprations[0]=['no'=>$n,'start'=>$s,'end'=>$e,'rows'=>0,'status'=>0];
				$n++;
			}
			$tables[getRandString(10)]=[				
				'table'=>$table,
				'content'=>$content,
				'rows'=>$rows,
				'size'=>$size,
				'start'=>$start,
				'end'=>$end,
				'status'=>0,
				'oprations'=>$oprations,
				'struc'=>$oprations,
			];
			
			
		}
	}
	$id=getRandString(10);
	$folderBack;
	$buckupFolder=$folderBack.'.backup';
	if(!file_exists($buckupFolder)){mkdir($buckupFolder,0777);}
	$bFolder=$buckupFolder.'/'.$id;
	mkdir($bFolder);
	/************************* */
	$info=[
		'id'=>$id,
		'name'=>$name,
		'status'=>0,
		'rows'=>$all_rows,
		'size'=>$all_size,
		'finshed_row'=>0,
		'date'=>$now,
	];
	$data=[
		'info'=>$info,		
		'tables'=>$tables,
		//'oprations'=>$oprations
	];
	$data=show_array($data);
	$out=['err'=>0,'msg'=>$id];

	
	/************************************** */
	//info file
	$file=$bFolder.'/_info.php';
	$content='<? $BU_info=\''.json_encode($info).'\';?>';
	if(!file_exists($file)){fopen($file, "w");}								
	file_put_contents($file,$content);
	// fclose($file);
	//info tablels
	$file=$bFolder.'/_tables.php';
	$content='<? $BU_tables=\''.json_encode($tables).'\';?>';
	if(!file_exists($file)){fopen($file, "w");}								
	file_put_contents($file,$content);
	// fclose($file);
	/************************************** */
	echo json_encode($out);
}?>