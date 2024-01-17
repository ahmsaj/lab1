<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['v_id'],$_POST['t'])){
	$id=pp($_POST['id']);
	$v_id=pp($_POST['v_id']);
	$t=pp($_POST['t']);
	$rows=0;
	$manual_sending=intval(_set_8g9zjll9cm);//0=>without,1=>auto sending, 2=>manual sending
	if($id==0){
		$sending=0;
		if($manual_sending==1){$sending=1;}
        $date=get_val($visXTables[$t],'d_start',$v_id);
		mysql_q("delete from gnr_x_prescription_itemes where presc_id in(select id from gnr_x_prescription where status=0 and doc='$thisUser')");
		mysql_q("delete from gnr_x_prescription where status=0 and doc='$thisUser'");
		list($patient,$clinic,$date)=get_val($visXTables[$t],'patient,clinic,d_start',$v_id);
        $complaint_txt=get_vals('cln_x_prev_dia','val'," visit='$v_id' ",' , ');        
		mysql_q("INSERT INTO gnr_x_prescription (mood,visit,clinic,doc,patient,date,complaint_txt,add_date)
		values('$t','$v_id','$clinic','$thisUser','$patient','$date','$complaint_txt','$now')");
		$id=last_id();
		echo script('actSelPres='.$id.';');
		$pStatus=0;		
		$process_status=0;
	}else{
		$r=getRec('gnr_x_prescription',$id);
		if($r['r']){
			$patient=$r['patient'];
			$clinic=$r['clinic'];
			$pStatus=$r['status'];
			$note=$r['note'];
			$complaint_txt=$r['complaint_txt'];
			$sending=intval($r['sending_status']); //0=> not sent, 1=>sent
			$process_status=intval($r['process_status']);//0=>not processed, 1=>not exchanged , 2=>completely ecchanged, 3=> half exchanged			
			if($r['doc']!=$thisUser){out();exit;}
		}else{
			exit;
		}
	}
	if($manual_sending){
		if(!$sending){
			$title="إرسال للصيدلية";// مرسلة للصيدلية
			$icon="ic40_send";
			$status=1;//sent
		}else if($process_status==0){// مرسلة لكن لم تتمك معالجتها أبدا
			$title="استرجاع الوصفة من الصيدلية";
			$icon="ic40_ref";
			$status=0;//retreived
		}
	}
    $sql_i="select * from gnr_x_prescription_itemes where presc_id='$id' group by mad_id order by id";
    $res_i=mysql_q($sql_i);
    $rows_i=mysql_n($res_i);?>
    <div class="win_body">
        <div class="form_body of" type="full_pd0">
            <div class="fxg h100" fxg="gtc:400px 1fr|gtr:52px calc(100% - 50px)">
                <div class="fs18 f1 lh40 r_bord b_bord ti40 ti40_pres pd5f">
                    <?=k_medicines_list?> <ff id="mdc_tot">( <?=number_format(getTotal('gnr_m_medicines'));?> )</ff>
                    <?=script('ptu='.$thisUser.';');?>
                </div>
                <div class="fs18 f1 lh40 b_bord ti40 ti40_list pd5f">
                    <?=k_prescription_details?> <ff id="mdcTot">( <?=$rows_i?> )</ff>
                    <div class="fr">
                        <div class="fr ic40 icc4 ic40_reload" onclick="loadPreTamp()" title="<?=k_download_prescription_form?>"></div>
                        <div class="fr ic40 icc2 ic40_save" onclick="savePreTamp()" title="<?=k_remember_prescription_form?>"></div>
                        <div class="fr ic40 icc1 ic40_note" onclick="presc_add_note(<?=$id?>)" title="إضافة ملاحظة"></div>
<!--
                        <? if($manual_sending==2){?>
                            <div class="fr ic40 Over cbg77 <?=$icon?>" onclick="presc_send_toPhr(<?=$id?>,<?=$status?>)" title="<?=$title?>"></div>
                        <?}?>
-->
                    </div>
                </div>

                <div class="h100 fxg r_bord" fxg="gtr:60px 1fr|gtc:1fr 1fr">
                    <div class="fs18 f1 lh50 pd10f fxg" fxg="gcs:2">
                        <input type="text" id="ser_prescr"  placeholder="<?=k_search?>" />
                    </div>
                    <div class="ofx r_bord so h100"><?
                        $sql="select * from gnr_m_medicines_cats order by name_$lg ASC";
                        $res=mysql_q($sql);
                        $rows=mysql_n($res);
                        if($rows>0){		
                            echo '<div class="catListStyle" prescList actButt="actCat">';
                            echo '<div actCat cn="0">'.k_all_cats.'</div>';		
                            while($r=mysql_f($res)){
                                $c_id=$r['id'];
                                $catname=$r['name_'.$lg];															
                                echo '<div cn="'.$c_id.'">'.$catname.'</div>';
                            }
                            echo'</div>';			
                        }?>
                    </div>
                    <div class="h100 ofx so " id="mdcList"></div>

                </div>

                <div class="ofx so h100 pd10f">
                    <div class="f1 fs16 lh40 clr1" preCompSec>
                    <div class="fr i40 i40_edit" preComp title="<?=k_edit?>"></div><?=k_diagnoses?> : 
                    <span class="f1 fs16 clr1 lh40 "><? if($complaint_txt){echo $complaint_txt;}?></span>
                    </div>
                    <div class="f1 hide" preCompEdit> 
                        <textarea t class="f1 fs16 bord cbg444 w100" fix="h:80"></textarea>
                        <div class="bu bu_t3 " onclick="prescrCompSave(<?=$id?>);"><?=k_save?></div>
                    </div>
                    <div class="clr55 lh40 f1 fs14" pn="<?=$id?>"><?=splitNo($note)?></div>
                    <table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" id="mdcTable">
                        <tr>
                        <th><?=k_medicine?></th>
                        <th><?=k_dosage?></th>
                        <th><?=k_num_of_tim?></th>
                        <th><?=k_dosage_status?></th>
                        <th><?=k_duration?></th>
                        <th>الكمية</th>
                        <th width="150"></th>
                        </tr><?

                        if($rows_i){
                            while($r=mysql_f($res_i)){
                                $r_id=$r['id'];
                                $mad_id=$r['mad_id'];
                                $dose=$r['dose'];
                                $num=$r['num'];
                                $duration=$r['duration'];
                                $dose_s=$r['dose_s'];
                                $note=$r['note'];
                                $name=$dose_t=$num_t=$duration_t=$dose_s_t='';
                                $name=get_val_arr('gnr_m_medicines','name',$mad_id,'m');
                                $quantity=$r['presc_quantity'];						
                                if($dose){$dose_t=get_val_arr('gnr_m_medicines_doses','name_'.$lg,$dose,'m1');}
                                if($num){$num_t=get_val_arr('gnr_m_medicines_times','name_'.$lg,$num,'m2');}
                                if($duration){$duration_t=get_val_arr('gnr_m_medicines_duration','name_'.$lg,$duration,'m3');}
                                if($dose_s){$dose_s_t=get_val_arr('gnr_m_medicines_doses_status','name_'.$lg,$dose_s,'m4');}
                                echo '
                                <tr mdc="'.$r_id.'">
                                    <td txt>'.splitNo($name).'
                                    <div class="clr55" mn="'.$r_id.'">'.splitNo($note).'</div>
                                    </td>
                                    <td txt>'.splitNo($dose_t).'</td>
                                    <td txt>'.splitNo($num_t).'</td>
                                    <td txt>'.splitNo($dose_s_t).'</td>
                                    <td txt>'.splitNo($duration_t).'</td>
                                    <td txt><ff class="clr5 fs18 Over"  id="mq_'.$r_id.'" onclick="editMdcQ('.$r_id.')">['.splitNo($quantity).']</ff></td>
                                    <td>
                                        <div class="fr ic40 icc2 ic40_del" onclick="delMdc('.$r_id.')" title="'.k_delete.'"></div> 
                                        <div class="fr ic40 icc1 ic40_edit" onclick="editMdc('.$r_id.')" title="'.k_edit.'"></div>
                                        <div class="fr ic40 icc4 ic40_note" onclick="presc_add_note('.$r_id.',\'medicin\')" title="إضافة ملاحظة"></div>
                                </td>
                                </tr>';
                            }
                        }?>				
                    </table>
                </div>
            </div>
        </div>
        <div class="form_fot fr">
            <div class="bu bu_t3 fl" onclick="endPres();"><?=k_end?></div>		
        </div>
    </div><?
}?>
