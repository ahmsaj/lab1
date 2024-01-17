<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['r'],$_POST['vis'],$_POST['pat'])){
	$id=pp($_POST['id']);
    $rec=pp($_POST['r']);
    $vis=pp($_POST['vis']);
    $pat=pp($_POST['pat']);
    $valus=[];
    if($rec){
        $sql="select * from den_x_prv_clinical_items where p_id='$rec'";
        $res=mysql_q($sql);
        if(mysql_n($res)){
            while($r=mysql_f($res)){
                $valus[$r['item_id']]=[$r['val'],$r['val_add']];
            }
        }else{
            exit;
        }
    }
    $r=getRecCon('den_m_prv_clinical'," act=1 and id='$id' ");
    if($r['r']){
        $name=$r['name_'.$lg];
        $multi=$r['multi'];
        echo '<div class="w100 h100 fl fxg of" fxg="gtr:1fr 52px">
            <div class=" ofx so">';
                $sql="select * from den_m_prv_clinical_items where act=1 and p_id='$id' order by ord ASC";
                $res=mysql_q($sql);
                $rows=mysql_n($res);
                if($rows){
                    echo '<form name="dcf" id="dcf" action="'.$f_path.'X/den_prv_cln_add_save.php" method="post" cb="denClnSaCb()">
                    <div class="fxg denClnForm pd20f" fxg="gtc:auto 1fr|gtc:1fr:700">
                    <input type="hidden" name="id" value="'.$id.'"/>
                    <input type="hidden" name="r_id" value="'.$rec.'"/>
                    <input type="hidden" name="vis" value="'.$vis.'"/>
                    <input type="hidden" name="pat" value="'.$pat.'"/>';
                    while($r=mysql_f($res)){
                        $it_id=$r['id'];
                        $name=$r['name_'.$lg];
                        $type=$r['type'];
                        $val_status=$r['val_status'];
                        $add_vals=$r['add_vals'];
                        $show_mt=$r['show_mt'];
                        $req=$r['req'];
                        $reqTxt='';
                        if($req){$reqTxt='<span class="clr5 fs14">*</span>';}
                        if($type==1){
                            if($add_vals==1){echo '<div class="f1 fs16 clr1 fxg lh40 uLine" fxg="gcs:2|gcs:1:700">'.$name.' </div>';}
                            if($add_vals==2){echo '<div class="f1 fs14 clr1 fxg lh40" fxg="gcs:2|gcs:1:700">'.$name.' </div>';}
                        }else{
                            echo '<div ti>'.$name.' : '.$reqTxt.'</div>';
                            echo '<div in inputHolder>'.showDenClnINput($it_id,$type,$add_vals,$val_status,$req,$valus[$it_id]).'</div>';
                        }
                    }
                    echo '</div>
                    </form>';
                }

                echo '
            </div>
            <div class="t_bord cbg4">
                <div class="fr ic40 ic40_save ic40Txt icc2 mg5f" saveDenCLn>'.k_save.'</div>
            </div>
        </div>
        ';
    }
}?>