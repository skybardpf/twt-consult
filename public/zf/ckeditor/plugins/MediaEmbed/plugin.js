/* 
* @example An iframe-based dialog with custom button handling logics.
*/
( function() {
    CKEDITOR.plugins.add( 'MediaEmbed',
    {
        requires: [ 'iframedialog' ],
        init: function( editor )
        {
           var me = this;
           CKEDITOR.dialog.add( 'MediaEmbedDialog', function ()
           {
              return {
                 title : 'Добавление видеоролика',
                 minWidth : 550,
                 minHeight : 200,
                 contents :
                       [
                          {
                             id : 'iframe',
                             label : 'Видео',
                             expand : true,
                             elements :
                                   [
                                      {
						               type : 'html',
						               id : 'pageMediaEmbed',
						               label : 'Embed Media',
						               style : 'width : 600px;',
						               html : '<iframe src="'+me.path+'/dialogs/mediaembed.html" frameborder="0" name="iframeMediaEmbed" id="iframeMediaEmbed" allowtransparency="1" style="width:600px;margin:0;padding:0;"></iframe>'
						              }
                                   ]
                          }
                       ],
                  onOk : function()
                 {
                    var content;
                    for (var i=0; i<window.frames.length; i++) {
                        try {
                            if (window.frames[i].name == 'iframeMediaEmbed') {
                                content = window.frames[i].document.getElementById("embed").value;
                            }
                        } catch (e) {;}
                    }
                    var rutubeRegex = /rutube.ru/;
                    var youtubeRegex = /youtube.com/;
                    var youtubeshortRegex = /youtu.be\/.*/;
                    if (rutubeRegex.test(content)) {
                    	var insresult = true;
                    	var codeRegex = /\/([0-9]+)\.html\?v=(.*)?/;
                    	var params = codeRegex.exec(content);
                    	var rutubeID = params[1];
                    	var rutubeCode = params[2];
                    	var embedCode = '<OBJECT width="600" height="450"><PARAM name="movie" value="http://video.rutube.ru/'+rutubeCode+'"></PARAM><PARAM name="wmode" value="window"></PARAM><PARAM name="allowFullScreen" value="true"></PARAM><EMBED src="http://video.rutube.ru/'+rutubeCode+'" type="application/x-shockwave-flash" wmode="window" width="600" height="450" allowFullScreen="true" ></EMBED></OBJECT>';
                    	var hiddenCode = '<!--video url='+content+'-->';
                    }
                    if (youtubeRegex.test(content)) {
                    	var codeRegex = /v=(.*)/;
                    	var params = codeRegex.exec(content);
                    	var youtubeCode = params[1];
                    	var embedCode = '<iframe width="600" height="450" src="http://www.youtube.com/embed/'+youtubeCode+'" frameborder="0" allowfullscreen></iframe>';
                        var hiddenCode = '<!--video url='+content+'-->';
                    }
                    if (youtubeshortRegex.test(content)) {
                    	var codeRegex = /youtu.be\/(.*)/;
                    	var params = codeRegex.exec(content);
                    	var youtubeCode = params[1];
                    	var embedCode = '<iframe width="600" height="450" src="http://www.youtube.com/embed/'+youtubeCode+'" frameborder="0" allowfullscreen></iframe>';
                        var hiddenCode = '<!--video url='+content+'-->';
                    }
                    final_html = '<div class="media_embed">'+embedCode+'</div>'+hiddenCode;
                    editor.insertHtml(final_html);
                    //clean_editor_data = editor.getData()+final_html;
                    //editor.setData(clean_editor_data);
                 }
              };
           } );

            editor.addCommand( 'MediaEmbed', new CKEDITOR.dialogCommand( 'MediaEmbedDialog' ) );

            editor.ui.addButton( 'MediaEmbed',
            {
                label: 'Embed Media',
                command: 'MediaEmbed',
                icon: this.path + 'images/icon.gif'
            } );
        }
    } );
} )();
