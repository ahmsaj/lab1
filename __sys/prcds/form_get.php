<? include("ajax_header.php");
if(isset($_POST['mod'] , $_POST['id'] , $_POST['type'])){
	$id=pp($_POST['id']);
	if(($id==0 && $chPer[1])||($id!=0 && $chPer[2])){	
        $type=pp($_POST['type']);
        $mod=pp($_POST['mod'],'s');
        $sub=pp($_POST['Sub'],'s');
        $fil=pp($_POST['fil'],'s');
        $col=pp($_POST['col'],'s');
        $add_vals=pp($_POST['add_vals'],'s');
        $add_vals_arr=explode(',',$add_vals);
        for($i=0;$i<count($add_vals_arr);$i++){
            $add_vals2=explode(':',$add_vals_arr[$i]);
            $add_vals_arr_d[$i]['col']=$add_vals2[0];
            $add_vals_arr_d[$i]['val']=$add_vals2[1];
            $add_vals_arr_d[$i]['show']=$add_vals2[2];
        }	
        $bc=stripcslashes($_POST['bc']);	
        $id=pp($_POST['id']);
        $sptf=$_POST['sptf'];
        $sptf_rr=array();
        $sptf_rr_con=array();
        $sptf_rr_con_hide=array();
        $sptf_rr_con_hide_val=array();
        if($sptf!='^'){
            //Decode($sptf,_pro_id);
            $sptfDe=Decode($sptf,_pro_id);
            $sptf_r=explode('^',$sptfDe);
            if($sptf_r[0]){
                $sptf_r_in=explode('|',$sptf_r[0]);
                for($s=0;$s<count($sptf_r_in);$s++){
                    $sptf_r2=explode(':',$sptf_r_in[$s]);
                    array_push($sptf_rr,array($sptf_r2[0],$sptf_r2[1]));
                }
            }
            $sptf_rr_in=explode('|',$sptf_r[1]);
            for($s=0;$s<count($sptf_rr_in);$s++){
                $sptf_con=explode(':',$sptf_rr_in[$s]);			
                array_push($sptf_rr_con,array($sptf_con[0],$sptf_con[1]));
            }
        }	
        $mod_data=loadModulData($mod);
        $cData=getColumesData($mod);
        $oprType=$type;
        /****************Editor**********************/
        $editor=0;
        foreach($cData as $dd){if($dd[3]==13)$editor=1;}
        if($editor){echo getEditorSet();}	
        /********************************************/
        $editForm=0;
        $eventType=1;
        if($id!=0){
            $eventType=3;
            $table=$mod_data[1];
            $sql="select * from $table where id='$id' limit 1";
            $res=mysql_q($sql);
            $rows=mysql_n($res);
            if($rows==0){
                echo '<div class="win_body"> 
                <div class="warn_msg f1">'.k_rec_not_found.'</div>';
                if($type==1){
                    echo'<div class="form_fot fr">	
                    <div class="bu bu_t2 fr" onclick="win(\'close\',\'#opr_form0\');">'.k_close.'</div></div>';
                }
                '</div>';
                exit;
            }else{
                $r=mysql_f($res);
                $editForm=1;
                $values_arr=array();
                for($i=0;$i<count($cData);$i++){
                    if(!($mod_data[12]==1 && $cData[$i][1]==$mod_data[3])){					
                        if(!in_array($cData[$i][3],array(10,11,15))){
                            if($cData[$i][9]){
                                foreach($lg_s as $ls){										
                                    $colll=str_replace('(L)',$ls,$cData[$i][1]);
                                    $values_arr[$cData[$i][1]][$ls]=$r[$colll];
                                }
                            }else{							
                                $values_arr[$cData[$i][1]]=$r[$cData[$i][1]];							
                            }
                        }
                    }
                }			
            }
        }
        if($type==11){
            $id=0;
            $type=1;
        }
        $body_calss='';
        $fildeVal=str_replace('cof_','',$fil);
        ?><script>parent_loader='';</script>
        <form name="co_form<?=$sub?>" id="co_form<?=$sub?>" action="<?=$f_path?>S/sys_form_save.php" method="post" enctype="multipart/form-data"><?	
        if($type==1 || $type==3){
            $body_calss='formBody so';?>            
            <div class="winBody"> 
        <? }?>  
            <div class="formHeader"></div>
            <div class="<?=$body_calss?>">
                <? $encData=$mod.'^*^'.$id.'^*^'.$sub.'^*^'.$fil.'^*^'.$col.'^*^'.$type.'^*^'.$bc.'^*^';?>
                <input type="hidden" name="encData" value="<?=Encode($encData,_pro_id);?>" /><? 
                //if($editForm==0){
                    foreach ($sptf_rr as $v){echo '<input type="hidden" name="'.$v[0].'" value="'.$v[1].'" />';}
                    foreach ($sptf_rr_con as $v){
                        if($v[1]){
                            $cn=colomCodeName($v[0]);
                            array_push($sptf_rr_con_hide,$cn);
                            $sptf_rr_con_hide_val[$cn]=$v[1];
                            echo '<input type="hidden" name="cof_'.$cn.'" value="'.$v[1].'" />';
                        }
                    }
                //}?>
                
                <table class="formTable" cellpadding="0" cellspacing="0" border="0">
                    <? if($mod_data[16]!=''){?>
                    <tr><td n><?=k_barcode?>:</td><td>
                    <audio src="<?=$m_path?>im/bcx.mp3" id="er_sound"></audio>
                    <div class="barReader" mode="a" no="<?=$id?>"><div class="fr ff">x</div></div>            
                    <textarea class="bc_text"></textarea>
                    </td></tr>
                    <? }?>
                    <? for($i=0;$i<count($cData);$i++){		
                        $convToStticValue=0;
                        $value='';				
                        if(!($mod_data[12]==1 && $cData[$i][1]==$mod_data[3])){
                            $value='';
                            if(!in_array($cData[$i][3],array(10,11)) && $editForm){
                                $value=$values_arr[$cData[$i][1]];
                            }
                            if($type==3 || $type==1){						
                                for($v=0;$v<count($add_vals_arr_d);$v++){						  
                                    if($add_vals_arr_d[$v]['col']==$cData[$i][1]){
                                        if($add_vals_arr_d[$v]['val']!='-1'){
                                            $ThisCVal=$add_vals_arr_d[$v]['val'];
                                        }else{
                                            $ThisCVal=$value;
                                        }
                                        if($cData[$i][9]){
                                            $value=array();
                                            $value[$lg]=$ThisCVal;									
                                        }else{
                                            $value=$ThisCVal;
                                        }
                                        if($add_vals_arr_d[$v]['show']=='h'){
                                            echo '<input type="hidden" name="cof_'.$cData[$i]['c'].'" value="'.$ThisCVal.'"/>';
                                            $convToStticValue=1;
                                            echo co_getFormInput_val($cData[$i],$value,$ThisCVal);	
                                        }
                                        if($add_vals_arr_d[$v]['show']=='hh'){
                                            echo '<input type="hidden" name="cof_'.$cData[$i]['c'].'" value="'.$ThisCVal.'"/>';
                                            $convToStticValue=1;
                                            //echo co_getFormInput_val($cData[$i],$value,$ThisCVal);	
                                        }
                                    }
                                }
                            }

                            if($convToStticValue==0){
                                if(in_array($cData[$i]['c'],$sptf_rr_con_hide)){
                                    echo co_getFormInput_val($cData[$i],$sptf_rr_con_hide_val[$cData[$i]['c']],$sptf_rr_con_hide_val[$cData[$i]['c']]);
                                }else{							
                                    echo co_getFormInput($id,$cData[$i],$value,$sub,0,$oprType);
                                }
                            }
                        }
                    }?>
                </table>
            </div>
            <? if($type==1 || $type==3){?>            
                <? if($sub>0){$wlp='win_level_pointer--;';}?>
                <div class="formFooter fx fx-gap10 fx-dir-rev">
                    <div class="fr ic40 ic40_x icc3 ic40Txt  br0" onclick="<?=$wlp?>win('close','#opr_form<?=$sub?>');"><?=k_cancel?></div>
                    <div class="fr ic40 ic40_save icc22 ic40Txt  br0" onclick="sub('co_form<?=$sub?>')"><?=k_save?></div>
                </div>
            <? }?>
            <? if($type==2 && $col==2){?>
                <div class="formFooter">
                    <div class="bu bu_t1 fl" onclick="sub('co_form<?=$sub?>')"><?=k_save?></div>
                </div>
            <? }?>
        </div>    
        <script>loadSuns(parent_loader);barCDataSet='<?=$mod_data[16]?>'</script>
        <div class="cb"></div>
        
        </form><?
        echo checkMevents($eventType,$mod_data[17],$id);
	}else{
        //out();
        $sub=pp($_POST['Sub'],'s');
        $mod=pp($_POST['mod'],'s');
        $modName=get_val_c('_modules','title_'.$lg,$mod,'code');
        echo '<div class="pd10">
            <div class="clr lh50 f1 fs16 clr5">'.k_no_perms_for_sec.' ( '.$modName.' )</div>
            <div class="bu bu_t2 fr" onclick="win(\'close\',\'#opr_form'.$sub.'\')">'.k_close.'</div>
        </div>';
    }
}?>