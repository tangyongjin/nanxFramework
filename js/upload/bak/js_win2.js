 NANXplugin_window.prototype.jsfun=function()
 {    
 	    
 	  
 	    defaultEditor = 
 	      {
                fieldLabel: '手机号',
                id: 'phone',
                width: 100,
                height: 25,
                blankText: '不允许空'
        }
        
     var btn=
     {
                        xtype: 'button',
                        text: '查询',
                        handler: function(){}
                };
                
     
     var btn2=
     {
                        xtype: 'button',
                        text: '分配',
                        handler: function(){}
                };
                
       var btn3=
     {
                        xtype: 'button',
                        text: '发送',
                        handler: function(){
                        	
                        	var msg=Ext.get('sms_and_email');
                        var conn = new Ext.data.Connection({
                             disableCaching: true,
                             method: 'post',
                             url: 'http://127.0.0.1/nanx/index.php/service/sms'
                              });
                              
                         var msgcfg={
                         	'msg':msg.dom.value,
                         	'email':'zhu11@ort.com.cn',
                         	'mobile':18611154093
                         	};
                         	
                         conn.request({
                             params: Ext.encode(msgcfg),
                                success: function(response) {
                             //       window.location.href = TMP_DIR + excel_cfg.excel_name + ".xls";
                                     },
                               failure: function() {
                        Ext.MessageBox.alert("连接失败");
                                   }
                         });
        
        
        
        
        
                        	}
                };
                


var data=[ [1, 'EasyJWeb', 'EasyJF','www.baidu.com','1861115409311']
]; 
var store=new Ext.data.SimpleStore({data:data,fields:["id","name","organization","homepage","mobile"]})     
     var grid = new Ext.grid.GridPanel({ 
title:"查询结果", 
height:80, 
width:600, 
columns:[{header:"姓名",dataIndex:"name"}, 
{header:"邮件",dataIndex:"organization"}, 
{header:"地址",dataIndex:"homepage"},
{header:"手机",dataIndex:"mobile"}
], 
store:store, 
autoExpandColumn:2 
}); 
   
   
   
   

var data_worker=[ [1, 'EasyJWeb', 'EasyJF','www.baidu.com','1861115409311']
]; 
var store_worker=new Ext.data.SimpleStore({data:data_worker,fields:["id","name","organization","homepage","mobile"]})     
     var grid_worker = new Ext.grid.GridPanel({ 
title:"安装工列表", 
height:80, 
width:600, 
columns:[{header:"姓名",dataIndex:"name"}, 
{header:"邮件",dataIndex:"organization"}, 
{header:"地址",dataIndex:"homepage"},
{header:"手机",dataIndex:"mobile"}
], 
store:store_worker, 
autoExpandColumn:2 
}); 
     
     var msg=
   {
    xtype: 'textarea',
    id: 'sms_and_email',
    height: 70,
    width:600 
};
 
   
 	  var add_form = new Ext.form.FormPanel({
                xtype: 'form',
                id: 'add_form123',
                frame: true,
                labelAlign: 'left',
                labelWidth: 50, 
                defaultType: 'textfield',
                height:100,
                items:[defaultEditor,btn,btn2]
        });
        
      var  line= {
    xtype: 'container',
    width:600,
    height:10
};
      
 	    var grid_win = new Ext.Window({
                                closeAction: 'destroy',
                                constrain:true,
                                width: 800,
                                height:500,
                                items:[add_form,line,grid,line,grid_worker,line,msg,line,btn3],
                                title:'客户报装管理'
                        });
                        grid_win.doLayout();
                        grid_win.show();
 }