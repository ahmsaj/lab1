<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){	
	$id=pp($_POST['id']);
	if(_set_9jfawiejb9==1){
		list($v_status,$diagnosis)=get_val('lab_x_visits_requested','status,diagnosis',$id);        
		if($v_status!=4){
			if(getTotalCO('lab_x_visits_requested_items',"r_id='$id' and status!=3")==0){
				if(mysql_q("UPDATE lab_x_visits_requested set status=4 where id='$id' ")){$v_status=4;}
			}
		}?>
        <div class="h100 ofx fxg" fxg="gtr:1fr 51px">
            <div class="ofx so pd10 "><?        
                $sql="select * from lab_x_visits_requested_items where r_id='$id' order by action ASC";
                $res=mysql_q($sql);
                $rows=mysql_n($res);
                if($rows>0){?>
                    <div class="f1 fs14 lh40 clr1"><?=k_status?>: <?=$an_requst[$v_status]?></div>
                    <div class="f1 fs14 lh40 clr1"><?=k_diagnoses?> : <?=$diagnosis?></div>                    
                    <table border="0" width="100%" cellspacing="0" cellpadding="4" class="grad_s holdH mg10v" type="static">
                    <tr><th><?=k_analysis?></th><th><?=k_status?></th><th><?=k_notes?></th>
                    </tr><?
                    while($r=mysql_f($res)){
                        $x_id=$r['id'];
                        $status=$r['status'];
                        $action=$r['action'];
                        $ana=$r['ana'];
                        $act=$r['act'];
                        $ress=$r['res'];
                        $service_id=$r['service_id'];
                        $mad_name=get_val('lab_m_services','short_name',$ana);
                        $msg='';                        
                        if($status>1){
                            $msg='<div class="fr ic30 icc2 ic30_info ic30Txt mg10" onclick="veiwAnaResult('.$x_id.',2)">'.k_view_results.'</div>';
                        }
                        if($action==2){
                            if($status==0){
                                $msg='<div class="fr ic30 icc1 ic30_edit ic30Txt mg10" onclick="veiwAnaResult('.$x_id.',2)" >'.k_enter_results.'</div>';
                            }
                            if($status==2){
                                mysql_q("UPDATE lab_x_visits_requested_items SET status=3 where id='$x_id'");
                            }
                            if($status>2 && $ress ){                                
                                $msg='<div class="fl bord pd10f Over cbgw w100 TL" onclick="veiwAnaResult('.$x_id.',2)" title="'.k_edit_results.'">'.nl2br($ress).'</div>';
                            }
                        }
                        if($act==0){
                            $msg='<div class="clr5 f1">'.k_lab_not_available.'</div>';
                        }?>
                        <tr class="ana_values" id="<?=$x_id?>">    
                            <td class="f1 fs14"><?=splitNo($mad_name)?></td>
                            <td><div class="f1" style="color:<?=$an_requst_in_col[$status]?>"><?=$an_requst_in[$status]?></div></td>
                            <td class="f1"><?=$msg?></td>
                        </tr><?
                    }?>		
                    </table><?
                }?>
            </div>                
            <div class="cbg444 t_bord lh50 pd10f"><?
                if($v_status==0){
                    echo '<div class="ic30 icc22 ic30_del  ic30Txt fl" onclick="delReqAna('.$id.')">'.k_delete.'</div>';
                    echo '<div class="ic30 icc11 ic30_edit ic30Txt mg10 fl" onclick="LabNewAnalysis('.$id.')"> '.k_edit.'</div>';
                    echo '<div class="ic30 icc33 ic30_send ic30Txt fr" onclick="LabSendAnaN('.$id.')">'.k_send_tests.'</div>';
                }                
                if($v_status>2){
                    if(getTotalCO('lab_x_visits_requested_items'," r_id='$id' and action=1 and status>1")){
                        echo '<div class="fr ic30 icc4 ic30_info ic30Txt" onclick="veiwAnaResult('.$id.',1)">'.k_view_all_results.'</div>';
                    }
                }
                /*if($v_status>0){
                    if(getTotalCO('lab_x_visits_requested_items'," r_id='$id' and action=2")>0){
                        echo '<div class="ic40 icc1 ic40_print fr" title="طباعة التحاليل الخارجية" onclick="printWindow(2,'.$id.')"></div>';
                    }
                }*/?>                
            </div>
        </div><?
	}else{
		$sql="select * , x.id as id from cln_x_pro_analy_items x , cln_m_pro_analysis z where z.id=x.mad_id and x.ana_id='$id' ";
		$res=mysql_q($sql);
		$rows=mysql_n($res);
		if($rows>0){
			$view=get_val('cln_x_pro_analy','view',$id)?>
			<div class="f1 winOprNote">
				<? if($view){echo k_m_you_can_modify_the_current_values;}
				else{echo k_m_enter_the_tests_values;}?>
			</div>
			<table border="0" width="100%" cellspacing="0" cellpadding="4" class="grad_s" type="static"><?
				while($r=mysql_f($res)){
					$x_id=$r['id'];
					$mad_id=$r['mad_id'];
					$value=$r['value'];
					$note=$r['note'];
					$mad_name=$r['name_'.$lg];
					?>
					<tr class="ana_values" id="<?=$x_id?>">    
						<td class="f1" width="200"><?=$mad_name?></td>
						<td  width="80"><input type="text" style="width:80px;" class="ana_values_v<?=$x_id?>" value="<?=$value?>" placeholder="<?=k_val?>"/></td>        
						<td align="left"><input type="text" class="ana_values_n<?=$x_id?>" value="<?=$note?>" placeholder="<?=k_notes?>" style="max-width:100%"/></td>
					</tr><?
				}?>
				<tr class="ana_values" id="<?=$x_id?>">    
					<td colspan="3" class="f1">
					<div class="bu bu_t1 fl" onclick="save_anaVal()" style="width:auto"><?=k_sav_md_test_res?></div></td>
				</tr>
			</table><?
		}
	}
}?>