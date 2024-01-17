<?
$api=0;
$PBL='../../';
if($_GET['api']){
	include($PBL.'__sys/prcds/ajax_header_x.php');
    include($PBL.'_lab/funs.php');
	include($PBL.'_lab/define.php');
    include($PBL.'_gnr/funs.php');
	include($PBL.'_gnr/define.php');
    $api=1;
}else{
	include("../../__sys/prcds/ajax_header.php");
}
$sql="select * from lab_m_results_colors where used=1";
$res=mysql_q($sql);
$rows=mysql_n($res);
if($rows>0){
	$r=mysql_f($res);
	$RPC_=$r['clr1'];
	$RPC_N=$r['clr2'];
	$RPC_X=$r['clr3'];
}
?>
<head>
<link href="<?=$m_path?>library/jquery/css/jq-ui.css" rel="stylesheet" type="text/css"/>
<? $fileName='Lg'.$lg.'Mv'.$ProVer.'.js';?>
<style>.RPC_{color: <?=$RPC_?>;}.RPC_N{color: <?=$RPC_N?>;}.RPC_X{color: <?=$RPC_X?>;}</style>
<script src="<?=$m_path?><?=$fileName?>"></script>
<script src="<?=$m_path?>library/jquery/jq3.6.js"></script>
<script src="<?=$m_path?>library/jquery/jq-ui.js"></script>
<script src="<?=$m_path?>library/Highcharts/highcharts.src.js"></script>
<script src="<?=$m_path?>library/Highcharts/highcharts-more.js"></script><?
if((isset($_GET['type'] , $_GET['id']) && $_GET['id']!='')||(isset($_GET['api']))){?>
	<? $style_file=styleFiles('P');?>
	<link rel="stylesheet" type="text/css" href="<?=$m_path.$style_file?>"></head>	
	<body dir="<?=$l_dir?>"><?
	$hisResNo=1;
	$type=pp($_GET['type']);
	$headerSize= floatval(_set_g6of5jw4rf);
	if(!$headerSize){$headerSize=3.5;}
	$id=pp($_GET['id'],'s');
	if(_set_qc1kubo5cr){
		$image=getImages(_set_qc1kubo5cr);
		$file=$image[0]['file'];
		$folder=$image[0]['folder'];
		list($w,$h)=getimagesize("sData/".$folder.$file);
		$fullfile=$m_path.'upi/'.$folder.$file;
		$logo= '<img width="100%" src="'.$fullfile.'"/>';
	}
	if($api){
		$apiType=pp($_GET['api']);
		$code=pp($_GET['code'],'s');
		$time=pp($_GET['time'],'s');
		if($apiType==1){
			list($vis,$pat)=get_val_con('lab_x_visits','id,patient',"code='$code' and d_start='$time' ");			
			if($vis){
				$ids=get_vals('lab_x_visits_services','id',"visit_id='$vis' ");
				$s_id=explode(',',$ids);
				$thisCode='32-'.$vis;			
			}else{exit;}
		}else if($apiType==2){
			list($id,$vis,$pat)=get_val_con('lab_x_visits_services','id,visit_id,patient',"code='$code' and date_enter='$time' ");		
			if($vis){		
				$ids=$id;
				$thisCode='31-'.$id;
			}else{exit;}
		}else{exit;}
	}else{
		if($type==1){
			$ids=$id;
			list($vis,$pat,$doc)=get_val('lab_x_visits_services','visit_id,patient,report_wr',$id);
			$thisCode='31-'.$id;
		}
		if($type==2){
			$ids=str_replace('a',',',$id);
			$s_id=explode(',',$ids);
			list($vis,$pat,$doc)=get_val('lab_x_visits_services','visit_id,patient,report_wr',$s_id[0]);
			$thisCode='32-'.$vis;
			mysql_q("UPDATE lab_x_visits SET print=print+1  where id='$vis'");
		}
	}
    $Vbal=get_visBal($v_no);
    if($Vbal==0){                                                                          
        $vis_date=get_val('lab_x_visits','d_start',$vis);
        //if($vis_date==0){$vis_date=$now;}
        $sgoc=getSrvOrdCat($ids);
        $OrdIds=$sgoc[0];
        $servSubCount=$sgoc[1];

        list($sex,$age)=getPatInfoL($pat);
        $patInfo=getPatInfo($pat,1,$vis_date);
        echo '<div class="LP4"><div id="allPages"></div></div>';
        echo '<div id="pageTamp">
            <div class="breakPage">';
                if($api==0){
                    echo '<div class="LP4Head" style="height:'.$headerSize.'cm">				
                        <div class=" fr w100">'.$logo.'</div>      	
                    </div>';
                }
                echo '<div class="LP4Head2 pd10" dir="ltr" >
                    <div class="frr lh40 fs16x f1s  ws pd10"  dir="ltr" style="">
                        '.$patInfo['n'].' | '.$patInfo['s'].'  |  '.$patInfo['b'].'
                    </div>';

                    echo '<div class="fll lh40 baarcode22 of pd10" style="margin-left:2.5cm">
                        <ff dir="ltr">'.date('Y-m-d',$vis_date).'</ff>
                    </div>
                </div>
                <div class="LP4Body cb" style="height:'.(26-$headerSize).'cm">__body__</div>
                <div class="LP4Fot cb"><div class="f1 fl lh30">V'.$vis.'|P'.$pat.'| '._info_jpgpklfhhy.'</div><div class="fr lh30 ff B">Page __p__ / __a__</div></div>
            </div>
        </div>
        <div id="catTamp">
            <div class=" fs14 anaTitle" ><!--title--></div>
            <div class="LCatBord">__catIn__</div>
        </div>
        <div id="docTamp">';
            //<div class="f1 fs16  lh40 ">'.k_dr.' : '.get_val('_users','name_'.$lg,$doc).'</div>
        echo '</div>';
        ?>
        <div id="scriptC"><script>var cats_n=new Array();</script></div><?
        $actCat=0;
        $actSerCount=0;
        $q3='';
        if($OrdIds){$q3="ORDER BY FIELD(id$OrdIds) ";}
        $sql="select * from lab_x_visits_services where id IN ($ids) $q3 ";
        $res=mysql_q($sql);
        $rows=mysql_n($res);
        if($rows>0){		
            $i=0;
            while($r=mysql_f($res)){
                $srv_id=$r['id'];
                $vis=$r['visit_id'];		
                $sample=$r['sample'];
                $type=$r['type'];
                $report_wr=$r['report_wr'];
                $service=$r['service'];
                $status=$r['status'];
                $fast=$r['fast'];
                $date_enter=$r['date_enter'];
                $date_reviwe=$r['date_reviwe'];
                $a_id=$srv_id;
                list($name,$report_de,$cat)=get_val('lab_m_services','name_'.$lg.',report_de,cat',$service);			
                $pkg=getPkgForAna($vis,$srv_id);
                $pkg_no=get_val('lab_x_visits_samlpes','no',$pkg);
                if($type==1 || $type==4){$ala_name=get_val('lab_m_services','name_'.$lg,$service);}
                if($type==2 || $type==3){$ala_name=$name;}

                if(($servSubCount[$srv_id] > 1  && $actSerCount==1) || $actCat!=$cat ){
                    echo '</table>';
                    echo '</div>';
                    $actSerCount=0;
                }
                if($actCat!=$cat){
                    $cat_name=splitNo(get_val('lab_m_services_cats','name_'.$lg,$cat));
                    echo script('cats_n['.$cat.']="'.$cat_name.'";');
                }			
                if($servSubCount[$srv_id]==1){
                    if($actSerCount==0){
                        echo '<div cat="'.$cat.'">';
                        if($type==1 ){
                            echo '<table class="labResTable" cellpadding="2" cellspacing="0" ><tr>
                            <th>Test</th>
                            <th>Results</th>
                            <th>Unit</th>
                            <th>Ref. Ranges</th>
                            <th colspan="'.$hisResNo.'">Historical Result</th>
                            </tr>';
                        }
                        $actSerCount=1;
                    }				
                    echo print_l_report($srv_id,$report_de,$sex,$age,$sample,$status,$type,$service);			
                }
                if($servSubCount[$srv_id]==0){
                    echo '<div cat="'.$cat.'">';
                    echo print_l_report($srv_id,$report_de,$sex,$age,$sample,$status,$type,$service);				
                }
                if($i==($rows-1) && $actSerCount==1 ){echo '</table>';}
                if($servSubCount[$srv_id]>1){		
                    echo '<div cat="'.$cat.'">
                    <div class="fs14 anaTitleSub pd10">'.splitNo($ala_name).'</div> 
                    <div class="LSerBord">'.print_l_report($srv_id,$report_de,$sex,$age,$sample,$status,$type).'</div>
                    </div>';	
                }
                $actCat=$cat;
                $i++;
            }
        }?>
        </body><?
    }else{
        echo '<div class=" f1 fs16 clr5 lh50 pd20">'.k_rmning_amnt_pd.'</div>';
    }
}?>
<script>
$(document).ready(function(e){
	maxHeight=parseInt((24-<?=$headerSize?>)/0.0264583);
	var pageTamp =$('#pageTamp').html();
	var catTamp =$('#catTamp').html();
	var docTamp =$('#docTamp').html();
	catH=$('#catTamp').height();
	$('#pageTamp , #catTamp , #docTamp').remove();
	allData=new Array();
	i=0;
	$('div[cat]').each(function(){
		n=$(this).attr('cat');
		d=$(this).html();
		h=$(this).height();	
		allData[i]=[n,h,d,0];
		$(this).remove();
		i++;
	})
	tryy=0;
	fin=0;
	actCat=0;
	actBlok='x';
	actBlokH=0;
	allPages='';
	pagesCounter=1;
	thisPageH=0;
	thisPage='';
	thisPagePart='';
	while(fin==0 && tryy<50){
		for(i=0;i<allData.length;i++){
			no=allData[i][0];
			he=allData[i][1];
			da=allData[i][2];
			st=allData[i][3];
			if(st==0){
				if(actCat==0){actCat=no;thisPageH+=catH;}
				if(actCat==no){if((he>actBlokH) && he<(maxHeight-thisPageH)){actBlok=i;actBlokH=he;}}
			}
		}
		if(actBlok!='x'){
			allData[actBlok][3]=1;
			no=allData[actBlok][0];
			he=allData[actBlok][1];
			da=allData[actBlok][2];	
			thisPagePart+=da;
			thisPageH+=he;
			actBlok='x';
			actBlokH=0;
		}else{
			if(thisPagePart!=''){
				catTampN='';
				catTampN=catTamp.replace('<!--title-->',cats_n[actCat]);
				catTampN=catTampN.replace('__catIn__',thisPagePart);
				thisPage+=catTampN;
				thisPagePart='';
				actCat=0;
			}else{
				if(thisPage!=''){
					$('#docPlace').remove();
					thisPage=thisPage+'<div id="docPlace">'+docTamp+'</div>';
					pageTampN=pageTamp.replace('__p__',pagesCounter);
					pageTampN=pageTampN.replace('__body__',thisPage);
					allPages+=pageTampN;
					pagesCounter++;
					actCat=0;
					thisPage='';
					thisPageH=0;
				}else{
					fin=1;
				}
			}
		}
		tryy++;
	}
	allPages=allPages.replace(/__a__/g,pagesCounter-1);
	$('#allPages').append(allPages);
    <? if($api==0){?>
		window.print();
		setTimeout(function(){window.close();},1500);
		<?
	}?>
});
</script>