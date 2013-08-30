/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

(function () {
    var placeholderReplaceRegex = /{good id=[^}]+?}/g;
    CKEDITOR.plugins.add('placeholder_ext', {
        requires: ['dialog'],
        lang: ['ru', 'en'],
        init: function (editor) {
            var lang = editor.lang.placeholder_ext;
            editor.addCommand('createplaceholder', new CKEDITOR.command(editor, {
                exec : function( editor ) {
                	return addGoodBtn();
                }
            }));
            editor.addCommand('editplaceholder', new CKEDITOR.dialogCommand('editplaceholder'));
            editor.ui.addButton('CreatePlaceholder_ext', {
                label: lang.toolbar,
                command: 'createplaceholder',
                icon: this.path + 'placeholder.gif'
            });
            if (editor.addMenuItems) {
                editor.addMenuGroup('placeholder_ext', 20);
                editor.addMenuItems({
                    editplaceholder: {
                        label: lang.edit,
                        command: 'editplaceholder',
                        group: 'placeholder_ext',
                        order: 1,
                        icon: this.path + 'placeholder.gif'
                    }
                });
                if (editor.contextMenu) editor.contextMenu.addListener(function (d, e) {
                    if (!d || !d.data('cke-placeholder')) return null;
                    return {
                        editplaceholder: CKEDITOR.TRISTATE_OFF
                    };
                });
            }
            editor.on('doubleclick', function (d) {
                if (CKEDITOR.plugins.placeholder_ext.getSelectedPlaceHoder(editor)) d.data.dialog = 'editplaceholder';
            });
            editor.addCss('.cke_placeholder{background-color: #ffff00;' + (CKEDITOR.env.gecko ? 'cursor: default;' : '') + '}');
            editor.on('contentDom', function () {
                editor.document.getBody().on('resizestart', function (d) {
                    if (editor.getSelection().getSelectedElement().data('cke-placeholder')) d.data.preventDefault();
                });
            });
            CKEDITOR.dialog.add('editplaceholder', this.path + 'dialogs/placeholder_ext.js');
        },
        afterInit: function (editor) {
            var dataProcessor = editor.dataProcessor,
                dataFilter = dataProcessor && dataProcessor.dataFilter,
                htmlFilter = dataProcessor && dataProcessor.htmlFilter;
            if (dataFilter) dataFilter.addRules({
                text: function (text) {
                    return text.replace(placeholderReplaceRegex, function (match) {
                        return CKEDITOR.plugins.placeholder_ext.createPlaceholder(editor, null, match, 1);
                    });
                }
            });
            if (htmlFilter) htmlFilter.addRules({
                elements: {
                    img: function(element) {
                    	if (element.attributes && element.attributes['data-cke-placeholder']) {
                    		var e = new CKEDITOR.htmlParser.text(element.attributes.id);
                    		element.add(e);
                    		delete element.name;
                    	}
					}
                }
            });
        }
    });
})();
CKEDITOR.plugins.placeholder_ext = {
    createPlaceholder: function (editor, oldElement, text, isGet) {
        var element = new CKEDITOR.dom.element('img', editor.document);
        element.setAttributes({
            contentEditable: 'false',
            'data-cke-placeholder': 1,
            'class': 'cke_placeholder',
            'src' : '/public/userfiles/goods/small/'+text.slice(9, -1)+'.jpg',
            'id' : text
        });
        if (isGet) return element.getOuterHtml();
        if (oldElement) {
            if (CKEDITOR.env.ie) {
                element.insertAfter(oldElement);
                setTimeout(function () {
                    oldElement.remove();
                    element.focus();
                }, 10);
            } else element.replace(oldElement);
        } else editor.insertElement(element);
        return null;
    },
    getSelectedPlaceHoder: function (editor) {
        var range = editor.getSelection().getRanges()[0];
        range.shrink(CKEDITOR.SHRINK_ELEMENT);
        var node = range.startContainer;
        while (node && !(node.type == CKEDITOR.NODE_ELEMENT && node.data('cke-placeholder'))) node = node.getParent();
        return node;
    }
};
