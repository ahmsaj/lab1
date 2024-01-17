<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['opr'])){
    $id=pp($_POST['id']);
    $opr=pp($_POST['opr']);
    $r=getRec('gnr_m_nurses',$id);
    if($r['r']){
        if($opr==0){?>
            <div class="winButts"><div class="wB_x fr" onclick="win('close','#full_win1');"></div></div>
            <div class="win_free">
                <div class="fxg h100" fxg="gtc:200px 1fr|gtr:50px 1fr">
                    <div class="f1 fs18 b_bord lh50 pd10" fxg="gcs:2"><?=$r['name']?> <ff class="clr5"> ( <?=$r['rate']?> / 5 )</ff></div>
                    <div class=" r_bord ofx so" nursOprs actButt="act">
                        <div class="cbg44 b_bord fs14 f1 lh50 pd10 TC" act on="1">معلومات عامة</div>
                        <div class="cbg44 b_bord fs14 f1 lh50 pd10 TC" on="2">المعدل الشهري</div>
                        <div class="cbg44 b_bord fs14 f1 lh50 pd10 TC" on="3">على مستوى الطبيب</div>
                        <div class="cbg44 b_bord fs14 f1 lh50 pd10 TC" on="4">على مستوى العيادة</div>
                    </div>
                    <div class="ofx so pd10 cbgw" id="nursInfoData"></div>
                </div>
            </div>
            <?
        }else{
            switch($opr){
                case 1:
                    $vis=getTotalCo('gnr_x_nurses_rate',"nurs='$id'");
                    $start=get_val_con('gnr_x_nurses_rate','date',"nurs='$id'","order by date ASC");
                    $end=get_val_con('gnr_x_nurses_rate','date',"nurs='$id'","order by date DESC");?>
                    <div class="pd10f">
                        <table border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" >
                            <tr><td txt>متوسط التقييم:</td><td><ff class="pd10">( <?=$r['rate']?> / 5 )</ff></td></tr>
                            <tr><td txt>عدد التقييمات:</td><td><ff class="pd10"><?=number_format($vis)?></ff></td></tr>
                            <tr><td txt>تاريخ أول تقييم:</td><td><ff class="pd10"><?=date('Y-m-d',$start)?></ff></td></tr>
                            <tr><td txt>تاريخ أخر تقييم:</td><td><ff class="pd10"><?=date('Y-m-d',$end)?></ff></td></tr>
                        </table>
                    </div>
                    <?
                break;
                case 2:
                    $vis=getTotalCo('gnr_x_nurses_rate',"nurs='$id'");
                    $start=get_val_con('gnr_x_nurses_rate','date',"nurs='$id'","order by date ASC");
                    $end=get_val_con('gnr_x_nurses_rate','date',"nurs='$id'","order by date DESC");
                    $s=intval(date('Ym',$start));
                    $e=intval(date('Ym',$end));?>
                    <div class="pd10f">
                        <table border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" >
                            <tr>
                                <th>الشهر</th>
                                <th>التقيمات </th>
                                <th>المتوسط</th>
                            </tr>
                            <?                            
                            if($start){
                                $thisMonth=$e;                                
                                while($thisMonth>=$s){                                    
                                    $y=substr($thisMonth,0,4);
                                    $m=substr($thisMonth,4,2);
                                    $Qs=strtotime($y.'-'.$m.'-1');
                                    $Qe=strtotime($y.'-'.($m+1).'-1');
                                    if($m==12){$Qe=strtotime(($y+1).'-1-1');}
                                    
                                    $q=" and date>='$Qs' and date< '$Qe' ";                                    
                                    $vis=getTotalCo('gnr_x_nurses_rate'," nurs='$id' $q");
                                    $avg=get_avg('gnr_x_nurses_rate','rate'," nurs='$id' $q");
                                    echo '<tr>
                                        <td><ff>'.$y.'-'.$m.'</ff></td>
                                        <td><ff class="pd20">'.number_format($vis).'</ff></td>
                                        <td><ff class="pd20">'.number_format($avg,2).'</ff></td>
                                    </tr>';
                                    $thisMonth--;
                                }
                            }?>
                        </table>
                    </div><?
                break;
                case 3:?>
                    <div class="pd10f">
                        <table border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" >
                            <tr>
                                <th>الطبيب</th>
                                <th>التقيمات </th>
                                <th>المتوسط</th>
                            </tr>
                            <?
                            $sql="select doc, count(vis) c , AVG(rate) a from gnr_x_nurses_rate where nurs='$id' group by doc order by a DESC";
                            $res=mysql_q($sql);                    
                            while($r=mysql_f($res)){                                
                                echo '<tr>
                                    <td txt>'.get_val('_users','name_'.$lg,$r['doc']).'</td>
                                    <td><ff class="pd20">'.number_format($r['c']).'</ff></td>
                                    <td><ff class="pd20">'.number_format($r['a'],2).'</ff></td>
                                </tr>';
                             }?>
                        </table>
                    </div><?
                break;
                case 4:?>
                    <div class="pd10f">
                        <table border="0" cellspacing="0" cellpadding="4" class="grad_s" type="static" >
                            <tr>
                                <th>الطبيب</th>
                                <th>التقيمات </th>
                                <th>المتوسط</th>
                            </tr>
                            <?
                            $sql="select clinic, count(vis) c , AVG(rate) a from gnr_x_nurses_rate where nurs='$id' group by clinic order by a DESC";
                            $res=mysql_q($sql);                    
                            while($r=mysql_f($res)){                                
                                echo '<tr>
                                    <td txt>'.get_val('gnr_m_clinics','name_'.$lg,$r['clinic']).'</td>
                                    <td><ff class="pd20">'.number_format($r['c']).'</ff></td>
                                    <td><ff class="pd20">'.number_format($r['a'],2).'</ff></td>
                                </tr>';
                             }?>
                        </table>
                    </div><?
                break;
            }
        }
    }
}?>