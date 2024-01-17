<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['vis'],$_POST['pat'])){
	$vis=pp($_POST['vis']);
	$pat=pp($_POST['pat']);
    $act_id=pp($_POST['id']);
    $viewType=pp($_POST['t']);
	$sql="select * from den_x_visits_services where patient ='$pat' and ( status in(0,1) OR (status=2 and d_finish>$ss_day )) and (doc=0 OR doc='$thisUser' )  order by  status DESC, d_start ASC";
    if($viewType==2){
        $sql="select * from den_x_visits_services where patient ='$pat' and (doc=0 OR doc='$thisUser') order by  status DESC, d_start ASC";
    }
	$res=mysql_q($sql);
	$rows=mysql_n($res);?>
    <div class="pd10f pr denOpsL" actButt="act"><?
        if($rows){
            while($r=mysql_f($res)){
                $id=$r['id'];
                $service=$r['service'];
                $d_start=$r['d_start'];
                $status=$r['status'];
                $teeth=$r['teeth'];
                $serDoc=$r['doc'];
                $serDoc_add=$r['doc_add'];
                $end_percet=$r['end_percet'];
                $total_pay=$r['total_pay'];
                
                $serviceTxt=get_val_arr('den_m_services','name_'.$lg,$service,'srv');
                if($status==0 && $serDoc==0){$status=4;}                    
                list($s_ids,$subServ,$percet)=get_vals('den_m_services_levels','id,name_'.$lg.',percet'," service=$service",'arr');
                $teethTxt='';
                if($teeth){
                    $tt=explode(',',$teeth);
                    $teethTxt.='<div t class="teethNo">';
                    foreach($tt as $ttt){$teethTxt.='<div>'.$ttt.'</div>';}
                    $teethTxt.='</div>';
                }
                $act='';
                if($act_id==$id){$act='act';}?>
                <div class="fl w100 mg5v pd20 pd10v br5" oprNo="<?=$id?>" <?=$act?>>
                    <div class="f1 lh20 clr2 fs14"><?=splitNo($serviceTxt)?></div>
                    <div class="f1" dSta="<?=$status?>"><?=$denSrvS[$status]?>                    
                    <ff14 class=" clr5 ff fs14 lh30" dir="ltr" title="<?=k_price_serv?>"> (£<?=number_format($total_pay)?>)</ff14>
                    </div>
                    <div class="mg10v t_bord ph10v">
                        <div d class="fr lh30"><ff14><?=date('Y-m-d',$d_start)?></ff14></div>
                        <div class="fl lh30 "><?=$teethTxt?></div>
                    </div>
                </div><?
            }
        }else{?><section class="f1 fs16 lh40 clr5"><?=k_no_ctin?></section><? }?>
   </div>
    ^
    <div class="ofx so h100 pd10">
        <div class="fl w100 f1 fs14 clr2  cbg777 br5  bord mg10v denMHis">
            <div class="lh40 b_bord cbg7 br5">
                <div class="fr i30 i30_add mg5f" addHisItem></div>
                <div class="f1 lh40 fs14 clr2 cbg7 pd10">السوابق المرضية</div>
            </div>
            <?=den_medical_history($pat,$name,$color,$short_code,$iconT,$visStatus)?>
        </div>
        <div class="f1 fs14  ">يمكن إضافة إجراء جديد من الزر الأحمر بعلامة +</div>
        <? if($rows){?>
            <div class="f1 fs14 mg10v">- أختر من قائمة الإجراءات لإظهار التفاصيل</div>
        <?}?>
        <div class="f1 fs14 clr2 mg10v cbg555 clr55 pd10f">ملاحظة :
            <br> قائمة الخدمات تتضمن الاجراءات الجاري العمل عليها أو الإجراءات الخاصة بهذا اليوم لإظهار كافة الإجراءات يمكن أختير ( عرض جميع الإجراءات ) من القائمة أو الضغط على الزر أرشيف الإجراءات  
        </div>
        
    </div><?
}?>
