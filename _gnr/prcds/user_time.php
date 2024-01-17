<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	list($sex,$clinic,$name)=get_val('_users','sex,subgrp,name_'.$lg,$id);
	if($sex==1){$d_t=k_dr;}else{$d_t=k_dr_f;}
	$d_title=$d_t.' : '.$name;
	if(getTotalCO('gnr_m_users_times'," id=$id ")==0){mysql_q("INSERT INTO gnr_m_users_times (id)values('$id')");}?>
	<form method="post" name="ds" id="ds" action="<?=$f_path?>X/gnr_user_time_save.php">
	<input type="hidden" name="id" value="<?=$id?>"/>
	<div class="win_body">
	<div class="form_header so lh40 clr1 f1 fs18"><?=$d_title?></div>	
	<div class="form_body of" type="full_pd0">
        <div class="fxg h100" fxg="gtc:200px 1fr|1fr"><? 
            $sql="select * from gnr_m_users_times where id =0 ";
            $res=mysql_q($sql);
            $rows=mysql_n($res);
            if($rows>0){
                $r=mysql_f($res);
                $set_days=$r['days'];
                $set_type=$r['type'];
                $set_data=$r['data'];
                if($set_type==1){
                    $d1=explode(',',$set_data);
                    if(count($d1)==4){
                        $range_s=$d1[0];
                        $range_e=$d1[1];
                    }
                }
                if($set_type==2){
                    $dd1=explode('|',$set_data);
                    $dd2=explode(',',$set_days);
                    for($s=0;$s<count($dd2);$s++){
                        $v=$dd2[$s];
                        $vv=$dd1[$s];
                        $vvv=explode(',',$vv);
                        if(count($vvv)==4){
                            ${'range_s'.$v}=$vvv[0];
                            ${'range_e'.$v}=$vvv[1];					
                        }
                    }
                }
                $time_w=30;
            }
            $sql="select * from gnr_m_users_times where id ='$id' ";
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
                if($set_type==2){$type=2;}
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
                <div class="r_bord pd10 ofx so">
                    <div class="f1 fs14 lh50 b_bord "><?=k_work_days?>: </div><?
                    $s_days_arr=explode(',',$days);
                    $set_days_arr=explode(',',$set_days);			
                    for($i=0;$i<7;$i++){
                        if(in_array($weekMod[$i],$set_days_arr)){
                            $ch='';
                            if(in_array($weekMod[$i],$s_days_arr) && $days!=''){$ch=' checked ';}
                            echo '<input type="checkbox" name="week'.$weekMod[$i].'" value="'.$weekMod[$i].'" par="w_d" '.$ch.'/>
                            <div class=" check_label f1 fs18 lh40">'.$wakeeDays[$weekMod[$i]].' </div>';
                        }
                    }?>
                </div>
                <div class="w100 pd10 ofx so">
                    <div class="rep_header fl">
                        <div n="n1" class="fl <?=$typec1?>" onclick="dateType(1);"><?=k_req_wkly?></div>
                        <div n="n2" class="fl <?=$typec2?>" onclick="dateType(2);"><?=k_irregular?></div>
                        <input type="hidden" name="type" id="d_type" value="<?=$type?>"/>
                    </div>
                    
                    
                    <div class="w100 ">
                        <div bn="n1" class="<?=$type1?>">
                            <table border="0" cellspacing="0" cellpadding="4" class="grad_s" width="100%" type="static">
                            <tr>
                            <th colspan="2"><?=k_frst_shift?></th>
                            <th colspan="2"><?=k_scnd_shift?></th>
                            </tr>
                            <tr>					
                                <th><?=k_begins?></th>
                                <th><?=k_ends?></th>					
                                <th><?=k_begins?></th>
                                <th><?=k_ends?></th>
                            </tr>
                            <tr>
                                <td>
                                    <select name="sheft_s1"  class="so"><?            
                                    for($i=($range_s);$i<=$range_e;$i+=$time_w*60){
                                        $sel='';if($i==$sheft_s1)$sel=' selected';
                                        echo '<option value="'.$i.'" '.$sel.' >'.date('A h:i ',$i).'</option>';
                                    }?>
                                    </select>
                                </td>
                                <td>
                                    <select name="sheft_e1" lass="so"><?              
                                    for($i=($range_s);$i<=$range_e;$i+=$time_w*60){
                                        $sel='';if($i==$sheft_e1)$sel=' selected';
                                        echo '<option value="'.$i.'" '.$sel.' >'.date('A h:i ',$i).'</option>';
                                    }?>
                                    </select>
                                </td>					
                                <td>
                                    <select name="sheft_s2" class="so"><option value="0" ></option><?
                                    for($i=($range_s);$i<=$range_e;$i+=$time_w*60){
                                        $sel='';if($i==$sheft_s2)$sel=' selected';
                                        echo '<option value="'.$i.'" '.$sel.' >'.date('A h:i ',$i).'</option>';
                                    }?>
                                    </select>
                                </td>      
                                <td>
                                    <select name="sheft_e2" class="so"><option value="0" ></option><?
                                    for($i=($range_s);$i<=$range_e;$i+=$time_w*60){
                                        $sel='';if($i==$sheft_e2){$sel=' selected';}
                                        echo '<option value="'.$i.'" '.$sel.' >'.date('A h:i ',$i).'</option>';
                                    } ?>
                                    </select>
                                </td>							
                            </tr>
                            </table>
                        </div>
                        <div bn="n2" class="<?=$type2?>">
                            <table border="0" cellspacing="0" cellpadding="4" class="grad_s holdH" type="static" width="100%">		
                                <tr>
                                    <th rowspan="2"><?=k_tday?></th>
                                    <th colspan="2" class="fs18"><?=k_frst_shift?></th>
                                    <? if($id!=0){?><th colspan="2"><?=k_scnd_shift?></th><? }?>
                                </tr>
                                <tr>
                                    <th width="100"><?=k_begins?></th>
                                    <th width="100"><?=k_ends?></th>
                                    <? if($id!=0){?><th width="100"><?=k_begins?></th>
                                    <th width="100"><?=k_ends?></th><? }?>
                                </tr><? 
                                for($s=0;$s<7;$s++){
                                    $d_num=$weekMod[$s];
                                    if(in_array($weekMod[$s],$set_days_arr) || $id==0){
                                    if($id!=0 && $set_type==2){
                                        $range_s=${'range_s'.$weekMod[$s]};
                                        $range_e=${'range_e'.$weekMod[$s]};
                                    }?>
                                    <tr rn="d_<?=$weekMod[$s]?>">
                                        <td class="f1 fs14"><?=$wakeeDays[$d_num]?></td>
                                        <td>
                                            <select name="sheft_s1_<?=$d_num?>" fix="w:100" class="so"><? 
                                            for($i=$range_s;$i<=$range_e;$i+=$time_w*60){
                                                $sel='';if($i==${'sheft_s1_'.$d_num})$sel=' selected';
                                                echo '<option value="'.$i.'" '.$sel.' >'.date('A h:i ',$i).'</option>';
                                            }?>
                                            </select>
                                        </td>
                                        <td>
                                            <select name="sheft_e1_<?=$d_num?>" fix="w:100" class="so"><?
                                            for($i=$range_s;$i<=$range_e;$i+=$time_w*60){
                                                $sel='';if($i==${'sheft_e1_'.$d_num})$sel=' selected';
                                                echo '<option value="'.$i.'" '.$sel.' >'.date('A h:i ',$i).'</option>';
                                            }?>
                                            </select>
                                        </td><? 
                                        if($id!=0){?>
                                            <td>
                                                <select name="sheft_s2_<?=$d_num?>" fix="w:100" class="so">
                                                <option value="0" ></option><?
                                                for($i=$range_s;$i<=$range_e;$i+=$time_w*60){
                                                    $sel='';
                                                    if($i==${'sheft_s2_'.$d_num}){$sel=' selected';}
                                                    echo '<option value="'.$i.'" '.$sel.' >'.date('A h:i ',$i).'</option>';
                                                } ?>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="sheft_e2_<?=$d_num?>" fix="w:100" class="so">
                                                <option value="0" ></option><?         
                                                for($i=$range_s;$i<=$range_e;$i+=$time_w*60){
                                                    $sel='';if($i==${'sheft_e2_'.$d_num})$sel=' selected';
                                                    echo '<option value="'.$i.'" '.$sel.' >'.date('A h:i ',$i).'</option>';
                                                }?>
                                            </select>
                                            </td><? 
                                        }?>
                                    </tr><?
                                }
                                }?>
                            </table>						
                        </div>
                    </div>
                </div>
            <? }?>	
        </div>
    </div>	
    <div class="form_fot fl">
		<div class="bu bu_t3 fl" onclick="save_Dset()"><?=k_save?></div>
        <div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>     
    </div>
    </div>
	</form><?
}?>