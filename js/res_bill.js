CurdPanel.prototype.month_bill = function (filter_filed) {


   
     var that = this;
     //防止重复打开
     if (Ext.getCmp('bill_win')) {
         Ext.getCmp('bill_win').close();
     }
     var userRecord = Ext.getCmp(this.panelId).getSelectionModel().getSelections();
     if (userRecord.length == 0) {
         Ext.Msg.alert('提示', '选择一条记录');
         return false;
     }

     var row = userRecord[0];
     
     var filtervalue= row.get(filter_filed);
     
     
     
     var activity_code = 'oss_resource_fault_discount';

     
     var curd_panel = new CurdPanel(activity_code,filter_filed,filtervalue);
     var ajaxresult = curd_panel.init();

     var ticket = setInterval(function () {
         if (curd_panel.callback_flag) {
             var bill_win = new Ext.Window({
             	   id:'bill_win',
                 width: 800,
                 height: 400,
                 title: curd_panel.gridTitle+'-->'+filtervalue,
                 items: [curd_panel.gridPanel]
             });
             bill_win.show();
             clearInterval(ticket);
         }
     }, 100);

 };
 
  
  