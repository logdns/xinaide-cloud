(function ($) {
  'use strict';

  $(document).on('click', '.xinaide-media-button', function () {
    var button = $(this);
    var target = $('#' + button.data('target'));
    var frame = wp.media({ title: '选择图片', button: { text: '使用这张图片' }, multiple: false });

    frame.on('select', function () {
      var attachment = frame.state().get('selection').first().toJSON();
      target.val(attachment.url).trigger('change');
      target.closest('.xinaide-field').find('.xinaide-media-preview').html('<img src="' + attachment.url + '" alt="">');
    });

    frame.open();
  });
})(jQuery);

