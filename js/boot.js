Ext.ns('App');
App.init = function(){
     Ext.QuickTips.init();
     Ext.EventManager.onWindowResize(App.resize);
     App.resize();
     App.bind();
        
var viewH=Ext.getBody().getViewSize();
var topH=Ext.get('border-top').getHeight();
var footerH=Ext.get('footer').getHeight();
var h_contentbox=(viewH.height - topH - footerH );
if(h_contentbox <664){h_contentbox=664;}
 
Ext.get('content-box').setStyle('height',h_contentbox+'px');
};
  

App.resize = function() {
        var wh = Ext.getBody().getViewSize();
        var w=wh.height;
        if(w<752){w=752;}
        var height_header_footer=Ext.get("border-top").getHeight()+ Ext.get("footer").getHeight();
        Ext.get('content-box').setStyle('height', w-height_header_footer);
}

App.bind = function() {
        if (Ext.get('cpanel-left')){
                Ext.get('cpanel-left').on('click', function(e, target) {
                        var activity_type = target.getAttribute('activity_type');
                        var acode = target.getAttribute('id');
                        var fnname= target.getAttribute('fnname');
                        var url_for_get_cfg= target.getAttribute('url_for_get_cfg');
                        var memo=target.getAttribute('memo');
                        App.route(activity_type, acode,fnname,url_for_get_cfg,memo);
                }, this,{
                        delegate: 'a.nanx-4-ext'
                })
        }

        if (Ext.get('border-top')){
                Ext.get('border-top').on('click', function(e, target){
                	       var whoami =Ext.get('whoami').dom.innerHTML;
                	       var vnode={attributes:{value:whoami,text:whoami}};
                	       var opform=Fb.backendForm('user','reset_pwd', vnode);
                         var wincfg={title:i18n.reset_pwd,category:'user',opcode:'reset_pwd',node:vnode};
                         var win=Act.prototype.actionWin('backend',opform,wincfg);
                }, this,{
                        delegate: 'a#userpanel'
                })
        }
        
          if (Ext.get('border-top')){
                Ext.get('border-top').on('click',function(e, target){
                	      var whoami =Ext.get('whoami').dom.innerHTML;
                	      var vnode={};
                	      vnode.attributes={value:whoami,text:whoami};
                	      var opform=Fb.backendForm('all','p2p_sms', vnode);
                        var xwin=Act.prototype.actionWin('backend',opform,{ title:i18n.sms,category:'all',opcode:'p2p_sms',node:vnode});
                }, this,{
                        delegate: 'a#send_sms'
                })
        }
        
          if (Ext.get('work_event')){
                Ext.get('work_event').on('click',function(e, target){
                    var pid=target.getAttribute('pid');
                    console.log(pid);
                        var vnode={};
                	      vnode.attributes={pid:pid};
                	      var opform=Fb.backendForm('all','read_sms', vnode);
                        var xwin=Act.prototype.actionWin('backend',opform,{viewonly:true,title:i18n.read_sms,category:'all',opcode:'read_sms',node:vnode});
                }, this,{
                        delegate:'a.sms_tag'
                })
        }
        if (Ext.get('accordion_holder')){
                Ext.get('accordion_holder').on('click',function(e, target){
                 var whoami =Ext.get('whoami').dom.innerHTML;
                 new Act({
                 code: 'NANX_TBL_DATA',
                 table: 'nanx_sms',
                 pid_order:'desc',
                 filter_field:'receiver',
                 filter_value:whoami,
                 wintitle:i18n.message,
                 showwhere: 'autowin' 
                   }) 
                }, this,{delegate:'span#show_all_sms'})
        }
        
        
        
        
}

App.route = function(activity_type, code,fnname,service_url,memo){
	      if(activity_type=='js'){
	       if(NANXplugin_window.prototype[fnname]) 
                    {
                   NANXplugin_window.prototype[fnname]();
                    }else
                   	{   
                   		  Ext.MessageBox.alert(i18n.alert,i18n.entry_function+':[<span class=red>'+fnname+'</span>]'+i18n.not_exists+","
                   		  +i18n.pls_check_js_upload+".<br/><br/>"+i18n.code_sample+" <br/><br/>______________________________________________<br/><br/>"
                   		  + "NANXplugin_window.prototype."+i18n.entry_function+"=function()<br/>"
                   		  +"{<br/>"
                   		  +"//code here<br/>"
                   		  +"}<br/>______________________________________________"
                   		  
                   		  );
                   	}
	      } 


	      if(activity_type=='table')
        	{
           new Act({
                'code': code,
                'edit_type':'noedit',
                'showwhere': 'autowin',
                'host': null
                });
          }
        
        
        if(activity_type=='sql')
        	{
           new Act({
                'code': code,
                'edit_type':'noedit',
                'showwhere': 'autowin',
                'host': null
                });
          }
          
        if(activity_type=='service')
        	{
           Act_service(code,service_url,memo);
          }
}
 

Ext.onReady(function(){
        App.init();
        getevent();
    //    App.rightAccordion();
       // Ext.QuickTips.init();
        //helps_prod();
})
  