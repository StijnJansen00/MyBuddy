(function ($) {
    "use strict";


    /*==================================================================
    [ Focus input ]*/
    $('.input100').each(function () {
        $(this).on('blur', function () {
            if ($(this).val().trim() != "") {
                $(this).addClass('has-val');
            } else {
                $(this).removeClass('has-val');
            }
        })
    })


    /*==================================================================
    [ Validate ]*/
    var input = $('.validate-input .input100');

    $('.validate-form').on('submit', function () {
        var check = true;

        for (var i = 0; i < input.length; i++) {
            if (validate(input[i]) == false) {
                showValidate(input[i]);
                check = false;
            }
        }

        return check;
    });


    $('.validate-form .input100').each(function () {
        $(this).focus(function () {
            hideValidate(this);
        });
    });

    function validate(input) {
        if ($(input).attr('type') == 'email' || $(input).attr('name') == 'email') {
            if ($(input).val().trim().match(/^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/) == null) {
                return false;
            }
        } else {
            if ($(input).val().trim() == '') {
                return false;
            }
        }
    }

    function showValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).addClass('alert-validate');
    }

    function hideValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).removeClass('alert-validate');
    }

    /*==================================================================
    [ Show pass ]*/
    var showPass = 0;
    $('.btn-show-pass').on('click', function () {
        if (showPass == 0) {
            $(this).next('input').attr('type', 'text');
            $(this).addClass('active');
            showPass = 1;
        } else {
            $(this).next('input').attr('type', 'password');
            $(this).removeClass('active');
            showPass = 0;
        }

    });


})(jQuery);


$(document).ready(function () {

    $('#grouptable tr').click(function () {
        var href = $(this).find("a").attr("href");
        if (href) {
            window.location = href;
        }
    });

});

(function () {
    'use strict';

    if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
        var msViewportStyle = document.createElement('style');
        msViewportStyle.appendChild(
            document.createTextNode(
                '@-ms-viewport{width:auto!important}'
            )
        );
        document.head.appendChild(msViewportStyle)
    }

}());


function plus(button) {


    const div = button.parentNode,
        counter = div.getElementsByClassName("counter")[0];
    counter.value++;

    devideamount()
}

function min(button) {

    const div = button.parentNode,
        counter = div.getElementsByClassName("counter")[0];
    if (counter.value < 1) return;
    counter.value--;

    devideamount()
}

function devideamount() {

    const counters = document.getElementsByClassName("counter"),
        amount = document.getElementById("amount").value,
        output = document.getElementsByClassName("output");

    let parts = 0;

    for (let i = 0; i < counters.length; i++) {

        parts += parseInt(counters[i].value);
    }

    const priceperpart = amount / parts;

    for (let i = 0; i < output.length; i++) {

        const counter = output[i].parentElement.getElementsByClassName('buttons')[0].getElementsByClassName('counter')[0].value;
        const rounded = Math.round((priceperpart * counter) * 100) / 100;

        output[i].value = rounded;
    }

    centcheck()
}

function centcheck() {

    const output = document.getElementsByClassName("output"),
        amount = document.getElementById("amount").value;

    let total = 0;
    let verschil = 0;

    for (let i = 0; i < output.length; i++) {
        total = total + parseFloat(output[i].value)
    }


    if (total > amount) {

        verschil = total - amount;

        const rounded = Math.round((output[0].value - verschil) * 100) / 100;

        output[0].value = rounded
    }

    if(amount > total){

        verschil = amount - total;

        const rounded = Math.round((output[0].value) * 100) / 100;

        let number = rounded + verschil;

        output[0].value = number.toFixed(2);
    }
}