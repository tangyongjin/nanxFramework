
Ext.ns('App');

App.LoginDialog = function() {
    return {
        getForm: function() {
            var form = new Ext.form.FormPanel({
                labelWidth: 80,
                buttonAlign: 'center',
                bodyStyle: 'padding:5px;',
                frame: true,
                defaultType: 'textfield',
                defaults: {
                    enableKeyEvents: true,
                    anchor: '90%',
                    allowBlank: false
                },
                items: [{
                    name: 'username',
                    fieldLabel: '用户名称',
                    listeners: {
                        scope: this,
                        keypress: function(field, e) {
                            if (e.getKey() == 13) {
                                var passwordField = form.getForm().findField('password');
                                if (passwordField) {
                                    passwordField.focus();
                                }
                            }
                        }
                    }
                }, {
                    name: 'password',
                    fieldLabel: '用户密码',
                    inputType: 'password',
                    listeners: {
                        scope: this,
                        keypress: function(field, e) {
                            if (e.getKey() == 13) {
                                var captchaField = form.getForm().findField('captcha');
                                if (captchaField) {
                                    captchaField.focus();
                                }
                            }
                        }
                    }
                }, {
                    name: 'captcha',
                    fieldLabel: '验证码',
                    listeners: {
                        scope: this,
                        keypress: function(field, e) {
                            if (e.getKey() == 13) {
                                this.submit();
                            }
                        }
                    }
                }, {
                    xtype: 'panel',
                    height: 100,
                    html: '<div style="margin:5px 0px 0px 84px"><a href="#"><img alt="如果看不清楚请单击图片更换图片。" onclick="this.src=\'commons/captcha.jsp?d=\'+new Date();" id="code" height="82" width="242" src="commons/captcha.jsp?d=' + new Date() + '" border="0"></a></div>',
                    border: false
                }, {
                    xtype: 'panel',
                    height: 30,
                    html: '<div style="margin:5px 0px 0px 84px;color:red">*如果图片不清晰请单击图片更换图片</div>',
                    border: false
                }],
                buttons: [{
                    text: '确定',
                    scope: this,
                    handler: function() {
                        this.submit();
                    }
                }, {
                    text: '重置',
                    scope: this,
                    handler: function() {
                        this.frm.form.reset()
                    }
                }]
            });
            return form;
        },

        getDialog: function() {
            var form = this.getForm();
            var dlg = new Ext.Window({
                width: 400,
                height: 300,
                title: '仓库管理系统',
                plain: true,
                closable: true,
                resizable: false,
                frame: true,
                layout: 'fit',
                closeAction: 'hide',
                border: false,
                modal: true,
                items: [form]
            });
            this.form = form;
            return dlg;
        },

        submit: function() {
            if (this.form.getForm().isValid()) {
                var f = this.form.getEl().child('form');
                UserAction.checkLogin(f, function(data, e) {
                    if (data.success) {
                        window.location = 'main.jsp';
                    } else {
                        Ext.Msg.alert('信息', data.data);
                    }
                });
            }
        },
        
        math:function(acode)
        {
        console.log(acode);
        },
        
        show: function() {
            if (!this.dlg) {
                this.dlg = this.getDialog();
            }
            this.dlg.show();
        }
    };
}();
