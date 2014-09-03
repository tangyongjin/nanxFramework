/**
 * 重载EXTJS-HTML编辑器
 * 
 * @class HTMLEditor
 * @extends Ext.form.HtmlEditor
 * @author wuliangbo
 */
HTMLEditor = Ext.extend(Ext.form.HtmlEditor, {
	addImage : function() {
		var editor = this;
		var imgform = new Ext.FormPanel({
			region : 'left',
			labelWidth : 55,
			frame : true,
			labelWidth: 60,
			bodyStyle : 'padding:5px 5px 0',
			autoScroll : true,
			border : false,
			fileUpload : true,
			items :[
			     {
						xtype : 'textfield',
						fieldLabel : '选择文件',
						name : 'files',
			    	inputType : 'file',
						allowBlank : false,
						blankText : '文件不能为空',
						height : 25
					 }],
			buttons : [{
				text : '上传',
				type : 'submit',
				handler : function() {
					if (!imgform.form.isValid()) {return;}
					imgform.form.submit({
						waitMsg : '正在上传......',
						url : URL_ROOT+'index.php/pic/upload',
						success : function(form, action) 
						{
							var element = document.createElement("img");
							element.src = action.result.fileURL;
							if (Ext.isIE) {
								editor.insertAtCursor(element.outerHTML);
							} else {
								var selection = editor.win.getSelection();
								if (!selection.isCollapsed) {
									selection.deleteFromDocument();
								}
								selection.getRangeAt(0).insertNode(element);
							}
							win.hide();
						},
						failure : function(form, action) {
							form.reset();
							if (action.failureType == Ext.form.Action.SERVER_INVALID)
								Ext.MessageBox.alert('警告',
										action.result.errors.msg);
						}
					});
				}
			}, {
				text : '关闭',
				type : 'submit',
				handler : function() {
					win.close(this);
				}
			}]
		})

		var win = new Ext.Window({
					title : "上传图片",
					width : 400,
					height : 200,
					modal : true,
					border : false,
					layout : "fit",
					items : imgform

				});
		win.show();
	},
	
	createToolbar : function(editor) {
		HTMLEditor.superclass.createToolbar.call(this, editor);
		this.tb.insertButton(16, {
					cls : "x-btn-icon",
					icon : URL_ROOT+"imgs/picture.png",
					handler : this.addImage,
					scope : this
				});
	}
});
Ext.reg('StarHtmleditor', HTMLEditor);
