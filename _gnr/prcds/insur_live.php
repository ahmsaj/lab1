<? include("../../__sys/prcds/ajax_header.php");
$dayNo=date('w');
$h_time=get_host_Time();
$h_realTime=$h_time[1]-$h_time[0];
$x_doctor=array();
$date=date('Y-m-d');
$blcs=array('','');
/*********************************************************************************/
$sql="select * from gnr_x_temp_oprs where type=3  order by date ASC";
$res=mysql_q($sql);
$rows=mysql_n($res);
if($rows){	
	while($r=mysql_f($res)){
		$id=$r['id'];
		$clinic=$r['clinic'];
		$type=$r['type'];
		$mood=$r['mood'];
		$vis=$r['vis'];
		$patient=$r['patient'];
		$pat_name=$r['pat_name'];
		$status=$r['status'];
		$sub_status=$r['sub_status'];
		$date=$r['date'];
		$subPart='';
		$statusTxt=k_since.' <ff14> '.dateToTimeS2($now-$date);
		$clinicTxt=get_val_arr('gnr_m_clinics','name_'.$lg,$clinic,'cl');
		$action='ins_det('.$id.')';
		if($status==1){$action='insurResEnter('.$id.')';}
		$blcs[$status].='
		<div class="fl w100 chrBlc '.$col.'" onclick="'.$action.'" style="border-bottom-color:'.$clinicTypesCol[$mood].'">
			<div class="fl w100 f1 fs14 clr1 lh30">'.$pat_name.' <span class="f1 clr5"> ( '.$clinicTypes[$mood].' )</span></div>
			<div class="fl fs14 lh20">'.$statusTxt.'</ff14></div>
				
		</div>';
	}
}
echo $blcs[0].'^'.$blcs[1];?>