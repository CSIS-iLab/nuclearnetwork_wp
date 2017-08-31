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
			tooltip: 'Insert Table of Contents',
			onclick: function() {
				editor.windowManager.open( {
					title: 'Insert Table of Contents',
					width: 400,
					height: 225,
					body: [
						{
							type: 'textbox',
							multiline: true,
							name: 'toc',
							rows: 10
						},
					],
					onsubmit: function( e ) {
						editor.insertContent( '[toc]' + e.data.toc + '[/toc]');
					}
				});
			}
		});
	});
})();