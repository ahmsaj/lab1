<? include("../../__sys/mods/protected.php");?>
<?
$pers=get_val('api_users','pers',$thisUser);
$pers=str_replace(',',"','",$pers);?>
<div class="centerSideInFull of fxg" fxg="gtc:1fr 1fr 1.5fr|gtr:50px 1fr">
    <div class=" b_bord r_bord" ><?
        $sql="select * from api_module where code IN('$pers') and act=1 and part_main=1 order by ord ASC";
        $res=mysql_q($sql);
        $rows=mysql_n($res);
        if($rows){
            echo '<select t id="mod" fix="h:50" class=" cbg666">
                <option value="0">'.k_choose_procedure.'</option>';
                while($r=mysql_f($res)){echo '<option value="'.$r['code'].'">'.$r['title_'.$lg].'</option>';}			
            echo '</select>';
        }?>
    </div>
    <div class=" b_bord r_bord f1 fs14 lh50 TC cbg444" ><?=k_explain_outputs?></div>
    <div class=" b_bord r_bord f1 fs14 lh50 TC" ><?=k_outputs?></div>
    
	<div class="of r_bord  cbg4 fxg" fxg="gtr:1fr 60px">
		<div class="ofx so pd10">
            <div id="mInfo"></div>
            <div id="mInfoOut"></div>
        </div>
		<div class=" t_bord hide" fix="h:50" id="mButt">
			<div class="ic40 ic40_send ic40Txt icc4 sButt mg10f"><?=k_send?></div>
			<div class="ic40 ic40_ref ic40Txt icc1 mg10f bButt hide"><?=k_back?></div>
		</div>
	</div>
	<div class="ofx so fl r_bord pd10 cbg444" id="mOutInfo"></div>
	<div class="ofxy so fl pd10 lh20 fs14" id="mOut" dir="ltr"></div>
</div>
<script>$(document).ready(function(e){tester_set();});</script>