import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';
import Muuri from 'muuri';
const axios = require('axios').default;


window.Alpine = Alpine;
Alpine.plugin(persist);
window.Muuri = Muuri;
window.axios = axios;

Alpine.start();
