function showCurdPanel(activity_code,filter_field,filter_value,ui_type)
{   
    var curd_panel = new CurdPanel(activity_code,filter_field,filter_value,ui_type);
    var content_div = document.getElementById("content-box");
    var grid_w = content_div.offsetWidth - 40;
    var grid_h = content_div.offsetHeight - 10;
    var modal=false;
    if(ui_type=='sub')
    {
    var grid_w =800;
    var grid_h =400;
    var modal=true; 
    }
    curd_panel.init();
    var ticket = setInterval(function () {
        if (curd_panel.callback_flag) 
        {       
        	      var winid='win'+curd_panel.gridTitle;
        	      if(!Ext.getCmp(winid))
        	      {
                var grid_win = new Ext.Window({
                    width: grid_w,
                    height: grid_h,
                    id:winid,
                    title: curd_panel.gridTitle,
                    renderTo: "content-box",
                    modal:modal,
                    items: [curd_panel.gridPanel]
                });
                grid_win.show();
               } 
               else
               	{ 
               		var grid_win=Ext.getCmp(winid);
               		grid_win.toFront();}   
            
            clearInterval(ticket);
        }
    }, 100);
}

//function  btnHandler(subActivity_code,motherPanel_id,filter_field)

function  btnHandler(cfg)
{
	var motherPanel_id=cfg.panelid;
	var mainCol=cfg.mainCol;
	var subFCol=cfg.subFCol;
	var btn_ref_act=cfg.btn_ref_act;
	
	var userRecord = Ext.getCmp(motherPanel_id).getSelectionModel().getSelections();
  if (userRecord.length == 0) {
         Ext.Msg.alert('提示', '选择一条记录');
         return false;
     }
  var row = userRecord[0];
  var filtervalue= row.get(mainCol);
  
   
  
  showCurdPanel(btn_ref_act,subFCol,filtervalue,'sub');
} 