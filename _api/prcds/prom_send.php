<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
    $r=getRec('api_x_promotion',$id);
    if($r['r']){
        $name=$r['name'];
        $status=$r['status'];
        $total=$r['total'];
        if($status<4){
            ?>
            <div class="win_body">
            <div class="form_header so lh40 clr1 f1 fs18"><?=$name?></div>
            <div class="form_body so" type="full">            
                <div class="f1 fs14 lh40 ">
                    الجمهور المستهدف : <ff14 class=" clr5"> ( <?=$total?> )</ff14>
                </div><? 
                
                    echo '<div id="sendNot" >
                        <div class="fl ic30 ic30_send ic30Txt icc4" onclick="prom_send_do('.$id.')">بدء الإرسال</div>
                    </div>';
                ?>
            </div>
            <div class="form_fot fr">
                <div class="bu bu_t2 fr" onclick="loadModule('wuv9f0s7zj');win('close','#m_info');"><?=k_close?></div>
            </div>
            </div><?
        }
    }
}?>