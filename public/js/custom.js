jQuery.validator.setDefaults({
  highlight: (element) => {
    jQuery(element)
      .closest('.form-control')
      .addClass('is-invalid')
      .removeClass('is-valid');
  },
  unhighlight: (element) => {
    jQuery(element)
      .closest('.form-control')
      .addClass('is-valid')
      .removeClass('is-invalid');
  },
  errorElement: 'span',
  errorClass: 'invalid-feedback',
  errorPlacement: (error, element) => {
    if (element.parent('.form-control').length)
      error.insertAfter(element.parent());
    else
      error.insertAfter(element);
  }
});
