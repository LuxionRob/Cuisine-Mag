import Alpine from 'alpinejs'

window.Alpine = Alpine

Alpine.start()

import $ from 'jquery'
window.$ = window.jQuery = $

require('./customSelect')
require('./product/quantity')
require('./popUp')
require('./user/create')
