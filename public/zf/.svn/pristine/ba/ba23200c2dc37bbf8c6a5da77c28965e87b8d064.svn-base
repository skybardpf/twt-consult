/* 
* @example An iframe-based dialog with custom button handling logics.
*/
( function() {
    CKEDITOR.plugins.add( 'audio',
    {
        requires: [ 'iframedialog' ],
        init: function( editor )
        {
           var me = this;
           CKEDITOR.dialog.add( 'audioDialog', function ()
           {
              return {
                 title : 'Добавление аудио файла',
                 minWidth : 550,
                 minHeight : 200,
                 contents :
                       [
                          {
                             id : 'iframe',
                             label : 'Аудио',
                             expand : true,
                             elements :
                                   [
                                      {
						               type : 'html',
						               id : 'pageAudio',
						               label : 'Audio',
						               style : 'width : 600px;',
						               html : '<iframe src="'+me.path+'/dialogs/audio.html" frameborder="0" name="iframeAudio" id="iframeAudio" allowtransparency="1" style="width:600px;margin:0;padding:0;"></iframe>'
						              }
                                   ]
                          }
                       ],
                  onOk : function()
                 {
                    var content;
                    for (var i=0; i<window.frames.length; i++) {
                        try {
                            if (window.frames[i].name == 'iframeAudio') {
                                content = window.frames[i].document.getElementById("audio").value;
                            }
                        } catch (e) {;}
                    }
                    console.log(content);
                     var time = new Date();
                    final_html = '<div id="audioplayer_'+time.getTime()+'">'+content+'</div><scr'+'ipt type="text/javascript">\
                        AudioPlayer.embed("audioplayer_'+time.getTime()+'", {soundFile: "'+content+'"});</scr'+'ipt>';
                    editor.insertHtml(final_html);
                    //clean_editor_data = editor.getData()+final_html;
                    //editor.setData(clean_editor_data);
                 }
              };
           } );

            editor.addCommand( 'audio', new CKEDITOR.dialogCommand( 'audioDialog' ) );

            editor.ui.addButton( 'audio',
            {
                label: 'Audio',
                command: 'audio',
                icon: this.path + 'images/audio.png'
            } );
        }
    } );
} )();
