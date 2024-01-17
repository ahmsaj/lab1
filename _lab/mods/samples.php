<? include("../../__sys/mods/protected.php");?>
<?
$clinic=getDoc_Clinic();
list($clinc_name,$clinc_code)=get_val('gnr_m_clinics','name_'.$lg.',code',$clinic);
list($doc,$sex,$doc_photo)=get_val('_users','name_'.$lg.',sex,photo',$thisUser);
$w='';
if(_set_b7jbsn8oog==0){$w='400px';}?>
<div class="centerSideInFull of">
    <div class="fxg h100" fxg="gtc:1fr <?=$w?> |gtr:50px 1fr"> 
        <div class="of r_bord b_bord cbg444 w100">
            <div class="lh50 uLine pd10 f1 fs18 cbg4">
            <div class="fr" id="soBut"></div><?=k_waiting?> ( <ff class="labNn1">0</ff> )</div>
        </div>
        <? if(_set_b7jbsn8oog==0){?>
            <div class="lh50 b_bord pd10 f1 fs18 cbg4"><?=k_sampels?> ( <ff class="labNn2">0</ff> )</div>
        <? }?>
        <div class="lvisR1 pd10f ofx so r_bord"></div>
        <? if(_set_b7jbsn8oog==0){?>
            <div class="fl of r_bord fxg" fxg="gtr:auto 1fr">
                <div class="pd5f cbg44">
                    <!-- <div></div> -->
                    <div class="f1 fs14"><input type="number" id="rsno" onkeyup="resvLSNo()"/></div>
                    <div class="f1 fs12 lh40 TC" t id="rlsMsg"><?=k_rcv_sam?></div>   
                </div>                
                <div class="lvisR2 pd10  ofx so mg10v"></div>
            </div>
        <? }?>
    </div>
</div>

<div class="hide fl">
    <audio id="ay" src="<?=$m_path?>images/y.mp3" type="audio/mp3"></audio>
    <audio id="ax" src="<?=$m_path?>images/x.mp3" type="audio/mp3"></audio>
</div>

<script>
    sezPage='vis_lab';
    $(document).ready(function(e){
        samples_ref(1);
        $('#cn_bc').focus();refPage(8,10000);
        var a_y = $('#ay')[0];
        var a_x = $('#ax')[0];
    });
</script>