<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['r_id'],$_POST['vis'],$_POST['pat'])){
	$id=pp($_POST['id']);
    $rec=pp($_POST['r_id']);
    $vis=pp($_POST['vis']);
    $pat=pp($_POST['pat']);
    $r=getRecCon('den_x_visits',"id='$vis' and patient='$pat'");
    if($r['r']){
        if($thisUser=$r['doctor']){
            $r=getRecCon('den_m_prv_clinical'," act=1 and id='$id' ");
            if($r['r']){
                $name=$r['name_'.$lg];
                $multi=$r['multi'];
                $sql="select * from den_m_prv_clinical_items where act=1 and p_id='$id' order by ord ASC";
                $res=mysql_q($sql);
                $rows=mysql_n($res);
                if($rows){
                    if($rec){
                        $doc=get_val('den_x_prv_clinical','doc',$rec);                      
                        if($doc!=$thisUser){exit;}
                        mysql_q("DELETE from  den_x_prv_clinical_items where p_id ='$rec' ");
                        echo "DELETE from  den_x_prv_clinical_items where p_id ='$rec' ";
                        $new_id=$rec;
                    }else{
                        $insSql="INSERT INTO den_x_prv_clinical (pat,doc,vis,form_id,date) values ('$pat','$thisUser','$vis','$id','$now')";
                    }
                    $err=0;
                   
                    $data=[];
                    while($r=mysql_f($res)){
                        $val='';
                        $val_add='';
                        $it_id=$r['id'];
                        $name=$r['name_'.$lg];
                        $type=$r['type'];
                        $val_status=$r['val_status'];
                        $add_vals=$r['add_vals'];
                        $show_mt=$r['show_mt'];
                        $req=$r['req'];
                        if($type==2){
                            $val=pp($_POST['dci_'.$it_id],'s');
                        }
                        if($type==3){
                            $val=0;
                            $val_add=pp($_POST['dci_'.$it_id.'_in'],'s');
                            if(isset($_POST['dci_'.$it_id])){$val=1;}else{$val_add='';}
                        }
                        if($type==4){
                            $arr=json_decode($add_vals,true);
                            $item=pp($_POST['dci_'.$it_id],'s');
                            foreach($arr as $k=>$v){
                                $id_t=$v['id'];
                                if($item==$id_t){
                                    $val=$item;
                                    if($v['objAdd']['show']){
                                         $val_add=pp($_POST['dci_'.$it_id.'_in'],'s');
                                    }
                                }
                            }
                        }
                        if($req && !$val){$err=1;}
                        $data[$it_id]=[$val,$val_add];
                    }
                    if($err==0){
                        if($rec==0){
                            $res=mysql_q($insSql);
                            $new_id=last_id();
                        }                       
                        foreach($data as $k=>$v){
                            $item_id=$k;
                            $val=$v[0];
                            $val_add=$v[1];
                            $sql="INSERT INTO den_x_prv_clinical_items (form_id, p_id,item_id, pat, val, val_add) values ('$id', '$new_id', '$item_id','$pat', '$val', '$val_add')";
                            mysql_q($sql);
                        }
                        echo 1;
                    }
                }
            }
        }
    }
}?>