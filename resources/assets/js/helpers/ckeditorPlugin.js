function CaptureKeys( editor ) {
    editor.editing.document.view.on( 'keydown', ( evt, data ) => {
        console.log( data );
        console.log( 'Pressed key: ' + data.domEvent.key );

        // Do something on keydown...
    })
};