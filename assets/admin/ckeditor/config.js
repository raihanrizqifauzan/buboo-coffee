/**
 * @license Copyright (c) 2003-2022, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.removeDialogTabs = "image:advanced;link:advanced";
	config.entities = true;
	config.allowedContent = true;
	config.filebrowserBrowseUrl = '../kcfinder/browse.php?type=files';
	config.filebrowserImageBrowseUrl = '../kcfinder/browse.php?type=images';
	config.filebrowserFlashBrowseUrl = '../kcfinder/browse.php?type=flash';
	config.filebrowserUploadUrl = '../kcfinder/upload.php?type=files';
	config.filebrowserImageUploadUrl = '../kcfinder/upload.php?type=images';
	config.filebrowserFlashUploadUrl = '../kcfinder/upload.php?type=flash';

};
CKEDITOR.dtd.$removeEmpty.span = 0;
