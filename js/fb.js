  Ext.override(Ext.Component,{
        Callback_setValue:function(value){
                var xtype=this.getXType();
                console.log(xtype);
                if(xtype=='textfield'||xtype=='textarea'||xtype=='combo'||xtype=='StarHtmleditor') {this.setValue(value);}
                if((xtype=='panel') &&( this.items.itemAt(0).getXType()=='checkbox' )) 
                {
                               for( var i=0;i< this.items.getCount();i++)
                               {
                               if(value.indexOf(this.items.itemAt(i).inputValue) !== -1)
                                 {
                                  this.items.itemAt(i).setValue(true);
                                 }
                                 else
                                  {
                                        this.items.itemAt(i).setValue(false);
                                  }
                               } 
                }
        } 
});

 
 Ext.ns('Fb');

 var Fb = {};
 var WaitMask = {
     mask: null,
     'ajaxinfo': i18n.mask_text,
     'uploadinfo': i18n.upload_wait_text,
     show: function(type) {
         this.mask = new Ext.LoadMask(Ext.getBody(), {
             msg: type ? this.uploadinfo : this.ajaxinfo
         })
         document.body.style.cursor = "wait";
         this.mask.show();
     },
     hide: function() {
         document.body.style.cursor = "auto";
         this.mask.hide();
         return true;
     }
 }
 
 
 Fb.showPic = function(pic) {
     console.log(pic);
     var xwin = new Ext.Window({
         constrain: true,
         modal: true,
         title: i18n.origin_pic + '   ' + pic,
         html: '<br/>&nbsp;&nbsp;' + pic + "<br/><img style='margin:10px;' src='" + pic + "'>"
     });
     xwin.show();
 }

 

