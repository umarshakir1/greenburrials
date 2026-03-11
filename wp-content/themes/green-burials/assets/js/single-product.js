/**
 * Single Product Page Interactivity
 */
document.addEventListener('DOMContentLoaded', function () {
    // Thumbnail Gallery Switching
    const mainImage = document.querySelector('.main-image-container img');
    const thumbnails = document.querySelectorAll('.thumbnail-item');


    thumbnails.forEach(thumb => {
        thumb.addEventListener('click', function () {
            const img = this.querySelector('img');
            const newSrc = img.getAttribute('data-large-src') || img.src;


            if (mainImage) {
                // Update main image
                mainImage.src = newSrc;
                // Clear srcset and sizes to prevent browser from overriding src
                mainImage.removeAttribute('srcset');
                mainImage.removeAttribute('sizes');

                // For WooCommerce gallery compatibility
                mainImage.setAttribute('data-src', newSrc);
                mainImage.setAttribute('data-large_image', newSrc);

                // Update active state
                thumbnails.forEach(t => t.classList.remove('active'));
                this.classList.add('active');
            } else {
            }
        });
    });

    // Quantity Selector
    const qtyInput = document.querySelector('.qty-input');
    const minusBtn = document.querySelector('.qty-btn.minus');
    const plusBtn = document.querySelector('.qty-btn.plus');

    if (qtyInput && minusBtn && plusBtn) {
        minusBtn.addEventListener('click', () => {
            let val = parseInt(qtyInput.value);
            if (val > 1) qtyInput.value = val - 1;
        });

        plusBtn.addEventListener('click', () => {
            let val = parseInt(qtyInput.value);
            qtyInput.value = val + 1;
        });
    }

    // Tabs Switching
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            const target = this.dataset.tab;

            // Update buttons
            tabBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            // Update content
            tabContents.forEach(content => {
                content.classList.remove('active');
                if (content.id === target) {
                    content.classList.add('active');
                }
            });
        });
    });

    // Review Scroll
    const reviewLink = document.querySelector('.review-count');
    const reviewsTab = document.querySelector('.tab-btn[data-tab="reviews"]');
    const reviewsSection = document.getElementById('reviews');

    if (reviewLink && reviewsTab && reviewsSection) {
        reviewLink.style.cursor = 'pointer';
        reviewLink.addEventListener('click', function () {
            reviewsTab.click();
            reviewsSection.scrollIntoView({ behavior: 'smooth' });
        });
    }

    // Related Products Slider - Enhanced with Touch Support
    const slider = document.querySelector('.related-slider');
    const prevBtn = document.querySelector('.arrow-btn.prev');
    const nextBtn = document.querySelector('.arrow-btn.next');

    if (slider && prevBtn && nextBtn) {
        let scrollAmount = 0;
        let isTouching = false;
        let startX = 0;
        let currentTranslate = 0;
        let prevTranslate = 0;

        const getSliderData = () => {
            // Updated selector to match content-single-product.php
            const firstCard = slider.querySelector('.category-product-card');
            if (!firstCard) return { step: 0, maxScroll: 0 };

            const style = window.getComputedStyle(slider);
            const gap = parseInt(style.columnGap) || parseInt(style.gap) || 0;

            const step = firstCard.offsetWidth + gap;
            const containerWidth = slider.parentElement.offsetWidth;
            const maxScroll = Math.max(0, slider.scrollWidth - containerWidth);

            return { step, maxScroll };
        };

        const updateSlider = (animate = true) => {
            if (animate) slider.style.transition = 'transform 0.4s cubic-bezier(0.165, 0.84, 0.44, 1)';
            else slider.style.transition = 'none';
            slider.style.transform = `translateX(-${scrollAmount}px)`;
        };

        nextBtn.addEventListener('click', (e) => {
            e.preventDefault();
            const { step, maxScroll } = getSliderData();
            if (scrollAmount < maxScroll) {
                scrollAmount += step;
                if (scrollAmount > maxScroll) scrollAmount = maxScroll;
            } else {
                scrollAmount = 0;
            }
            updateSlider();
        });

        prevBtn.addEventListener('click', (e) => {
            e.preventDefault();
            const { step, maxScroll } = getSliderData();
            if (scrollAmount > 0) {
                scrollAmount -= step;
                if (scrollAmount < 0) scrollAmount = 0;
            } else {
                scrollAmount = maxScroll;
            }
            updateSlider();
        });

        // Touch Support
        slider.addEventListener('touchstart', (e) => {
            isTouching = true;
            startX = e.touches[0].clientX;
            slider.style.transition = 'none';
            prevTranslate = scrollAmount;
        }, { passive: true });

        slider.addEventListener('touchmove', (e) => {
            if (!isTouching) return;
            const currentX = e.touches[0].clientX;
            const diff = startX - currentX;
            const { maxScroll } = getSliderData();

            let newTranslate = prevTranslate + diff;

            // Add resistance at edges
            if (newTranslate < 0) newTranslate = newTranslate * 0.3;
            if (newTranslate > maxScroll) newTranslate = maxScroll + (newTranslate - maxScroll) * 0.3;

            slider.style.transform = `translateX(-${newTranslate}px)`;
            currentTranslate = newTranslate;
        }, { passive: true });

        slider.addEventListener('touchend', () => {
            if (!isTouching) return;
            isTouching = false;
            const { step, maxScroll } = getSliderData();

            // Snap to nearest step or edges
            scrollAmount = Math.round(currentTranslate / step) * step;
            if (scrollAmount < 0) scrollAmount = 0;
            if (scrollAmount > maxScroll) scrollAmount = maxScroll;

            updateSlider();
        });

        // Reset scroll on window resize
        window.addEventListener('resize', () => {
            scrollAmount = 0;
            updateSlider(false);
        });
    }

    // Fix for WooCommerce Quantity Buttons
    const wcQtyContainer = document.querySelector('.product-actions-wrapper .quantity');
    const wcQtyInput = document.querySelector('.product-actions-wrapper .quantity input.qty');

    if (wcQtyContainer && wcQtyInput) {
        // Inject buttons if they don't exist
        if (!wcQtyContainer.querySelector('.qty-container')) {
            const container = document.createElement('div');
            container.className = 'qty-container';

            const minusBtn = document.createElement('button');
            minusBtn.type = 'button';
            minusBtn.className = 'qty-btn minus';
            minusBtn.textContent = '−'; // Using proper minus sign

            const plusBtn = document.createElement('button');
            plusBtn.type = 'button';
            plusBtn.className = 'qty-btn plus';
            plusBtn.textContent = '+';

            // Move input into container
            wcQtyInput.parentNode.insertBefore(container, wcQtyInput);
            container.appendChild(minusBtn);
            container.appendChild(wcQtyInput);
            container.appendChild(plusBtn);

            minusBtn.addEventListener('click', (e) => {
                e.preventDefault();
                let val = parseInt(wcQtyInput.value);
                if (val > 1) {
                    wcQtyInput.value = val - 1;
                    wcQtyInput.dispatchEvent(new Event('change', { bubbles: true }));
                }
            });

            plusBtn.addEventListener('click', (e) => {
                e.preventDefault();
                let val = parseInt(wcQtyInput.value);
                wcQtyInput.value = val + 1;
                wcQtyInput.dispatchEvent(new Event('change', { bubbles: true }));
            });
        }
    }

    // Sync Variation Data with Main Display
    jQuery(document).on('found_variation', function (event, variation) {

        const $form = jQuery(event.target).closest('form.cart');

        // Aggressively sync variation_id to all potential inputs
        const $variationIdInputs = $form.find('input[name="variation_id"], input.variation_id');
        if ($variationIdInputs.length) {
            $variationIdInputs.val(variation.variation_id).trigger('change');
        } else {
        }

        // Update Price
        if (variation.price_html) {
            const priceMain = document.querySelector('.price-main');
            if (priceMain) priceMain.innerHTML = variation.price_html;
        }

        // Update SKU
        if (variation.sku) {
            const skuElem = document.querySelector('.sku');
            if (skuElem) skuElem.textContent = variation.sku;
        }

        // Update Stock Status
        const availability = document.querySelector('.availability');
        if (availability) {
            if (variation.is_in_stock) {
                availability.textContent = variation.max_qty ? variation.max_qty : 'In Stock';
            } else {
                availability.textContent = 'Out of Stock';
            }
        }
    });

    jQuery(document).on('reset_data', function (event) {
        const $form = jQuery(event.target).closest('form.cart');
        $form.find('input[name="variation_id"], input.variation_id').val('').trigger('change');
    });

    // EPO Required Field Validation
    // Uses EPO's container-level required markers (.tc-is-required / li.tm-epo-has-required)
    // which are reliably set regardless of whether the HTML [required] attribute is rendered.
    function validateEpoRequiredFields() {
        const $form = jQuery('form.cart');
        let firstInvalidEl = null;
        let hasErrors = false;

        // Clear previous state
        $form.find('.epo-field-error').removeClass('epo-field-error');
        $form.find('.gb-epo-validation-notice').remove();

        // All EPO required containers: builder mode (.tc-is-required) + local mode (li.tm-epo-has-required)
        // Search the full product page (not only inside form.cart) because EPO can render its
        // builder wrapper adjacent to the form rather than strictly inside it.
        const $requiredContainers = jQuery('.tc-is-required, li.tm-epo-has-required').filter(function () {
            // Exclude any that are inside the cart modal or other non-product-page contexts
            return !jQuery(this).closest('#gb-cart-modal, .related-products, .widget').length;
        });

        $requiredContainers.each(function () {
            const $container = jQuery(this);

            // Skip conditionally hidden / collapsed fields
            if ($container.hasClass('tm-hidden') || !$container.is(':visible')) {
                return;
            }

            let isValid = true;

            // Select dropdowns
            const $selects = $container.find('select.tmcp-select, select.tm-epo-field, select.tmcp-field');
            if ($selects.length) {
                $selects.each(function () {
                    const val = jQuery(this).val();
                    if (!val || val === '') {
                        isValid = false;
                    }
                });
            }

            // Text / number / email inputs (excluding hidden, radio, checkbox)
            const $inputs = $container.find(
                'input.tmcp-textfield, input.tm-epo-field, input.tmcp-field'
            ).not('[type="hidden"],[type="radio"],[type="checkbox"]');
            if ($inputs.length) {
                $inputs.each(function () {
                    if (!jQuery(this).val() || jQuery(this).val().trim() === '') {
                        isValid = false;
                    }
                });
            }

            // Textareas
            const $textareas = $container.find('textarea.tm-epo-field, textarea.tmcp-field');
            if ($textareas.length) {
                $textareas.each(function () {
                    if (!jQuery(this).val() || jQuery(this).val().trim() === '') {
                        isValid = false;
                    }
                });
            }

            // Radio groups
            const $radios = $container.find('input[type="radio"].tmcp-field, input[type="radio"].tm-epo-field');
            if ($radios.length && !$radios.is(':checked')) {
                isValid = false;
            }

            // Checkbox groups (at least one must be checked)
            const $checkboxes = $container.find('input[type="checkbox"].tmcp-field, input[type="checkbox"].tm-epo-field');
            if ($checkboxes.length && !$checkboxes.is(':checked')) {
                isValid = false;
            }

            if (!isValid) {
                hasErrors = true;
                $container.addClass('epo-field-error');
                if (!firstInvalidEl) firstInvalidEl = $container;
            }
        });

        if (hasErrors) {
            // Insert error notice just above the button row
            const $anchor = $form.find('.single_add_to_cart_button, .btn-buy-now')
                .first()
                .closest('.woocommerce-variation-add-to-cart, p.cart, .cart-action-buttons, .action-group')
                .first();
            const $notice = jQuery(
                '<div class="gb-epo-validation-notice" role="alert">' +
                'Please fill in all required fields (marked with *) before adding to cart.' +
                '</div>'
            );
            ($anchor.length ? $anchor : $form.find('.single_add_to_cart_button, .btn-buy-now').first().parent())
                .before($notice);

            // Scroll to the first invalid field
            if (firstInvalidEl) {
                jQuery('html, body').animate({ scrollTop: firstInvalidEl.offset().top - 120 }, 400);
            }
        }

        return !hasErrors;
    }

    // Manual variation matching fallback
    function findMatchingVariation($form) {
        const variations = $form.data('product_variations');
        if (!variations || !variations.length) {
            return null;
        }

        const selectedAttributes = {};
        $form.find('.variations select').each(function () {
            const name = jQuery(this).attr('name');
            const value = jQuery(this).val();
            if (name && value) {
                selectedAttributes[name] = value;
            }
        });


        for (let i = 0; i < variations.length; i++) {
            const variation = variations[i];
            let matches = true;

            for (let attrName in selectedAttributes) {
                const selectedValue = selectedAttributes[attrName];
                const variationValue = variation.attributes[attrName];

                if (variationValue !== '' && variationValue !== selectedValue) {
                    matches = false;
                    break;
                }
            }

            if (matches) {
                return variation;
            }
        }

        return null;
    }

    // Robust Form Submission Handling
    jQuery('form.cart').on('submit', function (e) {
        const $form = jQuery(this);

        // Validate EPO required fields first
        if (!validateEpoRequiredFields()) {
            e.preventDefault();
            return false;
        }

        // If it's a variations form, ensure variation_id is set
        if ($form.hasClass('variations_form')) {
            let variationId = $form.find('input[name="variation_id"]').val();


            if (!variationId || variationId === '0' || variationId === '') {

                // Try to find the variation manually
                const matchedVariation = findMatchingVariation($form);
                if (matchedVariation) {
                    $form.find('input[name="variation_id"]').val(matchedVariation.variation_id);
                    variationId = matchedVariation.variation_id;
                } else {
                    e.preventDefault();

                    // Show user-friendly error
                    alert('Please select all product options before adding to cart.');

                    // Highlight the variations section
                    $form.find('.variations').css('border', '2px solid #ff0000');
                    setTimeout(function () {
                        $form.find('.variations').css('border', '');
                    }, 3000);

                    return false;
                }
            } else {
            }
        }

        const formData = new FormData(this);
        for (let [key, value] of formData.entries()) {
        }
    });

    // Buy Now Button Handling
    jQuery(document).on('click', '.btn-buy-now', function (e) {
        e.preventDefault();
        const $button = jQuery(this);
        const $form = jQuery('form.cart');
        const productId = $button.data('product-id');
        const quantity = jQuery('input.qty').val() || 1;


        // Validate EPO required fields first
        if (!validateEpoRequiredFields()) {
            return false;
        }

        // Validation for variable products
        if ($form.hasClass('variations_form')) {
            let variationId = $form.find('input[name="variation_id"]').val();

            if (!variationId || variationId === '0' || variationId === '') {

                // Try to find the variation manually
                const matchedVariation = findMatchingVariation($form);
                if (matchedVariation) {
                    $form.find('input[name="variation_id"]').val(matchedVariation.variation_id);
                    variationId = matchedVariation.variation_id;
                } else {
                    alert('Please select all product options before buying.');
                    $form.find('.variations').css('border', '2px solid #ff0000');
                    setTimeout(function () {
                        $form.find('.variations').css('border', '');
                    }, 3000);
                    return false;
                }
            }

            // Collect variation attributes
            const variationData = {};
            $form.find('select[name^="attribute_"]').each(function () {
                variationData[jQuery(this).attr('name')] = jQuery(this).val();
            });

            // Add to cart via AJAX and redirect
            $button.text('Processing...').prop('disabled', true);

            const ajaxUrl = (typeof gb_product_params !== 'undefined') ? gb_product_params.wc_ajax_url.replace('%%endpoint%%', 'add_to_cart') : '/?wc-ajax=add_to_cart';

            jQuery.ajax({
                url: ajaxUrl,
                type: 'POST',
                data: {
                    product_id: productId,
                    quantity: quantity,
                    variation_id: variationId,
                    ...variationData
                },
                success: function (response) {
                    if (response.error && response.product_url) {
                        window.location.href = response.product_url;
                    } else {
                        // Redirect to checkout
                        const checkoutUrl = (typeof gb_product_params !== 'undefined') ? gb_product_params.checkout_url : '/checkout/';
                        window.location.href = checkoutUrl;
                    }
                },
                error: function () {
                    $button.text('Buy Now').prop('disabled', false);
                    alert('Something went wrong. Please try again.');
                }
            });
        } else {
            // Simple product handling
            $button.text('Processing...').prop('disabled', true);

            const ajaxUrl = (typeof gb_product_params !== 'undefined') ? gb_product_params.wc_ajax_url.replace('%%endpoint%%', 'add_to_cart') : '/?wc-ajax=add_to_cart';

            jQuery.ajax({
                url: ajaxUrl,
                type: 'POST',
                data: {
                    product_id: productId,
                    quantity: quantity
                },
                success: function (response) {
                    const checkoutUrl = (typeof gb_product_params !== 'undefined') ? gb_product_params.checkout_url : '/checkout/';
                    window.location.href = checkoutUrl;
                },
                error: function () {
                    $button.text('Buy Now').prop('disabled', false);
                    alert('Something went wrong. Please try again.');
                }
            });
        }
    });
});

// Wishlist and Compare handlers moved to global js/script.js to prevent conflicts
