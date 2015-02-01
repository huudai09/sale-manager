(function($) {
    Page.setCallbacks('AsyncFormRequest', function() {
        $(this).find('.aform').filter(':not(.ajax-form-done)').each(function() {
            $(this).on('submit', function(ev) {
                var data = new FormData(this), thiz = $(this);
                ev.preventDefault();
                data.append('_json', 1);
                if (this.requesting)
                    return;

                this.requesting = true;

                $.ajax({
                    url: this.action,
                    type: this.method || 'POST',
                    data: data,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    beforeSend: function() {
//                        $('.bubblingG').toggleClass('show');
                        thiz.css('opacity', '.3');
                    },
                    error: function() {
                        thiz[0].requesting = false;
//                        $('.bubblingG').toggleClass('show');
                        thiz.css('opacity', '1');
                    },
                    success: function(res) {
//                        $('.bubblingG').toggleClass('show');
                        thiz.css('opacity', '1');
                        thiz[0].requesting = false;

                        if (res.reload) {
                            Page.reload();
                            return;
                        }

//                        var errorDiv = !thiz.find('.error').length
//                                ? $('<div />', {'class': 'error'}).prependTo(thiz[0])
//                                : thiz.find('.error');
//
//                        var successDiv = !body.find('.success').length
//                                ? $('<div />', {'class': 'success'}).prependTo(body[0])
//                                : body.find('.success');
//
//                        if (res.alert) {
//                            errorDiv.empty().html(res.alert).removeClass('blur');
//                            return;
//                        }
//
//                        thiz.addClass('short');
//                        thiz.find('input').prop('readonly', 'readonly');
//                        thiz.find('.domain-address').html('<strong>http://' + thiz.find('input[name="store_domain"]').val() + '.1shop.com.vn</strong>');
//                        if (res.success) {
//                            successDiv.empty().html(res.success);
//                        }

                    }
                });
            }).addClass('ajax-form-done');

        });
    });
}(jQuery));