Fb.toggle_combo=function(togglefalg)
{
   //enable or disable all combo in form
   var current_form = Ext.getCmp('back_opform');
   var cbs = current_form.findByType(['combo']);
   for (var i = 0; i < cbs.length; i++){
       if (togglefalg){cbs[i].enable(); }else{cbs[i].disable(); }
   }
}

 Fb.getFileType=function(name)
 {    
      var pictype = ['gif', 'bmp', 'png', 'jpg', 'jpeg', 'tif'];
      var no_pic = ['avi', 'css', 'doc', 'docx', 'midi', 'mov', 'mp3', 'mpeg', 'pdf', 'ppt', 'pptx', 'proj', 'psd', 'pst', 'rar', 'txt',
         'wav', 'wma', 'wmv', 'xls', 'zip'
      ];
      var xlstype=['xls'];
      var jstype=['js'];
      var sqltype=['sql'];
      var phptype=['php'];
      var meta = name.split('.').pop().toLowerCase();
      var ftype='unknow';
      if(pictype.indexOf(meta)!== -1){
         ftype = 'pic';
      }
      if(sqltype.indexOf(meta)!== -1){
         ftype = 'sql';
      }
      if(jstype.indexOf(meta)!== -1){
         ftype = 'js';
      }
      if(phptype.indexOf(meta)!== -1){
         ftype = 'php';
      }
      if (no_pic.indexOf(meta) !== -1) {
         ftype = meta;
      }
      return ftype;
 }

 Fb.geFileWrapper = function(field) {
     if (!field.value) {
         var box = {
             xtype: 'box'
         };
         return box;
     }

     var fname = field.value.split('/').pop();
     var ftype=Fb.getFileType(fname);
     if (ftype == 'pic'){
         var box = {
             xtype: 'box',
             html: '<div class=pic_holder><span>' + i18n.dbl_click_to_viewe_origin_pic + '</br></span><img id="' + field.name + '_img_mask" src="' + field.value + '"></div>',
             listeners: {
                 afterrender: function(b) {
                     var pic = Ext.get(field.name + '_img_mask');
                     pic.on('dblclick', function() {
                         Fb.showPic(field.value);
                     }, this)
                 }
             }
         };
     } else {
         var box = {
             xtype:'box',
             html: '<div  style="height:44px"  class=pic_holder><table><tr><td><img src="' + URL_ROOT + 'css/images/' + ftype + '.png "></td><td><a onClick=Fb.showDownload(' + "'" + field.value + "'" + ')  href=#>' + fname + '</a></td></tr></div>',
         };
     }
     return box;
 }

 Fb.getAttachmentEditor = function(cfg) {
     console.log(cfg);
     var xid = Ext.id();
     var fake_id = cfg.name;
     upload_field = [{
         xtype: 'fileuploadfield',
         emptyText: i18n.choose_file_to_upload,
         value: cfg.value,
         fieldLabel: cfg.label,
         id: cfg.name,
         name: cfg.name,
         buttonCfg: {
             iconCls: 'upload-icon'
         },
         width: 200,
         listeners:{
             'fileselected':function(obj,file){
                  console.log(file);
                  var ftype=Fb.getFileType(file);
                  console.log(ftype);
                  if(cfg.file_type)
                   {
                    if(cfg.file_type!==ftype){alert('check file type'); return;}
                   }
                  
                 var form=Ext.getCmp(xid).findParentByType('form');
                 if (form) {
                     console.log('In fileselected,form found');
                     console.log('this.ownerct is');
                     console.log(this.ownerCt);
                     this.ownerCt.field_realupload=true;
                     form.uptasks++;
                     form.realupload = true;
                 }
                 else
                  {
                     console.log('form not find???');
                  }
             }
         }
     }, {
         xtype: 'button',
         cls: 'hidden_upload_btn',
         hidden: true,
         listeners: {
             'click': function(){
                 console.log(this.ownerCt);
                 console.log(this.ownerCt.field_realupload);
                 var form = Ext.getCmp(xid).findParentByType('form');
                 if (!this.ownerCt.field_realupload) {
                     console.log('hidden clicked,and  delete  uptasks');
                     console.log('now taks is'+form.uptasks);
                     form.uptasks--;
                     return;
                 }
                 
                 WaitMask.show('upload');
                 var p = {
                     'formfield': cfg.name,
                     'dest': cfg.dest || 'uploads'
                 };
                 var postcfg = {
                     'params': Ext.encode(p)
                 };
                 if (form.getForm().isValid()){
                     form.getForm().submit({
                         url: AJAX_ROOT + UPLOAD_URL,
                         params:postcfg,
                         failure: function(f, r) {
                             WaitMask.hide();
                             Fb.showUploadResult(r,postcfg);
                             console.log('failed,and delte  uptasks');
                             form.uptasks--;
                             form.upload_errcount++;
                         },
                         success:function(f,r) {
                             WaitMask.hide();
                             if (r.result.success){
                                 var fd = form.getForm().findField(cfg.name);
                                 fd.setValue(r.result.serverURL);
                                 console.log('succeed,and delte  uptasks');
                                 form.uptasks--;
                                 Act.prototype.FormAction(form);
                             }
                             Fb.showUploadResult(r);
                         }
                     });
                 } 
             }
         }
     }];
     var compo = {
         xtype: 'compositefield',
         anchor: '100%',
         fake_id: fake_id,
         id: xid,
         fieldLabel: cfg.label,
         items: [upload_field]
     };
     var box = Fb.geFileWrapper(cfg);
     return [compo, box];
 }

 Fb.showUploadResult=function(r,cfg)
 {
   if(r.result.show_client_upload_info)
        {
        Ext.Msg.alert(i18n.message, r.result.msg);
        }
 }
 

 Fb.setFollowFieldValue = function(e, record, oneFieldCfg) {
     if (!oneFieldCfg['editor_cfg']) return;
     for (var i = 0; i < oneFieldCfg['editor_cfg']['follow_cfg'].length; i++) {
         var f = oneFieldCfg['editor_cfg']['follow_cfg'][i]['base_table_follow_field'];
         var ref_f = oneFieldCfg['editor_cfg']['follow_cfg'][i]['combo_table_follow_field'];
         var v = record.json[ref_f];
         var f2set = this.findParentByType('form').findById(f);
         if (f2set){
             var orginal_v= f2set.getValue();
            // if(!Ext.isEmpty(orginal_v)){return;}
             f2set.addClass('x-form-linked');
             f2set.setValue(v);
             f2set.el.applyStyles({
                 top: 200,
                 left: 400,
                 color: '#000040',
                 backgroundColor:'#8080FF'
             }).frame("#000040", 1, {
                 duration1: 0.3
             });

         }
     }
 }

 Fb.getDetailBtn = function(combo_table) {
     console.log(combo_table);
     var btn_detail = new Ext.Button({
         text: i18n.detail_with_dot,
         handler: function() {
             var combox = this.ownerCt.items.items[0];
             if (!combox.getValue()) {
                 return;
             }
             new Act({
                 code: 'NANX_TBL_DATA',
                 table: combo_table,
                 filter_field: combox.valueField,
                 filter_value: combox.getValue(),
                 nobtn: true,
                 win_size_height:150,
                 wintitle: i18n.detail + ':' + combox.getRawValue(),
                 showwhere: 'autowin',
                 transfer: true
             });
         }
     });
     return btn_detail;
 }



 Fb.getDirectComboEditor = function(jsonarray) {
     return {
         xtype: 'combo',
         store: new Ext.data.JsonStore({
             fields: ['code', 'value'],
             data: jsonarray
         }),
         displayField: 'value',
         editable: false,
         valueField: 'code',
         mode: 'local',
         typeAhead: true,
         triggerAction: 'all',
         lazyRender: true
     };
 }

 
  Fb.getHtmlEditor = function(id, label, value) {
     var htmlEditor = {
         xtype: "StarHtmleditor",
         fieldLabel: label,
         id: id,
         value: value,
         width: 680
     };
     return htmlEditor;
 }


 Fb.getDateEditor = function(oneFieldCfg,   readonly_flag) {
     var dateEditor = {
         fieldLabel: oneFieldCfg['display_cfg'].field_c,
         id: oneFieldCfg['field_e'],
         width: 200,
         height: 25,
         value:oneFieldCfg.editor_cfg.default_v,
         xtype: 'datefield',
         format: 'Y-m-d',
         readOnly: readonly_flag,
         blankText: i18n.not_allow_blank
     }
     return dateEditor;
 }

 Fb.getTimeEditor = function(oneFieldCfg,  readonly_flag) {
     var timeEditor = {
         fieldLabel: oneFieldCfg['display_cfg'].field_c,
         id: oneFieldCfg['field_e'],
         width: 200,
         height: 25,
         value:oneFieldCfg.editor_cfg.default_v,
         xtype: 'timepickerfield',
         readOnly: readonly_flag,
         blankText: i18n.not_allow_blank
     }
     return timeEditor;
 }

 Fb.getDatetimeEditor = function(oneFieldCfg,readonly_flag) {
     var dateTimeEditor = {
         fieldLabel: oneFieldCfg['display_cfg'].field_c,
         id: oneFieldCfg['field_e'],
         width: 200,
         height: 25,
         value:oneFieldCfg.editor_cfg.default_v,
         xtype: 'datetimefield',
         readOnly: readonly_flag,
         blankText: i18n.not_allow_blank
     }
     return dateTimeEditor;
 }

 Fb.getTextAreaEditor = function(oneFieldCfg, readonly_flag) {
     textAreaEditor = {
         fieldLabel: oneFieldCfg['display_cfg'].field_c,
         id: oneFieldCfg['field_e'],
         width: 660,
         height: 60,
         value:oneFieldCfg.editor_cfg.default_v,
         xtype: 'textarea',
         readOnly: readonly_flag,
         blankText: i18n.not_allow_blank
     }
     return textAreaEditor;
 }



 


 Fb.getTriggerBar12 = function(main_table) {
     var follow_add = new Ext.Button({
         text: i18n.add,
         handler: function() {
             var tfm = this.findParentByType('form');
             var root_combo = Ext.getCmp('combo_table');
             var ref_tab = root_combo.getValue();
             if (!Ext.isEmpty(ref_tab)) {
                 var newline = Fb.triggerRow12({
                     'serial': Ext.id(),
                     'base_table': main_table,
                     'refer_table': ref_tab
                 });

                 this.ownerCt.ownerCt.insert(12, newline);
                 this.ownerCt.ownerCt.doLayout();
             }
         }
     })
     var lb1 = new Ext.Container({
         'html': '&nbsp;&nbsp;' + i18n.base_table_col
     });
     var lb2 = new Ext.Container({
         'html': '<span style="margin-left:140px;">=' + i18n.reference_table_col + '</span>'
     });
     var f = new Ext.Container({
         'fieldLabel': i18n.follow_col,
         'layout': 'table',
         items: [follow_add, lb1, lb2]
     });
     return f;
 }
 
 Fb.addTriggerRow12_from_response = function(follow_cfg) {
     var current_form = Ext.getCmp('back_opform');
     for (var n = 0; n < follow_cfg.length; n++) {
         var field_2 = Fb.triggerRow12({
             serial:Ext.id(),
             base_table: follow_cfg[n].base_table,
             refer_table: follow_cfg[n].combo_table,
             left_ini: follow_cfg[n]['base_table_follow_field'],
             right_ini: follow_cfg[n]['combo_table_follow_field']
         });
         current_form.insert(11 + n, field_2);
     }
     current_form.doLayout();
 }
 
  Fb.triggerRow12 = function(cfg) {
     var left_tree_cfg = {
         item_type: 'combo_list',
         id: 'base_field' + Ext.id(),
         value: cfg.base_table,
         ini: cfg.left_ini,
         nanx_type:'root',
         level:1,
         displayField: 'text',
         valueField:'value',
         category_to_use: 'biz_cols'
     }

     var ds_l = Fb.buildTreeStore(left_tree_cfg);
     var xxx_combo = Fb.getBasicCombo(left_tree_cfg, ds_l);

     var right_tree_cfg = {
         item_type: 'combo_list',
         id: 'refer_field' + Ext.id(),
         nanx_type:'slave',
         level: 2,
         group_id:'follow_gp',
         value: cfg.refer_table,
         displayField: 'text',
         valueField: 'value',
         ini: cfg.right_ini,
         category_to_use: 'biz_cols'
     }

     var ds_r = Fb.buildTreeStore(right_tree_cfg);
     var yyy_combo = Fb.getBasicCombo(right_tree_cfg, ds_r);


     var btn_del = new Ext.Button({
         text: i18n.remove,
         handler: function() {
             this.ownerCt.ownerCt.remove(this.ownerCt);
         }
     });

     var equ = new Ext.BoxComponent({
         autoEl: {
             tag: 'div',
             html: '&nbsp;=&nbsp;'
         }
     });

     var field_link = new Ext.Container({
         'id': 'followRow' + cfg.serial,
         'layout': 'table',
         'nanx_type': 'follow_row',
         'style': '{margin-left:104px;}',
         items: [btn_del, xxx_combo, equ, yyy_combo]
     });
     return field_link;
 } 

 
 Fb.getTriggerBar12345 = function(main_table) {
     var dropdown_item_add = new Ext.Button({
         text:i18n.add_trigger,
         id:'trigger_bar_button',
         handler: function() {
             {
                 var form = this.findParentByType('form');
                 var trigger_rows =form.find('nanx_type','trigger_row');
                 var newline = Fb.triggerRow12345({
                     'serial': trigger_rows.length+1,
                     'base_table': main_table
                 });
                 this.ownerCt.ownerCt.insert(12,newline);
                 this.ownerCt.ownerCt.doLayout();
             }
         }
     })
    
     var headers=['base_table_col','trigger_table','trigger_table_list','trigger_table_value','trigger_table_filter'];
     var head_tb="<table><tr>";
     for(var i=0;i<headers.length;i++)
     {
      head_tb+='<td width=140px>'+i18n[headers[i]]+'</td>';
     }
     head_tb+="</tr></table>";
     var tb_c=new Ext.Container({html:head_tb});
     var f = new Ext.Container({
         fieldLabel:i18n.group_item,
         layout:'table',
      items:[dropdown_item_add,tb_c]
     });
     return f;
 }
 
 Fb.triggerRow12345 = function(cfg,meta5){
     console.log(cfg);
     var hostcfg = {
         item_type: 'combo_list',
         id: 'field_e_' + cfg.serial,
         value: cfg.base_table,
         width:140,
         displayField: 'text',
         valueField: 'value',
         category_to_use: 'biz_cols'
     }
     if(meta5&&meta5.field_e)hostcfg.ini=meta5.field_e;
     
     var store = Fb.buildTreeStore(hostcfg);
     var host_combo = Fb.getBasicCombo(hostcfg, store);
     group_id = 'TR_' + cfg.serial;
     var combo_cfg = {
         item_type: 'combo_group',
         root_combox: {
             id: 'combo_table_' + cfg.serial,
             ds_auto: true,
             group_id: group_id,
             level: 1,
             width:140,
             nanx_type: 'root',
             value_key_for_slave: 'value',
             category_to_use: 'biz_tables' 
         },
         slave_comboxes: [{
             id: 'list_field_' + cfg.serial,
             ds_auto: false,
             level: 2,
             width:140,
             group_id: group_id,
             nanx_type: 'slave',
             category_to_use: 'biz_cols'
         }, {
             id: 'value_field_' + cfg.serial,
             ds_auto: false,
             group_id: group_id,
             level: 2,
             width:140,
             nanx_type: 'slave',
             category_to_use: 'biz_cols'
         }
         ]
     };
     
     if(meta5&&meta5.combo_table)combo_cfg.root_combox.ini=meta5.combo_table;
     if(meta5&&meta5.list_field)combo_cfg.slave_comboxes[0].ini=meta5.list_field;
     if(meta5&&meta5.value_field)combo_cfg.slave_comboxes[1].ini=meta5.value_field;
     
     
     if(cfg.serial>1){
     combo_cfg.slave_comboxes.push(
     {
             id: 'filter_field_' + cfg.serial,
             ds_auto: false,
             group_id: group_id,
             level: 2,
             width:140,
             nanx_type: 'slave',
             category_to_use: 'biz_cols'
         });
     }
     if(meta5&&meta5.filter_field)combo_cfg.slave_comboxes[2].ini=meta5.filter_field;
         
         
     var root_slave = Fb.getComboGroup(combo_cfg);
     var btn_del = new Ext.Button({
         text: i18n.remove,
         id:Ext.id(),
         serial:cfg.serial,
         handler: function(){
             var form = this.findParentByType('form');
             var tr =form.find('nanx_type','trigger_row');
             if(this.serial==tr.length)
                 {
                   this.ownerCt.ownerCt.remove(this.ownerCt);
                 }
         }
     });

     var field_link = new Ext.Container({
         'id': 'followRow_'+Ext.id(),
         'layout':'table',
         'nanx_type':'trigger_row',
         'style':'{margin-left:105px;}',
         items:[btn_del,host_combo,root_slave]
     });
     return field_link;
 }
 
 Fb.addTriggerRow12345_from_response=function(triggers)
 {
    for(var i=0;i<triggers.length;i++)
    {
     var meta=triggers[i];
     var cfg={base_table:meta.base_table,serial:meta.level};
     var trigger_row=Fb.triggerRow12345(cfg,meta);
     var btn=Ext.getCmp('trigger_bar_button');
     var tfm = btn.findParentByType('form');
     tfm.insert(12,trigger_row);
     tfm.doLayout();
    }
 }
  
 
 Fb.dndgrid = function(grid_cfg) {
     var col_need = [];
     var fields = [];
     var col_model = [];
     for (var i = 0; i < grid_cfg.fields.length; i++) {
         var single_col = {};
         single_col.name = grid_cfg.fields[i].column;
         single_col.dataIndex = grid_cfg.fields[i].column;
         single_col.header = grid_cfg.fields[i].column_title;
         single_col.width = 150;
         col_need.push(single_col);
         fields.push(grid_cfg.fields[i].column);
     }

     var need = Ext.data.Record.create(col_need);
     var category_params = grid_cfg;
     var ds_cfg = {
         reader: new Ext.data.ArrayReader(need),
         baseParams: grid_cfg,
         proxy: new Ext.data.HttpProxy({
             url: TREE_URL,
             method: 'POST'
         }),
         root: 'server_resp',
         fields: fields
     };

     var cm = new Ext.grid.ColumnModel(col_need);
     var ds = new Ext.data.JsonStore(ds_cfg);
     ds.load();


     var singleCol = new Ext.grid.GridPanel({
         'title': grid_cfg.gridlabel,
         id: grid_cfg.grid_ext_id,
         height: 360,
         width: grid_cfg.grid_width,
         store: ds,
         border: true,
         cm: cm,
         columnLines: true,
         ddGroup: "NANX_gridDD",
         enableDragDrop: true,
         autoScroll: true,
         sm: new Ext.grid.RowSelectionModel({
             singleSelect: true
         })
     });
     singleCol.addListener('render', Fb.dnd_mgr.createDelegate(this, [grid_cfg.self_dnd], true));
     return {
         items: [singleCol]
     };
 };

 Fb.dnd_mgr = function(grid, self_dnd) {
     if (!self_dnd) {
         return;
     }
     var c = new Ext.dd.DropTarget(grid.container, {
         ddGroup: "NANX_gridDD",
         copy: false,
         notifyDrop: function(DragSource, event, DragData) {
             var ds = grid.store;
             var selModel = grid.getSelectionModel();
             var selected_rows = selModel.getSelections();
             if (DragSource.getDragData(event)) {
                 var row_index = DragSource.getDragData(event).rowIndex;
                 if (typeof(row_index) != "undefined") {
                     for (i = 0; i < selected_rows.length; i++) {
                         ds.remove(ds.getById(selected_rows[i].id))
                     }
                     ds.insert(row_index, DragData.selections);
                     selModel.clearSelections();
                 }
             }
         }
     });
 };

 Fb.split2col = function(pleft, pright, cfg, directData) {
     if (directData) {
         var ds_left = pleft;
         var ds_right = pright;
     } else {
         var ds_cfg_left = {
             autoLoad: true,
             proxy: new Ext.data.HttpProxy({
                 url: TREE_URL
             }),
             root: 'server_resp_left',
             fields: ['value', 'text'],
             baseParams: pleft
         };
         var ds_cfg_right = {};
         Ext.apply(ds_cfg_right, ds_cfg_left);
         ds_cfg_right.root = 'server_resp_right';
         var ds_left = (pleft == null) ? new Ext.data.ArrayStore() : new Ext.data.JsonStore(ds_cfg_left);
         var ds_right = (pright.data == false) ? new Ext.data.ArrayStore() : new Ext.data.JsonStore(ds_cfg_right);
     }
     var multiselector = {
         items: [{
             html: '<br/>' + cfg.label + ':'
         }, {
             bodyStyle: "margin-top:10px;",
             xtype: "itemselector",
             name: cfg.id,
             id: cfg.id,
             right_forced_one: pright.right_forced_one,
             imagePath: "../../jslib/ext/ux/images/",
             border: false,
             multiselects: [{
                 id: 'leftList',
                 width: 225,
                 height: 300,
                 displayField: "text",
                 valueField: "value",
                 store: ds_left
             }, {
                 id: 'rightList',
                 width: 225,
                 height: 300,
                 displayField: "text",
                 valueField: "value",
                 store: ds_right
             }],
             listeners: {
                 change: function() {
                     if (!this.right_forced_one) {
                         return;
                     }
                     ds_right.suspendEvents();
                     var items = ds_right.data.items;
                     if (items.length > 0) {
                         var REC_LAST = items.pop();
                         ds_right.removeAll();
                         ds_right.add(REC_LAST);
                         ds_left.add(items);
                         var r = Ext.getCmp('rightList');
                         r.view.refresh();
                         this.hiddenField.dom.value = REC_LAST.data.value;
                     }
                     ds_right.resumeEvents();
                 }
             }
         }]
     };
     return multiselector;
 };

 Fb.findSlaves = function(form, gpid, level, direct) {
     if(!form){return []}
     var found = [];
     var slaves = form.find('group_id', gpid);
     for (i = 0; i < slaves.length; i++) {
         if (arguments.length == 4) {
             if (slaves[i].level - 1 == level) {
                 found.push(slaves[i]);
             }
         } else {
             if (slaves[i].level > level) {
                 found.push(slaves[i]);
             }
         }
     }
     return found;
 }

 Fb.getCurrentValue=function(id)
 {
 }

 Fb.getBasicCombo = function(cfg, store,_readOnly) {
 
   console.log(cfg);
   if ( _readOnly== undefined) {  
         _readOnly=false;  
    }  
     var combox_cfg = {
         id: cfg.id,
         triggerAction: 'all',
         displayField: cfg.displayField,
         valueField: cfg.valueField,
         emptyText: i18n.combo_choose,
         fieldLabel: cfg.label,
         forceSelection: true,
         editable: false,
         readOnly:_readOnly,
         name: cfg.id,
         width:cfg.width?cfg.width:200,
         allowBlank: cfg.hasOwnProperty('allowBlank') ? cfg.allowBlank : true,
         style: cfg.style ? cfg.style : null,
         group_id: cfg.group_id ? cfg.group_id : 'RS_' + Ext.id(),
         nanx_type: cfg.nanx_type,
         level: cfg.level,
         border: false,
         editable: false,
         mode: 'local',
         store: store
     };

     var combo = new Ext.form.ComboBox(combox_cfg);

     store.on('load', function() {
         var p = Ext.getCmp(cfg.id);
         if (cfg.ini) {
             p.setValue(cfg.ini);
             cfg.ini = null;
         } else {
             p.setValue(p.getValue());
         }

         var tfm = Ext.getCmp(cfg.id).findParentByType('form');
         var tmp_v = combo.getValue();
         if (Ext.isEmpty(tmp_v)) {
             return;
         }
         var current_rec = combo.findRecord(combo.valueField || combo.displayField, tmp_v);
         if(!current_rec){return}
         var current_v = current_rec.json[cfg.value_key_for_slave] || combo.getValue();

         var x_group_id = cfg.group_id;
         var level = cfg.level;
         var direct_slaves = Fb.findSlaves(tfm, x_group_id, level, true);
         for (var i = 0; i < direct_slaves.length; i++) {
             var ds = direct_slaves[i].getStore();
             Fb.setStorePara(ds, 'value', current_v)
             Fb.setStorePara(ds, 'filter_value', current_v)
             direct_slaves[i].getStore().load();
         }
     });

     combo.on("select", function(c, record) {
         Fb.setFollowFieldValue.createDelegate(this, [c, record, cfg], true)();
         var fm = c.findParentByType('form');
         var tmp_v = c.getValue();
         if (Ext.isEmpty(tmp_v)) {
             return;
         }
         var current_rec = c.findRecord(c.valueField || c.displayField, tmp_v);
         var v = current_rec.json[cfg.value_key_for_slave];
         if (Ext.isEmpty(v)) {
             v = tmp_v;
         }


         
         var x_group_id = cfg.group_id;
         var level = cfg.level;
         var all_slaves = Fb.findSlaves(fm, x_group_id, level);
         var direct_slaves = Fb.findSlaves(fm, x_group_id, level, true);

         for (var i = 0; i < all_slaves.length; i++) {
             all_slaves[i].getStore().clearData();
             all_slaves[i].clearValue();
         }

         for (var i = 0; i < direct_slaves.length; i++) {
             var ds = direct_slaves[i].getStore();
             Fb.setStorePara(ds, 'filter_value', v)
             ds.reload();
         }
     });
     
     combo.on("render", function(c, record){
      c.el.applyStyles({
     //           background : 'none #E6E6E6'
             })
     }) 

     if (cfg.detail_btn) {
         console.log(cfg);
         var table = cfg.editor_cfg.trigger_cfg.combo_table;
         var btn_detail = Fb.getDetailBtn(table);
         var combowithdetail = new Ext.Container({
             fieldLabel: cfg['display_cfg'].field_c,
             layout: 'table',
             nanx_type: 'combo_with_detail',
             width: 280,
             items: [combo, btn_detail]
         });
         return combowithdetail;
     } else {
         return combo;
     }
 };


 Fb.setStorePara = function(store, key, value) {
    console.log(value);

     if (store.proxy.conn.jsonData) {
         store.proxy.conn.jsonData.filter_value = value;
     } else {
         store.baseParams.value = value;
     }
 }

 Fb.buildTreeStore = function(treecfg) {
     console.log(treecfg);
     
     baseParaObj = {};
     baseParaObj.category_to_use = treecfg.category_to_use;
     baseParaObj.value = treecfg.value;
     var id = treecfg.id ? treecfg.id : Ext.id();
     var ds_auto = treecfg.hasOwnProperty('ds_auto') ? treecfg['ds_auto'] : true;
     var store = new Ext.data.JsonStore({
         proxy: new Ext.data.HttpProxy({
             url: TREE_URL,
             method: 'POST'
         }),
         storeId: 'store_' + id,
         autoLoad: ds_auto,
         displayField: 'text',
         valueField: 'value',
         fields: ['value', 'text'],
         baseParams: baseParaObj,
         root: 'server_resp'
     });
     return store;
 }

 
 Fb.getInheritEditor = function(oneFieldCfg, rowOriginalValue, readonly_flag) {
     readonly_flag = true;
     inheritEditor = {
         fieldLabel: oneFieldCfg['display_cfg'].field_c,
         id: oneFieldCfg['field_e'],
         width: 200,
         height: 25,
         value: rowOriginalValue,
         readOnly: true,
         blankText: not_allow_blank
     }
     return inheritEditor;
 }

 Fb.getFieldWidth = function(cfg) {
     var f_width = 200;
     if (cfg.display_cfg.field_width == null) {
         f_width = 200;
     } else {
         f_width = cfg.display_cfg.field_width;
     }
     return f_width * 1.0;
 }

 Fb.getDefaultEditor = function(oneFieldCfg,readonly_flag) {
     var f_width = Fb.getFieldWidth(oneFieldCfg);
     var defaultEditor = {
         fieldLabel: oneFieldCfg['display_cfg'].field_c,
         id: oneFieldCfg['field_e'],
         width: f_width,
         height: 25,
         value:oneFieldCfg.editor_cfg.default_v,
         readOnly: readonly_flag,
         xtype: 'textfield',
         blankText: i18n.not_allow_blank
     }
     return defaultEditor;
 }

 Fb.getTriggerWhoIsWho=function  (one_col_cfg,whoami_cfg)
 {

    var trigger_cfg=one_col_cfg.editor_cfg.trigger_cfg;
    var trigger_table=trigger_cfg.combo_table;
    var level=trigger_cfg.level;
    var who_is_who=whoami_cfg.who_is_who;
    var login_user=whoami_cfg.whoami;
    var connected_value=null;   
    for (var i = 0; i < who_is_who.length; i++) {
        if(who_is_who[i].inner_table==trigger_table  &&  who_is_who[i].user==login_user )
        {
        connected_value=who_is_who[i].inner_table_value;
        break;
        }
    };
    return connected_value;
 }


   Fb.getTriggerEditor = function(  one_col_cfg, row,readonly_flag,whoami_cfg) {
     
     var connected_value=  this.getTriggerWhoIsWho(one_col_cfg,whoami_cfg);
     if (connected_value){readonly_flag=true;} 
     ghost_field = 'ghost_' + one_col_cfg['field_e'];
     if (row) {   // edit mode
         one_col_cfg.ini = row.json[ghost_field];
     }
     else
     {    //add mode
        if(connected_value){
            one_col_cfg.ini=connected_value;
       }else
       {
            one_col_cfg.ini=one_col_cfg.editor_cfg.default_v;
       }
     }
       
     var fields = [one_col_cfg.editor_cfg.trigger_cfg.list_field, one_col_cfg.editor_cfg.trigger_cfg.value_field];
     var table = one_col_cfg.editor_cfg.trigger_cfg.combo_table;
     var filter_cfg = {
         filter_field: one_col_cfg.editor_cfg.trigger_cfg.filter_field
     };
     var combo_store = Act.prototype.getStoreByTableAndField(table, fields, filter_cfg);
     one_col_cfg.id = one_col_cfg.field_e;
     one_col_cfg.valueField = one_col_cfg.editor_cfg.trigger_cfg.value_field;
     one_col_cfg.displayField = one_col_cfg.editor_cfg.trigger_cfg.list_field;
     one_col_cfg.level = one_col_cfg.editor_cfg.trigger_cfg.level;

     if (one_col_cfg.editor_cfg.trigger_cfg.level == 1) {
         one_col_cfg.nanx_type = 'root';
     } else {
         one_col_cfg.nanx_type = 'slave';
     }
     one_col_cfg.group_id = one_col_cfg.editor_cfg.trigger_cfg.group_id;
     one_col_cfg.detail_btn = true;
     return this.getBasicCombo(one_col_cfg, combo_store,readonly_flag);
 }

