$(document).ready(function() {

  /** Contact Us **/
  var cForm = $('#contactUs').validate({
    debug: false,
    errorClass: "notValid",
    validClass: "isValid",
    errorElement: "div",
    highlight: function (element, errorClass, validClass) {
      $(element).closest('.form-control').addClass(errorClass).removeClass(validClass);
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).closest('.form-control').removeClass(errorClass).addClass(validClass);
    },
    focusCleanup: false,
    rules: {
      cName: {
          required: true,
          minlength: 2,
          maxlength: 30
      },
      cEmail: {
          required: true,
          email: true
      },
      cPhone: {
          required: true,
          phoneUS: true
      },
      cMessage: {
          required: true,
          maxlength: 500
      },
      cCheck: {
          required: true,
          minlength: 5
      }
    },
    messages: {
      cName: {
        required: "Name is required!",
        minlength: "Name must be at least 2 letters!",
        maxlength: "Max characters exceeded!"
      },
      cEmail: {
        required: "E-mail address is required!",
        email: "Enter a valid e-mail address!"
      },
      cPhone: {
        required: "Phone number is required!",
        phoneUS: "USA Phone Format: 555-555-5555"
      },
      cMessage: {
        required: "Message is required!",
        maxlength: "Message must be under 500 characters!"
      },
      cCheck: {
        required: "An answer is required!",
        minlength: "Ok, now put Elite as your answer instead of 4. Your answer was 4, right?"
      }
    }
  });

  var allowed = 1;
  var regex = "/https?:\/\/[\-A-Za-z0-9+&@#\/%?=~_|$!:,.;]*/g";

  $('#cMessage').on('input', function() {
    var textArea = $(this).val().match(regex);

    if (textArea && textArea.length > allowed) {
      $('#sendBtn').prop("disabled", true);
    } else {
      $('#sendBtn').prop("disabled", false);
    }
  });

  /** On Form Submit **/
  $('#contactUs').on('submit', function(e) {

    /** If NOT Prevented By Validator **/
    if (!e.isDefaultPrevented()) {

      e.preventDefault();
      e.stopImmediatePropagation();

      /** URL **/
      var url = '/contact-us';

      /** Serialize Form **/
      var formData = $(this).serialize();

      /** AJAX POST **/
      $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        success: function (result, status, xhr) {
          var alertType = 'alert-' + result.type;
          var alertMsg = result.message;
          var alertBox = '<div class="alert ' + alertType + ' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>' + alertMsg + '</div>';
          $('#contactUs').find('#messages').html(alertBox);
          $('#contactUs')[0].reset();
        }
      });
    }
  });

  /** Reset Button **/
  $('input#resetBtn').click(function (e) {
    cForm.resetForm();
  });

});
