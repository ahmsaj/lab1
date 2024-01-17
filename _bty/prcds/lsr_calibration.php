<? include("../../__sys/prcds/ajax_header.php");
    $vis=pp($_POST['vis']);
    $device_id=get_val('bty_x_laser_visits','device',$vis);
    $r=getRecCon('bty_m_laser_device',"id = '$device_id' ");
    if($r['r']){        
        $device_id=$r['id'];
        $c1=$r['count1'];
        $c2=$r['count2'];?>
        <div class="win_body">
        <div class="form_header so lh40 clr1 f1 fs18"><?=k_chos_countr_strikes?></div>
        <div class="form_body so">
        <form name="calFor" id="calFor" action="<?=$f_path?>X/bty_lsr_calibration_save.php" method="post" cb="calibCb();" bv="">
            <input name="id" type="hidden" value="<?=$device_id?>" />
            <table class="fTable" cellpadding="0" cellspacing="0" border="0">
                <tr>
                    <td n=""><?=k_counter?>: <span>*</span></td>
                    <td i="" dir="rtl">
                        <div class="radioBlc " req="1" evn="0">
                        <input type="radio" name="countT" value="1" required/><label><ff>Alex : <?=number_format($c1)?></ff></label>
                            <input type="radio" name="countT" value="2"/><label><ff>NdYag : <?=number_format($c2)?></ff></label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td n=""><?=k_num_of_strikes?> : <span>*</span></td>
                    <td i="" dir="ltr"><input name="cont" type="number" required /></td>
                </tr>		
            </table>
        </form>
        </div>
        <div class="form_fot fr">
            <div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>
            <div class="bu bu_t3 fl" onclick="sub('calFor');"><?=k_save?></div>
        </div>
        </div><?
    }

?>