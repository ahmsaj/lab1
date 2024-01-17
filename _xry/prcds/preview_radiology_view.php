<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'])){
	$id=pp($_POST['id']);
	$r=getRec('xry_x_visits_requested_items',$id);	
	if($r['r']){
		$r_status=$r['status'];
		$xphoto=$r['xphoto'];
		$r_id=$r['r_id'];
		$xph_res=$r['res'];
		$res_photo=$r['res_photo'];
		$xphoto_status=$r['status'];
		$doc=get_val('xry_x_visits_requested','doc',$r_id);
		
		$mad_name=get_val('xry_m_services','name_'.$lg,$xphoto);
		$action=$r['action'];?>
		<div class="win_body">
            <div class="form_header f1 fs16 clr1 lh40">
                <? if($action==2){ echo k_enter_edit_result;}else{ echo $mad_name;}?>
            </div>
            <div class="form_body so"><? 			
                if(getTotalCO('xry_x_visits_requested_items',"r_id = '$r_id' and status!=3 ")==0){
                    mysql_q("update xry_x_visits_requested set status=4 where id ='$r_id' ");
                }
                if($r_status>1 && $action==1){				
                    mysql_q("update xry_x_visits_requested_items set status=3 where id ='$id' ");
                    echo '<div class="fs16 lh30" id="resView">';
                        if($res_photo){
                            echo '<div class="fl uLine w100" style="min-height:170px">'.imgViewer($res_photo,160,120).'</div>';
                        }
                        echo '<div class="cb viewRep">'.nl2br(splitNo($xph_res)).'</div>';
                    echo '</div>';
                }
                if($action==2){
                    $h='';
                    $h2='';
                    echo '<div class="f1 fs14 lh40 clr5 " >'.get_val('xry_m_services','name_'.$lg,$xphoto).'</div>';
                    if($xphoto_status==3){
                        echo '<div class="fs16 lh30" id="resView">';
                        if($res_photo){
                            echo '<div class="fl uLine w100"  style="min-height:170px">'.imgViewer($res_photo,200,150).'</div>';
                        }
                        echo '<div class="cb viewRep">'.nl2br(splitNo($xph_res)).'</div>';
                        echo '</div>';
                        $h=' hide ';
                    }else{
                        $h2=' hide ';
                    }
                    if($doc==$thisUser){		//echo imageUpN(0,$code,$code,$id,1,0,"tpImgLoad('$code',[data])");	
                        //imageUpN($id,$filed='photo',$code='',$val='',$req=0,$multi='0',$cb='',$fEx='',$text='',$cls='upBox'){
                        echo '<div class="'.$h.'" id="xphotoDiv">
                            '.imageUpN($res_photo,'xryPhoto','xryPhoto',$res_photo,1,1).'
                        </div>';
                        echo '<div class="'.$h.' f1 lh40 fs16">'.k_notes.'</div>';
                        echo '<textarea class="w100 '.$h.'" t id="anaresTxt" >'.$xph_res.'</textarea>';
                    }else{
                        $h=$h2=' hide ';

                    }
                }?>
            </div>
            <div class="form_fot">
                <div class="bu bu_t2 fr" onclick="win('close','#m_info2');m_xphotoN(<?=$r_id?>)"><?=k_close?></div>
                <? if($action==2){?>
                    <div class="bu bu_t3 fl <?=$h?>" id="saveB" onclick="prvSaveXp(<?=$id?>)"><?=k_save?></div>
                    <div class="bu bu_t1 fl <?=$h2?>" id="editB" onclick="prvEditPx()"><?=k_edit?></div>
                <?}?>
            </div>
		</div><?
	}
}?>