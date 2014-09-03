function Act_service(acode, service_url,memo) {
    button = {
        xtype: 'button',
        text: '执行',
        height: 30,
        iconCls: 'service_remote',
        iconAlign: "left",
        width: 90,
        handler: function() {
            Ext.MessageBox.confirm("确认", "确定执行操作?", function(btn) {
                if (btn == 'yes') {
                	 var waitMask=new Ext.LoadMask(Ext.getBody(), {msg:"处理中,请稍候..."});  
                    waitMask.show();//show方法显示
                    Ext.Ajax.request({
                        url:AJAX_ROOT+service_url,
                        success: function(response, opts) {
                        	  waitMask.hide();
                            Ext.Msg.alert('结果', '执行完成');
                            var obj = Ext.decode(response.responseText);
                            console.dir(obj);
                            Ext.Msg.alert('结果',obj.msg);
                            
                        },
                        failure: function(response, opts) {
                        	  waitMask.hide();
                            Ext.Msg.alert('结果', '发生错误,请联系开发者或网站');
                        }
                    });
                }
            });
        }
    };


    var f = new Ext.Container({
        items: [
            button
        ],
        style: " margin-left:158px;margin-top:30px;"
    });

    var memo = new Ext.Container({
        html:memo,
        style: " margin-left:10px;margin-top:10px;"
    });

    var service_win = new Ext.Window({
        autoScroll: true,
        closeAction: 'destroy',
        constrain: true,
        width: 400,
        height: 248,
        id: 'win_' + acode,
        title: '执行操作',
        items: [ memo,f],
        modal: true
    });
    service_win.show();
}