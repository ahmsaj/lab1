<? include("../../__sys/prcds/ajax_header.php");
$repType=array('',k_waiting,k_appointments);
if(isset($_POST['rep'],$_POST['part'],$_POST['ds'],$_POST['de'])){
	$out='';
	$rep=pp($_POST['rep']);
	$part=pp($_POST['part']);
	$ds=pp($_POST['ds'],'s');
	$de=pp($_POST['de'],'s');
	$min_avg=pp($_POST['min']);
	$max_avg=pp($_POST['max']);
	$chart_avg=pp($_POST['avg']);
	$partTxt=$clinicTypes[$part];
	if($chart_avg<1){$chart_avg=10;}
	if($max_avg>300){$max_avg=300;}
	if(!$partTxt){$partTxt=k_all_deps;}
	$dss=strtotime($ds);
	$dee=strtotime($de)+86400;
	if($dss<$dee && $min_avg < $max_avg){
		$title=''.$repType[$rep].' - '.$partTxt;
		$title2=$ds.' - '.$de;
		echo '<div class="f1 fs18 lh30 clr1 ">'.$repType[$rep].' &raquo; '.$partTxt.'</div>';
		echo '<div class="ff fs14 B lh30 clr11 uLine">'.$ds.' | '.$de.'</div>';
		if($rep==1){
			$tot=getWRSamm($rep,$part,$dss,$dee,$min_avg,$max_avg);
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" >
			<tr>
				<td><div class="clr1 f1 fs16">'.k_all_visits.'</div></td>
				<td><div class="clr5 f1 fs16">'.k_visits_smlr_thn_min.'</td>
				<td><div class="clr5 f1 fs16">'.k_visit_grtr_thn_max.'</td>
				<td><div class="clr6 f1 fs16">'.k_net_visits_in_rep.'</td>
			</tr>
			<tr>
				<td><ff class="clr1 fs24">'.number_format($tot[0]).'</ff></td>
				<td><ff class="clr5 fs24">'.number_format($tot[1]).'</ff></td>
				<td><ff class="clr5 fs24">'.number_format($tot[2]).'</ff></td>
				<td><ff class="clr6 fs24">'.number_format($tot[3]).'</ff></td>
			</tr>
			</table>';
			echo '<div class="f1 fs18 lh40 clr66 "> '.k_vis_no.' : <ff>'.number_format($tot[3]).'</ff></div>';
			$data=get_wr_data($rep,$part,$dss,$dee,$min_avg,$max_avg,$chart_avg);
			$ch_data='';
			$all=0;
			foreach($data as $k=>$d){				
				$ch_data.="['$k', $d],";   
				$all+=$d;
			}
			//echo $all;
			echo '
			<div id="rep_container" style="width:100%; height:400px; direction:ltr"></div>
			<div id="rep_container2" style="width:100%; height:600px; direction:ltr"></div>';?>
			<script>
			$("#rep_container").highcharts({	
				chart:{type:'column'},
				title:{text: '<?=$title?>'},
				subtitle:{text: '<?=$title2?>'},
				xAxis:{
					type: 'category',
					labels: {
						rotation: -45,
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif'
						}
					}
				},
				yAxis: {
					min: 0,
					title: {
						text: '<?=k_vis_no?>'
					}
				},
				legend: {
					enabled: false
				},
				tooltip: {
					pointFormat: '<b>{point.y} <?=k_visit?></b>'
				},
				series: [{
					name: 'Population',
					data: [<?=$ch_data?>],
					dataLabels: {
						enabled: true,
						format: '{point.y}', // one decimal
						y: -1, // 10 pixels down from the top
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif'
						}
					}
				}]
			});
			var pieColors = (function () {
			var colors = [],
				base = Highcharts.getOptions().colors[2],
				i;

			for (i = 0; i < <?=count($data)?>; i += 1) {
				// Start out with a darkened base color (negative brighten), and end
				// up with a much brighter color
				colors.push(Highcharts.Color(base).brighten((i - 1) / <?=count($data)*2?>).get());
			}
			return colors;
		}());
			$("#rep_container2").highcharts({
			chart: {
				//plotBackgroundColor: null,
				//plotBorderWidth: null,
				//plotShadow: false,
				type: 'pie'
			},
			title:{text: '<?=$title?>'},
			subtitle:{text: '<?=$title2?>'},
			tooltip: {
				pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					colors: pieColors,
					dataLabels: {
						enabled: true,
						format: '<b>{point.name}</b><br>{point.percentage:.1f} %',
						//distance: -50,
						filter: {
							property: 'percentage',
							operator: '>',
							value: 4
						}
					}
				}
			},
			series: [{
				name: ' ',
				data: [<?=$ch_data?>]
			}]
		});
			</script><?

		}
		if($rep==2){
			$tot=getWRSamm($rep,$part,$dss,$dee,$min_avg,$max_avg);
			echo '<table width="100%" border="0" cellspacing="0" cellpadding="4" class="grad_s" >
			<tr>
				<td><div class="clr1 f1 fs16"> '.k_all_appoints.'</div></td>
				<td><div class="clr6 f1 fs16">'.k_attnd_bfr_appoint.'</td>
				<td><div class="clr5 f1 fs16">'.k_attnd_aftr_appoint.'</td>				
			</tr>
			<tr>
				<td><ff class="clr1 fs24">'.number_format($tot[0]).'</ff></td>
				<td><ff class="clr6 fs24">'.number_format($tot[1]).'</ff></td>
				<td><ff class="clr5 fs24">'.number_format($tot[2]).'</ff></td>				
			</tr>
			</table>';
			echo '<div class="f1 fs18 lh40 clr66 ">'.k_attnd_bfr_appoint.' : <ff>'.number_format($tot[1]).'</ff></div>';
			/************************************/
			$data=get_wr_data($rep,$part,$dss,$dee,$min_avg,$max_avg,$chart_avg);
			$ch_data='';
			foreach($data as $k=>$d){$ch_data.="['$k', $d],";}
			echo '
			<div id="rep_container1" style="width:100%; height:400px; direction:ltr"></div>
			<div id="rep_container2" style="width:100%; height:600px; direction:ltr"></div>';?>
			<script>
			var pieColors = (function(){
				var colors = [],
				base = Highcharts.getOptions().colors[2],i;
				for (i = 0; i < <?=count($data)?>; i += 1) {
					colors.push(Highcharts.Color(base).brighten((i - 1) / <?=count($data)*2?>).get());
				}
				return colors;
			}());
			$("#rep_container1").highcharts({	
				chart:{type:'column'},
				title:{text: '<?=$title?>'},
				subtitle:{text: '<?=$title2?>'},
				xAxis:{
					type: 'category',
					labels: {
						rotation: -45,
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif'
						}
					}
				},
				yAxis: {
					min: 0,
					title: {
						text: '<?=k_vis_no?>'
					}
				},
				legend: {
					enabled: false
				},
				tooltip: {
					pointFormat: '<b>{point.y} <?=k_visit?></b>'
				},
				series: [{
					name: 'Population',
					data: [<?=$ch_data?>],
					dataLabels: {
						enabled: true,
						format: '{point.y}', // one decimal
						y: -1, // 10 pixels down from the top
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif'
						}
					}
				}]
			});
			$("#rep_container2").highcharts({
			chart: {
				//plotBackgroundColor: null,
				//plotBorderWidth: null,
				//plotShadow: false,
				type: 'pie'
			},
			title:{text: '<?=$title?>'},
			subtitle:{text: '<?=$title2?>'},
			tooltip: {
				pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					colors: pieColors,
					dataLabels: {
						enabled: true,
						format: '<b>{point.name}</b><br>{point.percentage:.1f} %',
						//distance: -50,
						filter: {
							property: 'percentage',
							operator: '>',
							value: 4
						}
					}
				}
			},
			series: [{
				name: ' ',
				data: [<?=$ch_data?>]
			}]
		});
			</script><?
			/************************************/		
			$data2=get_wr_data(3,$part,$dss,$dee,$min_avg,$max_avg,$chart_avg);
			$ch_data2='';
			foreach($data2 as $k=>$d){$ch_data2.="['$k', $d],";}
			echo '<div class="f1 fs18 lh40 clr66 ">'.k_attnd_aftr_appoint.' : <ff>'.number_format($tot[2]).'</ff></div>
			<div id="rep_container3" style="width:100%; height:400px; direction:ltr"></div>
			<div id="rep_container4" style="width:100%; height:600px; direction:ltr"></div>';?>
			<script>
			$("#rep_container3").highcharts({	
				chart:{type:'column'},
				title:{text: '<?=$title?>'},
				subtitle:{text: '<?=$title2?>'},
				xAxis:{
					type: 'category',
					labels: {
						rotation: -45,
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif'
						}
					}
				},
				yAxis: {
					min: 0,
					title: {
						text: '<?=k_vis_no?>'
					}
				},
				legend: {
					enabled: false
				},
				tooltip: {
					pointFormat: '<b>{point.y} <?=k_visit?></b>'
				},
				series: [{
					name: 'Population',
					data: [<?=$ch_data2?>],
					dataLabels: {
						enabled: true,
						format: '{point.y}', // one decimal
						y: -1, // 10 pixels down from the top
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif'
						}
					}
				}]
			});			
			$("#rep_container4").highcharts({
			chart: {
				//plotBackgroundColor: null,
				//plotBorderWidth: null,
				//plotShadow: false,
				type: 'pie'
			},
			title:{text: '<?=$title?>'},
			subtitle:{text: '<?=$title2?>'},
			tooltip: {
				pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					colors: pieColors,
					dataLabels: {
						enabled: true,
						format: '<b>{point.name}</b><br>{point.percentage:.1f} %',
						//distance: -50,
						filter: {
							property: 'percentage',
							operator: '>',
							value: 4
						}
					}
				}
			},
			series: [{
				name: ' ',
				data: [<?=$ch_data2?>]
			}]
		});
			</script><?
			/************************************/
			
			$data3=get_wr_data(4,$part,$dss,$dee,0,15,min($chart_avg,5));
			$ch_data3='';
			foreach($data3 as $k=>$d){$ch_data3.="['$k', $d],";}
			echo '<div class="f1 fs18 lh40 clr55 ">'.k_attnd_late_rate.' : <ff>'.number_format($tot[2]).'</ff></div>
			<div id="rep_container5" style="width:100%; height:400px; direction:ltr"></div>
			<div id="rep_container6" style="width:100%; height:600px; direction:ltr"></div>';?>
			<script>
			var pieColors2 = (function(){
				var colors = [],
				base = Highcharts.getOptions().colors[5],i;
				for (i = 0; i < <?=count($data)?>; i += 1) {
					colors.push(Highcharts.Color(base).brighten((i-1)/<?=count($data3)*2?>).get());
				}
				return colors;
			}());
			$("#rep_container5").highcharts({	
				chart:{type:'column',},
				title:{text: '<?=$title?>'},
				subtitle:{text: '<?=$title2?>'},
				xAxis:{
					type: 'category',
					labels: {
						rotation: -45,
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif'
						}
					}
				},
				yAxis: {
					min: 0,
					title: {
						text: '<?=k_vis_no?>'
					}
				},
				legend: {
					enabled: false
				},
				tooltip: {
					pointFormat: '<b>{point.y} <?=k_visit?></b>'
				},
				series: [{
					name: 'Population',
					color:Highcharts.getOptions().colors[5],
					data: [<?=$ch_data3?>],
					
					dataLabels: {
						enabled: true,
						format: '{point.y}', // one decimal
						y: -1, // 10 pixels down from the top
						style: {
							fontSize: '13px',
							fontFamily: 'Verdana, sans-serif'
						}
					}
				}]
			});			
			$("#rep_container6").highcharts({
			chart: {
				plotBackgroundColor: null,
				plotBorderWidth: null,
				plotShadow: false,
				type: 'pie'
			},
			title:{text: '<?=$title?>'},
			subtitle:{text: '<?=$title2?>'},
			tooltip: {
				pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
			},
			plotOptions: {
				pie: {
					allowPointSelect: true,
					cursor: 'pointer',
					colors: pieColors2,
					dataLabels: {
						enabled: true,
						format: '<b>{point.name}</b><br>{point.percentage:.1f} %',
						//distance: -50,
						filter: {
							property: 'percentage',
							operator: '>',
							value: 4
						}
					}
				}
			},
			series: [{
				name: ' ',
				data: [<?=$ch_data3?>]
			}]
		});
			</script><?

		}
	}else{
		echo '<div class="f1 fs16 lh40 clr5 ">'.k_error_data.'</div>';
	}	
}