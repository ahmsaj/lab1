<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['t'],$_POST['y'],$_POST['d'])){
	$t=pp($_POST['t']);
	$y=pp($_POST['y']);
	$d=pp($_POST['d'],'s');
	
	$s_date=date('Y',getMaxMin('min','gnr_x_acc_payments','date'));
	$e=getMaxMin('max','gnr_x_acc_p','date');
	$e_date=date('Y',$e);
	$last_id=getMaxMin('max','gnr_x_acc_p','id');

	$d_s=strtotime($y.'-1-1');
	$d_e=strtotime(($y+1).'-1-1');
	$d_e=min($d_e,$e);
	$o=0;
	if($y>=$s_date && $y<=$e_date){
		if($t==1){
			$dd=explode(',',$d);
			foreach($dd as $k=>$v){
				if($v){
                    $v=min($v,100);
                    $amount=" ROUND(((amount*$v)/100),-2) ";
                    if($v=='-1'){$amount='0';}
					$sql="UPDATE gnr_x_acc_payments SET amount= $amount
					where mood=$k and date>='$d_s' && date<='$d_e' and id<='$last_id' and pay_type=1 ";
					mysql_q($sql);
					$o+=mysql_a();	
				}
			}
		}
		if($t==2){
			if($d>=0 && $d<8){				
				$q='';				
				$t1='gnr_x_acc_p';
				$t2='gnr_x_acc_payments';
				if($d){$q=" $t1.mood='$d' and ";}
				$sql="UPDATE $t2 INNER JOIN $t1 ON $t2.id = $t1.id 
				SET $t2.amount = $t1.amount WHERE $q $t1.date>='$d_s' and $t1.date<='$d_e' ";
				mysql_q($sql);
				$o+=mysql_a();
			}
		}
		echo k_edited_recs.' : <ff> ( '.$o.' )</ff>';
	}
}?>