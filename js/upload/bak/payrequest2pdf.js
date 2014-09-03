NANXplugin.prototype.payrequest2pdf=function(btn)
{
         
        var motherPanel_id = btn.ownerCt.ownerCt.id;
        var userRecord = Ext.getCmp(motherPanel_id).getSelectionModel().getSelections();
         
        if (!(userRecord.length == 1)) {
                Ext.Msg.alert('请选择一条记录');
                return false;
        }
        var pid=userRecord[0].data.pid;
        var res_uid=userRecord[0].data.res_uid;
        var cycle= userRecord[0].data.bill_cycle;
        console.log(userRecord[0].data);          
        this.getpdf( pid,res_uid,cycle);
}



NANXplugin.prototype.getpdf = function(pid,res_uid,cycle) {
       
        var pdf_cfg = {
                'pid':pid,
                'pdfname':res_uid+'_'+cycle+'.pdf'
        };
        var conn = new Ext.data.Connection({
                disableCaching: true,
                method: 'post',
                timeout: 20000,
                url: AJAX_ROOT + 'cpdf/resBillPdf'
        });
        conn.request({
                params: Ext.encode(pdf_cfg),
                success: function(response) {
                 	        var ret_json = Ext.util.JSON.decode(response.responseText);
                	        if(ret_json.success)
                	         {
                           var   furl=TMP_DIR + pdf_cfg.pdfname;
                           var win = new Ext.Window({
                             'title':'下载pdf',
                             'html':'<div style="margin:20px;"><a href='+furl+'>'+pdf_cfg.pdfname+'</a></div>', 
                             height: 350,
                             width: 400
                             });
                            win.show();
                           }
                           else
                           {
                           Ext.MessageBox.alert("错误","写文件失败,检查tmp目录文件可写性");
                           }
                         
                },
                failure: function() {
                        Ext.MessageBox.alert("连接失败");
                }
        });
};
