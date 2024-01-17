<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['pat'],$_POST['type'])){
	$pat=pp($_POST['pat']);
	$type=pp($_POST['type']);?>
	<div class="win_body">
	<div class="form_header so lh40 clr1 f1 fs18"><?=get_p_name($pat)?>
	<div class="fr ic40 icc1 ic40_ref fr" onclick="giChart(<?=$pat?>,<?=$type?>)"></div>
	</div>
	<div class="form_body so">
		<?
		$q='';
		switch($type){
			case 1:
				$title=k_weight_to_age_chart;;
				$scale=k_weight;
				$scale2=k_age;
				$col1='age';
				$col2='weight';				
				break;
			case 2:		
				$title=k_height_to_age_chart;;
				$scale=k_height;
				$scale2=k_age;
				$col1='age';
				$col2='Length';
			break;
			case 3:		
				$title=k_head_to_age_chart;;
				$scale=k_head_circumf;
				$scale2=k_age;
				$col1='age';
				$col2='head';
				$q=" and age<=36 ";
			break;
			case 4:		
				$title=k_bmi_to_age_chart;;
				$scale="BMI";
				$scale2=k_age;
				$col1='age';
				$col2='weight,Length';
				$q=" and age>36 ";
			break;
			case 5:		
				$title=k_height_to_weight_chart;;
				$scale=k_height;
				$scale2=k_weight;
				$rType=7;
				$col2='weight';
				$col1='Length';
			break;
		}
		$sex=get_val_c('gnr_m_patients_medical_info','sex',$pat,'patient');	
		if(!$sex){
			$sex=get_val('gnr_m_patients','sex',$pat);
		}
		if($sex){
			$points=array();
			$minP=$maxP='x';
			$sql="select $col1,$col2 from gnr_x_growth_indicators where patient='$pat' $q order by age ASC";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows){
				while($r=mysql_f($res)){
					$c1=$r[$col1];					
					if($type==4){
						$Length=$r['Length'];
						$weight=$r['weight'];
						$c2=$weight/($Length/100*$Length/100);
						array_push($points,'['.($c1).','.$c2.']');						
					}else{
						$c2=$r[$col2];
						array_push($points,'['.($c1).','.$c2.']');						
					}
					if($minP=='x'){
						$minP=$maxP=$c1;
					}else{
						$minP=min($c1,$minP);
						$maxP=max($c1,$maxP);
					}
					
				}
				$minP-=5;
				$maxP+=5;
				$sql="select * from gnr_m_growth_indicators where type='$type' and sex='$sex' and scale>=$minP and scale<= $maxP order by scale ASC ";
				$res=mysql_q($sql);
				$rows=mysql_n($res);
				$data=array();			$data[0]=$data[1]=$data[2]=$data[3]=$data[4]=$data[5]=$data[6]=$data[7]=$data[8]=array();
				while($r=mysql_f($res)){
					$scale=$r['scale'];
					array_push($data[0],'['.$scale.','.$r['minus_2_res'].']');
					array_push($data[1],'['.$scale.','.$r['minus_1.5_res'].']');
					array_push($data[2],'['.$scale.','.$r['minus_1_res'].']');
					array_push($data[3],'['.$scale.','.$r['minus_0.5_res'].']');
					array_push($data[4],'['.$scale.','.$r['equation_res'].']');
					array_push($data[5],'['.$scale.','.$r['plus_0.5_res'].']');
					array_push($data[6],'['.$scale.','.$r['plus_1_res'].']');
					array_push($data[7],'['.$scale.','.$r['plus_1.5_res'].']');
					array_push($data[8],'['.$scale.','.$r['plus_2_res'].']');
				}?>
				<script>
					fixPage();
					$("#rep_container").highcharts({	
						chart:{
							type:'spline',
							scrollablePlotArea:{minWidth:600,scrollPositionX:1}
						},
						title:{text:'<?=$title?>',align:'center'},
						minorGridLineWidth:0,
						gridLineWidth:0,
						alternateGridColor: null,
						xAxis:{
							text: '<?=$scale2?>',
							labels:{rotation:-45}
						},
						yAxis:{
							title: {text:'<?=$scale?>'},
							minorGridLineWidth: 1,
							gridLineWidth: 1,
							alternateGridColor: null,					
						},
						tooltip:{enabled:false},
						plotOptions: {
							spline: {
								lineWidth: 1,
								states: {
									hover: {
										lineWidth: 1
									}
								},
								marker: {
									enabled: false,
									states: {
										hover: {
											enabled: false
										}
									}
								}
							},
						},
						
						series:[<? 
							foreach($data as $k=>$d){echo '{name: "'.$GI_txt[$k].'",data:['.implode(',',$d).']},';}?>
							{								
								type:'scatter',
								name:'p',
								data:[<?=implode(',',$points)?>],
								tooltip:{enabled:true},								
								marker:{									
									symbol: 'cross',
									enabled: true,									
									radius:3,
									//fillColor:'#ff0000',									
								},
							}
						],
						colors:['<?=implode("','",$GI_clr)?>'],
						navigation:{menuItemStyle: {fontSize:'30px'}}
					});
				</script><?
			}
		}?>
		<div id="rep_container" fix="wp:0|hp:0"></div>
    </div>
    <div class="form_fot fr">
        <div class="bu bu_t2 fr" onclick="win('close','#m_info3');"><?=k_close?></div>     
    </div>
    </div><?
}?>