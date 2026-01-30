import jQuery from 'jquery';
import Swal from 'sweetalert2';

window.$ = window.jQuery = jQuery;
window.Swal = Swal;

import './bootstrap';
import 'bootstrap';

import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import Clipboard from '@ryangjchandler/alpine-clipboard'
 
Alpine.plugin(Clipboard)
 
Livewire.start()