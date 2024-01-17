<? include("../../__sys/mods/protected.php");?>
<? header_sec($d_title,'action:'.k_backup.':ti_bak:newBp();|action:'.k_recovery.':ti_res:recBp()');?>
<script>
    $(document).ready(function(){
        $('body').on('click','[pro]',function(){updateTsblesList('pro',$(this))})
        $('body').on('click','[_pro]',function(){updateTsblesList('_pro',$(this),$(this).closest('tr').attr('tab'));})        
        $('body').on('click','[proc]',function(){updateTsblesList('proc',$(this));})
        $('body').on('click','[ch_pro_all]',function(){updateTsblesList('ch_pro_all',$(this));})
        
    })
    function updateTsblesList(type,obj,table=''){
        pro=obj.attr(type);
        t_type=obj.attr('t');
        //CL(type+','+pro+','+t_type+','+table)
        if(type=='pro'){
            if($('['+type+'='+pro+'][t='+t_type+']').prop('checked')){                
                $('[_'+type+'='+pro+'][t='+t_type+']').prop("checked",true);
                $('['+type+'c='+pro+'][t='+t_type+']').prop("checked",true);
                $('[_'+type+'c='+pro+'][t='+t_type+']').prop("checked",true); 
                $('['+type+'c='+pro+'][t='+t_type+']').show();
                $('[_'+type+'c='+pro+'][t='+t_type+']').show();              
            }else{
                $('[_'+type+'='+pro+'][t='+t_type+']').prop("checked",false);
                $('['+type+'c='+pro+'][t='+t_type+']').prop("checked",false);
                $('[_'+type+'c='+pro+'][t='+t_type+']').prop("checked",false);
                $('['+type+'c='+pro+'][t='+t_type+']').hide();
                $('[_'+type+'c='+pro+'][t='+t_type+']').hide();                
            }
        }
        if(type=='proc'){
            if($('['+type+'='+pro+'][t='+t_type+']').prop('checked')){
                $('[_'+type+'='+pro+'][t='+t_type+']').prop("checked",true);
                $('['+type+'c='+pro+'][t='+t_type+']').prop("checked",true);
                $('[_'+type+'c='+pro+'][t='+t_type+']').prop("checked",true); 
                $('['+type+'c='+pro+'][t='+t_type+']').show();
                $('[_'+type+'c='+pro+'][t='+t_type+']').show();              
            }else{
                $('[_'+type+'='+pro+'][t='+t_type+']').prop("checked",false);
                $('['+type+'c='+pro+'][t='+t_type+']').prop("checked",false);
                $('[_'+type+'c='+pro+'][t='+t_type+']').prop("checked",false);
                $('['+type+'c='+pro+'][t='+t_type+']').hide();
                $('[_'+type+'c='+pro+'][t='+t_type+']').hide();
            }
        }
        if(type=='_pro'){            
            if($('[tab='+table+']').find('[_pro]').prop('checked')){                
                $('[tab='+table+']').find('[_proc]').parent().css('background-color','#0f0');
                $('[tab='+table+']').find('[_proc]').prop("checked",true);
                $('[tab='+table+']').find('[_proc]').show();                 
            }else{   
                $('[tab='+table+']').find('[_proc]').parent().css('background-color','#f00');
                $('[tab='+table+']').find('[_proc]').prop("checked",false);
                $('[tab='+table+']').find('[_proc]').hide();  
            }
        }
        if(type=='ch_pro_all'){
            t=obj.attr('ch_pro_all');
            if(obj.prop('checked')){ 
                if(t=='mt'){$('[pro][t=m]').prop('checked',false);$('[pro][t=m]').click();$('[ch_pro_all=mc]').prop('checked',true);}
                if(t=='mc'){$('[proc][t=m]').prop('checked',false);$('[proc][t=m]').click();}
                if(t=='xt'){$('[pro][t=x]').prop('checked',false);$('[pro][t=x]').click();$('[ch_pro_all=xc]').prop('checked',true);}
                if(t=='xc'){$('[proc][t=x]').prop('checked',false);$('[proc][t=x]').click();}
            }else{
                if(t=='mt'){$('[pro][t=m]').prop('checked',true);$('[pro][t=m]').click();$('[ch_pro_all=mc]').prop('checked',false);}
                if(t=='mc'){$('[proc][t=m]').prop('checked',true);$('[proc][t=m]').click();}
                if(t=='xt'){$('[pro][t=x]').prop('checked',true);$('[pro][t=x]').click();$('[ch_pro_all=xc]').prop('checked',false);}
                if(t=='xc'){$('[proc][t=x]').prop('checked',true);$('[proc][t=x]').click();}
                
            }
        }
        if(type=='mod'){
            if($('['+type+'='+pro+']').prop('checked')){                
                $('[_'+type+'='+pro+']').prop("checked",true);                             
            }else{
                $('[_'+type+'='+pro+']').prop("checked",false);                
            }
        }
    }
</script>

<div class="centerSideInFull of h100">
    <div class="fxg h100" fxg="gtc:300px 1fr|gtr:40px 1fr">
        <div class="cbg3 r_bord h100 b_bord f1 fs16 lh40 pd10l clrw">
            <div class="fr ic40x ic40_add icc22 br0" addBackup></div>
            النسخ الاحتياطية
        </div>
        <div class="h100 of" fxg="grs:2">
            <div class="h100 of" id="backup_data"></div>
        </div>
        <div class="cbg4 r_bord h100 pd10f ofx so" id="backUpList">
       
        </div>
    </div>
</div> 
