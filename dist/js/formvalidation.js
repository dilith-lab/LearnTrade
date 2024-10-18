/*
JavaScript: Form Validation 
This file will include in scripts.inc.php

*/

// Login Page
$(function () {
  $("#login").validate({
    rules: {
      email: {
        required: true,
        email: true,
      },
      password: {
        required: true,
      },
    },
    messages: {
      email: {
        required: "Email cannot be blank",
        email: "Please enter a valid email address",
      },
      password: {
        required: "Password cannot be blank",
      },
    },
    errorElement: "span",
    errorPlacement: function (error, element) {
      error.addClass("invalid-feedback");
      element.closest(".form-group").append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass("is-invalid");
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass("is-invalid");
    },
  });
});

// Password Change Page
$(function () {
  $("#change-password").validate({
    rules: {
      password1: {
        required: true,
        minlength: 8,
        strongPassword: true,
      },
      password2: {
        required: true,
        equalTo: "#password1",
      },
    },
    messages: {
      password1: {
        required: "Password cannot be blank",
        minlength: "Password must be at least 8 characters long",
      },
      password2: {
        required: "Confirm Password cannot be blank",
        equalTo: "Passwords do not match",
      },
    },
    errorElement: "span",
    errorPlacement: function (error, element) {
      error.addClass("invalid-feedback");
      element.closest(".form-group").append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass("is-invalid");
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass("is-invalid");
    },
  });

  // Adding custom validation method
  $.validator.addMethod(
    "strongPassword",
    function (value, element) {
      return (
        this.optional(element) ||
        /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()\-_=+{};:,<.>]).{8,}$/.test(
          value
        )
      );
    },
    "Password must be at least 8 characters including 1 lowercase, 1 uppercase letter, 1 number, and 1 special character (!@#$%^&*)"
  );
});

// Profile Page
$(function () {
  $("#profile").validate({
    rules: {
      first_name: {
        required: true,
      },
      last_name: {
        required: true,
      },
      email: {
        required: true,
        email: true,
      },
      role_id: {
        required: true,
      },
      subject: {
        required: true,
      },
      skill: {
        required: true,
      },
      experience: {
        required: true,
      },
    },
    messages: {
      first_name: {
        required: "First name cannot be blank",
      },
      last_name: {
        required: "Last name cannot be blank",
      },
      email: {
        required: "Email cannot be blank",
        email: "Please enter a valid email address",
      },
      role_id: {
        required: "Please select the user role",
      },
      subject: {
        required: "Please select the subject/s",
      },
      skill: {
        required: "Skills cannot be blank",
      },
      experience: {
        required: "Experience cannot be blank",
      },
    },
    errorElement: "span",
    errorPlacement: function (error, element) {
      error.addClass("invalid-feedback");
      element.closest(".form-group").append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass("is-invalid");
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass("is-invalid");
    },
  });
});

// Register Page
$(function () {
  $("#register").validate({
    rules: {
      fname: {
        required: true,
      },
      lname: {
        required: true,
      },
      email: {
        required: true,
        email: true,
      },
      mobile: {
        required: true,
      },
      password: {
        required: true,
        minlength: 8,
        strongPassword: true,
      },
      password_confirm: {
        required: true,
        equalTo: "#password"
      },
      terms: {
        required: true,
      }
      
    },
    messages: {
      fname: {
        required: "First name cannot be blank",
      },
      lname: {
        required: "Last name cannot be blank",
      },
      email: {
        required: "Email cannot be blank",
        email: "Please enter a valid email address",
      },
      mobile: {
        required: "Mobile cannot be blank",
      },
      password: {
        required: "Password cannot be blank",
        minlength: "Password must be at least 8 characters long"
      },
      password_confirm: {
        required: "Confirm Password cannot be blank",
        equalTo: "Passwords do not match",
      },
      terms: {
        required: "Please agree the terms and conditions",
      }
    },
    errorElement: "span",
    errorPlacement: function (error, element) {
      error.addClass("invalid-feedback");
      element.closest(".form-group").append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass("is-invalid");
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass("is-invalid");
    },
  });

  // Adding custom validation method
  $.validator.addMethod(
    "strongPassword",
    function (value, element) {
      return (
        this.optional(element) ||
        /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()\-_=+{};:,<.>]).{8,}$/.test(
          value
        )
      );
    },
    "Password must be at least 8 characters including 1 lowercase, 1 uppercase letter, 1 number, and 1 special character (!@#$%^&*)"
  );

});


$(function () {
  $('[data-mask]').inputmask();
});