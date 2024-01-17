<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);?>
    <div class="win_body">
    <div class="form_body so"><?
		$sql="select * from _users u , gnr_m_users_times d where u.id=d.id and u.act=1  and u.id='$id'";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		$docs_data=array();
		if($rows>0){			
			$r=mysql_f($res);
			$name=$r['name_'.$lg];
			$clinic=$r['subgrp'];
			$days=$r['days'];
			$type=$r['type'];
			$data=$r['data'];			
			
			$d_days=explode(',',$days);
			echo '<div class="f1 fs18 clr1 lh40 TC">'.$name.'</div>';
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" over="0">';
			$day_no=date('w');
			foreach($d_days as $d){				
				if($type==1){
					$d_data=explode(',',$data);
					$thisDay='<ff>'.clockStr($d_data[0]).' &raquo; '.clockStr($d_data[1]).'</ff>';
				}
				if($type==2){
					$d_dates=explode('|',$data);
					$i=0;                            
					foreach($d_days as $dd){
						if($dd==$d){
							$dd_dates=explode(',',$d_dates[$i]);
							 $thisDay='<ff14>'.clockStr($dd_dates[0]).' - '.clockStr($dd_dates[1]).'</ff14><br>';
							 if($dd_dates[2]){
								$thisDay.='------------<br><ff14>'.clockStr($dd_dates[2]).' - '.clockStr($dd_dates[3]).'</ff14><br>';
							 }
						}
						$i++;
					}
				}
				$clor='';
				if($day_no==$d){$clor=$clr44;}
				echo '<tr bgcolor="'.$clor.'"><td class="f1 fs16 ">'.$wakeeDays[$d].'</td><td dir="ltr">'.$thisDay.'</td></tr>';
			}
			echo '</table>';
				
		}
		?>
    </div>
    <div class="form_fot fr">
        <div class="bu bu_t2 fr" onclick="win('close','#m_info4');"><?=k_close?></div><?
		$date=date('Y-m-d');
		if($thisGrp!='pfx33zco65'){	
        if(getTotalCO('gnr_x_arc_stop_doc'," `doc`='$id' and `date`='$date'")>0){?>
	        <div class="bu bu_t1 f1 fl" onclick="stopDocToday(<?=$id?>)"><?=k_doc_attnd?></div>
        <? }else{ ?>
        	<div class="bu bu_t3 f1 fl" onclick="stopDocToday(<?=$id?>)"><?=k_dnt_attnd?></div>
        <? }
		}?>
    </div>
    </div><? 
	
}?>