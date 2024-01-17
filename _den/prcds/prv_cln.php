<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['vis'],$_POST['pat'])){
	$id=pp($_POST['id']);
    $vis=pp($_POST['vis']);
    $pat=pp($_POST['pat']);
    $q=$q2='';
    if($id){$q=" and id='$id' "; $q2=" and form_id='$id' ";}
    $sql="select * from den_x_prv_clinical_items where pat='$pat' $q2 order by id ASC";
    $res=mysql_q($sql);
    $subData=[];
    while($r=mysql_f($res)){
        $subData[$r['p_id']][$r['item_id']]=[$r['val'],$r['val_add']];
    }
    $sql="select * from den_m_prv_clinical where act=1 $q order by ord ASC";
    $res=mysql_q($sql);
    $rows=mysql_n($res);
    if($rows){
        echo '<div class="clinicDenListIn">';
        while($r=mysql_f($res)){
            $id=$r['id'];
            $name=$r['name_'.$lg];
            $icon=$r['icon'];
            $multi=$r['multi'];
            $iconView='';
            if($icon){$iconView=viewImage($icon,0,40,40,'img');}
            $sql_n="select * from den_x_prv_clinical where pat='$pat' and form_id='$id' order by id ASC";
            $res_n=mysql_q($sql_n);
            $rows_n=mysql_n($res_n);
            echo '<div>
                <div tit>
                    <div i>'.$iconView.'</div>
                    <div t>'.$name.'</div>
                    <div>';
                    if($rows_n==0 || $multi){
                        echo '<div class="fr i30 i30_add mg5v " addDenCln="'.$id.'" n="0"></div>';
                    }
                echo '</div>
                </div>';
                if($rows_n){
                    echo '<div>';
                    while($rn=mysql_f($res_n)){
                        $doc=$rn['doc'];
                        $date=$rn['date'];
                        $f_id=$rn['form_id'];
                        $p_id=$rn['id'];
                        $docName=get_val_arr('_users','name_'.$lg,$doc,'doc');
                        echo '<div class="pd20f bord cbgw mg10v br5">';
                        
                        echo '<div class="w100 TL in lh20 cbg444 pd5f br5">  
                            <div class="fl f1 clr88 cbg444 pd5">'.$docName.' | <span dir="ltr" class="ff fs14 B lh30">'.date('Y-m-d',$date).'</span></div>';
                            if($doc==$thisUser){
                                echo '<div class="fr i30 i30_edit"  title="'.k_edit.'" n="'.$p_id.'" addDenCln="'.$id.'"></div>
                                <div class="fr i30 i30_del" title="'.k_delete.'" delDenCln="'.$p_id.'"></div>';
                            }
                        echo '</div>';
                                              
                        foreach($subData[$p_id] as $k=>$v){                          
                            list($name,$type,$val_status,$add_vals,$show,$act)=get_val_arr('den_m_prv_clinical_items','name_'.$lg.',type,val_status,add_vals,show_mt,act',$k,'it');
                            if($act){
                                switch($type){
                                    case 1: 
                                        if($add_vals==1){echo '<div class="f1 fs16 clr88 lh40 b_bord">'.$name.'</div>';}
                                        if($add_vals==2){echo '<div class="f1 fs14 clr88 lh30 ">'.$name.'</div>';}
                                    break;
                                    case 2: 
                                        if($add_vals==1){echo '<div class="f1 clr9 lh30 uLine">'.$name.': <span class="f1 lh30 dciS_'.$val_status.' B">'.$v[0].'</span></div>';}
                                        if($add_vals==2){echo '<div class="f1 clr9 lh20 uLine pd10v">'.$name.':<br><span class="f1 lh20 dciS_'.$val_status.'">'.nl2br($v[0]).'</span></div>';}
                                    break;
                                    case 3:
                                        if($show || $v[0]){
                                            echo '<div class="f1 clr9 lh20 uLine">'.$name.': 
                                            <span class="f1 lh30 dciS_'.$val_status.'">'.$denClnInpStatus[$v[0]].'</span>';
                                            if($add_vals==1 && $v[1]){
                                                echo '<span class="f1 lh30 dciS_'.$val_status.' B"> ( '.$v[1].' )</span>';
                                            }
                                            echo '</div>';
                                        }
                                    break;
                                    case 4:
                                        $arr=json_decode($add_vals,true);
                                        foreach($arr as $kk=>$vv){
                                            if($v[0]==$vv['id']){
                                                $title=$vv['title'][$lg];
                                                $status=$vv['objAdd']['status'];
                                                $show=$vv['objAdd']['show'];
                                                if($show || $v[0]){
                                                    echo '<div class="f1 clr9 lh20 uLine">'.$name.': 
                                                    <span class="f1 lh30 dciS_'.$status.'">'.$title.'</span>';
                                                    if($add_vals && $v[1]){
                                                        echo '<span class="f1 lh30 dciS_'.$status.' B"> ( '.$v[1].' )</span>';
                                                    }
                                                    echo '</div>';
                                                }
                                            }
                                        }
                                    break;
                                }
                            }
                            
                        }                        
                        echo '  
                        
                        </div>';
                    }
                    echo '</div>';
                }                
            echo '</div>';
            
        }
        echo '</div>';
    }
}?>