Fb.getWhoami=function()
{
      var whoami = document.getElementById('whoami');
     if (!whoami) {
         whoami = 'admin';
     } else {
         whoami = whoami.innerHTML;
     }

//   var inner_table_column = document.getElementById('inner_table_column').innerHTML;
//   var inner_table_value= document.getElementById('inner_table_value').innerHTML;
  return whoami;
  //return inner_table_value;
}

  Fb.determineOriginalValue = function(op_type, editCfg, row) {
    
     var rowOriginalValue = null;
     if (op_type == 'update') {
         rowOriginalValue = row.get(editCfg['field_e']);
     }
     if ((op_type == 'add') && (editCfg.editor_cfg.default_v)) {
         rowOriginalValue = editCfg.editor_cfg.default_v;
         var d = new Date();
         if ((editCfg.editor_cfg.default_v == 'date') || (editCfg.editor_cfg.default_v == 'datetime')) {
             rowOriginalValue = new Date();
         }
     }
      
 


     if (editCfg.editor_cfg.is_produce_col == 1) {
         whoami=this.getWhoami();
         if (op_type == 'add') {
//              alert('set to whoami'+whoami);
             rowOriginalValue = whoami;
           
         }
         
         if (op_type == 'update') {
             rowOriginalValue = row.get(editCfg['field_e']);
             if (!rowOriginalValue.length > 0) {
                 rowOriginalValue = whoami;
             }
         }

         if (op_type == 'batchUpdate') {
             rowOriginalValue = whoami;
             
         }
     }
   editCfg.editor_cfg.default_v=rowOriginalValue;
 }


  Fb.getFieldEditor = function(op_type, one_col_cfg, row,whoami_cfg) {
   
     this.determineOriginalValue(op_type, one_col_cfg, row);
     var readonly_flag = false;
     var skip_flag = false;
     if (one_col_cfg['field_e']=='pid'){
         readonly_flag = true;
     }

     if (one_col_cfg.editor_cfg.is_produce_col == 1){ readonly_flag = true;} 
     if ((one_col_cfg['field_e'] == 'pid') && (op_type == 'add')) {skip_flag = true;}
     if (skip_flag){return null;}
     
     if ((one_col_cfg['field_e'] == this.gridFilter) && (op_type == 'add')) {
         
         return [this.getInheritEditor(one_col_cfg, this.filterValue, true)];
     }
    
      
     if (!Ext.isEmpty(one_col_cfg.editor_cfg.trigger_cfg)) {
         return [Fb.getTriggerEditor(  one_col_cfg, row, readonly_flag,whoami_cfg )];
     } 
     

     if (one_col_cfg.editor_cfg.need_upload == 1) {
         var cfg = {
             label: one_col_cfg.display_cfg.field_c,
             name: one_col_cfg['field_e'],
             value: one_col_cfg.editor_cfg.default_v
         };
         return [this.getAttachmentEditor(cfg)];
     }

     if (one_col_cfg.editor_cfg.edit_as_html == 1) {
         return [this.getHtmlEditor(one_col_cfg['field_e'], one_col_cfg['display_cfg'].field_c)];
     }

     if (one_col_cfg.editor_cfg.datetime == 'datetime') {
         return [this.getDatetimeEditor(one_col_cfg, readonly_flag)];
     }

     if (one_col_cfg.editor_cfg.datetime == 'date') {
         return [this.getDateEditor(one_col_cfg,  readonly_flag)];
     }

     if (one_col_cfg.editor_cfg.datetime == 'time') {
         return [this.getTimeEditor(one_col_cfg, readonly_flag)];
     }

     if (one_col_cfg['edit_type'] == 'textarea') {
         return [this.getTextAreaEditor(one_col_cfg,readonly_flag)];
     }

     if ((one_col_cfg['edit_type'] == null) || (one_col_cfg['edit_type'] == '')) {
         return [this.getDefaultEditor(one_col_cfg, readonly_flag)];
     }

 }

 Fb.primaryKeyColumn = function(c) {
     return new Ext.ux.grid.CheckColumn({
         header: c,
         dataIndex: "primary_key"
     });
 }


 Fb.notNullColumn = function(c) {
     return new Ext.ux.grid.CheckColumn({
         header: c,
         dataIndex: "not_null"
     });
 }

 Fb.unsignedColumn = function(c) {
     return new Ext.ux.grid.CheckColumn({
         header: c,
         dataIndex: "unsigned"
     });
 }

 Fb.autoIncrColumn = function(c) {
     return new Ext.ux.grid.CheckColumn({
         header: c,
         dataIndex: "auto_increment"
     });
 }

 Fb.zerofillColumn = function(c) {
     return new Ext.ux.grid.CheckColumn({
         header: c,
         dataIndex: "zerofill"
     });
 }

 Fb.getFormData = function(form) {

     if (!form.getForm().isValid()  &&  !Ext.getCmp('force_not_check')   ) {
         Ext.Msg.alert(i18n.error, i18n.check_input);
         return false;
     }

     var fmdata = {};
     var formel = form.getEl();
     var ipts = formel.query('input');
     for (var i = 0; i < ipts.length; i++) {
         var field_id = ipts[i].getAttribute("id");
         if (Ext.getCmp(field_id)) {
             var field = Ext.getCmp(field_id);
             var field_type = field.getXType();
             var field_value = field.getValue();
             if ((field_type == 'datefield') || (field_type == 'datetimefield')) {
                 var testdate = new Date(field_value);
                 if (isNaN(testdate.valueOf())) {
                     field_value = null;
                 }
             }
             fmdata[field_id] = field_value;
         }
     }
     var xtypes = form.findByType("timepickerfield");
     for (var i = 0; i < xtypes.length; i++) {
         fmdata[xtypes[i].id] = xtypes[i].getValue();
     }
     var fm_tmp_v = form.getForm().getValues();
     Ext.applyIf(fmdata, form.getForm().getValues());
     for (var p in fmdata) {
         if ((p.substring(0, 7) == 'ext-gen') || (p.substring(0, 8) == 'ext-comp')) {
             delete fmdata[p];
         };
     }

     if (fmdata.opcode && fmdata.opcode.indexOf('set_biz_field_combo_follow') >= 0) {
         fmdata['nanx_follow_cfg'] = Fb.getFollowCfg(form);
     }
  
     if (fmdata.opcode && fmdata.opcode.indexOf('add_trigger_group') >= 0){
         var trigger_rows =form.find('nanx_type','trigger_row');
         fmdata['trigger_counts'] = trigger_rows.length;
     }
    
     var extradata = getGridExtraData();
    
     console.log(extradata);


     //mustHaveOneRow


     if (extradata){
       if (extradata.mustHaveOneRow && 0==extradata.row_count)
         {
          alert(i18n.choose_only_one_record);
          return; 
         }
       }
        



     


     if (extradata){
         fmdata.extradata = extradata;
     }
     
     if (fmdata.hasOwnProperty('transfer')){
         if (fmdata.transfer == 'false'){
             fmdata.transfer = false;
         }
         if (fmdata.transfer == 'true'){
             fmdata.transfer = true;
         }
     }
     return fmdata;
 }

  

 Fb.getComboGroup = function(item) {
     var f = [];
     var root_cfg = item.root_combox;
     root_cfg.nanx_type = 'root';
     if (!root_cfg.group_id) {
         var x_group_id = Ext.id();
         root_cfg.group_id = x_group_id;
     }
     root_cfg.displayField = 'text';
     root_cfg.valueField = 'value';
     var ds_root = Fb.buildTreeStore(root_cfg);
     var f_root = Fb.getBasicCombo(root_cfg, ds_root);
     f.push(f_root);

     for (var k = 0; k < item.slave_comboxes.length; k++) {
         var slave_cfg = item.slave_comboxes[k];
         slave_cfg.group_id = slave_cfg.group_id ? slave_cfg.group_id : x_group_id;
         slave_cfg.nanx_type = 'slave';
         slave_cfg.displayField = 'text';
         slave_cfg.valueField = 'value';
         var ds_slave = Fb.buildTreeStore(slave_cfg);
         var f_slave = Fb.getBasicCombo(slave_cfg, ds_slave);
         f.push(f_slave);
     }
     return f;
 }

 Fb.getFollowCfg = function(form) {
     var follow_rows = form.find('nanx_type', 'follow_row');
     var l_r_group = [];
     for (var i = 0; i < follow_rows.length; i++) {
         var l_r = follow_rows[i].findByType(['combo']);
         l_r_group.push({
             'base_table_follow_field': l_r[0].value,
             'combo_table_follow_field': l_r[1].value
         });
     }
     return l_r_group;
 }

 Fb.showDownload = function(fname) {
     var xwin = new Ext.Window({
         constrain: true,
         modal: true,
         height: 180,
         title: i18n.excel_download,
         html: '<br/><div style="margin:20px;">' + i18n.clk_to_download + '<br/><br/><a href=' + fname + '>' + fname + '</a></div>'
     });
     xwin.show();
 }

 Fb.ajaxPostData = function(url, para, succ) {
     WaitMask.show();
     var json = Ext.encode(para);
     var that = this;
     Ext.Ajax.request({
         url: url,
         jsonData: json,
         method: 'POST',
         success: function(response, opts) {
             WaitMask.hide();
             var ret = Ext.util.JSON.decode(response.responseText);
             if (ret.success) {
                 if (ret.file_operation) {
                     return;
                 }
                 
                 if (ret.showdownload) {
                     Fb.showDownload(ret.fname);
                     return;
                 }
                 if (ret.msg.length > 0) {
                     Ext.Msg.alert(i18n.msg, ret.msg);
                 }
                 if (succ) {
                     succ(ret);
                 }
             } else {
                 if(ret.errmsg){Ext.Msg.alert(i18n.error, ret.errmsg);}else{Ext.Msg.alert(i18n.error, ret.msg);}
             }
         },
         failure: function(response, opts) {
             WaitMask.hide();
             Ext.Msg.alert(i18n.msg, response.responseText);
         }
     });
 }

 Fb.setDndForm = function(cfg, node) {
     var pleft = {
         left_category: cfg.left_category,
         right_category: cfg.right_category
     };
     if (cfg.hasOwnProperty('left_filter_value')) {
         pleft.value = node.attributes[[cfg.left_filter_value]]
     }
     var pright = {};
     if (!(cfg.right_value == false)) {
         Ext.apply(pright, pleft);
         pright.category_to_use = cfg.right_category;
         pright.value = node.attributes[[cfg.right_filter_value]];
     } else {
         pright.data = false;
     }
     pright.right_forced_one = (cfg.hasOwnProperty('right_forced_one')) ? true : false;
     var split2col = new Fb.split2col(pleft, pright, cfg, false);
     var f = new Ext.Container({
         items: split2col
     });
     return f;
 };



 Fb.LayoutManager = function(grid) {
     var c = new Ext.dd.DropTarget(grid.getView().scroller.dom, {
         ddGroup: "NANX_gridDD",
         notifyDrop: function(DragSource, event, DragData) {
             var orgStore = DragSource.grid.getStore();
             var records = DragSource.dragData.selections;
             var index = orgStore.find('value', records[0].data.value);
             var xy = event.getXY();
             var landed = getColRange(grid, xy[0], xy[1], event);
             var col_use = landed.col;
             var col_name = 'col_' + col_use;
             var cell = {};
             cell[col_name] = records[0].data.value;
             var Field_rec = new Ext.data.Record(cell);
             if (landed.out) {
                 var new_col_config = {
                     dataIndex: 'col_' + landed.col,
                     header: i18n.col_prefix + landed.col
                 };
                 var cm = grid.getColumnModel();
                 cm.config.push(new_col_config);
                 cm.setConfig(cm.config);
                 grid.doLayout();
             }
             if (landed.new_row) {
                 grid.store.add(Field_rec);

             } else {
                 var current_row = grid.getStore().getRange(landed.row, landed.row);
                 var fieldName = 'col_' + landed.col;
                 var tmpvalue = current_row[0].get('col_' + landed.col);
                 if (!(tmpvalue === undefined)) {
                     var restore_Field = new Ext.data.Record({
                         value: tmpvalue
                     });
                 }
                 current_row[0].set('col_' + landed.col, records[0].data.value);
                 grid.store.commitChanges();
             }
         }
     });
 };

 Fb.RestoreField = function(grid, row, col, event) {
     var cellMenu = new Ext.menu.Menu({
         items: [{
             text: i18n.remove,
             iconCls: "menu_del"
         }],
         listeners: {
             click: function(item) {
                 var current_row = grid.getStore().getRange(row, row);
                 var tmpvalue = current_row[0].get('col_' + col);
                 current_row[0].set('col_' + col, undefined);
                 var x = Ext.getCmp('reorder_columns_grid');
                 var restore_Field = new Ext.data.Record({
                     value: tmpvalue
                 });

                 if (tmpvalue.length > 0) {
                     var index = x.getStore().find('value', tmpvalue);
                     if (index == -1) {
                         x.getStore().add(restore_Field);
                     }
                 }
             }
         }
     });
     event.stopEvent();
     cellMenu.showAt(event.xy);
 };

 Fb.getOperationForm = function(node, mcfg) {
     var layout = 'form';
     var forms = [];
     var needsend = ['pid','group_id', 'table', 'hostby', 'column_definition', 'DDL'];
     var hidden = {
         opcode: mcfg.opcode,
         nodevalue: node.attributes.value
     };
     for (var i = 0; i < needsend.length; i++) {
         var nodekey = needsend[i];
         if (node.attributes.hasOwnProperty(nodekey)) {
             hidden[nodekey] = node.attributes[nodekey];
         }
     }
     for (var property in hidden) {
         var hiddenfield = {
             id: property,
             xtype: 'hidden',
             value: hidden[property]
         };
         forms.push(hiddenfield);
     }

     if (mcfg.place == 'context') {
         var items = mcfg.itemcfg;
         for (var i = 0; i < items.length; i++) {
             if (items[i].hasOwnProperty('layout_panel')) {
                 var layout = 'absolute';
             }
             var f = Fb.getBackendFormItem(items, i, node);
             if (f){
                if (f.isArray){
                 for (var j = 0; j < f.length; j++) {
                     forms.push(f[j]);
                 }
             } else {
                 forms.push(f);
             }
           }
              
         }
     }


     var label_w = 100;
     if (mcfg.label_width) {
         label_w = mcfg.label_width;
     }
     var opform = new Ext.form.FormPanel({
         id: "back_opform",
         frame: true,
         autoScroll: true,
         autoDestroy: true,
         border: false,
         layout: layout,
         height: 400,
         labelWidth: label_w,
         fileUpload: true,
         labelAlign: 'right',
         bodyStyle: "padding-left:10px;",
         defaults: {
             allowBlank: false
         },
         name: "opform",
         items: forms
     });
     
     if( mcfg.callback_set_url)
     {
     opform.on('render',function(){  Fb.CallbackSetFieldValue.createDelegate(this, [mcfg], true)() });
     }
     return opform;
 };

 Fb.CallbackSetFieldValue = function(mcfg) {
     function setSingleField(jsondata, item) {
         if (item.path) {
             var v = jsondata[item.path];
             var compent = Ext.getCmp(item.id);
             if (compent) { compent.Callback_setValue(v) };
            }
         }
         
         Ext.Ajax.request({
             url: AJAX_ROOT + mcfg.callback_set_url,
             jsonData: Ext.encode(mcfg.json),
             callback: function(options, success, response) {
                 var ret_json = Ext.util.JSON.decode(response.responseText);
                 var key_used = mcfg.callback_set_json_key;
                 if (key_used == '/'){
                     var data_from_json = ret_json;
                 } else {
                     var data_from_json = ret_json[key_used];
                 }
                 
                 Ext.each(mcfg.itemcfg, function(item) {

                     switch (item.item_type){
                      case 'combo_group':
                      {
                         setSingleField(data_from_json, item.root_combox);
                         for (var i = 0; i < item.slave_comboxes.length; i++) {
                             setSingleField(data_from_json, item.slave_comboxes[i]);
                         }
                         Ext.getCmp(item.root_combox.id).getStore().reload();
                      }
                      break;
                      
                      case 'follow_tbar':
                             follow_key_used = item.path;
                             Fb.addTriggerRow12_from_response(ret_json[follow_key_used]);
                      break;
                      
                      case 'trigger_bar':
                      follow_key_used = item.path;
                      console.log(ret_json[follow_key_used]); 
                      Fb.addTriggerRow12345_from_response(ret_json[follow_key_used]);
                      break;
                      
                      default:
                         setSingleField(data_from_json, item);
                     }
                 });
             }
         });
 }



 Fb.preProcessNodeAtt = function(cfg, xnode) {
  
    /*
    if (item.hasOwnProperty('sqlparagroup')) {
         var group = item.sqlparagroup;
         var sqlpara = {};
         for (var p_index = 0; p_index < group.length; p_index++) {
             var key = group[p_index]['key'];
             var value_ref = group[p_index]['init'];
             var value = node.attributes[value_ref];
             var new_key = '$' + key;
             sqlpara[new_key] = value;
         }
         field_v = sqlpara;
     }*/
     
     var fixed = Fb.DeepClone(cfg);
     function fix_obj_tag(taged, node) {
         if (taged.substring(0, 2) == '##') {
             var skey = taged.substring(2, taged.length);
             return xnode.parentNode.attributes[skey];
         }
         if (taged.substring(0, 1) == '#') {
             var skey = taged.substring(1, taged.length);
             return xnode.attributes[skey];
         }
         
         if (taged.substring(0,7) == '@random') {
             return   Fb.randomString();
         }
         
         
         return taged;
     }

     if (fixed.value) {
        if((typeof fixed.value)=='number' ){fixed.value=fixed.value;}
        else
          { 
            if(fixed.value===true){fixed.value='true';}
            else{ fixed.value = fix_obj_tag(fixed.value, xnode);}
          }
     
     }
     if (fixed.json) {
         for (var subkey in fixed.json) {
             fixed.json[subkey] = fix_obj_tag(fixed.json[subkey], xnode);
         }
     }
     return fixed;
 }


 Fb.getBackendFormItem = function(items, i, node) {
     var item = Fb.DeepClone(items[i]);
     var item = Fb.preProcessNodeAtt(item, node);
     var readonly = item.readonly ? item.readonly : false;
     var hidden = item.hidden ? item.hidden : false;
     var checked = item.all_checked ? item.all_checked : false;
     var field_v=item.value;

     switch (item.item_type) {
      
         case 'field':
             var f = {
                 fieldLabel:item.label,
                 id: item.id ? item.id : "input_" + i,
                 name: item.id ? item.id : "input_" + i,
                 xtype: 'textfield',
                 allowBlank:false,
                 width: item.width ? item.width : 200,
                 readOnly: readonly,
                 hidden: hidden,
                 validator: item.validate_rule ? function(v) {
                     return Fb[item.validate_rule].apply(null, [v]);
                 } : function(v){
                     if(Ext.isEmpty(v)){return false;}else{return true;}
                   },
                 value:item.postfix ? field_v + item.postfix : field_v
             };
             if(item.inputType){f.inputType=item.inputType;}
             break;



         case 'raw_table':
              var container_id = 'raw_table_' + Ext.id();
              var f = new Ext.Container({
                 layout: 'absolute',
                 height: item.grid_h,
                 autoScroll: true,
                 border:true,
                 width:400,
                 id:container_id,
                 x:105,
                 y:0
             });
               
                new Act({
            edit_type:'edit',
            code:'NANX_TBL_DATA',
            table:item.value,
            transfer:false,
            singleSelect:true,
            grid_id:'raw_table_grid_id',
            showwhere:'container',
            renderto: container_id
                    });
             break;



         case 'StarHtmleditor':
             var html = {
                 fieldLabel: item.label,
                 id: item.id,
                 name: item.id,
                 width:450,
                 height:250,
                 xtype:'StarHtmleditor',
                 readOnly:readonly,
                 value: field_v
             };
             var f = new Ext.Container({
                 items: [{
                         html: item.label + ':<br/>'
                     },
                     html
                 ]
             });
             break;
         case 'dnd_2_col':
             var f = Fb.setDndForm(item, node);
             break;
         case 'checkbox':
             var f = {
                 fieldLabel: item.label,
                 id: item.id,
                 name: item.id,
                 xtype: 'checkbox',
                 checked: true
             };
             break;
         case 'textarea':
             var f = {
                 fieldLabel: item.label,
                 id: item.id,
                 name: item.id,
                 xtype: 'textarea',
                 width: 600,
                 height: item.height ? item.height : 300
             };
             break;
             
         case 'html_container':
             var f = new Ext.Container({
                 items: {
                     html: item.html
                 }
             });
             break;
         
         case 'check_group_static':
             var f = {
                 id: item.id,
                 fieldLabel: item.label,
                 autoHeight: true,
                 items: item.items,
                 defaultType: 'checkbox'
             };
             break;

         case 'check_group':
             var f = {
                 id: item.id,
                 hidden: hidden,
                 hideMode: 'visibility',
                 fieldLabel: item.label,
                 defaultType: 'checkbox',
                 items: []
             };
             var check_store = new Ext.data.JsonStore({
                 proxy: new Ext.data.HttpProxy({
                     url: TREE_URL,
                     method: 'POST'
                 }),
                 fields: ['value', 'text'],
                 baseParams: {
                     category_to_use: item.group_category,
                     value: item.value
                 },
                 root: 'server_resp'
             });
             check_store.load();
             check_store.on('load', function() {
                 for (var i = 0; i < this.getCount(); i++) {
                     var rec = this.getAt(i).json;
                     var newitem = new Ext.form.Checkbox({
                         boxLabel: rec.text,
                         id: rec.value,
                         name: item.id,
                         checked: checked,
                         itemCls: '',
                         labelStyle: 'padding-left:10px;',
                         inputValue: rec.value
                     });
                     var check_items = Ext.getCmp(item.id).items;
                     check_items.add(newitem);
                 }
                 Ext.getCmp(item.id).doLayout();
             });
             break;

         case 'radio_group':
             var rg = [];
             console.log(item);
             for (i = 0; i < item.items.length; i++) {
                 if (item.items[i].hasfollow) {
                     item.items[i].listeners = {
                         afterrender: function() {
                             var rd = Ext.get(this.id);
                             var field = '&nbsp;&nbsp;<input name=' + this.id + '_input style="margin-top:6px;"   class="x-form-text x-form-field">';
                             rd.parent().createChild(field);
                         }
                     }
                 }

                 rg.push(item.items[i]);
             }

             var f = new Ext.form.RadioGroup({
                 reference_group_id:111111222222,
                 fieldLabel: item.label,
                 labelStyle: 'white-space:nowrap;',
                 layout: 'form',
                 style: {
                     'margin-left': '0px',
                     'margin-top': '10px'
                 },
                 columns: 1,
                 items: rg
             });

             break;

         case 'dndgrid':
             item.grid_width = item.width ? item.width : 470;
             item.value = node.attributes[[item.value_reference]];
             var dndgrid = new Fb.dndgrid(item);
             var f = new Ext.Container({
                 items: dndgrid
             });
             break;

         case 'upload':
             var f = Fb.getAttachmentEditor(item);
             break;

         case 'pic_selector':
              var container_id = 'media_grid_' + Ext.id();
              var f = new Ext.Container({
                 layout: 'absolute',
                 height: item.grid_h,
                 autoScroll: true,
                 border:true,
                 id: container_id,
                 x: 0,
                 y: 0
             });
 
             var Act_f= new Act({
                 code: 'NANX_FS_2_TABLE',
                 pid_order:'desc',
                 os_path:'imgs',
                 file_anchor_id:item.file_anchor_id,
                 file_trunk:5,
                 checkbox:false,
                 hideHeaders:true,
                 nosm:true,
                 grid_id: item.grid_ext_id,
                 grid_h:item.grid_h,
                 renderto: container_id,
                 media_type:'img',
                 showwhere: 'container' 
                   });
             
             break;

         case 'combo_list':
         
         
             item.displayField = 'text';
             item.valueField = 'value';
             var store = Fb.buildTreeStore(item);
             console.log(item);
             var f = Fb.getBasicCombo(item, store);
             break;
         
         
         
         case 'combo_group':
             var f = Fb.getComboGroup(item);
             break;

         case 'follow_tbar':
               var f=Fb.getTriggerBar12(node.attributes.hostby);
             break;

         case 'trigger_bar':
             var main_table=node.attributes.hostby;
             var f = Fb.getTriggerBar12345(main_table);
             break;

         case 'layout_panel':
         
             var container_id = 'r_grid_' + Ext.id();
             var f = new Ext.Container({
                 layout: 'absolute',
                 height: 360,
                 autoScroll: true,
                 id: container_id,
                 x: 220,
                 y: 0
             });
 
             var Act_f = new Act({
                 code: "NANX_TB_LAYOUT",
                 activity_type: "sql",
                 edit_type: 'edit',
                 showwhere:"container",
                 grid_id: item.grid_ext_id,
                 renderto: container_id,
                 gridheader: true,
                 checkbox: false,
                 para_json: {
                     '$table': field_v
                 },
                 callback: [{
                     event: 'cellcontextmenu',
                     fn: Fb.RestoreField
                 }, {
                     event: 'render',
                     fn: Fb.LayoutManager
                 }]
             });
             
             break;
         default:
             var f = {};
     }
     return f;
 }


