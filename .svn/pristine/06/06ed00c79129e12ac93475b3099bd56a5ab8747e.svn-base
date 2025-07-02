
$(function () {
  'use strict';
  // Initialize the jQuery File Upload widget:
  $('#fileupload').fileupload({
    // Uncomment the following to send cross-domain cookies:
    //xhrFields: {withCredentials: true},
    url: '/File/UPload'
  });

  // Enable iframe cross-domain access via redirect option:
  $('#fileupload').fileupload(
    'option',
    'redirect',
    window.location.href.replace(/\/[^/]*$/, '/cors/result.html?%s')
  );

  if (window.location.hostname === 'blueimp.github.io') {
    // Demo settings:
    $('#fileupload').fileupload('option', {
      url: '//jquery-file-upload.appspot.com/',
      disableImageResize: /Android(?!.*Chrome)|Opera/.test(
        window.navigator.userAgent
      ),
      maxFileSize: 999000,
      acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i
    });
    // Upload server status check for browsers with CORS support:
    if ($.support.cors) {
      $.ajax({
        url: '//jquery-file-upload.appspot.com/',
        type: 'HEAD'
      }).fail(function () {
        $('<div class="alert alert-danger"></div>')
          .text('Upload server currently unavailable - ' + new Date())
          .appendTo('#fileupload');
      });
    }
  } else {
    // Load existing files:
    $('#fileupload').addClass('fileupload-processing');


    $.ajax({
      url: $('#fileupload').fileupload('option', 'url'),
      dataType: 'json',
      context: $('#fileupload')[0]
    })
      .always(function () {
        $(this).removeClass('fileupload-processing');
      })
      .done(function (result) {
        console.log(result);
        $(this)
          .fileupload('option', 'done')
          .call(this, $.Event('done'), { result: result });
      });
  }
});
