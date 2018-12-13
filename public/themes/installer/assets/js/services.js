$( document ).ready(function() {

    $('.submit-email').on('click', function (e) {
        e.preventDefault();

        var form = $('#email-form'), $this = $(this);

        $.post(form.attr('action'), form.serialize())
            .done(function (data) {
                window.location.href = $this.attr('href');
            })
            .fail(function ($xhr) {
                var data = $xhr.responseJSON;
                $('div').removeClass('has-error');

                $.each(data, function (idx, value) {
                    $('#'+idx).closest('.form-group').first().addClass('has-error');
                });
            });
    });

});