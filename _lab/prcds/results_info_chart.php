<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['data'] , $_POST['type'])){
	$data=pp($_POST['data'],'s');
	$t=pp($_POST['type']);
	$p=pp($_POST['p'],'s');	
	echo $p.'^';
	$subType=0;
	if($t==3){
		list($tt,$eq_id)=explode('^',$p);
		list($subType,$ana_no)=get_val('lab_m_services_equations','item,ana_no',$eq_id);
		$ana_text=get_val('lab_m_services','short_name',$ana_no);
	}
	$d='';
	$dd=explode(',',$data);
	foreach($dd as $c){
		$ddd=explode(':',$c);		
		if($t==2){
			if($d!=''){$d.=',';}
			$d.="['".get_val('lab_m_services_items','name_'.$lg,$ddd[0])."',".$ddd[1]."]";
		}else{
			$d.="cats_c.push('".get_val('lab_m_services_items','name_'.$lg,$ddd[0])."');";	
			$d.='data_all.push('.$ddd[1].');';	
			
		}
	}
	$rr=rand(999,9999);
if($t==2){?>
	<script type="text/javascript">
		data=new Array(<?=$d?>);		
		$('#rep_container<?=$rr?>').highcharts({
			chart:{plotBackgroundColor: null,plotBorderWidth: 1,plotShadow: false},
			title: {text: ''},tooltip: {pointFormat:'<div><ff>%{point.percentage:.1f}</ff></div>',},
			plotOptions: {
				pie: {allowPointSelect: true,cursor: 'pointer',dataLabels: {enabled: true,
						format: '<div class="f1 fs16">{point.name} :</div><div> <ff>%{point.percentage:.1f}</ff></div>',					
					}
				}
			},series: [{type: 'pie',data:data,}],		
		});

	</script><?
}else{
	if($subType==0){?>
		<script type="text/javascript">
		cats=new Array();
		data_all=new Array();
		<?=$d?>

		$('#rep_container<?=$rr?>').highcharts({
			chart: {type: 'column'},
			title: {text: ''},
			navigator : {enabled : false},
			scrollbar : {enabled : false},	
			rangeSelector : {enabled : false},	
			xAxis: {categories: cats,labels:{rotation:-45}},
			yAxis: {min: 0,title:{text: ''}},
			tooltip: {
				headerFormat: '<span style="font-size:12px">{point.key}</span><table>',
				pointFormat: '<tr><td class="f1" style="color:{series.color};padding:0">{series.name}: </td>' +
					'<td style="padding:0"><b>{point.y}</b></td></tr>',
				footerFormat: '</table>',
				shared: true,
				useHTML: true
			},
			series: [
			{name: '<?=k_val?>',data: data_all, dataLabels:{enabled: true,format: '{y}',rotation:-45,align:'left',y:-5}}, 

			]
		});
		</script><?
	}
	if($subType==1){?>
		<script type="text/javascript">
		cats_c=new Array();
		data_all=new Array();
		<?=$d?>		
		$('#rep_container<?=$rr?>').highcharts({
			chart: {type:'areaspline',scrollablePlotArea:{minWidth:600,scrollPositionX:1}},
			xAxis:{categories:cats_c},
			title:{text:'<?=$ana_text?>'},
			series:[{name:'<?=k_val?>',data: data_all, dataLabels:{enabled: true,format:'{y}',rotation:-45,align:'left',y:-5}}],
			responsive: {
				rules: [{condition:{maxWidth:500},chartOptions:{legend:{layout:'horizontal',align:'center',verticalAlign:'bottom'}}}]
			}

		});
		</script><?
	}
}?><div id="rep_container<?=$rr?>" style="width:100%; direction:ltr"></div><? 	
}?>
