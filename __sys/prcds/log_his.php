<? include("ajax_header.php");
/*
if(isset($_POST['u'])){
$u=pp($_POST['u']);

$times='<section class="lh_poi">';
for($i=0;$i<24;$i++){
	$margin=$i*100/24;$t=$i;if($i>12){$t=$i-12;}
	$times.='<section style="margin-'.k_align.':'.$margin.'%">'.($t).'</section>';
}
$times.='</section>';

if($u){$q=" where user ='$u' ";$title=get_val('_users','name_'.$lg,$u);}else{$title=k_allusrs;}
echo '<div class="f1 fs18 lh40 clr1">'.$title.'</div>';
$sql="select * from _log_his $q order by s_in ASC";
$res=mysql_q($sql);
$rows=mysql_n($res);
if($rows>0){
	$today=0;
	$dayData='';
	echo '<div class="lh_days">'.$times;
	while($r=mysql_f($res)){
		$s=$r['s_in'];
		$e=$r['s_out'];
		$thisDay=$s-($s%86400);
		//if($s>($now-($now%86400))){echo $s;}
		if($thisDay!=$today){
			if($today!=0){ 
				echo '<div title="'.date('Y-m-d',$today).'">'.$dayData.'</div>';
				while(($thisDay-$today)>86400){
					$today+=86400;
					echo '<div title="'.date('Y-m-d',$today).'"></div>';
					
				}
			}
			$dayData='';
			$today=$thisDay;
		}else{
			$ss=$s%86400;
			$ee=$e%86400;
			
			//echo ' <span dir="ltr">['.clockStr($ss).'|'.clockStr($ee).'] </span>';
			if($ss > $ee){$ee=86400;}
			$width=($ee-$ss)*100/86400;
			$margin=$ss*100/86400;			
			$dayData.='<div style="width:'.$width.'%;margin-'.k_align.':'.$margin.'%" 
			title="['.clockStr($ee).' | '.clockStr($ss).'] '.date('Y-m-d',$today).'"></div>';
		}		
	}
	echo '<div title="'.date('Y-m-d',$today).'">'.$dayData.'</div>';
	echo '</div>';
}

$sql="select * from _log $q order by s_in ASC";
$res=mysql_q($sql);
$rows=mysql_n($res);
if($rows>0){
	echo '<div class="f1 fs18 lh40 clr1">'.k_crr_ses.'</div>';
	$today=0;
	$dayData='';
	echo '<div class="lh_days">'.$times;
	while($r=mysql_f($res)){
		$s=$r['s_in'];
		$e=$r['s_out'];
		$thisDay=$s-($s%86400);		
		if($thisDay!=$today){
			if($today!=0){ 
				echo '<div title="'.date('Y-m-d',$today).'">'.$dayData.'</div>';
				while(($thisDay-$today)>86400){
					$today+=86400;
					echo '<div title="'.date('Y-m-d',$today).'"></div>';					
				}
			}
			$dayData='';
			$today=$thisDay;
		}
		$ss=$s%86400;
		$ee=$e%86400;
		
		//echo ' <span dir="ltr">['.clockStr($ss).'|'.clockStr($ee).'] </span>';
		if($ss > $ee){$ee=86400;}
		$width=($ee-$ss)*100/86400;
		$margin=$ss*100/86400;			
		$dayData.='<div style="width:'.$width.'%;margin-'.k_align.':'.$margin.'%" 
		title="['.clockStr($ee).' | '.clockStr($ss).'] '.date('Y-m-d',$today).'"></div>';
	}
	echo '<div title="'.date('Y-m-d',$today).'">'.$dayData.'</div>';
	echo '</div>';
}
}*/
?>