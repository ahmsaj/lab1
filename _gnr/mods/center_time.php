<? include("../../__sys/mods/protected.php");?>
<? 
if(getTotalCO('gnr_m_users_times'," id=0 ")==0){mysql_q("INSERT INTO gnr_m_users_times (id)values(0)");}
if(isset($_POST['type'])){
	$days='';
	$fd=0;
	for($i=0;$i<7;$i++){		
		if(isset($_POST['week'.$weekMod[$i]])){
			if($fd==1){$days.=',';}
			$fd=1;
			$days.=$weekMod[$i];
		}
	}
	$duration=pp($_POST['duration'],'s');
	$type=pp($_POST['type']);
	if($type==1){
		$sheft_s1=pp($_POST['sheft_s1'],'s');
		$sheft_e1=pp($_POST['sheft_e1'],'s');
		$sheft_s2=pp($_POST['sheft_s2'],'s');
		$sheft_e2=pp($_POST['sheft_e2'],'s');
		$data=$sheft_s1.','.$sheft_e1.','.$sheft_s2.','.$sheft_e2;
	}
	if($type==2){
		$data='';
		$f=0;
		for($i=0;$i<7;$i++){		
			if(isset($_POST['week'.$weekMod[$i]])){
				$v=$weekMod[$i];
				if($f==1){$data.='|';}
				$sheft_s1=pp($_POST['sheft_s1_'.$v],'s');
				$sheft_e1=pp($_POST['sheft_e1_'.$v],'s');
				$sheft_s2=pp($_POST['sheft_s2_'.$v],'s');
				$sheft_e2=pp($_POST['sheft_e2_'.$v],'s');
				$data.=$sheft_s1.','.$sheft_e1.','.$sheft_s2.','.$sheft_e2;
				$f=1;
			}
		}
	}	
	$sql="UPDATE gnr_m_users_times set days='$days',duration='$duration',type='$type',clinic='$clinic',data ='$data' where id=0";
	mysql_q($sql);
	echo '<!--***-->do_x';exit;
}else{
	
$range_s=3600*0;
$range_e=3600*24;
?>
<form method="post" name="ds" id="ds" action="<?=$f_path?>X/gnr_user_time_save.php">
<input type="hidden" name="id" value="0"/>	
<div class="centerSideInFull of"><? 
	$sql="select * from gnr_m_users_times where id ='0' ";
	$res=mysql_q($sql);
	$rows=mysql_n($res);
	if($rows>0){
		$r=mysql_f($res);
		$days=$r['days'];
		$duration=$r['duration'];
		$type=$r['type'];
		$data=$r['data'];
		$sec=$r['sec'];
		$sheft_s1=$sheft_e1=$sheft_s2=$sheft_e2='';
		if($set_type==2)$type=2;
		$type1='';
		$type2='';
		$typec1='';
		$typec2='';
		if($type==1){
			$d1=explode(',',$data);
			if(count($d1)==4){
				$sheft_s1=$d1[0];
				$sheft_e1=$d1[1];
				$sheft_s2=$d1[2];
				$sheft_e2=$d1[3];
			}
			$typec1=' act ';
			$type2=' hide ';
		}
		if($type==2){
			$typec2=' act ';
			$type1=' hide ';
			
			$dd1=explode('|',$data);
			$dd2=explode(',',$days);
			for($s=0;$s<count($dd2);$s++){
				$v=$dd2[$s];
				$vv=$dd1[$s];
				$vvv=explode(',',$vv);
				if(count($vvv)==4){
					${'sheft_s1_'.$v}=$vvv[0];
					${'sheft_e1_'.$v}=$vvv[1];
					${'sheft_s2_'.$v}=$vvv[2];
					${'sheft_e2_'.$v}=$vvv[3];
				}
			}
		}
		$time_w=30;?>
        <div class="fxg h100" fxg="gtc:250px 1fr|1fr"> 
            <div class="r_bord pd10 ofx so cbg4">
                <div class="f1 fs14 lh50 b_bord "><?=k_work_days?>: <?=$def_title?> </div><?			
                $s_days_arr=explode(',',$days);
                $set_days_arr=explode(',',$set_days);				
                for($i=0;$i<7;$i++){
                    if(in_array($weekMod[$i],$set_days_arr) || $user==0){
                    $ch='';
                    if(in_array($weekMod[$i],$s_days_arr) && $days!=''){$ch=' checked ';}
                    echo '<input type="checkbox" name="week'.$weekMod[$i].'" value="'.$weekMod[$i].'" par="w_d" '.$ch.'/>
                    <div class=" check_label f1 fs16">'.$wakeeDays[$weekMod[$i]].'</div>';
                    }
                }?>
                <div class="b_bord uLine"></div>
                <div class="ic40 icc2 ic40_save ic40Txt" onclick="save_Dset()"><?=k_save?></div> 
            </div>
            <div class="pd10 of cbg444 fxg" fxg="gtr:auto 1fr|1fr">
                <div class="rep_header w100 b_bord lh60">
                    <div n="n1" class="fl <?=$typec1?>" onclick="dateType(1);"><?=k_req_wkly?></div>
                    <div n="n2" class="fl <?=$typec2?>" onclick="dateType(2);"><?=k_irregular?></div>
                </div>
                <input type="hidden" name="type" id="d_type" value="<?=$type?>"/>
                
                <div class="ofx so w100">
                    <div bn="n1" class="<?=$type1?>">
                        <table border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" style="max-width:400px">
                            <tr>
                                <th width="120"><?=k_begins?></th>
                                <th width="120"><?=k_ends?></th>
                            </tr>
                            <tr>
                            <td>
                                <select name="sheft_s1" style="" class="so"><?            
                                for($i=($range_s);$i<=$range_e;$i+=$time_w*60){
                                    $sel='';if($i==$sheft_s1)$sel=' selected';
                                    echo '<option value="'.$i.'" '.$sel.' >'.date('A h:i ',$i).'</option>';
                                }?>
                                </select>
                            </td>
                            <td>
                                <select name="sheft_e1"  class="so"><?              
                                for($i=($range_s);$i<=$range_e;$i+=$time_w*60){
                                    $sel='';if($i==$sheft_e1)$sel=' selected';
                                    echo '<option value="'.$i.'" '.$sel.' >'.date('A h:i ',$i).'</option>';
                                }?>
                                </select>
                            </td>
                            </tr>
                        </table>
                    </div>
                    <div bn="n2" class="<?=$type2?>">
                        <table border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" width="100%" style="max-width:400px">
                        <tr>
                            <th><?=k_tday?></th>
                            <th width="100"><?=k_begins?></th>
                            <th width="100"><?=k_ends?></th>
                        </tr><? 
                        for($s=0;$s<7;$s++){
                            $d_num=$weekMod[$s];?>
                            <tr rn="d_<?=$weekMod[$s]?>">
                                <td class="f1 fs14"><?=$wakeeDays[$d_num]?></td>
                                <td>
                                    <select name="sheft_s1_<?=$d_num?>" style="width:100%;" class="so"><?
                                    for($i=$range_s;$i<=$range_e;$i+=$time_w*60){
                                        $sel='';if($i==${'sheft_s1_'.$d_num})$sel=' selected';
                                        echo '<option value="'.$i.'" '.$sel.' >'.date('A h:i ',$i).'</option>';
                                    } ?>
                                    </select>
                                </td>
                                <td>
                                    <select name="sheft_e1_<?=$d_num?>" style="width:100%;" class="so"><?
                                    for($i=$range_s;$i<=$range_e;$i+=$time_w*60){
                                        $sel='';if($i==${'sheft_e1_'.$d_num})$sel=' selected';
                                        echo '<option value="'.$i.'" '.$sel.' >'.date('A h:i ',$i).'</option>';
                                    }?>
                                    </select>
                                </td>
                            </tr><?
                        }?>
                        </table>
                    </div>		
                </div>
            </div>
        </div>
        <? }?>
</div>
</form>
<script>
$(document).ready(function(){
	loadFormElements('#ds');
	fixPage();	
	setupForm('ds','');
	fixForm();
	$('div[par=w_d]').click(function(){showSetDays();})
	showSetDays();
})
</script>
<? 

}?>