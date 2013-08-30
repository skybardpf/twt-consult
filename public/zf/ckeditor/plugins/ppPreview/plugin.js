CKEDITOR.plugins.add( 'ppPreview',
{
    requires : [ 'iframedialog' ],
	init : function( editor )
	{
        var me = this;

        editor.addCommand('ppPreview', new CKEDITOR.dialogCommand('ppPreviewDialog'));

        editor.ui.addButton( 'ppPreview',
			{
				label : 'Preview',
				icon : this.path + 'images/pppreview.png',
				command : 'ppPreview'
			} );

        CKEDITOR.dialog.add('ppPreviewDialog',
            function() {
                return {
                    title : 'Предпросмотр',
                    minWidth : 1040,
                    minHeight : 500,
                    contents : [ {
                        id : 'iframe',
                        label : 'Предпросмотр',
                        expand : true,
                        elements : [ {
                            type : 'html',
                            id : 'PPPreview',
                            label : 'Предпросмотр',
                            style : 'width : 1040px;',
                            html : '<iframe src="/ajaxes/preview/" frameborder="0" name="PPPreviewFrame" id="PPPreviewFrame" allowtransparency="1" style="width:1040px;height:500px;margin:0;padding:0;"></iframe>'
                        } ]
                    } ],
                    onOk : function() {
                        for ( var i = 0; i < window.frames.length; i++) {
                            try {
                                if (window.frames[i].name == 'PPPreviewFrame') {
                                    $(window.frames[i].document).find('.del a').show();
                                    var content = window.frames[i].attachedIDS;
                                    window.frames[i].attachedIDS = {};
                                }
                            } catch(e) {}
                        }
                    },
                    onCancel: function() {
                        for ( var i = 0; i < window.frames.length; i++) {
                            try {
                                if (window.frames[i].name == 'PPPreviewFrame') {
                                    $(window.frames[i].document).find('.del a').show();
                                    window.frames[i].attachedIDS = {};
                                }
                            } catch(e) {}
                        }
                    },
                    onShow: function() {
                        var $form = $('#'+editor.name).parents('form');
                        var target = $form.attr('target');
                        var action = $form.attr('action');
                        $form.attr({
                            target: 'PPPreviewFrame',
                            action: '/ajaxes/preview/'+window.location.pathname.split('/')[2]+'/'
                        });
                        $form.submit();
                        $form.attr({
                            target: target,
                            action: action
                        });
                    }
                };
            });
	}
} );


