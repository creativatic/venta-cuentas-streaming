import Alpine from 'alpinejs';
window.Alpine = Alpine;
import 'bootstrap';

import Swal from 'sweetalert2';
// Hacer disponible Swal globalmente (opcional)
window.Swal = Swal;

import toastr from 'toastr';
import 'toastr/build/toastr.min.css';

Alpine.start();
