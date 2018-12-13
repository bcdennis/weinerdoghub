/**
 * @author: Bitempest.com Team
 * @version: 2.0.0
 */

/**
 * Reset errors from the form before adding the new errors from the ajax request
 *
 * @param form
 */
function resetForm(form) {
    var captcha = form.find('.g-recaptcha').length;

    if(captcha) {
        grecaptcha.reset();
    }

    form.find('.text-error').remove().end()
        .find('.has-error').removeClass('has-error');
}

/**
 * Add errors to the form in depending the error form laravel
 *
 * @param form
 * @param data
 */
function addErrors(form, data) {
    $.each(data, function (idx, item) {
        var div = form.find('.'+idx);
        div.addClass('has-error');
        div.append('<span class="text-error">'+item+'</span>');
    });
}

/**
 * Events listeners
 */

$('#login-form').on('click', 'button', function (event) {
    event.preventDefault();

    var form = $( "#login-form" );

    $.post( form.attr('action'), form.serialize())
        .done(function (data) {
            window.location.href = $('meta[name="root"]').attr('content');
        })
        .fail(function ($xhr) {
            var data = $xhr.responseJSON;
            resetForm(form);
            addErrors(form, data);
        });
    return false;
});

$('#register-form').on('click', 'button', function (event) {
    event.preventDefault();

    var form = $( "#register-form" );

    $.post(form.attr('action'), form.serialize())
        .done(function (data) {
            window.location.href = data.to;
        })
        .fail(function ($xhr) {
            var data = $xhr.responseJSON;
            resetForm(form);
            addErrors(form, data);
        });
    return false;
});

$('.btn-edit-post').on('click', function (ev) {
    var btn = $(this);

    $.get(btn.data('info')).done(function(data) {
        var form = $('#edit-post-form');
        form.attr('action', btn.data('edit'));
        $('#edit-title').val(data.title);
        $('#edit-description').val(data.description);

        var categories = '';

        $.each(data.categories, function (idx, item) {
            if (item.template == '' || item.template == 'nsfw') {
                categories += item.slug + ",";
                $('.c-'+item.id).attr('checked', true);
            }
        });
        $('.cts').text(categories);

    }).fail(function () {
        location.reload();
    });
});

$('#edit-post-form').on('click', 'button', function (event) {
    event.preventDefault();

    var btn = $(this), form = $('#edit-post-form');

    if ( ! btn.hasClass('loading')) {
        btn.addClass('loading');
        $.post(form.attr('action'), form.serialize())
            .done(function (data) {
                window.location.href = data.to;
            })
            .fail(function ($xhr) {
                var data = $xhr.responseJSON;
                btn.removeClass('loading');
                resetForm(form);
                addErrors(form, data);
            });
    }
    return false;
});

$('#file-upload-form').on('click', 'button', function (event) {
    event.preventDefault();

    var formData, btn = $(this), form = $( "#file-upload-form" )[0], $this = $(form);

    if (typeof(FormData) == 'undefined') {
        formData = new FormDataCompatibility(form);
    } else {
        formData = new FormData(form);
    }

    form = $(form);

    if ( ! btn.hasClass('loading')) {
        btn.addClass('loading');
        $.ajax({
            url: $this.attr('action'),
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false
        }).done(function (data) {
            window.location.href = data.to;
        }).fail(function ($xhr) {
            var data = $xhr.responseJSON;
            btn.removeClass('loading');
            resetForm(form);
            addErrors(form, data);
        });
    }
    return false;
});

$('#list-upload-form').on('click', 'button.make-list', function (event) {
    event.preventDefault();

    var formData, btn = $(this),
        form = $( "#list-upload-form" )[0],
        $this = $(form);

    if (typeof(FormData) == 'undefined') {
        formData = new FormDataCompatibility(form);
    } else {
        formData = new FormData(form);
    }

    form = $(form);

    if ( ! btn.hasClass('loading')) {
        btn.addClass('loading');
        $.ajax({
            url: $this.attr('action'),
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false
        }).done(function (data) {
            window.location.href = data.to;
        }).fail(function ($xhr) {
            var data = $xhr.responseJSON;
            btn.removeClass('loading');
            resetForm(form);

            var items = form.find('.list-item-container');

            $.each(data, function (idx, item) {
                var div = null;
                if (idx.search('items.') != -1) {
                    idx = idx.split('.');
                    var itemId = idx[1],
                        itemField = idx[2],
                        listItem = $(items[itemId]);
                    div = listItem.find('.'+itemField);
                } else {
                    div = form.find('.list-form .'+idx);
                }
                div.addClass('has-error');
                div.append('<span class="text-error">'+item+'</span>');
            });

        });
    }

    return false;
});

