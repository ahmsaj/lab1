<? include("../../__sys/prcds/ajax_header.php");

$dayNo=date('w');
$h_time=get_host_Time();
$h_realTime=$h_time[1]-$h_time[0];
$x_doctor=array();
$date=date('Y-m-d');
/********************************************************************************/
$sql="select doc from gnr_x_arc_stop_doc where `date`='$date' ";
$res=mysql_q($sql);
$rows=mysql_n($res);
if($rows>0){
	while($r=mysql_f($res)){
		$doc=$r['doc'];
		array_push($x_doctor,$doc);		
	}
}
/*********************************************************************************/
$sql="select * , u.id as u_id from _users u , gnr_m_users_times d where u.id=d.id and u.act=1 ";
$res=mysql_q($sql);
$rows=mysql_n($res);
$docs_data=array();
if($rows>0){
	$i=0;
	while($r=mysql_f($res)){
		$docs_data[$i]['doc']=$r['id'];
		$docs_data[$i]['name']=$r['name_'.$lg];
		$docs_data[$i]['clinic']=$r['subgrp'];
		$docs_data[$i]['days']=$r['days'];
		$docs_data[$i]['type']=$r['type'];
		$docs_data[$i]['data']=$r['data'];
		$i++;
	}
}
/*********************************************************************************/
$sql="select * from gnr_m_clinics where act=1 order by ord ASC";
$res=mysql_q($sql);
$rows=mysql_n($res);
if($rows>0){
	$starT=$h_time[0]/60/60;
	$P_width=100/(($h_time[1]-$h_time[0])/3600);
	$hows=intval($h_time[1]-$h_time[0])/3600;
	/***********************/
	$timePointer="";
	for($i=0;$i<$hows-1;$i++){		
		$time=$i+$starT;
		$mins=':00';
		if($time!=intval($time)){
			$mins=':30';
			$time=intval($time);
		}
		if($time>12){$time=$time-12;}
		$timePointer.='<div style="width:'.$P_width.'%">'.($time.$mins).'</div>';
	}
	$time=$i+$starT;
	if($time>12){$time=$time-12;}	
	$timePointer.='<div style="width:1px">'.($time.':00').'</div>';
	/***********************/
	echo '<div class="datesTable">
		<div class="lh30 cb">&nbsp;<div class="fl">'.clockStr($h_time[0]).'</div><div class="fr">'.clockStr($h_time[1]).'</div></div>';
	while($r=mysql_f($res)){
		$c_id=$r['id'];
		$photo=$r['photo'];
		$name=$r['name_'.$lg];
		$type=$r['type'];		
		$str_data='';
		foreach($docs_data as $data){
			if($data['clinic']==$c_id){				
				if(in_array($dayNo,explode(',',$data['days']))){
					$d_time=get_doc_Time($data['type'],$data['data'],$data['days']);					
					$d_realTime=$d_time[1]-$d_time[0];					
					$bar_width=($d_realTime*100)/$h_realTime;
					if($d_time[0]-$h_time[0]==0){
						$bar_margin=0;
					}else{
						$bar_margin=($d_time[0]-$h_time[0])*100/$h_realTime;
					}
					$status=1;
					if(in_array($data['doc'],$x_doctor)){$status=2;}					
					$d1='<div class="timePointer fl">'.$timePointer.'</div>
					<div class=" clic_bar_in cbn_'.$status.'" 
					style="width:'.$bar_width.'%;margin-'.k_align.':'.$bar_margin.'%" onclick="dateDocInfo('.$data['doc'].')">
					'.$data['name'].' | <span dir="ltr">'.clockStr($d_time[0]).' &raquo; '.clockStr($d_time[1]).'</span></div>';					
					if($d_time[2]){
						$d_realTime=$d_time[3]-$d_time[2];					
						$bar_width=($d_realTime*100)/$h_realTime;
						$bar_margin=($d_time[2]-$h_time[0])*100/$h_realTime;						
						$status=1;
						if(in_array($data['doc'],$x_doctor)){$status=2;}					
						$d2='<div class="timePointer fl">'.$timePointer.'</div>
						<div class=" clic_bar_in cbn_'.$status.'" 
						style="width:'.$bar_width.'%;margin-'.k_align.':'.$bar_margin.'%" onclick="dateDocInfo('.$data['doc'].')">
						'.$data['name'].' | <span dir="ltr">'.clockStr($d_time[2]).' &raquo; '.clockStr($d_time[3]).'</span></div>';
					}					
					$str_data.='<div class="clic_bar">'.$d1.$d2.'</div>';$d1=$d2='';
				}
			}
		};
		if($str_data){echo '<div class="lh60 f1 fs18">'.$name.'</div>'.$str_data.'<div class="cliLine fl"></div>';
		}	
	}
	echo '</div>';
}?>