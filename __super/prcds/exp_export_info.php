<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['mod'])){
	$catsTxt=['',k_bmod,k_amod];
	$tables=['','_modules','_modules_'];
	$items=['title_'.$lg,'title_'.$lg];
	$mod=pp($_POST['mod'],'s');	
    $modType=get_val_c('_modules_list','type',$mod,'mod_code');
		
    $r=getRecCon($tables[$modType],"code='$mod'");
    if($r['r']){
        $code=$r['code'];
        $title=$r['title_'.$lg];
        $progs=$r['progs'];
        $exFile=$r['exFile'];
        $progs_used=$r['progs_used'];
        $cat_title=$catsTxt[$modType];
        ?>
        <div class="win_body">
        <div class="form_header so lh40 clr1 f1 fs16"><?=$title?> (<?=$cat_title?>)</div>
        <div class="form_body so"><?
        $count_used_pro=$count_ex_file=$count_event=0;
        $used_pro_txt=$ex_file_txt=$event_txt=$condsTxt=$linksTxt=k_not_existed;
        /*if($progs_used!=''){
            $progs_used=explode(',',$progs_used);
            $count_used_pro=count($progs_used);
            $used_pro_txt='<ff class="fl">'.$count_used_pro.'</ff>';
        }*/
        /*if($exFile!=''){
            $exFiles=explode(',',$exFile);
            $count_ex_file=count($exFiles);
            $ex_file_txt='<ff class="fl">'.$count_ex_file.'</ff>';
        }
        //$progTxt=k_no_sel;
        //if($progs!=''){$progTxt=$progs;}
        /*if($exFile!=''){
            $exFile=explode(',',$exFile);
        }*/
    ?>
        <table class="fTable" cellpadding="0" cellspacing="0" border="0">
            <tbody>
            <tr><td n><?=k_program?>:</td><td class="fs14 uc"><?=$progTxt?></td></tr><?
            if($progs_used){?>
                <tr><td n><?=k_pro_linked?>:</td><td class="fs14 uc"><?=$progs_used?></td></tr><?
            }            
            if($modType==1){                
                $conds=getTotalCO('_modules_cons',"mod_code='$mod'");
                if($conds){?>
                    <tr><td n><?=k_prog_cond_num?>:</td><td><ff><?=$conds?></ff></td></tr><?
                }
                $links=getTotalCO('_modules_links',"mod_code='$mod'");
                if($links){?>
                    <tr><td n><?=k_prog_links_num?>:</td><td><ff><?=$links?></ff></td></tr><?
                }
                $events=$r['events'];
                if($events){
                    $eventsD=explode('|',$eventsD);?>
                    <tr><td n><?=k_events?>:</td><td><ff><?=count($eventsD)?></ff></td></tr><?
                }
            }else{
                $file=$r['file'];
                $file_name=get_val_con('_modules_files','file',"code='$file'");?>
                <tr>
                    <td n> <?=k_module_file?>:</td>
                    <td class=" fs14" ><ff><?=$file_name?></ff></td>
                </tr><?	
            }
            if($exFile){
                $exFile=str_replace(',',"','",$exFile);
                $filesName=get_vals('_modules_files_pro','file'," code in('$exFile') ",'<br>')?>
                <tr><td n><?=k_jx_fl?>:</td><td class="ff fs14 lh20" dir="ltr"><?=$filesName?></td></tr><?
            }
            ?>
            </tbody>
        </table>

    <?}
?>

    </div>
    <div class="form_fot fr">
        <div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>         
    </div>
    </div><?
	
	
}?>