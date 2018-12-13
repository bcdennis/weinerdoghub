$('document').ready(function() {

    $('.onoffswitch-checkbox').on('change', function (ev) {
        var $this = $(this), isChecked = $(this).is(':checked');
        var url = $this.data('url');

        $.post(url, {active: isChecked ? 0 : 1});
    });

    $(".sortable-list").sortable({
        connectWith: ".connectList",
        update: function (event, ui) {
            var categories = $('ul.sortable-list').find('li');
            var ids = [], url = $('.sortable-list').data('url');
            categories.each(function (idx, item) {
                var id = $(item).data('id');
                ids.push(id);
            });
            $.post(url, {order: ids});
        }
    }).disableSelection();

    $('.image-modal').on('click', function () {
        var url = $(this).data('url');
        var img = $($('.modal-dialog').find('img')[0]);

        img.attr('src', url);
    });
});