	  var dir= WEB_ROOT+"jslib/datav/";
	  seajs.config({
			alias: {				
				'datav':  dir + 'datav.js',
				'tree':   dir + 'tree.js'
			}
		});
		
	 
    function showTree(jsonData)
   { 		
		//var jsonData = "[{ID:'0', name:'工厂',size:13,parentID:''},{id:'1', name:'分销A',size:13,parentID:'0'},{id:'2', name:'分销B',size:13,parentID:'0'}]"; 
		seajs.use(["tree", "datav"], function(Tree,DataV) 
		{
			var tree = new Tree("viewTree", {width:960});			
			/* json数据源的方式实现 */
			var data = json2Array(jsonData);
   		 tree.setSource(data);
			 tree.render();
		});
   }
   
   
   Ext.Ajax.request(
{  
    url:AJAX_ROOT+'node/listNodes',
    success:function(response,config)
     { 
	     json=response.responseText;
	     //alert(json);
	     showTree(json);
   }
});
   
    
    
		//将JSON数据转换成所需的二维数组
	    function json2Array(jsonData) {
	        var jsonsString = jsonData.slice(1, jsonData.length - 1);
	        var jsonStrings = jsonsString.split("},");
	        var length = jsonStrings.length;
	        var jsons = [];
	        for (var i = 0; i != length-1; ++i) {
	            jsonStrings[i] += '}';
	        }
	        var source = [[]];
	        for (var i = 0; i != length; ++i) {
	            jsons[i] = eval('(' + jsonStrings[i] + ')');
	            var data = [];
	            for(var key in jsons[i]) {
	                if(i == 0) {
	                    source[0].push(key);                    
	                }
	                data.push(jsons[i][key]);
	            }
	            source.push(data);
	        }		       
	        
	        return source;
	    }
	    
	    
	    
    
	
    Ext.QuickTips.init(); 
	Ext.onReady(function(){
  	   var infoPanel = new Ext.form.FormPanel({  
  	        title:'添加节点',
  	        width:300,
  	        frame:true,
			labelWidth : 60,
			
  	        items: [{  
  	            xtype: 'textfield',  
  	            fieldLabel: '当前节点',  
 	            disabled : "true", 
				width:200,
 			    allowBlank : false, 
  	            id : "oldNodeName",
  	            name: 'oldNodeName'  
  	        },{  
  	        	xtype : 'hidden',
			       	id : 'nodeId',
  	            name  : 'nodeId'  
  	        },{  
  	            xtype: 'textfield',  
  	            fieldLabel: '下级节点',
  	            allowBlank : false, 
				width:200,
				id : 'nodeName',
  	            name: 'nodeName'  
  	        }],  
  	            buttons:[{  
  	            text:'确定',  
  	            handler:function(){ 
					if (infoPanel.form.isValid()) {
						doAdd();  
					}
  	            }  
  	        }]  
  	  
  	    });
  	var role_store = new Ext.data.JsonStore({
		url: AJAX_ROOT+'role/listall',
		//autoLoad : true,
		fields: ['role_code', 'role_name']
		});
		role_store.load();
		var addUserPanel=new Ext.form.FormPanel({
			width:300,
			frame:true,
			labelWidth : 60,
			style:{
				marginTop:'10px'
			},
			title:'添加用户',
			items:[{
				xtype:'textfield',
				fieldLabel:'当前节点',
				disabled:true,
				width:200,
				allowBlank : false, 
				id:'add_oldNodeId'
			},{
				xtype:'hidden',
				id:'add_nodeId'
			},{
				xtype:'textfield',
				fieldLabel:'用户类型',
				xtype:"combo",
				valueField : 'value',
			    displayField : "text",
				mode : 'local',
				editable : false,
				allowBlank:false,
				id:'add_device_agent',
				width:200,
				triggerAction : 'all',
				store:[['web','WEB'],['pda','PDA']]	
			},{
				xtype:'textfield',
				fieldLabel:'帐号',
				allowBlank : false,
				width:200,
				id:'add_userName'
			},{
				xtype:'textfield',
				fieldLabel:'员工姓名',
				allowBlank : false,
				width:200,
				id:'add_staffName'
			},{
				xtype:'textfield',
				fieldLabel:'角色名称',
				xtype:"combo",
				valueField : 'role_code',
			  displayField : "role_name",
				mode : 'local',
				editable : false,
				allowBlank:false,
				id:'role_code',
				width:200,
				triggerAction : 'all',
				store:role_store
			},{
				fieldLabel:'密码',
				xtype:'textfield',
				id:'user_password',
				width:200,
				maxLength : 20,
				maxLengthText : '密码不能大于20位',
				minLength:4,
				minLengthText : '密码不能小于4位',
				inputType : 'password',
				allowBlank:false
			},{
				fieldLabel:'重复密码',
				xtype:'textfield',
				id:'user_password1',
				maxLength : 20,
				width:200,
				maxLengthText : '密码不能大于20位',
				minLength:4,
				minLengthText : '密码不能小于4位',
				inputType : 'password',
				allowBlank:false	
			}],
			 buttons:[{  
  	            text:'确定',  
  	            handler:function(){ 
								if (addUserPanel.form.isValid()) {
										addUser(); 
									}
  	    			 }  
  	        	 },{
								text:'取消',
								handler:function(){ 
										Ext.getCmp("add_userName").setValue(""),
										Ext.getCmp("add_nodeId").setValue(""),
										Ext.getCmp("user_password").setValue(""),
										Ext.getCmp("user_password1").setValue(""),
										Ext.getCmp("add_oldNodeId").setValue(""),
										Ext.getCmp("add_staffName").setValue(""),
										Ext.getCmp("add_device_agent").setValue(""),
										Ext.getCmp("role_code").setValue("")
										
  	            }  
			
			}]  
		
		});
		 var borderPanel=new Ext.Panel({
			layout:'form',
			border:false,
			bodyStyle: {
    				background: '#F4F4F4'
    		},
			applyTo:'operate_form',  
			items:[infoPanel,addUserPanel]
			
	   });
	    //添加用户
		function addUser(){
			if(Ext.getCmp("add_userName").getValue()==null||Ext.getCmp("add_userName").getValue()==""){
								 Ext.Msg.show({
									title: '系统提示',
									msg: '请选择节点',
									buttons: Ext.Msg.OK,
									icon: Ext.Msg.INFO 
									});
								return;
			}
			if(Ext.getCmp("user_password").getValue()!=Ext.getCmp("user_password1").getValue()){
								 Ext.Msg.show({
									title: '系统提示',
									msg: '两次输入的密码不一致,请重新输入',
									buttons: Ext.Msg.OK,
									icon: Ext.Msg.INFO 
									});
								return;
			}
			var myObj={
					'user':Ext.getCmp("add_userName").getValue(),
					'node_id':Ext.getCmp("add_nodeId").getValue(),
					'password':Ext.getCmp("user_password").getValue(),
					'staff_name':Ext.getCmp("add_staffName").getValue(),
					'device_agent':Ext.getCmp("add_device_agent").getValue(),
					'role_code':Ext.getCmp("role_code").getValue()
			}
			var json = Ext.encode(myObj);
			Ext.Ajax.request({
				url : AJAX_ROOT+'user/add',
				method : 'POST',
				jsonData:json,
				success : function(response) {
					var obj = Ext.decode(response.responseText);
					if (obj.code == 0) {
						MsgTip.msg('系统信息', "添加用户成功!", true, 2);
						location.reload();
					} else {
						Ext.Msg.show({
									title : '错误提示',
									msg : '添加失败',
									buttons : Ext.Msg.OK,
									icon : Ext.Msg.ERROR
								});
					}
				},
				failure : function() {
					Ext.Msg.show({
								title : '错误提示',
								msg : '系统错误',
								buttons : Ext.Msg.OK,
								icon : Ext.Msg.ERROR

							});
				}
			});
		}
  		//添加节点
	  	var doAdd = function()  
	  	{	  		
			var parentId = document.getElementById("nodeId").value;
			var nodeName = document.getElementById("nodeName").value;
			
			var obj= 
			{
				parentId : parentId,
				nodeName : nodeName
			};
      
      var jsonstr= "{'parentId':'"+ parentId+"','nodeName':'"+nodeName+"'}";
        

			Ext.Ajax.request({  
					url : AJAX_ROOT+'node/addChild',  
					method : "POST",  
					params : {  
					   param : jsonstr
					},					
					success : function(){
						   alert("添加成功"); 
						   location.reload();
					}  
			});  
	  	}
	});  
