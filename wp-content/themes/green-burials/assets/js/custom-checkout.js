jQuery(function ($) {
    function ShippingModal() {
        var bodyOpenClass = 'shipping-modal-open';

        function getElements() {
            var $modal = $('#shipping-address-modal');
            var $summary = $('#shipping-summary');
                modalExists: $modal.length > 0,
                summaryExists: $summary.length > 0
            });
            return {
                openButton: $('#add-shipping-address-btn'),
                modal: $modal,
                overlay: $modal.find('[data-shipping-modal-dismiss]'),
                closeButton: $modal.find('.shipping-address-modal__close'),
                notice: $modal.find('.shipping-address-modal__notice'),
                saveButton: $('#save-shipping-address'),
                cancelButton: $('#cancel-shipping-address'),
                summary: $summary,
                summaryDetails: $summary.find('.shipping-summary__details'),
                summaryEmpty: $summary.find('.shipping-summary__empty'),
                summaryReset: $('#remove-shipping-address'),
                shippingCheckbox: $('#ship-to-different-address-checkbox')
            };
        }

        function setShippingUsage(shouldUseShipping) {
            var els = getElements();
                hasCheckbox: els.shippingCheckbox.length > 0
            });
            if (!els.shippingCheckbox.length) {
                return;
            }
            els.shippingCheckbox.prop('checked', shouldUseShipping).trigger('change');
        }

        function usingShippingAddress() {
            var els = getElements();
            return els.shippingCheckbox.length ? els.shippingCheckbox.is(':checked') : false;
        }

        function copyValues($from, $to) {
            $from.find(':input').each(function (index) {
                var $fromInput = $(this);
                var $toInput = $to.find(':input').eq(index);
                if ($toInput.length) {
                    $toInput.val($fromInput.val());
                }
            });
        }

        function gatherSummaryLines() {
            var lines = [];
            var $firstName = $('[name="shipping_first_name"]');
            var $lastName = $('[name="shipping_last_name"]');
            var $company = $('[name="shipping_company"]');
            var $address1 = $('[name="shipping_address_1"]');
            var $address2 = $('[name="shipping_address_2"]');
            var $city = $('[name="shipping_city"]');
            var $postcode = $('[name="shipping_postcode"]');
            var $state = $('[name="shipping_state"]');
            var $country = $('[name="shipping_country"]');
            var $phone = $('[name="shipping_phone"]');

            var name = [readField($firstName), readField($lastName)].filter(Boolean).join(' ');
            if (name) {
                lines.push(name);
            }

            var company = readField($company);
            if (company) {
                lines.push(company);
            }

            var street = [readField($address1), readField($address2)].filter(Boolean).join(', ');
            if (street) {
                lines.push(street);
            }

            var locality = [readField($city), readField($state), readField($postcode)].filter(Boolean).join(', ');
            if (locality) {
                lines.push(locality);
            }

            var country = readField($country);
            if (country) {
                lines.push(country);
            }

            var phone = readField($phone);
            if (phone) {
                lines.push('Tel: ' + phone);
            }

            return lines;
        }

        function renderSummary() {
            var els = getElements();
            if (!els.summary.length) {
                return;
            }

            var lines = gatherSummaryLines();
            var shouldShowSummary = usingShippingAddress() && lines.length;

            els.summaryDetails.empty();

            if (shouldShowSummary) {
                lines.forEach(function (line) {
                    $('<span />').text(line).appendTo(els.summaryDetails);
                });
                els.summaryDetails.removeAttr('hidden');
                els.summaryEmpty.attr('hidden', true);
                els.summaryReset.removeAttr('hidden');
                if (els.openButton.length) {
                    els.openButton.text(els.openButton.data('editLabel'));
                }
            } else {
                els.summaryDetails.attr('hidden', true);
                els.summaryEmpty.removeAttr('hidden');
                els.summaryReset.attr('hidden', true);
                if (els.openButton.length) {
                    els.openButton.text(els.openButton.data('addLabel'));
                }
            }
        }

        function showNotice(message) {
            var els = getElements();
            if (!els.notice.length) {
                return;
            }

            if (message) {
                els.notice.text(message).removeAttr('hidden');
            } else {
                els.notice.attr('hidden', true).empty();
            }
        }

        function validateShippingFields() {
            var els = getElements();
            if (!els.modal.length) {
                return true;
            }

            var invalidField = null;

            els.modal.find('.shipping_address .validate-required').each(function () {
                var $row = $(this);
                var $input = $row.find(':input').filter(':enabled').first();
                if (!$input.length) {
                    return;
                }

                var value = $.trim(readField($input));
                if (!value) {
                    $row.removeClass('woocommerce-validated').addClass('woocommerce-invalid');
                    $input.addClass('woocommerce-invalid');
                    if (!invalidField) {
                        invalidField = $input;
                    }
                } else {
                    $row.removeClass('woocommerce-invalid').addClass('woocommerce-validated');
                    $input.removeClass('woocommerce-invalid');
                }
            });

            if (invalidField) {
                showNotice('Please complete the required shipping fields.');
                invalidField.trigger('focus');
                return false;
            }

            showNotice('');
            return true;
        }

        var shippingUsageBeforeModal = null;
        var explicitlyEnabledDuringModal = false;

        function openModal() {
            var els = getElements();
            if (!els.modal.length) {
                return;
            }

            shippingUsageBeforeModal = usingShippingAddress();
            explicitlyEnabledDuringModal = false;
            if (shippingUsageBeforeModal === false) {
                setShippingUsage(true);
                explicitlyEnabledDuringModal = true;
            }

            // Hide original fields and copy values to cloned
            if ($originalShippingFields && $originalShippingFields.length) {
                $originalShippingFields.hide();
                // Move ids to cloned for SelectWoo
                $originalShippingFields.find(':input').each(function() {
                    var $input = $(this);
                    var id = $input.attr('id');
                    if (id) {
                        $input.data('original-id', id).removeAttr('id');
                        $clonedShippingFields.find(':input').eq($originalShippingFields.find(':input').index($input)).attr('id', id);
                    }
                });
                copyValues($originalShippingFields, $clonedShippingFields);
            }

            els.modal.addClass('is-open').attr('aria-hidden', 'false');
            $('body').addClass(bodyOpenClass);

            initializeSelectControls(els.modal);

            setTimeout(function () {
                var $firstField = els.modal.find('.shipping_address :input:visible').first();
                if ($firstField.length) {
                    $firstField.trigger('focus');
                }
            }, 20);

            $(document).on('keydown.shippingModal', function (event) {
                if (event.key === 'Escape') {
                    event.preventDefault();
                    closeModal(true);
                }
            });
        }

        function closeModal(restoreFocus, options) {
            var opts = options || {};
            var els = getElements();
            if (!els.modal.length) {
                return;
            }

            els.modal.removeClass('is-open').attr('aria-hidden', 'true');
            $('body').removeClass(bodyOpenClass);
            $(document).off('keydown.shippingModal');

            // Show original fields
            if ($originalShippingFields && $originalShippingFields.length) {
                // Move ids back to original
                $originalShippingFields.find(':input').each(function(i) {
                    var $input = $(this);
                    var originalId = $input.data('original-id');
                    if (originalId) {
                        $input.attr('id', originalId).removeData('original-id');
                        $clonedShippingFields.find(':input').eq(i).removeAttr('id');
                    }
                });
                $originalShippingFields.show();
            }

            if (!opts.persistUsage && shippingUsageBeforeModal === false && explicitlyEnabledDuringModal) {
                setShippingUsage(false);
            }

            shippingUsageBeforeModal = null;
            explicitlyEnabledDuringModal = false;

            if (restoreFocus && els.openButton.length) {
                els.openButton.trigger('focus');
            }
        }

        function handleSave() {
            if (!validateShippingFields()) {
                return;
            }

            // Copy values from cloned to original
            if ($clonedShippingFields && $originalShippingFields) {
                copyValues($clonedShippingFields, $originalShippingFields);
            }

            setShippingUsage(true);
            renderSummary();
            closeModal(true, { persistUsage: true });
        }

        function handleReset() {
            setShippingUsage(false);
            renderSummary();
            $(document.body).trigger('update_checkout');
        }

        function bindUI() {
            var els = getElements();

            if (!els.openButton.length) {
                return;
            }

            $(document)
                .on('click.shippingModal', '#add-shipping-address-btn', function (event) {
                    event.preventDefault();
                    openModal();
                })
                .on('click.shippingModal', '#save-shipping-address', function (event) {
                    event.preventDefault();
                    handleSave();
                })
                .on('click.shippingModal', '#cancel-shipping-address', function (event) {
                    event.preventDefault();
                    closeModal(true);
                })
                .on('click.shippingModal', '#remove-shipping-address', function (event) {
                    event.preventDefault();
                    handleReset();
                })
                .on('click.shippingModal', '[data-shipping-modal-dismiss]', function (event) {
                    event.preventDefault();
                    closeModal(true);
                })
                .on('change.shippingModal keyup.shippingModal', '.shipping_address :input', function () {
                    // Sync values from cloned to original
                    if ($clonedShippingFields && $originalShippingFields) {
                        copyValues($clonedShippingFields, $originalShippingFields);
                    }
                    if (usingShippingAddress()) {
                        renderSummary();
                    }
                })
                .on('change.shippingModal', '#ship-to-different-address-checkbox', function () {
                    renderSummary();
                });

            $(document.body).on('updated_checkout.shippingModal', function () {
                initializeSelectControls($('#shipping-address-modal'));
                renderSummary();
            });
        }

        function hasRequiredElements() {
            ensureModalStructure();
            return $('#add-shipping-address-btn').length && $('#shipping-address-modal').length;
        }

        var $originalShippingFields = null;
        var $clonedShippingFields = null;
        var shippingFieldsCloned = false;

        function ensureModalStructure() {
            var $modal = $('#shipping-address-modal');
            if ($modal.length) {
                return $modal;
            }

            if (!shippingFieldsCloned) {
                $originalShippingFields = $('.shipping-details-section .woocommerce-shipping-fields .shipping_address').first();

                if (!$originalShippingFields.length) {
                    $originalShippingFields = $('.woocommerce-shipping-fields .shipping_address').first();
                }
                if ($originalShippingFields.length) {
                    $clonedShippingFields = $originalShippingFields.clone();
                    $clonedShippingFields.find('input, select, textarea').removeAttr('name').removeAttr('id');
                    shippingFieldsCloned = true;
                }
            }

            if (!$originalShippingFields || !$originalShippingFields.length) {
                return $modal;
            }


            var $summaryContainer = $('#shipping-summary');
            var $shippingSection = $('.shipping-details-section');

            if (!$summaryContainer.length && $shippingSection.length) {
                $summaryContainer = $('<div>', {
                    id: 'shipping-summary',
                    class: 'shipping-summary'
                }).append(
                    $('<p>', {
                        class: 'shipping-summary__empty',
                        text: 'Shipping will use the billing address unless you add one below.'
                    }),
                    $('<div>', {
                        class: 'shipping-summary__details',
                        hidden: true
                    }),
                    $('<button>', {
                        type: 'button',
                        id: 'remove-shipping-address',
                        class: 'shipping-summary__reset',
                        hidden: true,
                        text: 'Use billing address instead'
                    })
                );
                $shippingSection.prepend($summaryContainer);
            }

            var $modalWrapper = $('<div>', {
                id: 'shipping-address-modal',
                class: 'shipping-address-modal',
                'aria-hidden': 'true'
            });

            var $overlay = $('<div>', {
                class: 'shipping-address-modal__overlay',
                'data-shipping-modal-dismiss': ''
            });

            var $dialog = $('<div>', {
                class: 'shipping-address-modal__dialog',
                role: 'dialog',
                'aria-modal': 'true',
                'aria-labelledby': 'shipping-modal-title'
            });

            var $close = $('<button>', {
                type: 'button',
                class: 'shipping-address-modal__close',
                'data-shipping-modal-dismiss': '',
                'aria-label': 'Close shipping address form'
            }).append($('<span>', { 'aria-hidden': 'true', text: '×' }));

            var $content = $('<div>', {
                class: 'shipping-address-modal__content'
            });

            $('<h3>', {
                id: 'shipping-modal-title',
                text: 'Shipping details'
            }).appendTo($content);

            $('<p>', {
                class: 'shipping-address-modal__intro',
                text: 'Please provide the destination information for your order.'
            }).appendTo($content);

            $('<div>', {
                class: 'shipping-address-modal__notice',
                role: 'alert',
                hidden: true
            }).appendTo($content);

            $content.append($clonedShippingFields);

            var $actions = $('<div>', {
                class: 'shipping-address-modal__actions'
            });

            $('<button>', {
                type: 'button',
                class: 'button shipping-address-modal__cancel',
                id: 'cancel-shipping-address',
                text: 'Cancel'
            }).appendTo($actions);

            $('<button>', {
                type: 'button',
                class: 'button alt shipping-address-modal__save',
                id: 'save-shipping-address',
                text: 'Save Address'
            }).appendTo($actions);

            $content.append($actions);

            $dialog.append($close, $content);
            $modalWrapper.append($overlay, $dialog);

            if ($shippingSection.length) {
                $shippingSection.append($modalWrapper);
            } else {
                $('.woocommerce-shipping-fields').first().append($modalWrapper);
            }

            if (!$('#add-shipping-address-btn').length) {
                var $trigger = $('<button>', {
                    type: 'button',
                    id: 'add-shipping-address-btn',
                    class: 'shipping-address-trigger',
                    'data-add-label': 'Add Shipping Address',
                    'data-edit-label': 'Edit Shipping Address',
                    text: 'Add Shipping Address'
                });
                if ($shippingSection.length) {
                    $shippingSection.find('.shipping-summary').after($trigger);
                } else {
                    $('.woocommerce-shipping-fields').first().prepend($trigger);
                }
            }

            initializeSelectControls($modalWrapper);

            return $('#shipping-address-modal');
        }

        function initializeSelectControls($context) {
            if (!$context || !$context.length) {
                return;
            }

            var $selects = $context.find('select');
            if (!$selects.length) {
                return;
            }

                selectCount: $selects.length,
                hasSelectWoo: typeof $.fn.selectWoo === 'function'
            });

            if (typeof $.fn.selectWoo === 'function') {
                $context.find('.select2').remove();
                // Trigger country/state refresh first to populate options
                $(document.body).trigger('country_to_state_changed');
                if (typeof wc_country_select_select2 === 'function') {
                    wc_country_select_select2();
                }
                setTimeout(function () {
                    $(document.body).trigger('wc-enhanced-select-init');
                }, 0);
            } else {
                setTimeout(function () {
                    $(document.body).trigger('init_checkout');
                }, 0);
            }

            setTimeout(function () {
                $(document.body).trigger('country_to_state_changed');
                if (typeof wc_country_select_select2 === 'function') {
                    wc_country_select_select2();
                }
            }, 50);
        }

        function init() {
            if (!hasRequiredElements()) {
                    trigger: $('#add-shipping-address-btn').length,
                    modal: $('#shipping-address-modal').length
                });
                return false;
            }

            bindUI();
            renderSummary();
            return true;
        }

        function initWithRetry(attempt) {
            var maxAttempts = 8;
            var retryDelay = 250;
            var currentAttempt = typeof attempt === 'number' ? attempt : 0;

            if (hasRequiredElements()) {
                return init();
            }

            if (currentAttempt >= maxAttempts) {
                return false;
            }

            setTimeout(function () {
                initWithRetry(currentAttempt + 1);
            }, retryDelay);
            return false;
        }

        return {
            init: init,
            initWithRetry: initWithRetry
        };
    }

    function initAccessTabs() {
        $('.access-tab').on('click', function () {
            var target = $(this).data('target');

            $('.access-tab').removeClass('active');
            $(this).addClass('active');

            $('.access-form-content').removeClass('active');
            $('#' + target + '-checkout-msg, #' + target + '-form-content').addClass('active');
        });
    }

    initAccessTabs();

    function initShippingModal() {
        ShippingModal().initWithRetry();
    }

    initShippingModal();

    // Re-initialize when WooCommerce replaces checkout fragments
    $(document.body).on('checkout_error updated_checkout', function () {
        initShippingModal();
    });
});
