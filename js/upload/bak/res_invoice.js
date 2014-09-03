NANXplugin.prototype.resInvoice=function(btn)
{
 var motherPanel_id = btn.ownerCt.ownerCt.id;
 var userRecord = Ext.getCmp(motherPanel_id).getSelectionModel().getSelections();
 if (!(userRecord.length == 1)) {
         Ext.Msg.alert('提示', '请选择一条记录');
         return false;
 }
 
 var row = userRecord[0];
 var res=row.get('res_uid');
 
 var succ=function(resInfo){
 	var columns = new Array();
 	for(prop in resInfo)
  {
	  var readOnlyFlag=true;
 		if ( (prop=='success')||(prop=='msg')||(prop=='html') ) {continue;}
 		//if (prop=='suggest_pay'){ readOnlyFlag=false;}
     defaultEditor = {
        fieldLabel: resInfo[prop]['name'],
        id: prop,
        value: resInfo[prop]['value'],
        width: 200,
        height: 25,
        readOnly:readOnlyFlag,
        xtype: "textfield",
        blankText: '不允许空'
    }
         columns.push(defaultEditor);
         //return columns;
 	}
 	  var html=resInfo.html;
 	  var updateForm = new Ext.form.FormPanel({
                xtype: 'form',
                id: 'res_invoice_form',
                borderStyle: 'padding-top:3px',
                frame: true,
                defaultType: 'textfield',
                labelAlign: 'right',
                labelWidth: 190,
                defaluts: {
                        allowBlank: false,
                        width: 200
                },
                items: columns
        });
     
     
     var table = new Ext.Container({
                id:'res_history',
                html:html,
                id: 'res_dashboard' 
            });
            
     var win=Ext.getCmp('invoice_win');
     win.add(table);
     win.add(updateForm);
     win.doLayout();
     win.show();
 	
 	};
 
 var invoice_win = new Ext.Window({
     autoScroll: true,
     id:'invoice_win',
     title:'付款申请',
     closeAction: 'destroy',
     shadow:false,
     stateful:false, 
     constrain:true,
     width:1100,
     height:700,
     buttons:[{text:'保存付款申请单',
     	         handler:saveRequest}
     	        ]
     });
 
     invoice_win.on('beforerender',function(){  console.log('beforerender');       });           
     invoice_win.show();
     var adu = {'res_uid':res};
     Fb.ajaxPostData(AJAX_ROOT + 'service/getOneResProfile', adu, succ);
     
}


function saveRequest()
{
	var form=Ext.getCmp('res_invoice_form');
	var data=Fb.getFormData(form);
  Fb.ajaxPostData(AJAX_ROOT + 'service/saveResPayRequest', data,function(){});
}

function updateSuggest(info)
{
	 	for(prop in info)
	 	{
      if(Ext.get(prop)) 
      {
      var item=Ext.getCmp(prop);
      item.setValue(info[prop]);
      }
	 	}
 

}

function month_btn(cycle)
{
  var resform=Ext.get('res_uid');
  var res_uid=resform.getValue();
  var adu = {'res_uid':res_uid,'cycle':cycle};
  Fb.ajaxPostData(AJAX_ROOT + 'service/getResSuggest', adu, updateSuggest);
}