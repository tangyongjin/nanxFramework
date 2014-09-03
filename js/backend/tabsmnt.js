var tabsFirst = [
    {
        category:'tab1_app',
        css:'app_manage',
        title:i18n.application,
        child:[{
            id:'NANX_APP_SUMMARY',
            title:i18n.app_summary,
            css:'app_summary'
        }, {
            id:'NANX_SYS_CONFIG',
            css:'syscfgs',
            title:i18n.app_config
        }]
    },
    {
        category:'tab_tblmnt',
        title:i18n.tables,
        css:'tables',
        child:[{
            id:'table_data',
            title:i18n.table_data,
            css:'table_data'
        }, {
            id:'table_col',
            title:i18n.fields_mnt,
            css:'table_col'
        }, {
            id:'table_index',
            title:i18n.index_mnt,
            css:'table_index'
        }, {
            id:'NANX_TBL_CREATE',
            title:i18n.create_new_table,
            css:'table_builder'
        }]
    }, {
        category:'tab1_helps',
        title:i18n.operation_help,
        css:'help',
        child:[{
            id:'help_prefix',
            title:i18n.help_prefix,
            css:'sub_help'
        }, {
            id:'help_basetables',
            title:i18n.help_basetables,
            css:'sub_help'
        }, {
            id:'help_activity',
            title:i18n.help_activity,
            css:'sub_help'
        }, {
            id:'help_acl',
            title:i18n.help_acl,
            css:'sub_help'
        }, {
            id:'help_fks',
            title:i18n.help_fks,
            css:'sub_help'
        }, {
            id:'help_fields',
            title:i18n.help_fields,
            css:'sub_help'
        }]
    }
];

var  TabsMenu={
     tabsFirst:tabsFirst,
     getTabs:function()
     {return this.tabsFirst;}
};

Dbl.MainTabPanel = function(){
        var FirstTabs=TabsMenu.getTabs();
        var subtabs=[];
        for (i=0;i<FirstTabs.length;i++){
                var t={};
                t.id=FirstTabs[i].category;
                t.title=FirstTabs[i].title;
                t.hidden=true;
                t.iconCls=FirstTabs[i].css;
                t.listeners={
                        activate: function(tab){
                                this.getLevel2(tab);
                        },
                        scope:this
                };
                t.layout='fit';
                subtabs.push(t);
        }
        Dbl.MainTabPanel.superclass.constructor.call(this,{
                id:"MainTab",
                region:"center",
                minSize:200,
                maxSize:800,
                activeTab:0,
                border:false,
                margins:"0 2 0 0",
                resizeTabs:true,
                minTabWidth:115,
                enableTabScroll:true,
                items:[subtabs]
        })
};

Ext.extend(Dbl.MainTabPanel,Ext.TabPanel,{
        selectedTable:'',
        tableDataPanel:'',
        tableStructurePanel:'',
        dbStructurePanel:'',
        lastTableTabId:'',
        activeTabHandler:function(){
                Fb.UserActivity.setKeys([{
                        key:"active_subtab",
                        value:this.id
                }]);
                
                if ((this.id=='table_data')||(this.id=='table_index')||(this.id=='table_col')){
                        var current_table = Fb.UserActivity.getValue("table");
                        if (typeof(current_table)=="string")
                        {        
                                if (this.id=='table_data'){var activity_code='NANX_TBL_DATA';}
                                if (this.id=='table_col'){var activity_code='NANX_TBL_STRU';}     
                                if (this.id=='table_index'){var activity_code='NANX_TBL_INDEX';}
                                
                                if (this.table==current_table){
                                        this.show();
                                } else {
                                        this.table = current_table;
                                        var grid_id='grid_'+activity_code;
                                        new Act({
                                                edit_type:'edit',
                                                code:activity_code,
                                                table:current_table,
                                                transfer:false,
                                                grid_id:grid_id,
                                                showwhere:'render_to_tabpanel',
                                                host:this
                                        });
                                }
                        }
                }
                
                if(['NANX_TBL_CREATE','NANX_APP_SUMMARY','NANX_SYS_CONFIG'].indexOf(this.id)!=-1){
                  var cfg={
                                code:this.id,
                                grid_id:'grid_'+this.id,
                                showwhere:'render_to_tabpanel',
                                host: this
                                };
                            if (this.id=='NANX_SYS_CONFIG'){
                              cfg.code='NANX_TBL_DATA';
                              cfg.table='nanx_system_cfg';
                             }
                            if(this.id=='NANX_TBL_CREATE'){
                                 cfg.table='nanx_shadow';
                              }
                 new Act(cfg);
                }
                if ((this.id).substring(0,5)=='help_'){
                        this.removeAll();
                        var panel=new Ext.Panel({
                                id:'help_context'
                        });
                        Ext.Ajax.request({
                                url:HELP_DIR+this.id,
                                success:function(response){
                                        Ext.getCmp('help_context').update(response.responseText);
                                }
                        });
                        this.add(panel);
                        this.doLayout();
                }
                
                 
        },
        getLevel2: function(current){
                var FirstTabs =TabsMenu.getTabs();
                current.removeAll();
                var id = current.id;
                for(j=0;j<FirstTabs.length;j++){
                        if (id==FirstTabs[j].category)break;
                }
                var tbcfg=FirstTabs[j].child;
                var subtabs=[];
                for (var i=0;i<tbcfg.length;i++){
                        var r={};
                        r.id=tbcfg[i].id;
                        r.title=tbcfg[i].title;
                        r.iconCls=tbcfg[i].css;
                        r.layout="fit";
                        r.listeners={activate:this.activeTabHandler };
                        subtabs.push(r);
                };
                var l2tabs=new Ext.TabPanel({
                        id:'package_'+id,
                        cls:"dbl-subtab",
                        margins: "0 3 0 3",
                        resizeTabs:true,
                        border:false,
                        minTabWidth:125,
                        tabPosition:"top",
                        enableTabScroll:true,
                        items:subtabs,
                        activeItem:0
                });
                current.add(l2tabs);
                current.doLayout();
        },
        
        activeTabL1L2:function(level_cfg)
        {   
            if(!level_cfg){return;}
            if(level_cfg.isArray)
            {
            var x=Ext.getCmp(level_cfg[0]);
            x.show();
            var panel=Ext.getCmp('package_'+level_cfg[0]);
            var xid=panel.findById(level_cfg[1]);
            xid.show();
            }
            else
            {
            var x=Ext.getCmp(level_cfg);
            x.show();
            }
        }
});