/*
 * @example An iframe-based dialog with custom button handling logics.
 */
(function() {
	CKEDITOR.plugins
			.add(
					'galleryButton',
					{
						requires : [ 'iframedialog' ],
						init : function(editor) {
							var me = this;
							CKEDITOR.dialog
									.add(
											'galleryButtonDialog',
											function() {
												return {
													title : 'Добавление фотогалереи',
													minWidth : 800,
													minHeight : 500,
													contents : [ {
														id : 'iframe',
														label : 'Видео',
														expand : true,
														elements : [ {
															type : 'html',
															id : 'galleryButton',
															label : 'Embed Media',
															style : 'width : 800px;',
															html : '<iframe src="/admin/fotogallery/list_attach/" frameborder="0" name="iframegalleryButton" id="iframegalleryButton" allowtransparency="1" style="width:800px;height:500px;margin:0;padding:0;"></iframe>'
														} ]
													} ],
													onOk : function() {
														for ( var i = 0; i < window.frames.length; i++) {
															if (window.frames[i].name == 'iframegalleryButton') {
																$(window.frames[i].document).find('.del a').show();
																var content = window.frames[i].attachedIDS;
																window.frames[i].attachedIDS = {};
															}
														}
														if (typeof content!='undefined') {														
															var cnt = '';
															for (var i in content) {
																cnt += '<b class="photogallery" rel="'+content[i].tag+'">Фотогаллерея: '+content[i].name+'</b><br>';
															}
															editor.insertHtml(cnt);
														}
														
													},
													onCancel: function() {
														for ( var i = 0; i < window.frames.length; i++) {
															if (window.frames[i].name == 'iframegalleryButton') {
																$(window.frames[i].document).find('.del a').show();
																window.frames[i].attachedIDS = {};
															}
														}
													}
												};
											});

							editor.addCommand('galleryButton',
									new CKEDITOR.dialogCommand(
											'galleryButtonDialog'));

							editor.ui.addButton('galleryButton', {
								label : 'galleryButton',
								command : 'galleryButton',
								icon : this.path + 'images/addGallery.gif'
							});
						}
					});
})();
