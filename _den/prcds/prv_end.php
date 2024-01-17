<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
    $rate=pp($_POST['rate']);
    if(_set_hgsa9kq373 && $rate==1){
        if(getTotalCo('gnr_x_nurses_rate',"mood=4 and vis='$id' ")==0){
            echo 'rate';
            exit;
        }
    }
	$r=getRec('den_x_visits',$id);
	if($r['r']){
		$status=$r['status'];
		$patient=$r['patient'];
		if($status==1){
			$sql="select * from den_x_visits_services where patient='$patient' and doc='$thisUser' order by d_start DESC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			?>
            <div class="h100 fxg of" fxg="gtr:1fr 60px">
                <div class="fxg of" fxg="gtc: 1.5fr 1fr">
                    <div class="ofx so pd10"><?
                        if($rows>0){?>
                            <div class="f1 fs16 lh50 clr1 pd10 uLine"><?=k_srvs_prvd?></div>
                            <table class="grad_s holdH" width="100%" cellpadding="4" cellspacing="0" type="static" over="0">		
                            <tr>
                                <th width="100"><?=k_date?></th>
                                <th><?=k_service?></th>
                                <th><?=k_val_srv?> </th>
                                <th><?=k_complete_percent?> </th>
                                <th><?=k_rcvble?></th>
                            </tr><?
                            $t1=$t2=$t3=0;
                            while($r=mysql_f($res)){
                                $service=$r['service'];
                                $total_pay=$r['total_pay'];
                                $d_start=$r['d_start'];
                                $end_percet=$r['end_percet'];
                                $srvTxt=get_val_arr('den_m_services','name_'.$lg,$service,'s');
                                $srvNet=0;
                                if($end_percet){
                                    $srvNet=$total_pay*$end_percet/100;
                                }
                                $t1+=$total_pay;
                                $t2+=$end_percet;
                                $t3+=$srvNet;
                                ?>
                                <tr>
                                <td><ff14><?=date('Y-m-d',$d_start)?></ff14></td>
                                <td txtS><?=$srvTxt?></td>
                                <td><ff14 class="clr8"><?=number_format($total_pay)?></ff14></td>					
                                <td><ff14>%<?=$end_percet?></ff14></td>	
                                <td><ff14  class="clr6"><?=number_format($srvNet)?></ff14></td>
                                </tr><?
                            }?>
                            <tr fot>
                                <td colspan="2" txtS><?=k_total?></td>
                                <td class="cbg8"><ff14 class="clrw"><?=number_format($t1)?></ff14></td>
                                <td></td>	
                                <td class="cbg6"><ff14 class="clrw"><?=number_format($t3)?></ff14></td>
                            </tr>
                            </table><?
                        }else{?>
                            <div class="f1 fs16 clr5 lh60 pd20"><?=k_no_srvcs?> </div><?
                        }?>
                    </div><?
                    $pay=patDenPay($patient,$thisUser);
                    $bal=$t3-$pay;
                    $balPay=$bal;
                    if($balPay<0){$balPay=0;}
                    $maxPay=$t1-$pay;
                    if($maxPay<0){$maxPay=0;}?>
                    <div class="l_bord  ofx so pd10" >
                        <div class="f1 fs16 lh50 clr1 pd10 uLine"><?=k_srvs_prvd?></div>
                        <table width="100%" border="0" cellspacing="0" cellpadding="4" type="static" class="grad_s holdH">
                        <tr>
                            <td class="f1"><?=k_val_srvs?>  : </td>
                            <td class="TC cbg8" width="100"><ff14 class="clrw"><?=number_format($t1)?></ff14></td>
                        </tr>
                        <tr>
                            <td class="f1"> <?=k_comp_srv_val?> : </td>
                            <td class="TC cbg6"><ff14 class="clrw"><?=number_format($t3)?></ff14></td>
                        </tr>
                        <tr>
                            <td class="f1"><?=k_prev_pays?>  :</td>
                            <td class="TC cbg5"><ff14 class="clrw"><?=number_format($pay)?></ff14></td>
                        </tr>
                        <tr>
                            <td class="f1"><?=k_balance?> :</td>
                            <td class="TC cbg66 clrw">
                                <ff class="clrw"><?=number_format($bal)?></ff><br> 
                                <ff14 class="clr6"><?=number_format($maxPay)?></ff14>
                            </td>
                        </tr>
                        <tr fot>
                            <td class="f1"><?=k_proposed_pay?>  :</td>
                            <td class="TC"><input type="number" max="<?=$maxPay?>" id="denPay" value="<?=$balPay?>" ></td>
                        </tr>
                        </table>
                    </div>
                </div>                
                <div class="t_bord cbg444">
                    <div class="ic40x ic40_done ic40Txt icc2 fr mg10f" endDenVis><?=k_end?></div>
                </div>
            </div>
			
			<?
		}else{
			echo script("loc('_Visit-Den')");
		}
	}
}?>