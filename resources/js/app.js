require('./bootstrap')
require('../js/product/quantity');

import Alpine from 'alpinejs'

window.Alpine = Alpine

Alpine.start()

import $ from 'jquery'
window.$ = window.jQuery = $

$('[data-confirm]').on('click', function (e) {
    var message = $(this).data('confirm')

    if (!confirm(message)) {
        e.preventDefault()
        e.stopImmediatePropagation()
    }
})

require('./customSelect')
