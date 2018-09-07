/*
Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/
CKEDITOR.editorConfig = function( config )
{
    // Define changes to default configuration here. For example:
    // config.language = 'fr';
    config.uiColor = '#F1F5F2';
    // �ļ����
    config.filebrowserImageBrowseUrl = "../includes/dialog/select_images.php";
    config.filebrowserFlashBrowseUrl = "../includes/dialog/select_media.php";
    config.filebrowserImageUploadUrl  = "../includes/dialog/select_images_post.php";
	
	config.autoParagraph = false;
    config.enterMode = CKEDITOR.ENTER_BR;
	config.shiftEnterMode = CKEDITOR.ENTER_P; 
};