$('#url-upload-form').on('click', 'button', function (event) {
    event.preventDefault();

    var btn = $(this), form = $('#url-upload-form');

    if ( ! btn.hasClass('loading')) {
        btn.addClass('loading');
        $.post(form.attr('action'), form.serialize())
            .done(function (data) {
                window.location.href = data.to;
            })
            .fail(function ($xhr) {
                var data = $xhr.responseJSON;
                btn.removeClass('loading');
                resetForm(form);
                addErrors(form, data);
            });
    }
    return false;
});

function like(container) {
    $('.'+container).on('click', '.like', function (event) {
        event.preventDefault();

        var btn = $(this);

        $.post(btn.data('url'), {value: 1})
            .done(function (data) {
                var closestDiv = btn.closest('div');
                $('.'+container).find('.smiles-number-'+data.id).text(data.points);
                btn.toggleClass('active');
                $(closestDiv.find('button.dislike')).removeClass('active');
            })
            .fail(function ($xhr) {
                var status = $xhr.status;

            });
    });
}

function dislike(container)
{
    $('.'+container).on('click', '.dislike', function (event) {
        event.preventDefault();

        var btn = $(this);

        $.post(btn.data('url'), {value: -1})
            .done(function (data) {
                var closestDiv = btn.closest('div');
                $('.'+container).find('.smiles-number-'+data.id).text(data.points);
                btn.toggleClass('active');
                $(closestDiv.find('button.like')).removeClass('active');
            });
    });
}

like('posts');
dislike('posts');

like('post');
dislike('post');

/**
 * Increment the total number of comments
 */
function incrementTotalComments() {
    var totalComments = $('.total-comments');
    var total = Number(totalComments.text());
    totalComments.text(total + 1);
}

/**
 * Decrement the total number of comments
 */
function decrementTotalComments() {
    var totalComments = $('.total-comments');
    var total = Number(totalComments.text());

    if (total - 1 < 0) {
        total = 1;
    }
    totalComments.text(total - 1);
}

var replyHandler = function (e) {
    e.preventDefault();

    var $this = $(this), replyForm;
    var cancelStr = $('meta[name="lang.cancel"]').attr('content');
    var thisComment = $this.closest('.comment'),
        replyWrapper = $('<div class="comment reply-form"></div>'),
        cancelBtn = $('<button type="button" class="btn btn-text btn-cancel">'+cancelStr+'</button>');
    replyForm = $('.comments-wrapper').find('form').first().clone();

    var parent_id = $this.data('parent'),
        id = $this.data('id'), post = $this.data('post');

    $this.prop('disabled', true);

    if(thisComment.hasClass('reply-comment')) {
        $(replyWrapper).addClass('reply-comment');
    }

    replyForm.prepend($('<input type="hidden" name="parent_id" value="'+parent_id+'">'));
    replyForm.attr('id', 'comment-form-'+parent_id+'-'+id);
    replyForm.find('.right').prepend(cancelBtn);
    replyForm.find('textarea').val('@'+$this.data('name')+' ');

    thisComment.after(replyWrapper.append(replyForm));

    var parentForm = $('#comment-form-'+parent_id+'-'+id);

    parentForm.find('.submit-btn').on('click', function (e) {
        e.preventDefault();

        $.post(parentForm.attr('action'), parentForm.serialize())
            .done(function (data) {
                parentForm.closest('.reply-form').replaceWith(data.partial);
                $this.prop('disabled', false);

                incrementTotalComments();
            })
            .fail(function ($xhr) {
                var data = $xhr.responseJSON;
                parentForm.find('textarea').addClass('error');
            });
    });

    $('.btn-cancel').on('click', function(e) {
        e.preventDefault();

        $(this).closest('.comment').remove();
        $this.prop('disabled', false);
    });
};

$('.main-comment').find('.submit-btn').on('click', function (e) {
    e.preventDefault();

    var form = $(this).closest('form');
    var post = $('.comments').data('post');

    $.post(form.attr('action'), form.serialize())
        .done(function (data) {
            var message = form.find('textarea');
            $('.comments').prepend(data.partial);
            message.removeClass('error');
            message.val('');

            incrementTotalComments();
        })
        .fail(function ($xhr) {
            var data = $xhr.responseJSON;
            form.find('textarea').addClass('error');
        });
});

$('.comments').on('click', '.btn-reply-comm', replyHandler);

