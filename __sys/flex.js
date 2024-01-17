// JavaScript Document
$(document).ready(function(){fxObjects($('body'));})
function fxObjects(obj){
	obj.find('[fxg]').each(function(){
		fxg=$(this).attr('fxg');
		if(typeof fxg != typeof undefined){
			fxg_pd=fxg.split('|');
			fxgPars=fxg_pd.length;         
			for(f=0;f<fxgPars;f++){
                if(fxg_pd[f]){
                    fxg_pd2=fxg_pd[f].split(':');
                    fxg_n=fxg_pd2[0];
                    fxg_v=fxg_pd2[1];
                    fxg_m=fxg_pd2[2];
                    creatStyle($(this),fxg_n,fxg_v,fxg_m);
                }
			}
            $(this).removeAttr('fxg');
		}
	})
    
}
var styObj=[]
function creatStyle(sel,type,val,media){
    st=0;
    sStyle='';
    if(styObj.length>0){
        $.each(styObj,function(key,value){
            if(val==value[2] && type==value[1] &&  media==value[3]){
                st=value[0];                
                sStyle=value[2];
            }
        });
    }
    if(st==0){
        st=Math.floor(Math.random()*100000);
        if(val){
            vv=val.split(',');
            if(vv[0]=='mm' && vv.length==3){
                if(vv[1]=='a'){vv[1]='auto';}
                if(vv[2]=='a'){vv[2]='auto';}                        
            }
        }
        if(type=='gta'){
            v=val.split('-');
            val='';
            $.each(v,function(i,vvv) {
               val+='\n"'+vvv.replace(',',' ')+'"';
            });
            val+='\n';
        }
        switch(type){        
            case 'gtc':sStyle='.st'+st+'{grid-template-columns:'+val+';}';break;
            case 'gtr':sStyle='.st'+st+'{grid-template-rows:'+val+';}';break;        
            case 'gap':sStyle='.st'+st+'{gap:'+val+';}';break;
            case 'gap-x':sStyle='.st'+st+'{column-gap:'+val+';}';break;
            case 'gap-y':sStyle='.st'+st+'{row-gap:'+val+';}';break;
            case 'gcs':sStyle='.st'+st+'{grid-column:span '+val+';}';break;
            case 'grs':sStyle='.st'+st+'{grid-row:span '+val+';}';break;
            case 'gcp':sStyle='.st'+st+'{grid-column:'+val+';}';break;
            case 'grp':sStyle='.st'+st+'{grid-row:'+val+';}';break;
            case 'gta':sStyle='.st'+st+'{grid-template-areas:'+val+';}';break;
            case 'gta-n':sStyle='.st'+st+'{grid-area:'+val+';}';break;
            case 'gtb':sStyle='.st'+st+'{grid-template-columns:repeat(auto-fit,minmax('+val+',1fr));}';break;
            case 'gtb-r':sStyle='.st'+st+'{grid-template-rows:repeat(auto-fit,minmax('+val+',1fr));}';break;
                
            case 'gtbf':sStyle='.st'+st+'{grid-template-columns:repeat(auto-Fill,minmax('+val+',1fr));}';break;
            case 'gtbf-r':sStyle='.st'+st+'{grid-template-rows:repeat(auto-Fill,minmax('+val+',1fr));}';break;

            case 'grow':sStyle='.st'+st+'{flex-grow:'+val+';}';break;
            case 'fx':sStyle='.st'+st+'{flex:'+val+';}';break;
        }
        if(media){sStyle='@media only screen and (max-width:'+media+'px){'+sStyle+'}';}
        //CL(sStyle)
        styObj.push([st,type,val,media]);
        $('#st').append(sStyle);
    }
    sel.addClass('st'+st);
}