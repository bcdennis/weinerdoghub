(function (jQuery, window, document) {

    var smileUx = {

        init: function () {
            // Check for ie10
            if (Function('/*@cc_on return document.documentMode===10@*/')()) {
                document.documentElement.className += 'ie10';
            }

            // Social Media Tabs
            $('.social-tabs li').on('click', function (e) {
                e.preventDefault();

                var thisTab = $(this),
                    allTabs = $('.social-tabs li'),
                    tabContent = $('.social-tab-content');

                smileUx.tabs(thisTab, allTabs, tabContent);
            });

            // Comments Tabs
            $('.comments-tabs li').on('click', function (e) {
                e.preventDefault();

                var thisTab = $(this),
                    allTabs = $('.comments-tabs li'),
                    tabContent = $('.comments-tab-content');

                smileUx.tabs(thisTab, allTabs, tabContent);
            });

            // List Items Tabs
            $('.item-upload-tabs li').on('click', function (e) {
                e.preventDefault();

                var thisTab = $(this),
                    thisContext = thisTab.closest('div'),
                    allTabs = thisContext.find('.item-upload-tabs li'),
                    tabContent = thisContext.find('.item-upload-content');

                smileUx.tabs(thisTab, allTabs, tabContent);
            });

            // More Categories Dropdown
            $('.btn-more-categories').on('click', function (e) {
                smileUx.dropDown(e, $('.more-menu-items'));
            });

            // Popular Categories Dropdown
            $('.btn-more-popular').on('click', function (e) {
                smileUx.dropDown(e, $('.popular-menu-items'));
            });

            // Notifications Dropdown
            $('.btn-notifications').on('click', function (e) {
                smileUx.dropDown(e, $('.notifications-dropdown'));
            });

            // Upload Ways Dropdown
            $('.btn-upload-ways').on('click', function (e) {
                smileUx.dropDown(e, $('.upload-ways.dropdown'));
            });

            // Comment Actions Dropdown
            $('.comments').on('click', '.btn-comm-actions', function (e) {
                smileUx.dropDown(e, $(this).next());
            });

            // Sticky Navigation
            smileUx.makeSticky();

            // Mobile Menu
            $('.btn-mobile-menu').on('click', function (e) {
                var trigger = $(this),
                    menu = $('.mobile-menu');

                smileUx.mobileMenus(e, trigger, menu);
            });

            // Mobile Categories
            $('.btn-mobile-categories').on('click', function (e) {
                var trigger = $(this),
                    menu = $('.mobile-categories');

                smileUx.mobileMenus(e, trigger, menu);
            });

            // Modals
            $('.modal-trigger').on('click', smileUx.modals);

            // Dropdown Checkbox
            $('.modal-upload-url').on('click', '.dropdown-checkboxes', function () {
                smileUx.dropdownCheckbox($('.modal-upload-url .dropdown-checkboxes-wrapper'));
            });
            $('.modal-upload-file').on('click', '.dropdown-checkboxes', function () {
                smileUx.dropdownCheckbox($('.modal-upload-file .dropdown-checkboxes-wrapper'));
            });
            $('.modal-edit-post').on('click', '.dropdown-checkboxes', function () {
                smileUx.dropdownCheckbox($('.modal-edit-post .dropdown-checkboxes-wrapper'));
            });
            $('.list-category').on('click', '.dropdown-checkboxes', function () {
                smileUx.dropdownCheckbox($('.list-category.dropdown-checkboxes-wrapper'));
            });

            // Add description
            $('.upload-footer .description-checkbox').change(function () {
                $(this).closest('form').find('.post-description').toggleClass('hide');
            });

            // Share Buttons
            $('.posts').on('click', 'button.share', smileUx.shareButtons);

            // Go Top
            smileUx.goTop();

            // Show Search
            $('.btn-trigger-search').on('click', smileUx.activateSearch);

            // Make Lists
            smileUx.listFunctionality();

            // Temporarily Solution
            if ($('.comments-tabs li').length >= 2) {
                $('.comments-tabs').css({'text-align': 'center'});
            } else {
                $('.comments-tabs li.active').css({
                    'border': 'none',
                    'background': 'none'
                });
            }
        },

        tabs: function (thisTab, allTabs, tabContent) {
            thisTab.addClass('active');
            allTabs.not(thisTab).removeClass('active');

            var thisTabClass = thisTab.attr('class').split(' ')[0];
            tabContent.find('.active').removeClass('active');
            tabContent.find('.' + thisTabClass).addClass('active');
        },

        dropDown: function (e, menuToDrop) {
            e.preventDefault();
            e.stopPropagation();

            menuToDrop.toggle();
            $('.dropdown').not(menuToDrop).hide();

            $(document).on('click', function () {
                menuToDrop.hide();
            });
        },

        makeSticky: function () {
            var $window = $(window),
                stickyEl = $('.menu'),
                stickyElTop = stickyEl.offset().top;

            $window.scroll(function () {
                stickyEl.toggleClass('fixed', $window.scrollTop() > stickyElTop);
            });
        },

        mobileMenus: function (e, trigger, menu) {
            e.preventDefault();
            e.stopPropagation();

            var triggerClass = trigger.attr('class'),
                menuClass = menu.attr('class'),
                exceptThis = '.' + triggerClass + ',' + '.' + menuClass;

            menu.toggle();

            $('body').on('click touchstart', function (ev) {
                if ($(ev.target).closest(exceptThis).length) {
                    return;
                } else {
                    menu.hide();
                }
            });

            $(window).resize(function () {
                if ($(this).width() > 750) {
                    menu.hide();
                }
            });
        },

        modals: function (e) {
            e.preventDefault();

            var thisModal = $(this).data('target');

            open($(thisModal));

            // Close modal when close button or modal backdrop are clicked
            $('.modal-close, .modal-backdrop').on('click', function (e) {
                e.preventDefault();
                close($(thisModal));
            });
            // or close modal when esc key is pressed
            $(document).keyup(function (e) {
                if (e.keyCode == 27) {
                    close($(thisModal));
                }
            });

            $('.inside-modal-trigger').on('click', function (e) {
                e.preventDefault();

                var toModal = $(this).data('target');

                close($(thisModal));
                open($(toModal));

                $('.modal-close, .modal-backdrop').on('click', function (e) {
                    e.preventDefault();
                    close($(toModal));
                });
            });

            function open(modal) {
                modal.fadeIn(150);
                $('body').append('<div class="modal-backdrop"></div>');
            }

            function close(modal) {
                modal.hide();
                $('.modal-backdrop').remove();

                smileUx.resetForm(modal.find('form'));
            }
        },

        dropdownCheckbox: function (thisDropdown) {
            var maxCat = thisDropdown.find('.checkboxes-list').data('max-cat');

            thisDropdown.find('.checkboxes-list').toggle();

            thisDropdown.find('.checkboxes-list input[type="checkbox"]').on('change', function (e) {
                $(this).parents('li').toggleClass('selected');

                var catChecked = thisDropdown.find('input:checked').length - 1,
                    uncheckedInputs = thisDropdown.find('.checkboxes-list input[type="checkbox"]:not(:checked)');

                if (this.checked) {
                    catChecked++;
                }

                if (catChecked == maxCat) {
                    uncheckedInputs.attr('disabled', true);
                } else {
                    uncheckedInputs.attr('disabled', false);
                }
            });

            if (!thisDropdown.find('.checkboxes-list').is(':visible')) {
                var categories = getChecked();

                if (categories.length == 0) {
                    thisDropdown.find('.categories-selected').text('Select a category (max 2)');
                } else {
                    thisDropdown.find('.categories-selected').text(categories);
                }
            }

            $('.modal-upload, body').on('click', function (e) {
                if (thisDropdown.find('.checkboxes-list').is(':visible')) {
                    if (!($(e.target).parents('.checkboxes-list').length ||
                            $(e.target).hasClass('checkboxes-list') ||
                            $(e.target).hasClass('dropdown-checkboxes') ||
                            $(e.target).parent('.dropdown-checkboxes').length)) {

                        thisDropdown.find('.checkboxes-list').toggle();
                        var categories = getChecked();

                        if (categories.length == 0) {
                            thisDropdown.find('.categories-selected').text('Select a category (max 2)');
                        } else {
                            thisDropdown.find('.categories-selected').text(categories);
                        }
                    }

                    thisDropdown.find('.checkboxes-list input[type="checkbox"]:not(:checked)').each(function () {
                        var parent = $(this).closest('li');

                        if (parent.hasClass('selected')) {
                            parent.removeClass('selected');
                        }
                    });

                    thisDropdown.find('.checkboxes-list input[type="checkbox"]').on('change', function (e) {
                        $(this).parents('li').addClass('selected');
                    });
                }
            });

            function getChecked() {
                var arr = [];

                thisDropdown.find('.checkboxes-list input[type="checkbox"]:checked').each(function () {
                    arr.push($(this).val());
                });

                return arr;
            }
        },

        shareButtons: function () {
            var $this = $(this),
                shareList = $this.closest('div').find('.share-options');

            shareList.show();
            $this.hide();

            $(document).on('scroll', function () {
                $this.show();
                shareList.hide();
            });
        },

        goTop: function () {
            var goTopBtn = $('.btn-go-top');

            $(window).on('scroll', function () {
                if ($(this).scrollTop() > 500 && $(this).width() > 768) {
                    goTopBtn.fadeIn();
                } else {
                    goTopBtn.fadeOut();
                }
            });

            goTopBtn.on('click', function (e) {
                e.preventDefault();

                $('html, body').animate({scrollTop: 0}, 450);
            });
        },

        activateSearch: function (e) {
            e.preventDefault();
            var trigger = $(this),
                searchForm = $('.user-functions').find('#main-search'),
                searchInput = searchForm.find('input[type="search"]');

            searchForm.toggle(150, function () {
                searchInput.val('');
                searchInput.focus();
            });

            $(document).on('scroll', function () {
                close();
            });

            $('body').on('click touchstart', function (ev) {
                if ($(ev.target).closest(searchForm).length ||
                    $(ev.target).closest(trigger).length) {
                    return;
                } else {
                    close();
                }
            });

            function close() {
                searchForm.hide();
                searchInput.val('');
            }
        },

        listFunctionality: function () {
            // add item to list
            var listItemTemplate = $('.list-items-wrapper .list-item-container').clone(true);
            $('.btn-more-items').on('click', function () {
                $(listItemTemplate).clone(true).appendTo('.list-items-wrapper');

                orderListItems();
            });

            // remove item from list
            $('.list-items-wrapper').on('click', '.delete-item', function () {
                $(this).closest('.list-item-container').remove();

                orderListItems();
            });

            // move item top trigger
            $('.list-items-wrapper').on('click', '.move-top', function () {
                var item = $(this).closest('.list-item-container');

                moveItem($(this).attr('class'), item, item.clone(true), item.prev());
            });
            // move item bottom trigger
            $('.list-items-wrapper').on('click', '.move-bottom', function () {
                var item = $(this).closest('.list-item-container');

                moveItem($(this).attr('class'), item, item.clone(true), item.next());
            });

            function moveItem(direction, item, itemCopy, sibling) {
                item.remove();

                if (direction == 'move-top') {
                    itemCopy.insertBefore(sibling);
                } else {
                    itemCopy.insertAfter(sibling);
                }

                orderListItems();
            }

            function orderListItems() {
                movingItemsRestrictions();

                $('.list-items-wrapper').find('.list-item-container').each(function (index, element) {
                    var tags = $(element).find('input, textarea');

                    $.each(tags, function (idx, item) {
                        item = $(item);
                        item.attr('name', item.attr('name').replace(/items\[.*?\]/i, 'items[' + index + ']'));
                    });

                    $(element).find('.item-counter').text(index + 1);
                    $(element).find('.item-position').val(index + 1);

                    switch ((index + 1) % 10) {
                        case 1:
                            if (index + 1 == 11) {
                                $(element).find('.number-abbr').text('th');
                            } else {
                                $(element).find('.number-abbr').text('st');
                            }
                            break;
                        case 2:
                            $(element).find('.number-abbr').text('nd');
                            break;
                        case 3:
                            $(element).find('.number-abbr').text('rd');
                            break;
                        default:
                            $(element).find('.number-abbr').text('th');
                    }
                });
            }

            /* enable and disable buttons when needed
             the first shouldn't go top
             the last shouldn't go bottom
             */
            $('.list-items-wrapper .list-item-container:first-of-type button')
                .attr('disabled', true);

            function movingItemsRestrictions() {
                $('.list-items-wrapper .list-item-container:first-of-type button')
                    .attr('disabled', true);

                if ($('.list-items-wrapper .list-item-container').length > 1) {
                    $('.list-item-container').siblings()
                        .find('.move-top').attr('disabled', false).end()
                        .find('.move-bottom').attr('disabled', false);

                    $('.list-items-wrapper .list-item-container:first-of-type')
                        .find('.move-top').attr('disabled', true).end()
                        .find('.move-bottom').attr('disabled', false).end()
                        .find('.delete-item').attr('disabled', false);

                    $('.list-items-wrapper .list-item-container:last-of-type')
                        .find('.move-top').attr('disabled', false).end()
                        .find('.move-bottom').attr('disabled', true);
                }
            }
        },

        resetForm: function (form) {
            var dropdownCheckboxes = form.find('.dropdown-checkboxes'),
                postDescription = form.find('.post-description'),
                captcha = form.find('.g-recaptcha').length,
                descriptionCheckbox = form.find('.description-checkbox');

            // reset all form fields
            form[0].reset();

            // reset dropdown with checkboxes
            if (dropdownCheckboxes) {
                dropdownCheckboxes.find('.selected').removeClass('selected');
                $('input:disabled').attr('disabled', false);

                dropdownCheckboxes.find('.categories-selected')
                    .text(dropdownCheckboxes.find('.categories-selected-text').text());
            }

            // reset captcha
            if (captcha) {
                grecaptcha.reset();
            }

            // remove error classes & text
            form.find('.text-error').remove().end()
                .find('.has-error').removeClass('has-error');

            // special field
            if (descriptionCheckbox.length && postDescription && !postDescription.hasClass('hide')) {
                postDescription.addClass('hide');
            }
        }
    };

    smileUx.init();

})(jQuery, window, document);
