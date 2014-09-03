Topmenu = {
        menuPanel:"",
        tbar:"",
        init:function() {
                Topmenu.userControls = new Ext.ButtonGroup({
                        xtype:"buttongroup",
                        id:"user_controls",
                        frame:false
                });
                Topmenu.menuPanel = this.createMenuPanel();
        },
        createMenuPanel:function() {
                return new Ext.Panel({
                        region:"north",
                        layout:"fit",
                        border:false,
                        tbar:{
                                id:"header_tbar",
                                style:{
                                        "padding-left":"20px"
                                },
                                items:[
                                {
                                        iconCls:"about_dblite",
                                        text:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp',
                                        handler:Topmenu.showAboutWindow
                                },
                                {
                                        xtype:"tbseparator"
                                },
                                {
                                        text:i18n.return_front_end,
                                        width:25,
                                        handler:function() {
                                                window.location.href = "../";
                                        }
                                }]
                        },
                        items:[]
                })
        },
        showAboutWindow:function() {
                Topmenu.createAboutWindow();
        },
        createAboutWindow:function() {
                this.win = new Ext.Window({
                        title:"NaN-X",
                        id:"about_window",
                        width:400,
                        height:400,
                        resizable:false,
                        autoScroll:true,
                        layout:"border",
                        modal:true,
                        plain:true,
                        stateful:true,
                        items:[{
                                xtype:"panel",
                                id:"about_panel",
                                region:"center",
                                frame:true,
                                items:[{
                                        cls:"dblite_about_logo"
                                },
                                {
                                        id:"about_dblite",
                                        autoEl:{
                                                tag:"div" 
                                        }
                                }] 
                        }],
                        buttons:[{
                                text:i18n.close,
                                handler:function() {
                                        this.ownerCt.ownerCt.close()
                                }
                        }]
                });
                this.win.show();
                Ext.Ajax.request({
                        url:HELP_DIR + 'about',
                        success:function(response) {
                                Ext.getCmp('about_dblite').update(response.responseText);
                        }
                });
        } 
};