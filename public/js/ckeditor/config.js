/**
 * @license Copyright (c) 2003-2019, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	config.language = 'es';
	// config.uiColor = '#AADC6E';
	
	config.toolbar = [
		//{ name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates' ] },
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ] },
		{ name: 'editing', groups: [ /*'find', 'selection',*/ 'spellchecker' ], items: [ /*'Find', 'Replace', '-', 'SelectAll', '-',*/ 'Scayt' ] },
		//{ name: 'forms', items: [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'TextColor', 'Bold', 'Italic', 'Underline', 'Strike', /*'Subscript', 'Superscript',*/ '-', 'CopyFormatting', 'RemoveFormat' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align'/*, 'bidi'*/ ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'/*, '-', 'BidiLtr', 'BidiRtl', 'Language'*/ ] },
		'/',
		{ name: 'tools', items: [ 'Maximize', 'ShowBlocks' ] },
		{ name: 'insert', items: [ 'Image', /*'Flash',*/ 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak'/*, 'Iframe'*/ ] },
		{ name: 'links', items: [ 'Link', 'Unlink', 'Anchor' ] },
		{ name: 'styles', items: [ 'Styles', 'Format', 'Font', 'FontSize' ] },
		//{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
		//{ name: 'others', items: [ '-' ] },
		{ name: 'about', items: [ 'About' ] }
	];
	
};
