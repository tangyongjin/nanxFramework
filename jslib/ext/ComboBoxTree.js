Ext.ns("WTEK.ui");
/**
 * 下拉列表选择树
 * <br>
 * 依赖EXTJS3版本
 * @class WTEK.ui.ComboBoxTree
 * @extends Ext.form.ComboBox
 * @author yongtree 
 */
Ext.BLANK_IMAGE_URL = 'ext/resources/images/default/s.gif'; 
WTEK.ui.ComboBoxTree = Ext.extend(Ext.form.ComboBox, {
	/**
	 * 回调函数,用于传递选择的id，text属性
	 * 
	 * @type
	 */
	callback : Ext.emptyFn,
	store : new Ext.data.SimpleStore({fields : [],data : [[]]}),
	editable : this.editable||false,
	mode : 'local',
	emptyText : this.emptyText||"请选择",
	allowBlank : this.allowBlank||true,
	blankText : this.blankText||"必须输入!",
	id : this.id||"",
	triggerAction : 'all',
	maxHeight : 200,
	anchor : '95%',
	displayField : 'text',
	valueField : 'id',
	tpl : "<tpl for='.'><div style='height:200px'><div id='tree'></div></div></tpl>",
	selectedClass : '',
	onSelect : Ext.emptyFn,
	rootText : this.rootText||'root',
	tree : this.tree,
	loader:this.loader,
	initComponent : function() {
		//var _loader =  new Ext.tree.TreeLoader({baseParams : this.baseParams,	url : this.treeUrl});
		tree = this.tree;
		var c = this;
		/**
		 * 点击选中节点并回调传值
		 */
		this.tree.on('click', function(node) {
					if (node.id != null && node.id != '') {
						if (node.id != '_oecp') {
							c.setValue(node.text);
							c.callback.call(this, node.id, node.text);
							c.collapse();
						} else {
							Ext.Msg.alert("提示", "此节点无效，请重新选择!")
						}
					}
				})
		this.on('expand', function() {
					this.tree.render('tree');
					this.tree.expandAll();
				});
		WTEK.ui.ComboBoxTree.superclass.initComponent.call(this);
	},
	reload :function(){
		
	}
})