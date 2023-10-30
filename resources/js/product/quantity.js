import $ from "jquery";

document.addEventListener("DOMContentLoaded", function () {
    const minusBtns = document.querySelectorAll(".minus-btn");
    const plusBtns = document.querySelectorAll(".plus-btn");
    const quantityInputs = document.querySelectorAll(".quantity-input");

    minusBtns.forEach(minusBtn => {
        minusBtn.addEventListener("click", function () {
            let quantityInput = this.parentNode.querySelector(".quantity-input");
            let currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        });
    });

    plusBtns.forEach(plusBtn => {
        plusBtn.addEventListener("click", function () {
            let quantityInput = this.parentNode.querySelector(".quantity-input");
            let currentValue = parseInt(quantityInput.value);
            let max = parseInt(quantityInput.getAttribute("data-max"));
            if (currentValue < max) {
                quantityInput.value = currentValue + 1;
            }
        });
    });

});

