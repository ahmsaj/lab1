<? include("../../__sys/prcds/ajax_header.php");
if(isset($_GET['type'] , $_GET['id'])){?>
	<head>
	<link href="<?=$m_path?>library/jquery/css/jq-ui.css" rel="stylesheet" type="text/css"/>
	<link href="<?=$m_path?>library/jquery/css/jquery.datetimepicker.css" rel="stylesheet" type="text/css"/>
	<? $fileName='Lg'.$lg.'Mv'.$ProVer.'.js';?>
	<script src="<?=$m_path?>__sys/<?=$fileName?>"></script>
	<script src="<?=$m_path?>library/jquery/jq3.6.js"></script>
	<script src="<?=$m_path?>library/jquery/jq-ui.js"></script>	
	<script src="<?=$m_path?>library/Highcharts/highcharts.src.js"></script>
	<script src="<?=$m_path?>library/Highcharts/highcharts-more.js"></script>
	<? $style_file=styleFiles('P');?>
	<link rel="stylesheet" type="text/css" href="<?=$m_path.$style_file?>"></head>
	<body dir="<?=$l_dir?>"><?
	$type=pp($_GET['type']);
	$id=pp($_GET['id']);
	$par=pp($_GET['par']);
	$pageH=29.5;
	$headerSize=4;
	$footerSize=2;
	$headerTamp='';
	$footerTamp='<div class="lh30 fs14 ff B TC"> __p__ / __a__</div>';
	$data='';
	if($type==1){
		$headerSize=1.5;
		$footerSize=1;
		$r=getRec('lab_x_work_table',$id);
		if($r['r']){
			$name=$r['name'];
			$date=$r['date'];
			$services=$r['services'];
			$status=$r['status'];
			$print=$r['print'];
			$c=0;
			if($services){$srvArr=explode(',',$services);$c=count($srvArr);	}
			$dStatus='';
			$txtDate='<ff>'.date('Y-m-d | A h:i',$date).'</ff>';
			
			$headerTamp='<div class="fr ff B fs18">#'.$id.' </div>
			<div class="fl fs16 f1">'.$dStatus.' '.$txtDate.' </div> 
			<div class="fl f1 fs16 pd10"> | عدد التحاليل : <ff >'.$c.' </ff></div>';
			if($services){
				$sql="select id,visit_id ,patient,service from lab_x_visits_services where w_table='$id' order by service ASC , d_start ASC";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				$actSrv=0;
				$newLine=1;
				if($rows){
					while($r=mysql_f($res)){
						$s_id=$r['id'];
						$vis=$r['visit_id'];
						$patient=$r['patient'];
						$service=$r['service'];
						if($actSrv!=$service){
							$i=1;							
							$srvTxt=get_val('lab_m_services','short_name',$service);
							if($actSrv!=0){
								if($newLine==2){
									$data.='<td width="40"></td>
									<td class="f1 fs12 ws" width="200"></td>
									<td></td></tr>';
									$newLine=1;
								}
								$data.='</table></div>';
								
							}
							$actSrv=$service;
							$data.='<div blc>
							<div class="lh40" blcT><ff class="fl">'.$srvTxt.'</ff></div>
							<table width="100%" border="0" cellspacing="0" type="static" cellpadding="4" class="grad_s " >';
							//echo <tr head><th width="30">#</th><th width="100">'.k_patient.'</th><th>النتائج</th></tr>';
						}
						if($newLine==1){$data.='<tr>';}
						$data.='<td width="40"><ff>'.$i.'</ff></td>
						<td class="f1 fs12 ws" width="200">'.get_p_name($patient).'</td>
						<td></td>';
						if($newLine==2){$data.='</tr>';$newLine=1;}else{$newLine=2;}
						$i++;
					}
					if($newLine==2){
						$data.='<td width="40"></td>
						<td class="f1 fs12 ws" width="200"></td>
						<td></td></tr>';
					}
					$data.= '</table></div>';
					$newLine=1;
				}
			}
		}		
	}
	echo '<div class="LPF4">
		<div id="allPages">
			<div id="pData">'.$data.'</div>
			<div id="sData"></div>
		</div>
	</div>
	<div id="pageTamp">
		<div class="breakPage">
			<div class="LPF4Head b_bord" style="height:'.$headerSize.'cm">'.$headerTamp.'</div>
			<div class="cb" style="height:'.($pageH-$headerSize-$footerSize).'cm">__body__</div>
			<div class="LPF4Fot cb t_bord" style="height:'.$footerSize.'cm">'.$footerTamp.'</div>
		</div>
	</div>';?>
    </body><?
}?>

<script>
function CL(s){console.log(s);}
$(document).ready(function(e){
	maxHeight=parseInt((<?=$pageH-$headerSize-$footerSize?>)/0.0264583);	
	var pageTamp =$('#pageTamp').html();	
	$('#pageTamp').remove();
	allData=[];
	rows=[];
	pages=[];	
	allPages='';		
	pageText='';
	i=0;
	$('#pData [blc]').each(function(){
		tableH='';
		tRows=[];
		bTitle=$(this).children('[blcT]').prop("outerHTML");
		$(this).children('[blcT]').remove();
		$(this).find('tr[head]').each(function(){
			tableH+=$(this).prop("outerHTML");
			$(this).remove();
		})
		$(this).find('tr').each(function(){
			tRows.push($(this).prop("outerHTML"));
			$(this).remove();
		})
		tableTag=$(this).children('table').prop("outerHTML");
		allData[i]={
			title: bTitle,
			tag:tableTag,
			head:tableH,
			rows:tRows,
		}
		i++;
	})
	
	$('#pData').html('');
	for(b=0;b<allData.length;b++){
		$('#sData').html(allData[b].title);
		$('#sData').append(allData[b].tag);
		$('#sData table').append(allData[b].head);		
		pageStart=$('#sData').html();
		$('#pData').append(pageStart);
		
		if(pageText!=''){
			blkHi=$('#pData').height();
			if(maxHeight>blkHi){
				pageText=$('#pData').html();
			}else{
				pages.push(pageText);
				pageText='';
				$('#pData').html(pageStart);
			}
		}else{
			pageText=$('#pData').html();
		}			
		for(r=0;r<allData[b].rows.length;r++){
			$('#pData table:last').append(allData[b].rows[r]);
			blkHi=$('#pData').height();
			if(maxHeight>blkHi){
				pageText=$('#pData').html();
			}else{
				pages.push(pageText);				
				pageText='';
				$('#pData').html(pageStart);
				$('#pData table').append(allData[b].rows[r]);
				pageText=$('#pData').html();
			}				
		}
	}
	if(pageText){pages.push(pageText);}
	$('#pData').remove();
	pageC=pages.length;
	for(p=0;p<pageC;p++){
		pageFin='';
		pageFin=pageTamp.replace('__body__',pages[p]);
		pageFin=pageFin.replace('__p__',(p+1));
		allPages+=pageFin.replace('__a__',pageC);
	}
	$('#allPages').html(allPages);
	window.print();setTimeout(function(){window.close();},1000);
});
</script>
