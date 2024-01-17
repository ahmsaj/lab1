<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['id'],$_POST['p'])){
	$id=pp($_POST['id']);
	$patient=pp($_POST['p']);
	list($v_name,$type)=get_val('cln_m_vital','name_'.$lg.',type',$id);
	list($sex,$birth)=get_val('gnr_m_patients','sex,birth_date',$patient);	
	$birthCount=birthCount($birth);?>
	<div class="win_body">
	<div class="form_header so lh50 clr1 f1 fs18">
		<!--<div class="fr ic40 icc1 ic40_ref" onclick="vitalChart(<?=$patient?>,<?=$id?>)"></div>--><?
		echo get_p_name($patient);
		echo ' [ <ff class="clr5"> '.$birthCount[0].' </ff> <span class="clr1 f1 fs18 clr5">'.$birthCount[1]. '</span> ] <span class="clr1 f1 fs18 "> [ '.$sex_types[$sex]. ' ] </span> ';?>
	</div>
	<div class="form_body so"><?
		$script=$script2=$script3='';
		$sql="select * from cln_x_vital_items where patient='$patient' and vital = '$id'  order by date ASC ";
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
						$max=getMaxMin('max','cln_x_vital_items','value'," where patient='$patient' and vital = '$id' ");
						$min=getMaxMin('min','cln_x_vital_items','value'," where patient='$patient' and vital = '$id' ");
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
var ranges = data2,
    averages = data1;


Highcharts.chart('container', {

    title: {
        text: false
    },

    xAxis: {
       categories:cat 
    },

    yAxis: {
        title: {
            text: null
        }
    },
	plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    tooltip: {
        crosshairs: true,
        shared: true,
        valueSuffix: ''
    },

    series: [{
        name: '<?=$v_name?>',
        data: averages,
        zIndex: 1,
        marker: {
            fillColor: 'white',
            lineWidth: 2,
            lineColor: Highcharts.getOptions().colors[0]
        }
    },
	{
        name: 'N',
        data: ranges,
        type: 'arearange',
        lineWidth: 2,
        linkedTo: ':previous',
        color: Highcharts.getOptions().colors[2],
        fillOpacity: 0.5,
        zIndex: 0,
        marker: {
            enabled: false
        },
		dataLabels: {
			enabled: true
		}
    }]
});

</script>
<div id="container" style="height:450px; min-width: 310px; direction:ltr"></div><? 
		}
		
	?>
    </div>
    <div class="form_fot fr">
        <div class="bu bu_t2 fr" onclick="win('close','#m_info');"><?=k_close?></div>     
    </div>
    </div><?
}?>
