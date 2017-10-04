(function() {
	tinymce.PluginManager.add('nuclearnetwork', function( editor, url ) {

		editor.addButton('note', {
			text: 'Footnote',
			icon: null,
			tooltip: 'Insert Footnote',
			onclick: function() {
				editor.windowManager.open( {
					title: 'Insert Footnote Content',
					width: 400,
					height: 100,
					body: [
						{
							type: 'textbox',
							multiline: true,
							name: 'note'
						}
					],
					onsubmit: function( e ) {
						editor.insertContent( '[note]' + e.data.note + '[/note]');
					}
				});
			}
		});

		editor.addButton('toc', {
			text: 'Table of Contents',
			icon: null,
			tooltip: 'Insert ToC Heading',
			onclick: function() {
				editor.insertContent( '[toc]' );
			}
		});

		editor.addButton('readPDF', {
			text: 'PDF Page',
			icon: null,
			tooltip: 'Insert PDF Page Link',
			onclick: function() {
				editor.windowManager.open( {
					title: 'Insert PDF Page Number to link to',
					width: 400,
					height: 100,
					body: [
						{
							type: 'textbox',
							multiline: false,
							name: 'page'
						}
					],
					onsubmit: function( e ) {
						editor.insertContent( '[readPDF page="' + e.data.page + '"]');
					}
				});
			}
		});
	});
})();