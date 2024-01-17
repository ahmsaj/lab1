<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$b_id=pp($_POST['b_id'],'s');
	$id=pp($_POST['id']);
	$dir= $folderBack.'.backup/'.$b_id.'/';
	$info =$dir.'_info_res.php';
	$tables = $dir.'_tables_res.php';
    $data_file = $dir.'data_'.$id.'.php';
	$next=0;
	$done=0;
	$out=['id'=>0,'next'=>0,'prog'=>'','rows'=>0];
	if(file_exists($info) && file_exists($tables) && file_exists($data_file)){        
		include($info);
		include($tables);
        
		$info=json_decode($BU_info,true);
		$tables=json_decode($BU_tables,true);
             
		$rows=$info['rows'];		
		$finshed_row=0;//$info['finshed_row'];
		$status=$info['status'];
		if($info['status']==0){$info['status']=1;}
        $type=$info['type'];
		foreach($tables as $k => $table){         		
			$tab=$table['table'];
			$tab_rows=$table['rows'];
			$tab_status=$table['status'];
			$start=$table['start'];
			$end=$table['end'];            
			foreach ($table['oprations'] as $k2 => $val){              
                $structure=0;
                if($k2==0){$structure=1;}
				if($id==$val['no']){					
					if($val['status']==0){
						$tab_contnet=1;												
						$start=$val['start'];
						$end=$val['end'];
						$data_file = $dir.'data_'.$id.'.php';
                        $DATA=file_get_contents($data_file);
						//echo $tab;						
                        $data=json_decode($DATA,true);                     
                       // echo '('.$data[$tab]['AI'].')';
                        //echo show_array($data);
                        backupRestor($tab,$data[$tab],$val,$type,$structure);
						$tables[$k]['oprations'][$k2]['status']=1;
						$done=1;
                        $finshed_row+=$val['rows'];
					}else{
						$id++;          	
					}
					$next=$id+1;
				}                
				if($val['status']==1){$finshed_row+=$val['rows'];}
			}
		}
		//if($next==0){$info['status']=2;}
		/************Update Info ************* */
		 $info['finshed_row']=$finshed_row;
		// if(!file_exists($file)){fopen($file, "w");}								
		// file_put_contents($file,$content);
		
		$file=$dir.'/_info_res.php';
		$content='<? $BU_info=\''.json_encode($info).'\';?>';
		if(!file_exists($file)){fopen($file, "w");}								
		file_put_contents($file,$content);
		// fclose($file);
		/************Update tables ************* */
		$file=$dir.'_tables_res.php';
		$content='<? $BU_tables=\''.json_encode($tables).'\';?>';
		if(!file_exists($file)){fopen($file, "w");}
		file_put_contents($file,$content);
		// fclose($file);
		
        $per=$finshed_row*100/$rows;
        $prog='<div class="cbgw pd10f br5 mg10v">
            <div class="f1 fs16 TC lh40">'.number_format($per,3).'%</div>
            <div class="snc_prog "><div style="width:'.number_format($per,3).'%"></div></div>
            <div class="f1 fs12 TC lh20">'.number_format($rows).'/'.number_format($finshed_row).'</div>
        </div>';
    }
	$out=[
		'id'=>$id,
		'next'=>$next,
		'prog'=>$prog,
		'rows'=>$rows,
	];
	if(!file_exists($dir.'data_'.$next.'.php')){
		deleleBuckup($b_id,2);
	}
	echo json_encode($out);
}?>