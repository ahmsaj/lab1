<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'])){
	$vis=pp($_POST['vis']);
	$timeTxt='';
	$r=getRec('den_x_visits',$vis);
	if($r['r']){
		$d_check=$r['d_check'];
		$d_finish=$r['d_finish'];
		$dts=$r['dts_id'];
		$status=$r['status'];
		if($status==2){
			echo '<div class="f1 cbg5 clrw fs16 lh40  TC">'.k_the_visit_ended.'</div>
			<div class="f1 fs14 lh30 clrw TC lh40">'.k_ended_on.' <ff class="fs14" dir="ltr"> '.date('Y-m-d',$d_finish).'</ff></div>';
		}else{
			$bg='cbg6';
			if($dts){
				$r2=getRec('dts_x_dates',$dts);
				$d_start=$r2['d_start'];
				$d_end=$r2['d_end'];
				$time=$d_end-$d_start;
				$timeGo=$now-min($d_start,$now);
				$perc=$timeGo*100/$time;				
				if($perc>100){$bg='cbg5';}
				$percW=min($perc,100);
				if($now<=$d_start){
					$timeTxt=k_start_in;
					$prvTime=minToHour($d_start-$now);
					$bg='cbg8';
					$percW=100;
				}
				if($now>$d_start){
					if($now>$d_end){
						$timeTxt=k_ended_since;
						$prvTime=minToHour($now-$d_end);
						
					}else{
						$timeTxt=k_rest_to_end;
						$prvTime=minToHour($d_end-$now);
					}
				}
			}else{
				$time=_set_a5ddlqulxk*60;
				$timeGo=$now-$d_check;
				$perc=$timeGo*100/$time;
				$d_end=$d_check+$time;				
				if($perc>100){$bg='cbg5';}
				$percW=min($perc,100);			
				if($now>$d_start){
					if($now>$d_end){
						$prvTime=minToHour(($now-$d_end));
						$timeTxt=k_ended_since;
					}else{
						$prvTime=minToHour(($d_end-$now));
						$timeTxt=k_rest_to_end;
					}
				}
			}
            $work_time=getRealWorkTime($vis,4);
            if($work_time){?>
                <div class="f1 fs12 lh20 of fs14 w100"><?=$timeTxt?>: <ff class="fs16"><?=dateToTimeS2($defTime)?></ff></div>		
                <div class="ff fs14 lh30 of ws w100 "><?=dateToTimeS2($time).' / '.dateToTimeS2($timeGo);?> | <?=number_format($percW,1)?> %</div>		
                <div class="cbg4 fl w100 of " fix="h:6">
                    <div class="<?=$bg?> fl " fix="h:6" style="width:<?=$percW?>%">&nbsp;</div>
                </div><?
            }else{
                if($vis_status==2){
                    echo '<div class="lh60 fs14  f1 TC clrw cbg55">'.k_visit_finshd.'</div>';
                }
            }
		}
	}
}?>