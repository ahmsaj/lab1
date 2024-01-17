<? include("../../__sys/prcds/ajax_header.php");?>
<div class="ofx so soL3" fix="hp:30"><?
    $sql="select * from lab_m_services_templates where doc=0 order by id ASC";
    $res=mysql_q($sql);
    $rows=mysql_n($res);
    if($rows>0){
        while($r=mysql_f($res)){            
            $name=$r['name'];
            $temp=$r['temp'];			
            echo '<div class="f1 pd10 bord mg5f lh30 Over icc33 clrw" tmpId="'.$temp.'">'.$name.'</div>';
        }
    }else{
        echo '<div class="f1 fs14 clr5 lh40">'.k_nsvd_tmpt.'</div>';
    }?>
</div>
<div class="ic30 ic30_x ic30Txt icc2 fl mg10v" lt_close><?=k_close?></div>
