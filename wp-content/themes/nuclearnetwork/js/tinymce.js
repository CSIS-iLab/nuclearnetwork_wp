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
	});
})();