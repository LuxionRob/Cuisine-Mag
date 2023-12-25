import Alpine from 'alpinejs'
import lineChart from './dashboard/lineChart'

window.Alpine = Alpine

Alpine.start()

import $ from 'jquery'
window.$ = window.jQuery = $

require('./customSelect')
require('./product/quantity')
require('./popUp')

document.addEventListener('DOMContentLoaded', () => {
    lineChart()
})
