<? include("../../__sys/mods/protected.php");?>
<?
$pers=get_val('api_users','pers',$thisUser);
$pers=str_replace(',',"','",$pers);?>
<div class="centerSideInFull of fxg" fxg="gtc:300px 1fr|gtr:50px 1fr">
    <div class=" b_bord r_bord" ><?
        $sql="select * from api_noti_list where act=1 order by ord ASC";
        $res=mysql_q($sql);
        $rows=mysql_n($res);
        if($rows){
            echo '<select t id="noti" fix="h:50" class=" cbg666">
                <option value="0">'.k_choose_procedure.'</option>';
                while($r=mysql_f($res)){echo '<option value="'.$r['id'].'">'.$r['name_'.$lg].'</option>';}			
            echo '</select>';
        }?>
    </div>
    <div class=" b_bord f1 fs18 lh50 pd10" ><?=k_outputs?></div>
    <div class="ofx so r_bord pd10"  id="mInfo"></div>	
    <div class="ofx so pd10 lh20 fs14"  id="mOut" dir="ltr"></div>		
	
</div>
<script>$(document).ready(function(e){noti_set();});</script>