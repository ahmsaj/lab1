<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id']) || isset($_POST['sItme'],$_POST['pat'])){
	if(isset($_POST['id'])){
		$id=pp($_POST['id']);
		$q="id='$id'";
	}else{
		$sItme=pp($_POST['sItme']);
		$pat=pp($_POST['pat']);
		$q=" patient='$pat' and  serv_val_id='$sItme'";
	}
	$r=getRecCon('lab_x_visits_services_results',$q);
	if($r['r']){
		$id=$r['id'];
		$a_id=$r['serv_id'];
		$pat=$r['patient'];
		$svId=$r['serv_val_id'];
		$unit=$r['unit'];
		$unitTxt=get_val_arr('lab_m_services_units','code',$unit,'un');
		$anlName=get_val('lab_m_services_items','name_en',$svId);
		$clrN=2;
		?>
		<script src="<?=$m_path?>library/highstock/js/highstock.js"></script> 
		<script src="https://code.highcharts.com/highcharts.js"></script>
		<script src="<?=$m_path?>library/highstock/js/highcharts-more.js"></script>
		
		<div class="winBody of fxg " >
			<div class="formHeader so lh40 clr1 f1 fs18">
				<div class="fr ic40 icc1 ic40_ref" onclick="prlChart(<?=$id?>)"></div>
				<?=get_p_name($pat);?> <ff class="clr5"> <?=$anlName?> | <?=$unitTxt?></ff>
			</div>
			<div class="formBody h1100 fxg"  fxg="gtr:calc(100vh - 240px)">
				<div class="fxg h100" fxg="gtc:30% 70%|gtr:1fr">
					<div class=" ofx so r_bord pd10 h100"><?
						$script=$script2=$script3='';		
						$sql="select * from lab_x_visits_services_results where serv_val_id='$svId' and patient='$pat' order by date DESC";
						$res=mysql_q($sql);
						$rows=mysql_n($res);
						if($rows>0){
							$max=getMaxMin('max','lab_x_visits_services_results','value'," where serv_val_id='$svId' and patient='$pat' ");
							$min=getMaxMin('min','lab_x_visits_services_results','value'," where serv_val_id='$svId' and patient='$pat' ");
							$i=1;
							?><table width="100%" border="0" cellspacing="0" type="static" cellpadding="4" class="grad_s mlord holdH" ><?
							while($r=mysql_f($res)){
								$date=date('Y-m-d',$r['date']);				
								$value=$r['value'];
								$normal_val=$r['normal_val'];
								$unit=$r['unit'];
								$xSrv_id=$r['id'];
								$serv_val_id=$r['serv_val_id'];
								$report_type=$r['serv_type'];
								$value=$r['value'];
								$add_value=$r['add_value'];
								$n_val=$r['normal_val'];
								$hide=$r['hide'];

								list($data,$aStatus,$nTxt)=show_LVal($report_type,$value,$n_val,$add_value,$unit);
								if($aStatus>0){$norC='clr66 cbg666';}
								if($aStatus<0){$norC='clr5 cbg555';}
								if($aStatus==2){$norC='clr8 cbg888';}
								$rrv=0;
								?>
								<tr >						
								<td><ff><?=$date?></ff></td>
								<td class="ff fs18 B <?=$norC?> "><?=$data?></span></td>				
								<td class="ff fs16 "><?=$nTxt?></td>
								</td></tr><?
								if(in_array($report_type,array(1,2,4,7))){
									$script.='data1.push([\''.$date.'\','.$value.']);';
									$script.='cat.push([\'<ff>'.$date.'</ff>\']);';
								}
								if($n_val){
									$nor_val=explode(',',$n_val);
									if($report_type==1){						
										$script.='data2.push([\''.$date.'\','.$nor_val[1].','.$nor_val[2].']);';
									}
									if($report_type==2){
										$rType=$nor_val[0];
										$rVal=$nor_val[1];
										if($rType==0){$v1=$rVal;$v2=$max*1.2;}
										if($rType==1){$v1=$min*0.8;$v2=$nor_val[1];}
										if($rType==2){$v1=$rVal;$v2=$max*1.2;;}
										if($rType==3){$v1=$min*0.8;$v2=$rVal;}
										if($rType==4){$v1=$v2=$rVal;}
										if($rType!=5){
											$script.='data2.push([\''.$date.'\','.$v1.','.$v2.']);';
										}
									}
									if($report_type==4){
										$rType=$nor_val[1];
										$rVal=$nor_val[2];
										if($rType==0){$v1=$rVal;$v2=$max*1.2;}
										if($rType==1){$v1=$min*0.8;$v2=$rVal;}
										if($rType==2){$v1=$rVal;$v2=$max*1.2;;}
										if($rType==3){$v1=$min*0.8;$v2=$rVal;}
										if($rType==4){$v1=$v2=$rVal;}
										if($rType!=5){
											$script.='data2.push([\''.$date.'\','.$v1.','.$v2.']);';
										}
									}
									if($report_type==7){
										$script.='data2.push([\''.$date.'\','.$nor_val[0].','.$nor_val[1].']);';
										$clrN=0;
									}
								}
								$i++;
							}?>
							</table><? 
						}?>
					</div>
					<div>
						<? if(in_array($report_type,array(1,2,4,7))){?>
							<div id="container4" style="direction:ltr" class="">--</div>
							<script type="text/javascript">
								var data1=new Array();
								var data2=new Array();
								var cat=new Array();
								<?=$script?>
								var ranges = data2;
								var averages = data1;
								fixPage();
								fixForm();
								
								$('#container4').highcharts({
									chart: {type: 'line'},
									title:{text: false	},
									xAxis:{categories:cat},
									yAxis:{title: {text: null}},
									plotOptions:{line:{dataLabels: {enabled: true},enableMouseTracking: false}},
									tooltip: {crosshairs: true,shared: true,valueSuffix: ''},
									series: [{
										name:'<?=$anlName?>',
										data:averages,
										zIndex:1,
										marker:{fillColor:'white',lineWidth:2,lineColor:Highcharts.getOptions().colors[0]}
									},
									{
										name:'N',
										data:ranges,
										 type:'arearange',
										lineWidth:2,
										linkedTo:':previous',
										color:Highcharts.getOptions().colors[<?=$clrN?>],
										fillOpacity: 0.5,
										zIndex:0,
										marker:{enabled: false},
										dataLabels: {enabled: true}
									}]
								});
							</script>
							
						<?}else{
							echo '<div class="f1 fs16 clr5 lh40 pd10">'.k_item_dnt_include_chart.'</div>';
						}?>
					</div>
				</div>				
			</div>
			<div class="formFooter ">
				<div class="bu bu_t2 fr" onclick="win('close','#m_info4');"><?=k_close?></div>     
			</div>
		</div><?
	}else{?>
		<div class="win_body">
		<div class="form_header so lh40 clr1 f1 fs18">
		<div class="fr ic40 icc1 ic40_ref" onclick="prlChart(<?=$id?>)"></div>
		<?=get_p_name($pat);?> <ff class="clr5"> <?=$anlName?> | <?=$unitTxt?></ff>
		</div>
		<div class="form_body of">			
			<div class="f1 fs16 lh40 clr5"> <?=k_no_results?> </div>
		</div>
		<div class="form_fot fr">
			<div class="bu bu_t2 fr" onclick="win('close','#m_info4');"><?=k_close?></div>     
		</div>
		</div>
	<? }
}?>