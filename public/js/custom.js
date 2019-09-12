
// jQuery validator defaults
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

// Sweet Alert
function swAlert(status, message, options = {}) {

  // Verify if has an alert opened, if yes, close it
  let swState = swal.getState();
  if (swState.isOpen) swal.close();

  if (message == null) return;

  const { timer } = options;

  // Replace all <br> to \n
  message = String(message).replace('<br>', '\n');

  swal({
    title: (status == 'success') ? 'Success!' : 'An error has occurred =(',
    icon: status,
    text: message,
    timer: (timer) ? timer : (status == 'error') ? false : 4500,
    button: (status == 'success') ? false : { className: 'default' },
    ...options
  });
}

function swConfirm(message, options = {}) {

  return new Promise(async (resolve) => {

    const res = await swal({
      icon: 'warning',
      text: message,
      closeOnClickOutside: false,
      buttons: {
        cancel: 'No',
        confirm: {
          text: 'Yes',
          closeModal: false
        }
      },
      ...options,
    });

    if (res) $('.swal-button--cancel').hide(100);
    resolve(res);

  });

}
