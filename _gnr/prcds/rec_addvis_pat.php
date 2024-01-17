<? include("../../__sys/prcds/ajax_header.php");
if(isset($_POST['t'],$_POST['c'])){
	$t=pp($_POST['t']);
	$c=pp($_POST['c']);
	$clincView='';
	if($c){	list($name,$photo,$cType)=get_val('gnr_m_clinics','name_'.$lg.',photo,type',$c);
        $ph_src='';
        if($photo){
		    $ph_src=viewImage($photo,1,30,30,'img','clinic.png');
        }
		$clincView='
		<div class="fl w100 b_bord pd5v">
			<div class="fl lh30 pd5" fix="h:30">'.$ph_src.'</div>
			<div class="fl lh30 f1 fs12 pd10">'.k_clinic.' : '.$name.'</div>
		</div>';
		$prg=explode(',',_set_anonjaukgo);
		if($cType==2 || !in_array($clinicCode[$cType],$prg)){
			echo script('patEvent=2;');
		}
	}
	echo biludWiz(2,$t);?>	
	<div class="fxg" fxg="gtc:1fr 4fr|gtc:1fr 3fr:1400|gtc:1fr 2fr:1100" fix="wp:0|hp:50">
		<div class="fl r_bord pd10 ofx so ">
		<?=$clincView.patForm()?></div>
		<div class="fl pd10 ofx so" fix1="wp:220|hp:0" patList></div>
	</div>
	<?
}?>