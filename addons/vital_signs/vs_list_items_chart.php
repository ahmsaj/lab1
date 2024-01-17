<? include("../header.php");
if(isset($_POST['vis'],$_POST['pat'],$_POST['id'])){
	$id=pp($_POST['id']);
	$vis=pp($_POST['vis']);
	$pat=pp($_POST['pat']);
	$r=getRecCon('cln_x_visits'," id='$vis' and patient='$pat' and doctor='$thisUser'");
	if($r['r']){
		list($sex,$birth)=get_val('gnr_m_patients','sex,birth_date',$pat);
		list($v_name,$type)=get_val('cln_m_vital','name_'.$lg.',type',$id);
			$birthCount=birthCount($birth);?>
		<div class="lh40 clr1111 f1 fs14"><?
		echo get_p_name($pat);
		echo ' <span class="clr1 f1 fs14 "> ( '.$sex_types[$sex]. ' ) </span>
		<ff class="clr55"> '.$birthCount[0].' </ff>
		<span class="clr55 f1 fs14 clr55"> '.$birthCount[1]. '</span>';?>
		</div>^
		<?
		if($id){
			$vits=array($id);
		}else{
			$vits=get_vals('cln_x_vital_items','vital'," patient='$pat' ",'arr');
		}
		foreach($vits as $id){
			list($v_name,$type)=get_val('cln_m_vital','name_'.$lg.',type',$id);
			echo '<div class="lh50 f1 fs16 clr1111 TC">'.$v_name.'</div>';
			$script=$script2=$script3='';
			$sql="select * from cln_x_vital_items where patient='$pat' and vital = '$id'  order by date ASC ";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				$i=1;
				while($r=mysql_f($res)){				
					$date=date('Y-m-d',$r['date']);				
					$value=$r['value'];
					$normal_val=$r['normal_val'];
					$script.='data1.push([\''.$date.'\','.$value.']);';
					$script.='cat.push([\'<ff>'.$date.'</ff>\']);';
					if($normal_val){
						$nor_val=explode(',',$normal_val);
						if($type==1){					
							$script.='data2.push([\''.$date.'\','.$nor_val[1].','.$nor_val[2].']);';
						}
						if($type==2){
							$max=getMaxMin('max','cln_x_vital_items','value'," where patient='$pat' and vital = '$id' ");
							$min=getMaxMin('min','cln_x_vital_items','value'," where patient='$pat' and vital = '$id' ");
							$v1=$v2=0;
							if($nor_val[0]==0){$v1=$nor_val[1];$v2=$max;}
							if($nor_val[0]==1){$v1=$min;$v2=$nor_val[1];}
							if($nor_val[0]==2){$v1=$nor_val[1];$v2=$max;}
							if($nor_val[0]==3){$v1=$min;$v2=$nor_val[1];}
							if($nor_val[0]==4){$v1=$v2=$nor_val[1];}
							$script.='data2.push([\''.$date.'\','.$v1.','.$v2.']);';
						}
					}
					$i++;
				}?>

				<script type="text/javascript">
				var data1=new Array();
				var data2=new Array();
				var cat=new Array();
				<?=$script?>
				var ranges=data2,averages=data1;
				Highcharts.chart('container<?=$id?>',{
					title:{text: false},
					xAxis:{categories:cat},
					yAxis:{title:{text:null}},
					plotOptions:{line:{dataLabels:{enabled:true},enableMouseTracking:false}},
					tooltip:{crosshairs:true,shared:true,valueSuffix:''},
					series:[{
						name:'<?=$v_name?>',data:averages,zIndex:1,
						marker:{fillColor:'white',lineWidth:2,lineColor:Highcharts.getOptions().colors[0]}
					},{
						name:'N',
						data:ranges,
						type:'arearange',
						lineWidth:2,
						linkedTo:':previous',
						color:Highcharts.getOptions().colors[2],
						fillOpacity: 0.5,
						zIndex:0,
						marker:{enabled:false},
						dataLabels:{enabled:true}
					}]
				});
				</script>

				<div id="container<?=$id?>" class="f9 bord pd10f" style="height:450px; min-width: 310px; direction:ltr"></div><? 
			}
		}
	}
}?>