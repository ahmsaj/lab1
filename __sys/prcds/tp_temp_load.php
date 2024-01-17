<? include("../../__sys/prcds/ajax_header.php");?>
<div class="win_body">
<div class="form_header so lh40 clr1 f1 fs16">أختر من قائمة النماذج</div>
<div class="form_body of" type="full_pd0">
    <div class="h100 w100 fxg" fxg="gtc:1fr 2.5fr">
        <div class="r_bord h100 pd10 ofx so" actButt="tpAct"><? 
            $dataView='';
            $sql="select * from _tp_temps where act=1";
            $res=mysql_q($sql);
            $rows=mysql_n($res);
            if($rows){
                $act='tpAct';
                $hide='';
                while($r=mysql_f($res)){
                    $id=$r['id'];
                    $name=$r['name'];
                    $data=$r['data'];
                    echo Script("PTTmpeListData[$id]='$data';");
                    echo '<div class="f1 fs14 pd10f lh20 Over cbg1 TC clrw mg10v br2" tptn="'.$id.'" '.$act.'>'.$name.'</div>';
                    $dataView.='<div class="tpEditorRowsTemp '.$hide.'" tptd="'.$id.'">'.showTpBlcsTemp($data).'</div>';
                    if($act=='tpAct'){
                        $act='';
                        $hide='hide';
                        echo Script("actPTTmpe=$id;");
                    }
                }
            }else{
                echo '<div class="f1 fs14 clr5 lh40">لا يوجد نماذج محفوظة</div>';
            }
            ?>
        </div>
        <div class="ofx so pd10f"><?=$dataView?></div>
    </div>
</div>
<div class="form_fot fr">        
    <div class="fl ic40 ic40_reload icc22 ic40Txt mg10f br0" tpTempLoadDo>تحميل النموذج</div>		    	
    <div class="fr ic40 ic40_x icc3 ic40Txt mg10v br0" onclick="win('close','#m_info5');"><?=k_close?></div>
</div>
</div>