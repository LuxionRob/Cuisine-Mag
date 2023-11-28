trigger = $('.select .trigger')
options = $('.select .option')
contactInput = $('#contact-input')

trigger.on('click', function (e) {
    e.stopPropagation()
    trigger.hide()

    options.show()
})

options.on('click', function (e) {
    trigger.show()
    console.log(this.children, trigger.children())

    trigger.children().replaceWith($(this.children).clone())
    contactInput.attr('value', this.value)
    options.hide()
})

$(document).on('click', function (e) {
    trigger.show()
    options.hide()
})
