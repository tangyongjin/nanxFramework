Ext.ns('Ext.ux.grid');
 
Ext.ux.grid.CheckColumn = Ext.extend(Ext.grid.Column, {

    /**
     * @private
     * Process and refire events routed from the GridView's processEvent method.
     */
    processEvent:function(name, e, grid, rowIndex, colIndex,a,b,c){
    	
    	  console.log(name);
    	  console.log(e);
    	  console.log(e.getTarget());
    	  
    	  
        if (name == 'mousedown') {
        	
        	
        	 
        	
        	  var index    = rowIndex;
            var record = grid.store.getAt(rowIndex);
            var colModel = grid.getColumnModel();
            var colIdx   =colIndex;
            var col      = colModel.columns[colIdx];
            var val      = record.data[col.dataIndex] ;
        	  
            var click_Data={
                grid: grid,
                record:record,
                field: col.dataIndex,
                value: !val,
                originalValue:val,
                row:rowIndex,
                column:colIndex
            };
            
            record.set(this.dataIndex, !record.data[this.dataIndex]);
            grid.fireEvent('afteredit',click_Data);

            return false; // Cancel row selection.
        } else {
            return Ext.grid.ActionColumn.superclass.processEvent.apply(this, arguments);
        }
    },

    renderer : function(v, p, record){
        p.css += ' x-grid3-check-col-td'; 
        return String.format('<div class="x-grid3-check-col{0}">&#160;</div>', v ? '-on' : '');
    } 
   
});

// register ptype. Deprecate. Remove in 4.0
Ext.preg('checkcolumn', Ext.ux.grid.CheckColumn);

// backwards compat. Remove in 4.0
Ext.grid.CheckColumn = Ext.ux.grid.CheckColumn;

// register Column xtype
Ext.grid.Column.types.checkcolumn = Ext.ux.grid.CheckColumn;