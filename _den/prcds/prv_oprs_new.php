<? include("../../__sys/prcds/ajax_header.php");?>
<div class="fxg h100" fxg="gtc:1fr 1fr 2fr|gtc:1fr 1fr 2fr|gtr:40px 1fr">
    <div class="b_bord lh40 f1 fs14 pd10 cbg9 clrw">التصنيف</div>
    <div class="b_bord lh40 f1 fs14 TC cbg444 l_bord r_bord">
        <input type="text" placeholder="بجث بالإجراء" id="oprSear"/>
    </div>
    
    <div class="of h100" fxg="grs:2" id="d_oprDet">
        <div class="pd10f f1 fs14 clr5">أبد بأختير التصنيف لاختيار الإجراء</div>
    </div>
    
    <div class="pd10f ofx so cbg4 denCatList" actButt="act"><?
        $sql="select * from den_m_services_cat order by name_$lg ASC";
        $res=mysql_q($sql);
        while($r=mysql_f($res)){
            $id=$r['id'];
            $name=$r['name_'.$lg];
            echo '<div no="'.$id.'">'.splitNo($name).'</div>';
        }?>
    </div>
    <div class="l_bord r_bord ofx so cbg444" id="d_oprList"></div>
</div>