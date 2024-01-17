<? include("../../__sys/mods/protected.php");?>
<?=header_sec($def_title,'');
$data=get_val_con('_settings','val',"code='0ydmtuvd3x'");
$data=str_replace("'",'"',$data);
$data=json_decode($data, true);?>
<div class="centerSideInHeader lh50"></div>
<div class="centerSideIn so">
    <form name="setAppDis" id="setAppDis" action="<?=$f_path.'X/dts_save_app_discount_save.php'?>" method="post" cb="boReload()">
        <table border="0" cellspacing="0" cellpadding="4" class="grad_s holdH g_ord" t_ord="" c_ord="">
            <tr>
                <th width="200">القسم</th>
                <th width="200">نوع الحسم</th>
                <th width="200">قيمة الحسم</th>      
            </tr><?
            foreach($clinicTypes as $k=>$type){
                if(in_array($k,array(1,3,4,5,7))){
                    $sel='';
                    if($data[$k][0]==2){$sel=' selected ';}
                    echo '<tr>
                        <td txt>'.$type.'</td>
                        <td>
                            <select name="type['.$k.']">
                                <option value="1">نسبة مئوية</option>
                                <option value="2" '.$sel.'>مبلغ ثابت</option>
                            </select>
                        </td>
                        <td><input type="number" name="val['.$k.']" value="'.$data[$k][1].'"/></td>            
                    </tr>';
                }
            }?>
        </table>
        <div class="fl ic40 icc2 ic40_save ic40Txt" onclick="sub('setAppDis')">Save</div>
    </form>
</div>