$('#delete-account-form').on('click', 'button', function (e) {
    e.preventDefault();

    var form = $('#delete-account-form');

    $.post(form.attr('action'), form.serialize())
        .done(function (data) {
            window.location.href = $('meta[name="root"]').attr('content');;
        })
        .fail(function ($xhr) {
            var input = $('#delete-account-form').find('input');
            input.addClass('error');
            input.val('');
        });
});

$(window).load(function() {

    like('comments');
    dislike('comments');

    var comments = $('.comments');

    comments.on('click','.report', function (ev) {
        ev.preventDefault();

        var $this = $(this);

        $.post($this.data('url')).done(function () {
            var comment;
            if ($this.data('type') == 'parent') {
                var parentStr = 'parent_'+$this.data('id');
                comment = $('#block_'+parentStr);
                $('#'+parentStr).remove();
                comment.remove();
                decrementTotalComments();
            } else {
                comment = $('#comment-'+$this.data('id'));
                comment.remove();
            }
        });
    });

    comments.on('click','.delete', function (ev) {
        ev.preventDefault();
        var $this = $(this);

        $.post($this.data('url')).done(function () {
            var comment;
            if ($this.data('type') == 'parent') {
                var parentStr = 'parent_'+$this.data('id');
                comment = $('#block_'+parentStr);
                $('#'+parentStr).remove();
                comment.remove();
                decrementTotalComments();
            } else {
                comment = $('#comment-'+$this.data('id'));
                comment.remove();
            }
        });
    });

    comments.on('click', '.more', function (event) {
        event.preventDefault();

        var $this = $(this);
        var last = $this.data('last') == undefined ? 0 : $this.data('last');

        $.get($this.data('url')+'?last='+last)
            .done(function (data) {
                var parent = $('.more-'+$this.data('parent'));
                $this.data("last", parseInt(data.last));
                if (data.total > 0) {
                    parent.before(data.partial);
                }
                if ( ! data.hasMore) {
                    parent.remove();
                }
            });
    });

    var loading = $('.loading-comments');

    if (comments.data('url')) {
        comments.infiniteScrollHelper({
            loadMore: function(page, done) {
                page = page - 1;
                var url = comments.data('url') + '?ajax=yes&page='+page;

                $.getJSON(url, function(data) {
                    if (page >= data.last + 1 || data.total == 0) {
                        loading.remove();
                        return false;
                    }
                    loading.before(data.partial);
                    done();
                });
            },
            bottomBuffer: 80,
            debounceInt: 10
        });
    }

    $('.posts').infiniteScrollHelper({
        loadMore: function(page, done) {
            var posts = $('.posts'),
                url = posts.data('url') + '/?ajax=yes&page='+page;

            if (posts.hasClass('search')) {
                url += '&q='+encodeURIComponent(posts.data('q'));
            }

            $.getJSON(url, function(data) {
                if (data.total != 0) {
                    posts.append(data.partial);
                    FB.XFBML.parse();
                }
                if (page >= data.last + 1 || data.total == 0) {
                    return false;
                }
                done();
            });
        },
        bottomBuffer: 80,
        debounceInt: 10
    });

    var notif = $('.notif');

    notif.infiniteScrollHelper({
        loadMore: function(page, done) {
            var url = notif.data('url') + '/?ajax=yes&page='+page;

            $.getJSON(url, function(data) {
                if (data.total != 0) {
                    notif.append(data.partial);
                }
                if (page >= data.last + 1 || data.total == 0) {
                    return false;
                }
                done();
            });
        },
        bottomBuffer: 80,
        debounceInt: 10
    });

    $('.posts,.post').on('click', '.post-wrapper', function () {
        var div = $(this);
        var img = div.find('.gif-player');

        if (img.length == 0) {
            return true;
        }

        if (div.hasClass('gif')) {
            img.data('preview', img.attr('src'));
            img.attr('src', img.data('gif'));
            div.removeClass('gif');
        } else {
            div.addClass('gif');
            img.attr('src', img.data('preview'));
        }
    });
    $('.submit-report').on('click', function (e) {
        e.preventDefault();

        var form = $('#report-post-form'), $this = $(this);

        $.post(form.attr('action'), form.serialize())
            .always(function (data) {
                window.location.href = $this.data('redirect');
            });
    });

    $('.posts,.post').on('click', '.share-btn', function (e) {
        e.preventDefault();
        var $this = $(this),
            settings = 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=400,width=600';

        window.open($this.attr('href'), '_blank', settings);
    });

});

