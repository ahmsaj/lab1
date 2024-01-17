<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['opr'],$_POST['pat'])){
	$id=pp($_POST['id']);
	$opr=pp($_POST['opr']);
	$pat=pp($_POST['pat']);
	if($opr==1){
		$patName=get_p_name($id);?>
		<div class="win_body">
			<div class="form_header so lh40 clr1 f1 fs20"><?=$patName?></div>
			<div class="form_body of" type="pd0">
				<div class="fxg h100" fxg="gtc:250px 1fr">
					<div class="fl r_bord pd10" >
						<div class="butPRopt op2 ofx so" id="op3" actButt="act">
						<div n3 no="0" act><?=k_all_vitals?></div><? 
						$sql="select vital , count(vital) c from cln_x_vital_items where patient = '$id' group by vital  ";
						$res=mysql_q($sql);
						while($r=mysql_f($res)){
							$vital=$r['vital'];
							$c=$r['c'];?>
							<div n3 no="<?=$vital?>"><?=get_val('cln_m_vital','name_'.$lg,$vital)?>  <span> ( <?=$c?> )</span></div><? 
						}?>
						</div>	
					</div>
					<div id="pr_vital" class="fl pd10 ofx so h100"></div>
				</div>
			</div>
			<div class="form_fot fr">
				<div class="bu bu_t2 fr" onclick="win('close','#m_info4');"><?=k_close?></div>     
			</div>
		</div><?
	}else{
		$q='';
		if($id!=0){$q= "and vital= '$id' "; }
		$sql1="select vital , count(vital) c from cln_x_vital_items where patient = '$pat' $q group by vital  ";
		$res1=mysql_q($sql1);
		while($r1=mysql_f($res1)){
			$vital=$r1['vital'];
			$c=$r1['c'];
			$v_name=get_val('cln_m_vital','name_'.$lg,$vital);?>
			<div class="f1 fs18 lh50 uLine clr1"><?=$v_name?>  <ff> ( <?=$c?> )</ff></div><?
			$sql="select * from cln_x_vital_items where patient='$pat' and vital='$vital' order by date ASC ";
			$res=mysql_q($sql);
			$rows=mysql_n($res);
			if($rows>0){
				$script='';
				list($name,$unit,$type,$equation)=get_val('cln_m_vital','name_ar,unit,type,equation',$vital);				
				while($r=mysql_f($res)){
					$id=$r['id'];
					$date=date('Y-m-d',$r['date']);			
					$value=$r['value'];
					$normal_val=$r['normal_val'];
					$script.='prvData1.push([\''.$date.'\','.$value.']);';
					$script.='prvDataCat.push([\'<ff>'.$date.'</ff>\']);';
					if($normal_val){
						$nor_val=explode(',',$normal_val);
						if($type==1){						
							$script.='prvData2.push([\''.$date.'\','.$nor_val[1].','.$nor_val[2].']);';
						}
						if($type==2){
							$max=getMaxMin('max','cln_x_vital_items','value'," where patient='$patient' and vital = '$id' ");
							$min=getMaxMin('min','cln_x_vital_items','value'," where patient='$patient' and vital = '$id' ");
							$v1=$v2=0;
							if($nor_val[0]==0){$v1=$nor_val[1];$v2=$max;}
							if($nor_val[0]==1){$v1=$min;$v2=$nor_val[1];}
							if($nor_val[0]==2){$v1=$nor_val[1];$v2=$max;}
							if($nor_val[0]==3){$v1=$min;$v2=$nor_val[1];}
							if($nor_val[0]==4){$v1=$v2=$nor_val[1];}
							$script.='prvData2.push([\''.$date.'\','.$v1.','.$v2.']);';
						}
					}
				}?>
				<script type="text/javascript">
					prvData1=[];
					prvData2=[];
					prvDataCat=[];
					<?=$script?>
					var ranges = prvData2,averages = prvData1;
					Highcharts.chart('container<?=$id?>',{
						title:{text:false},xAxis:{categories:prvDataCat},yAxis:{title:{text:null}},
						plotOptions:{line:{dataLabels:{enabled:true},enableMouseTracking:false}},
						tooltip:{crosshairs:true,shared:true,valueSuffix:''},
						series:[{
							name:'<?=$v_name?>',data:averages,zIndex:1,
							marker:{fillColor:'white',lineWidth:2,lineColor:Highcharts.getOptions().colors[0]}
						},{
							name:'N',data:ranges,type:'arearange',
							lineWidth:2,linkedTo:':previous',color:Highcharts.getOptions().colors[2],
							fillOpacity:0.5,zIndex:0,marker:{enabled:false},dataLabels:{enabled:true}
						}]
					});
				</script>
				<div id="container<?=$id?>" style="height:450px; min-width: 310px; direction:ltr"></div><? 
			}
		}
	}
}?>