Fb.getCellStr = function(grid, rowIndex, cellIndex) {
         var rec = grid.getStore().getAt(rowIndex);
         var columnName = grid.getColumnModel().getDataIndex(cellIndex);
         var cellValue = rec.get(columnName);
         return cellValue;
     };
     
Fb.getHtmlAttribute = function(str, tag) {
         var reg_str = "<img[^>]+"+tag+'="http:\\\/\\\/([^">]+)';
         var reg_rule=new RegExp(reg_str,'g');
         var results = reg_rule.exec(str);
         var found= results[1];
         if(tag=='src'){found="http://"+found}
         return found;
     };    
     
     
     
 Fb.formBuilder = function(opform, opcode) {
     var help_panel = new Ext.Panel({
         autoLoad: HELP_DIR + opcode,
         height: 400,
         autoScroll: true
     });

     var form2items = new Ext.Panel({
         border: false,
         layout: "accordion",
         layoutConfig: {
             animate: true
         },
         items: [{
             title: i18n.operation,
             items: opform
         }, {
             title: i18n.operation_help,
             items: help_panel
         }],
         opform: opform
     });
     return form2items;
 };

 Fb.UserActivity = {
     setKeys: function(kv) {
         for (var i = 0; i < kv.length; i++) {
             var c = kv[i];
             Fb.UserActivity.keys[c.key] = c.value;
         }
     },
     getValue: function(a) {
         return Fb.UserActivity.keys[a];
     },
     keys: {}
 };

  
 
 
  Fb.check_table_prefix = function(v) {
     var tablename=Ext.util.Format.trim(v);
     if(tablename.indexOf(' ') >= 0 )  
     {  
       return false;
     }  
       
     if (tablename.length == APP_PREFIX.length) {
         return false;
     }
     if (tablename == APP_PREFIX + '_') {
         return false;
     }
     
     if(!(tablename.indexOf(APP_PREFIX)==0))
     {
      return false;
     }
     return true;
 }
 
