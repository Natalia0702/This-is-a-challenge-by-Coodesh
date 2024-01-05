import Toastify from 'toastify-js';

export const toast = {
    success(message, className = '', style = null) {
        Toastify({
            text: message,
            className: className,
            style: style ? style : {
                background: "linear-gradient(to right, #00b09b, #96c93d)",
            }
        }).showToast();
    },
    error(message, className = '', style = null) {
        Toastify({
            text: message,
            className: className,
            style: style ? style : {
                background: "linear-gradient(to right, #96b09b, #963535)",
            }
        }).showToast();
    },
    info(message, className = '', style = null) {
        Toastify({
            text: message,
            className: className,
            style: style ? style : {}
        }).showToast();
    },
    Toastify,
}
