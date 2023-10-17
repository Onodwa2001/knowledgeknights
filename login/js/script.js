// Password criteria - Check whether the user meet the password requirement
$('#id_password').on('focus', function() {
    $('.password_required').slideDown();
 })
 
 $('#id_password').on('blur', function() {
    $('.password_required').slideUp();
 })
 
 $('#id_password').on('keyup', function() {
    passValue = $(this).val();
    if (passValue.match(/[a-z]/g)) {
       $('.lowercase').addClass('active');
    } else {
       $('.lowercase').removeClass('active');
    }
 
    if (passValue.match(/[A-Z]/g)) {
       $('.capital').addClass('active');
    } else {
       $('.capital').removeClass('active');
    }
 
    if (passValue.match(/[0-9]/g)) {
       $('.number').addClass('active');
    } else {
       $('.number').removeClass('active');
    }
 
    if (passValue.match(/[!@#$%^&*]/g)) {
       $('.special-characters').addClass('active');
    } else {
       $('.special-characters').removeClass('active');
    }
    if (passValue.length == 8 || passValue.length > 8) {
       $('.eight-characters').addClass('active');
    } else {
       $('.eight-characters').removeClass('active');
    }
 });
// Password Visibility
const togglePassword = document.querySelector('#togglePassword');
const password = document.querySelector('#id_password');

togglePassword.addEventListener('click', function (e) {
    // toggle the type attribute
    const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
    password.setAttribute('type', type);
    // toggle the eye slash icon
    this.classList.toggle('fa-eye-slash');
});
 
$(document).ready(function () {
   $('.js-example-basic-multiple').select2();
});