Fb.validate_password_input = function(v) {
      
      var pwd=Ext.getCmp('password').getValue();
      var pwd2=Ext.getCmp('password2').getValue();
      console.log(pwd);
      console.log(pwd2);
      if(pwd.length<1){return false;} 
      if(!(pwd===pwd2)){return false;}
      else
        {return true;}
       
 }
 

 Fb.backendForm = function(category, opcode, xnode) {
     var o_mcfg = Category.getSubMenuCfg(category, opcode);
     var fixed_mcfg = Fb.preProcessNodeAtt(o_mcfg, xnode);
     var opform = Fb.getOperationForm(xnode, fixed_mcfg);
     return opform;
 }



 function helps_prod() {
     var x = Category.getContextMenus();
     for (var i = 0; i < x.length; i++) {
         menus = x[i].menus;
         for (var j = 0; j < menus.length; j++) {
             obj = {};
             obj.title = menus[j].title;
             obj.opcode = menus[j].opcode;
             items = [];
             if (menus[j].itemcfg) {
                 for (k = 0; k < menus[j].itemcfg.length; k++) {
                     if (!menus[j].itemcfg[k].hasOwnProperty('hidden')) {
                         items.push(menus[j].itemcfg[k].label);
                     }
                 }
             }
             obj.items = items;

             var url = "http://127.0.0.1/newoss/index.php/dbdocu/help_generator";
             Fb.ajaxPostData(url, obj, null);
         }
     }
     return;
 }


 Date.prototype.yyyymmdd = function() {
     var yyyy = this.getFullYear().toString();
     var mm = (this.getMonth() + 1).toString(); // getMonth() is zero-based         
     var dd = this.getDate().toString();
     return yyyy + '-' + (mm[1] ? mm : "0" + mm[0]) + '-' + (dd[1] ? dd : "0" + dd[0]);
 };


 Date.prototype.yymmddhhmmss = function() {
     var yyyy = this.getFullYear().toString();
     var mm = (this.getMonth() + 1).toString(); // getMonth() is zero-based         
     var dd = this.getDate().toString();
     var hour = "" + this.getHours();
     if (hour.length == 1) {
         hour = "0" + hour;
     }
     var minute = "" + this.getMinutes();
     if (minute.length == 1) {
         minute = "0" + minute;
     }
     var second = "" + this.getSeconds();
     if (second.length == 1) {
         second = "0" + second;
     }
     return yyyy + "-" + mm + "-" + dd + " " + hour + ":" + minute + ":" + second;
 }


 function getGridExtraData() {
     var gridid = 'not_exists_grid_id';
     if (Ext.getCmp('reorder_columns_grid')) {
         gridid = 'reorder_columns_grid';
     }

     if (Ext.getCmp('x_grid_for_dnd')) {
         gridid = 'x_grid_for_dnd';
     }


    if (Ext.getCmp('raw_table_grid_id')) {
         gridid = 'raw_table_grid_id';
     }
 


     if (!Ext.getCmp(gridid)) {
         return null;
     }

     var ds = Ext.getCmp(gridid).getStore();
     
     var destGrid=Ext.getCmp(gridid);
     console.log(destGrid.selModel.singleSelect);


     if(destGrid.selModel.singleSelect)
     {
      var singleSelectGrid=true;   
      var items=destGrid.getSelectionModel().getSelections();
     }
     else
     {
     var singleSelectGrid=false;
     var items = ds.data.items;
     }
   

     var griddata = [];
     for (var i = 0; i < items.length; i++) {
         var c = items[i].data;
         griddata.push(c);
     }

     var cm =destGrid.getColumnModel();
     console.log(cm);
     
     var col_count = cm.getColumnCount();
     return {
         mustHaveOneRow:singleSelectGrid,
         data: griddata,
         col_count: col_count,
         row_count: items.length
     }
 }



 Fb.DeepClone = function(obj) {

     var seenObjects = [];
     var mappingArray = [];
     var f = function(simpleObject) {
         var indexOf = seenObjects.indexOf(simpleObject);
         if (indexOf == -1) {
             switch (Ext.type(simpleObject)) {
                 case 'object':
                     seenObjects.push(simpleObject);
                     var newObject = {};
                     mappingArray.push(newObject);
                     for (var p in simpleObject)
                         newObject[p] = f(simpleObject[p]);
                     return newObject;

                 case 'array':
                     seenObjects.push(simpleObject);
                     var newArray = [];
                     mappingArray.push(newArray);
                     for (var i = 0, len = simpleObject.length; i < len; i++)
                         newArray.push(f(simpleObject[i]));
                     return newArray;

                 default:
                     return simpleObject;
             }
         } else {
             return mappingArray[indexOf];
         }
     };
     return f(obj);
 }
 
 
 Fb.randomString=function (){
	var chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz";
	var string_length = 8;
	var randomstring = '';
	for (var i=0; i<string_length; i++) {
		var rnum = Math.floor(Math.random() * chars.length);
		randomstring += chars.substring(rnum,rnum+1);
	}
	return randomstring;
}