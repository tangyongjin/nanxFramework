Ext.ns("Ext.ux");
Ext.ux.FieldLabeler = (function(){
    function getParentProperty(propName) {
        for (var p = this.ownerCt; p; p = p.ownerCt) {
            if (p[propName]) {
                return p[propName];
            }
        }
    }

    return {
        init: function(f) {
            f.onRender = f.onRender.createSequence(this.onRender);
            f.onResize = this.onResize;
            f.onDestroy = f.onDestroy.createSequence(this.onDestroy);
        },
        onRender: function() {
//          Do nothing if being rendered by a form layout
            if (this.ownerCt) {
                if (this.ownerCt.layout instanceof Ext.layout.FormLayout) {
                    return;
                }
            }

            this.resizeEl = (this.wrap || this.el).wrap({
                cls: 'x-form-element',
                style: (Ext.isIE || Ext.isOpera) ? 'position:absolute;top:0;left:0;overflow:visible' : ''
            });
            this.positionEl = this.itemCt = this.resizeEl.wrap({
                cls: 'x-form-item '
            });
            if (this.nextSibling()) {
                this.margins = {
                    top: 0,
                    right: 0,
                    bottom: this.positionEl.getMargins('b'),
                    left: 0
                };
            }
            this.actionMode = 'itemCt';

//          If our Container is hiding labels, then we're done!
            if (!Ext.isDefined(this.hideLabels)) {
                this.hideLabels = getParentProperty.call(this, "hideLabels");
            }
            if (this.hideLabels) {
                this.resizeEl.setStyle('padding-left', '0px');
                return;
            }

//          Collect the info we need to render the label from our Container.
            if (!Ext.isDefined(this.labelSeparator)) {
                this.labelSeparator = getParentProperty.call(this, "labelSeparator");
            }
            if (!Ext.isDefined(this.labelPad)) {
                this.labelPad = getParentProperty.call(this, "labelPad");
            }
            if (!Ext.isDefined(this.labelAlign)) {
                this.labelAlign = getParentProperty.call(this, "labelAlign") || 'left';
            }
            this.itemCt.addClass('x-form-label-' + this.labelAlign);

            if(this.labelAlign == 'top'){
                if (!this.labelWidth) {
                    this.labelWidth = 'auto';
                }
                this.resizeEl.setStyle('padding-left', '0px');
            } else {
                if (!Ext.isDefined(this.labelWidth)) {
                    this.labelWidth = getParentProperty.call(this, "labelWidth") || 100;
                }
                this.resizeEl.setStyle('padding-left', (this.labelWidth + (this.labelPad || 5)) + 'px');
                this.labelWidth += 'px';
            }

            this.label = this.itemCt.insertFirst({
                tag: 'label',
                cls: 'x-form-item-label',
                style: {
                    width: this.labelWidth
                },
                html: this.fieldLabel + (this.labelSeparator || ':')
            });
        },

//      private
//      Ensure the input field is sized to fit in the content area of the resizeEl (to the right of its padding-left)
//      We perform all necessary sizing here. We do NOT call the current class's onResize because we need this control
//      we skip that and go up the hierarchy to Ext.form.Field
        onResize: function(w, h) {
            Ext.form.Field.prototype.onResize.apply(this, arguments);
            w -= this.resizeEl.getPadding('l');
            if (this.getTriggerWidth) {
                this.wrap.setWidth(w);
                this.el.setWidth(w - this.getTriggerWidth());
            } else {
                this.el.setWidth(w);
            }
            if (this.el.dom.tagName.toLowerCase() == 'textarea') {
                var h = this.resizeEl.getHeight(true);
                if (!this.hideLabels && (this.labelAlign == 'top')) {
                    h -= this.label.getHeight();
                }
                this.el.setHeight(h);
            }
        },

//      private
//      Ensure that we clean up on destroy.
        onDestroy: function() {
            this.itemCt.remove();
        }
    };
})();