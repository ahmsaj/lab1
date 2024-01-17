<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$b_id=pp($_POST['b_id'],'s');
	$id=pp($_POST['id']);
	$dir= $folderBack.'.backup/'.$b_id.'/';
	$info =$dir.'_info.php';
	$tables = $dir.'_tables.php';
	$next=0;
	$done=0;
	if(file_exists($info) && file_exists($tables)){
		include($dir.'_info.php');
		include($dir.'_tables.php');
		$info=json_decode($BU_info,true);
		$tables=json_decode($BU_tables,true);		
		$rows=$info['rows'];
		$finshed_row=0;//$info['finshed_row'];
		$status=$info['status'];
		if($info['status']==0){$info['status']=1;}
		foreach($tables as $k => $table){
			$tab=$table['table'];
			$tab_rows=$table['rows'];
			$tab_status=$table['status'];
			$start=$table['start'];
			$end=$table['end'];

			$column_id='id';
			if($tab=='api__log'){
				$column_id='user';
			}	

			foreach ($table['oprations'] as $k2 => $val) {
				if($next==0 && $done==1){
					$next=$val['no'];					
				}
				if($id==$val['no']){
					if($val['status']==0){
						$structure=0;
						$tab_contnet=1;
						$start=$val['start'];
						if($k2==0){
							$structure=1;
						}
						$start=intval($val['start']);
						$end=intval($val['end']);						
						$data=backUpTable($tab,"where `$column_id` >= $start and `$column_id` <= $end ",$tab_contnet);
						//$data=str_replace("`","'",json_encode($d`ata,JSON_UNESCAPED_UNICODE));
						$out=json_encode($data,JSON_UNESCAPED_UNICODE);
						file_put_contents($dir.'data_'.$val['no'].'.php', $out);
						$tables[$k]['oprations'][$k2]['status']=1; 
						$finshed_row+=$val['rows'];
						$done=1;
					}else{			
						$id++;
					}
				}
				if($val['status']==1){$finshed_row+=$val['rows'];}
			}
		}
		if($next==0){$info['status']=2;}
		/************Update Info ************* */
		// $info['finshed_row']=$finshed_row;
		// if(!file_exists($file)){fopen($file, "w");}								
		// file_put_contents($file,$content);
		
		$file=$dir.'/_info.php';
		$content='<? $BU_info=\''.json_encode($info).'\';?>';
		if(!file_exists($file)){fopen($file, "w");}								
		file_put_contents($file,$content);
		// fclose($file);
		/************Update tables ************* */
		$file=$dir.'_tables.php';
		$content='<? $BU_tables=\''.json_encode($tables).'\';?>';
		if(!file_exists($file)){fopen($file, "w");}								
		file_put_contents($file,$content);
		// fclose($file);
	}
	$per=$finshed_row*100/$rows;
	$prog='<div class="cbgw pd10f br5 mg10v">
		<div class="f1 fs16 TC lh40">'.number_format($per,3).'%</div>
		<div class="snc_prog "><div style="width:'.number_format($per,3).'%"></div></div>
		<div class="f1 fs12 TC lh20">'.number_format($rows).'/'.number_format($finshed_row).'</div>
	</div>';
	$out=[
		'id'=>$id,
		'next'=>$next,
		'prog'=>$prog,
		'rows'=>$rows,
	];
	echo json_encode($out);
}?>