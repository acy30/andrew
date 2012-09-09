/**
 * Mensajes de errores advertencias informacion visto bueno
 */
/*
 * **Mensajes Informacion
 */
//*** no se cierra
function showNoticeToast(message) {
    $().toastmessage('showNoticeToast',message);
}
//***se cierra transcurrido un tiempo
function showStickyNoticeToast(message) {
    $().toastmessage('showToast', {
         text     : message,
         sticky   : true,
         position : 'top-right',
         type     : 'notice',
         closeText: '',
         close    : function () {console.log("toast is closed ...");}
    });
}
/*
 * **Mensajes visto bueno
 */
//*** no se cierra
function showSuccessToast(message) {
    $().toastmessage('showSuccessToast', message);
}
//***se cierra transcurrido un tiempo
function showStickySuccessToast(message) {
    $().toastmessage('showToast', {
        text     : message,
        sticky   : true,
        position : 'top-right',
        type     : 'success',
        closeText: '',
        close    : function () {
            console.log("toast is closed ...");
        }
    });

}
/*
 * **Mensajes errores
 */
//*** no se cierra
function showErrorToast(message) {
    $().toastmessage('showErrorToast', message);
}
//***se cierra transcurrido un tiempo
function showStickyErrorToast(message) {
    $().toastmessage('showToast', {
        text     : message,
        sticky   : true,
        position : 'top-right',
        type     : 'error',
        closeText: '',
        close    : function () {
            console.log("toast is closed ...");
        }
    });
}
/*
 * **Mensajes Informacion
 */
//*** no se cierra
function showWarningToast(message) {
    $().toastmessage('showWarningToast', message);
}
//***se cierra transcurrido un tiempo
function showStickyWarningToast(message) {
    $().toastmessage('showToast', {
        text     : message,
        sticky   : true,
        position : 'top-right',
        type     : 'warning',
        closeText: '',
        close    : function () {
            console.log("toast is closed ...");
        }
    });
}
