import './bootstrap';

// viteだとCSSが正常に反映されないためmixに戻す
// import Alpine from 'alpinejs';
require('./bootstrap');

window.Alpine = Alpine;

Alpine.start();
