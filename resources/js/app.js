import './bootstrap';
import { Notyf } from 'notyf';

// Notyf global — arriba derecha
const notyf = new Notyf({
    duration: 3500,
    position: { x: 'right', y: 'top' },
    dismissible: true,
    ripple: true
});

window.notyf = notyf;

// Flash messages desde data attributes del body
const body = document.body;

if (body.dataset.flashSuccess) {
    notyf.success(body.dataset.flashSuccess);
}

if (body.dataset.flashError) {
    notyf.error(body.dataset.flashError);
}

// Loader helpers
window.showLoader = function () {
    document.getElementById('loader').classList.add('active');
};

window.hideLoader = function () {
    document.getElementById('loader').classList.remove('active');
};

// Mostrar loader al enviar cualquier form
document.querySelectorAll('form').forEach(function (form) {
    form.addEventListener('submit', function () {
        showLoader();
    });
});
