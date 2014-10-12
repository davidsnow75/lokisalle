/**
 * TOGGLERS
 *
 * Ajoute/retire la classe 'active' à un élément du DOM au clic sur celui qui porte
 * la classe 'js-toggle'
 */

(function () {
    'use strict';

    var togglers,
        togglersNb,
        i;

    togglers = document.querySelectorAll('.js-toggle');
    togglersNb = togglers.length;

    for (i = 0; i < togglersNb; i += 1) {
        togglers[i].addEventListener('click', function () {
            document.querySelector(this.getAttribute('href')).classList.toggle('active');
            this.classList.toggle('active');
        });
    }
}());

