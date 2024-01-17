<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['p'])){
	$id=pp($_POST['id']);
    $p=pp($_POST['p']);
    $q='';
    if($p){$qq=" and id<$p ";}
    $r=getRec('api_chat',$id);
    $viewRec=20;
    if($r['r']){
        $patient=$r['patient'];
        $pat_type=$r['pat_type'];
        $s_date=$r['s_date'];
        $last_act=$r['last_act'];
        $active_user=$r['active_user'];
        $status=$r['status'];
        $pat=get_p_dts_name($patient,$pat_type);
        $total=getTotalCO('api_chat_items',"chat_id='$id' $qq ");
        $q='';
        $resStr=$total-$viewRec;
        $resStr=max($resStr,0);                
        $sql="select * from api_chat_items where chat_id='$id' $qq order by date ASC limit $resStr,$viewRec";
        $res=mysql_q($sql);
        $rows=mysql_n($res);
        $newMess=0;
        $data='';
        $last_id=0;
        if($rows){
            while($r=mysql_f($res)){
                $m_id=$r['id'];
                $mt=$r['mess_type'];
                $mess=$r['mess'];
                $user=$r['user'];
                $date=$r['date'];
                $status=$r['status'];
                if(!$last_id){
                    $last_id=$m_id;
                }
                if($status==0 && $newMess==0 && $mt==1){
                    $data.='<div t="3" p>الرسائل الجديدة</div>';
                    $newMess=1;                            
                }
                if($mt==1){$status=1;}
                    $data.='<div t="'.$mt.'" s="'.$status.'" n="'.$m_id.'">
                    <div>'.$mess.'
                        <div>'.date('Y-m-d A h:m:s',$date).'</div>
                    </div>
                </div>';
            }
            if($newMess==0){
                $data.='<div t p>&nbsp;</div>';
                $newMess=1;
            }
            if($p==0){readAll($id);}
        }
        echo $resStr.'^'.$last_id.'^';
        if($p==0){?>
            <div class="fl of w100 h100" >
                <div class="fl cbg444 w100 lh50 b_bord pd10">
                    <div class="fl f1 fs16"><?=$pat?></div>
                    <div class="fr ic30 ic30_x icc2 ic30Txt mg10v" closeChat>إغلاق المحادثة</div>
                </div>
                <div class="fl w100 mesIn ofx so " fix="hp:112" id="mesIn">
                    <div t p>&nbsp;</div>
                    <?=$data;?>
                </div>
                <div class="fl cbg444 w100 lh60 t_bord ofx so">
                    <div class="fl pd10" fix="wp:50"><input type="text" id="newMess"/></div>
                    <div class="fl ic40x ic40_send icc4 mg10v" newMess></div>
                </div>
            </div><?
        }else{            
            echo $data;
        }
    }
}?>