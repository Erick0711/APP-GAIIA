// const { use } = require("vue/types/umd");

/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!****************************************!*\
  !*** ./resources/assets/js/profile.js ***!
  \****************************************/
// $(document).on('click', '.edit-profile', function (event) {
//   event.preventDefault();
//   $('#pfUserId').val(loggedInUser.id);
//   $('#pfName').val(loggedInUser.nombre_pers);
//   $('#pfEmail').val(loggedInUser.email);
//   $('#edit_preview_photo').attr('src', `storage/img/${loggedInUser.avatar_url}`);
//   $('#EditProfileModal').appendTo('body').modal('show');
// });
// $(document).on('change', '#pfImage', function () {
//   var ext = $(this).val().split('.').pop().toLowerCase();
//   if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
//     $(this).val('');
//     $('#editProfileValidationErrorsBox').html('The profile image must be a file of type: jpeg, jpg, png.').show();
//   } else {
//     displayPhoto(this, '#edit_preview_photo');
//   }
// });

$(document).on('click', '.edit-profile', function (event) {
  event.preventDefault();
  $('#EditProfileModal').appendTo('body').modal('show');
  const uri = $("#btnPrEditSave").data('uri');
  const data = new FormData();
  data.append('id', loggedInUser.id);
  $.ajax({
    url: uri+"/obtenerUsuario",
    type: 'POST',
    data: data,
    processData: false,
    contentType: false,
    dataType: 'json',
    success: function success(response) {
      const { id, persona, email, avatar_url} = response;
      $('#pfUserId').val(id);
      $('#nombre_pers').val(`${persona.nombre_pers}`);
      $('#apellido_pers').val(`${persona.apellido_pers}`);
      $('#pfEmail').val(email);
      if(avatar_url.length > 0){
        $('#edit_preview_photo').attr('src', `storage/img/${avatar_url}`);
      }
      $(document).on('change', '#pfImage', function () {
      var ext = $(this).val().split('.').pop().toLowerCase();
      if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
        $(this).val('');
        $('#editProfileValidationErrorsBox').html('The profile image must be a file of type: jpeg, jpg, png.').show();
      } else {
        displayPhoto(this, '#edit_preview_photo');
      }
    });
    },
    error: function error(response) {
      // console.log(response);
    },

  });
});

window.displayPhoto = function (input, selector) {
  var displayPreview = true;
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    reader.onload = function (e) {
      var image = new Image();
      image.src = e.target.result;
      image.onload = function () {
        $(selector).attr('src', e.target.result);
        displayPreview = true;
      };
    };
    if (displayPreview) {
      reader.readAsDataURL(input.files[0]);
      $(selector).show();
    }
  }
};
$(document).on('submit', '#editProfileForm', function (event) {
  event.preventDefault();
  const uri = $("#btnPrEditSave").data('uri');
  var userId = $('#pfUserId').val();
  const formulario = new FormData(this);
  var loadingButton = jQuery(this).find('#btnPrEditSave');
  loadingButton.button('loading');
  $.ajax({
    url: uri+"/editProfile/"+userId,
    type: 'POST',
    data: formulario,
    processData: false,
    contentType: false,
    dataType: 'json',
    success: function success(response) {
    },
    error: function error(response) {
      // console.log(response);
    },
    complete: function complete() {
      loadingButton.button('reset');
      $('#EditProfileModal').modal('hide');
    }
  });
});
/******/ })()
;