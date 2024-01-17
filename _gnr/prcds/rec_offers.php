<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
    $clr='cbg555';
    if($id){$clr='cbg666';}?>
    <div class="h100 fxg " fxg="gtc:2fr 5fr">
        <div class="of r_bord fxg" fxg="gtr:auto 1fr" >
            <div class="fl w100 pd10 <?=$clr?> b_bord"><? 
                if($id){
                    $patName=get_p_name($id);
                    ?>
                    <div class="f1 fs14 lh40 uLine">
                        <div class="fr i30 i30_add mg5v" offerPat></div><?=$patName?>
                    </div><?
                    $sql="select * from gnr_x_offers where patient='$id' and date_e>$now and status=0 order by date DESC";
                    $res=mysql_q($sql);
                    $rows=mysql_n($res);
                    if($rows){
                        echo '<div class="pd10v clnLis2" actButt="act">';
                        while($r=mysql_f($res)){
                            $o_id=$r['id'];
                            $offer_id=$r['offer_id'];
                            $offer_name=get_val('gnr_m_offers','name',$offer_id);
                            echo '<div class="cbg6" oId2="'.$o_id.'">'.$offer_name.'</div>';
                        }
                        echo '</div>';
                    }else{
                        echo '<div class="f1 clr5 lh40">لا يوجد عروض مباعة للمريض</div>';
                    }
                }else{?>
                    <div class="f1 fs14 lh50 clr5">
                        <div class="fr i30 i30_add mg10v" offerPat></div>لا يوجد مريض محدد
                    </div><?
                }?>
            </div>
            <div class="ofx so">
                <div class="f1 fs14 lh40 mg10 b_bord">العروض المتاحة :</div>
                <div class="pd10f clnLis" actButt="act"><?
                    $date_off_end=$now-86400;
                    $sql="select * from gnr_m_offers where act=1 and date_s < $now and date_e > $date_off_end and type in(1,6) order by type ASC";
                    $res=mysql_q($sql);
                    $rows=mysql_n($res);
                    if($rows){
                        while($r=mysql_f($res)){
                            $o_id=$r['id'];
                            $name=$r['name'];
                            echo '<div oId="'.$o_id.'">'.$name.'</div>';
                        }
                    }?>
                </div>
            </div>
        </div>        
	    <div class="of" id="offerView"></div>
    </div><?
}?>