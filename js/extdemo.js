var data = '[{"cod_domini":"1","nom_domini":"Sant Esteve de Palautordera"},{"cod_domini":"2","nom_domini":"Parc Natural del Montseny"},{"cod_domini":"5","nom_domini":"Sant Pere de Vilamajor"},{"cod_domini":"6","nom_domini":"Santa Maria i Mosqueroles"}]';


// var mystore = new Ext.data.JsonStore({
//     //autoload: true,
//     fields: [ 
//         {type: 'integer', name: 'cod_domini'},
//         {type: 'string', name: 'nom_domini'}
//     ]
// });


//http://123.57.223.10:7000/curd/listData?start=0&limit=25

x_table_query_obj={"table":"t_course_small","code":"act_t_course_small_1686696377","whoami":"admin","who_is_who":[],"owner_data_only":null,"id_order":"asc","query_cfg":null}

var mystore=new Ext.data.JsonStore({
        proxy:new Ext.data.HttpProxy({
            url:'http://123.57.223.10:7000/curd/listData',
            method:'POST',
            jsonData:x_table_query_obj
        }),

        listeners:{
            'beforeload':function(){
                // WaitMask.show();
            },
            'load':function(){
                // WaitMask.hide();
            }
        },
        
        // fields:['id','name'],
        fields: [ 
        {type: 'integer',name: 'id'},
        {type: 'string', name: 'name'}
        ],
        // autoLoad:true,
        root:'rows',
        storeId:Ext.id(),
        // totalProperty:'total'
});


// mystore.load();

mystore.load({
                params:{
                    start:0,
                    limit:25
                }
            });



// mystore.loadData(Ext.decode(data)); // decode data, because it is in encoded in string

var cbxSelDomini = new Ext.form.ComboBox({
    hiddenName: 'Domini',
    name: 'nom_domini',
    mode: 'local',
    width:600,
    pageSize:25,
    triggerAction: 'all',
    listClass: 'comboalign',
    displayField: 'name',
    valueField: 'id',
    typeAhead: true,
    forceSelection: true,
    selectOnFocus: true,
    store: mystore
});



  var opform = new Ext.form.FormPanel({
         id: "back_opform",
         frame: true,
         autoScroll: true,
         autoDestroy: true,
         border: false,
         // layout: layout,
         height: 400,
         labelWidth: 100,
         fileUpload: true,
         labelAlign: 'right',
         bodyStyle: "padding-left:10px;",
         defaults: {
             allowBlank: false
         },
         name: "opform",
         renderTo: Ext.getBody(),

         items: [cbxSelDomini]
     });