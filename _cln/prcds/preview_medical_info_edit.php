<? include("../../__sys/prcds/ajax_header.php");
?><div class="win_body"> <?
if(isset($_POST['p_id'])&&isset($_POST['n'])){
	$p_id=pp($_POST['p_id']);
	$n=pp($_POST['n']);
	if($t2=getTotalCO('gnr_m_patients'," id='$p_id' ")>0){?> 
	    <div class="form_header cb">
            <div class="listDataSelCon2">
                 <div class="fl addToList" onclick="addToMadList(<?=$n?>)" title="<?=k_add?>"></div>
                 <div class="fl listDataSel2" fix="wp:58">
                     <input type="text" id="serMad"  onkeyup="ser_mad_T()" placeholder="<?=k_search?>" />
                 </div>                                   		
            </div>                  
        </div>
        <div class="form_body so " type="full" >        
            <div class="listData2 fl">                
                <div class="list_option2 so" id="list_mad"></div>
            </div> 
            <div class="option_selected2 fl so" id="sel_mad_in"><?=showMadInfo($n,$p_id,1)?></div> 
        </div>
        
        <div class="form_fot fr">
	        <div class="bu bu_t2 fr" onclick="loadMadInfo();win('close','#m_info')"><?=k_close?></div>
        </div>	
        <script>listButt()</script>
		<?
	}
	
}?>

</div>