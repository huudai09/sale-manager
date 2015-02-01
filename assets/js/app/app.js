(function($, w) {
    w.Page = {
        CONTENT: '#content',
        init: function(cb) {
            cb.call(this);
        },
        setupRedirectorAction: function() {
            this.load(w.defaultModule);
            document.onclick = function(ev) {
                var target = ev.target;
                if (target.nodeName == 'A' && target.href) {
                    if ($(target).hasClass('m-link-normal'))
                        return;
                    ev.preventDefault();
                    $('.m-link.active').removeClass('active');
                    $(target).hasClass('m-link') && $(target).addClass('active');
                    Page.load(target);
                }
            };
        },
        updateURI: function(data) {
            if (this.link) {
                document.title = ('App | ' + data.title) || 'App';
                w.history.pushState(null, data.title || 'App', URL + '/' + this.link);
            }
        },
        reload: function() {
            this.hideSubframeHandler();
            this.load(location.pathname.replace(URL + '/', ''));
        },
        //
        load: function(link, type, opts) {
            var thiz = this;

            // override request options
            this.request.update_uri = opts ? opts.update_uri : true;
            this.request.container = opts ? opts.container : null;

            link && (function() {
                thiz.link = (link.nodeName == 'A' ? link.getAttribute('href') : link);
                thiz.request.send($.extend({
                    url: URL + '/' + thiz.link,
                    type: type || 'GET',
                    dataType: 'json',
                    data: {_json: 1, time: new Date().getTime()},
                    beforeSend: thiz.request.onload,
                    success: thiz.request.success
                }, opts ? (opts.ajax || {}) : {}
                ));
            }());
        },
        request: {
            loading: false, // toggle loading status
            update_uri: true, // force uri update
            container: null, // should be node object
            send: function(prop) {
                var thiz = this;
                thiz.ajax = $.ajax(prop);
            },
            onload: function() {
                Page.request.loading = true;
                Page.request.setLoader();
            },
            setLoader: function() {
                return $(Page.CONTENT)[this.loading ? 'addClass' : 'removeClass']('loading');
            },
            success: function(res) {
                var container = Page.request.container || Page.CONTENT;
                Page.request.update_uri && Page.updateURI(res);
                Page.request.setLoader((Page.request.loading = false));
                $(container).html(res.content);
                Page.runCallbacks();
            }
        }
    };

    // resize page
    $.extend(Page, {
        resizeHander: function() {
            var wH = $(w).innerHeight();
            $('#wrapper').height(wH);
        },
        resizeAction: function() {
            this.resizeHander();
            $(w).resize(this.resizeHander);
        }
    });

    // reveal 2nd frame
    // element must contains data-link attribute and has class name is `on2nd`
    $.extend(Page, {
        create2ndFrame: function() {
            return !$('.frame2nd').length
                    ? $('<div />', {'class': 'frame2nd'}).prependTo('body')
                    : $('.frame2nd');
        },
        show2ndFrameHandler: function() {
            var data = $(this).data();
            var frame = Page.create2ndFrame();
            $(this).toggleClass('active');
            frame.toggleClass('active');
            data.link && Page.load(data.link, null, {
                update_uri: false,
                container: frame[0]
            });
        },
        show2ndFrameAction: function() {
            $(document).on('click.show2ndFrame', '.on2nd', this.show2ndFrameHandler);
        }
    });


    // hide all subframes
    $.extend(Page, {
        hideSubframeHandler: function() {
            $('.frame2nd.active').removeClass('active');
        },
        hideSubframeAction: function() {
            $('#wrapper').click(this.hideSubframeHandler);
        }
    });

    // setup callbacks
    $.extend(Page, {
        cbs: {},
        setCallbacks: function(n, c, b) {
            this.cbs[n] = {
                fn: c,
                live: b || false
            };
        },
        setLiveCallbacks: function(n, c) {
            this.setCallbacks(n, c, true);
        },
        runCallbacks: function(ctx) {
            for (var x in this.cbs) {
                if (this.cbs.hasOwnProperty(x)) {
                    this.cbs[x].fn.call(ctx || document) && this.cbs[x].live && (delete this.cbs[x]);
                }
            }
        }
    });

    // initialize
    $(function() {
        Page.init(function() {
            for (var x in this) {
                (x.indexOf('Action') > 0) && this[x]();
            }
        });
    });

}(jQuery, window));