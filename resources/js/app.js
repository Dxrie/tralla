import jQuery from 'jquery';
window.$ = window.jQuery = jQuery;

import './bootstrap';
import 'bootstrap';

import { Livewire, Alpine } from '../../vendor/livewire/livewire/dist/livewire.esm';
import Clipboard from '@ryangjchandler/alpine-clipboard'
 
Alpine.plugin(Clipboard)
 
Livewire.start()