
// Helper function for lazy loading (defined globally to be accessible from carousels)
window.gbShowElement = (element) => {
    if (!element) return;
    element.classList.add('is-visible');
    const images = element.tagName === 'IMG' ? [element] : element.querySelectorAll('img');
    images.forEach(img => {
        if (img.dataset.src) {
            img.src = img.dataset.src;
            img.removeAttribute('data-src');
        }
    });
    if (element.dataset.bg) {
        element.style.backgroundImage = `url("${element.dataset.bg}")`;
        element.removeAttribute('data-bg');
    }
};

// Best Sellers Carousel - Slide one product at a time
document.addEventListener('DOMContentLoaded', function () {
    const carousel = document.getElementById('bestSellersCarousel');
    const nextBtn = document.getElementById('bestSellersNext');
    const prevBtn = document.getElementById('bestSellersPrev');

    if (!carousel || !nextBtn || !prevBtn) return;

    const cards = carousel.querySelectorAll('.bestseller-card');
    const totalCards = cards.length;

    if (totalCards === 0) return;

    let currentIndex = 0;

    function getItemsVisible() {
        if (window.innerWidth <= 480) return 1;
        if (window.innerWidth <= 768) return 1;
        if (window.innerWidth <= 1024) return 3;
        return 4;
    }

    function updateCarousel() {
        const itemsVisible = getItemsVisible();
        const cardWidth = cards[0].offsetWidth;

        const style = window.getComputedStyle(carousel);
        let gap = parseFloat(style.gap);
        if (isNaN(gap)) {
            gap = window.innerWidth <= 768 ? 15 : 32;
        }

        const slideDistance = window.innerWidth <= 768 ? (window.innerWidth - 15) : (cardWidth + gap);
        const maxIndex = Math.max(0, totalCards - itemsVisible);

        if (currentIndex > maxIndex) currentIndex = maxIndex;

        const translateX = -(currentIndex * slideDistance);
        carousel.style.transform = `translateX(${translateX}px)`;

        prevBtn.disabled = currentIndex === 0;
        nextBtn.disabled = currentIndex >= maxIndex;

        prevBtn.style.opacity = currentIndex === 0 ? '0.5' : '1';
        nextBtn.style.opacity = currentIndex >= maxIndex ? '0.5' : '1';
        prevBtn.style.cursor = currentIndex === 0 ? 'not-allowed' : 'pointer';
        nextBtn.style.cursor = currentIndex >= maxIndex ? 'not-allowed' : 'pointer';

        // Show current and next visible cards
        for (let i = currentIndex; i < currentIndex + itemsVisible + 1; i++) {
            if (cards[i]) window.gbShowElement(cards[i]);
        }
    }

    nextBtn.addEventListener('click', function () {
        const itemsVisible = getItemsVisible();
        const maxIndex = Math.max(0, totalCards - itemsVisible);
        if (currentIndex < maxIndex) {
            currentIndex++;
            updateCarousel();
        }
    });

    prevBtn.addEventListener('click', function () {
        if (currentIndex > 0) {
            currentIndex--;
            updateCarousel();
        }
    });

    // Touch support for mobile
    let touchStartX = 0;
    let touchEndX = 0;

    carousel.addEventListener('touchstart', e => {
        touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });

    carousel.addEventListener('touchend', e => {
        touchEndX = e.changedTouches[0].screenX;
        if (Math.abs(touchEndX - touchStartX) > 50) {
            if (touchEndX < touchStartX) nextBtn.click();
            else prevBtn.click();
        }
    }, { passive: true });

    setTimeout(updateCarousel, 100);
    window.addEventListener('load', updateCarousel);
    window.addEventListener('resize', () => setTimeout(updateCarousel, 250));
});

// Latest Products Carousel
document.addEventListener('DOMContentLoaded', function () {
    const carousel = document.getElementById('latestProductsTrack');
    const nextBtn = document.getElementById('latestNext');
    const prevBtn = document.getElementById('latestPrev');

    if (!carousel || !nextBtn || !prevBtn) return;

    const cards = carousel.querySelectorAll('.latest-product-card');
    const totalCards = cards.length;

    if (totalCards === 0) return;

    let currentIndex = 0;

    function getItemsVisible() {
        if (window.innerWidth <= 480) return 1;
        if (window.innerWidth <= 768) return 1;
        if (window.innerWidth <= 1024) return 3;
        return 4;
    }

    function updateCarousel() {
        const itemsVisible = getItemsVisible();
        const cardWidth = cards[0].offsetWidth;
        const style = window.getComputedStyle(carousel);
        let gap = parseFloat(style.gap);
        if (isNaN(gap)) {
            gap = window.innerWidth <= 768 ? 15 : 32;
        }

        const slideDistance = window.innerWidth <= 768 ? (window.innerWidth - 15) : (cardWidth + gap);
        const maxIndex = Math.max(0, totalCards - itemsVisible);

        if (currentIndex > maxIndex) currentIndex = maxIndex;

        const translateX = -(currentIndex * slideDistance);
        carousel.style.transform = `translateX(${translateX}px)`;

        prevBtn.disabled = currentIndex === 0;
        nextBtn.disabled = currentIndex >= maxIndex;
        prevBtn.style.opacity = currentIndex === 0 ? '0.5' : '1';
        nextBtn.style.opacity = currentIndex >= maxIndex ? '0.5' : '1';

        // Show current and next visible cards
        for (let i = currentIndex; i < currentIndex + itemsVisible + 1; i++) {
            if (cards[i]) window.gbShowElement(cards[i]);
        }
    }

    nextBtn.addEventListener('click', function () {
        const itemsVisible = getItemsVisible();
        const maxIndex = Math.max(0, totalCards - itemsVisible);
        if (currentIndex < maxIndex) {
            currentIndex++;
            updateCarousel();
        }
    });

    prevBtn.addEventListener('click', function () {
        if (currentIndex > 0) {
            currentIndex--;
            updateCarousel();
        }
    });

    let touchStartX = 0;
    let touchEndX = 0;
    carousel.addEventListener('touchstart', e => { touchStartX = e.changedTouches[0].screenX; }, { passive: true });
    carousel.addEventListener('touchend', e => {
        touchEndX = e.changedTouches[0].screenX;
        if (Math.abs(touchEndX - touchStartX) > 50) {
            if (touchEndX < touchStartX) nextBtn.click();
            else prevBtn.click();
        }
    }, { passive: true });

    setTimeout(updateCarousel, 100);
    window.addEventListener('load', updateCarousel);
    window.addEventListener('resize', () => setTimeout(updateCarousel, 250));
});

// Reviews Slider
document.addEventListener('DOMContentLoaded', function () {
    const track = document.getElementById('reviewsTrack');
    const nextBtn = document.getElementById('reviewNext');
    const prevBtn = document.getElementById('reviewPrev');

    if (!track || !nextBtn || !prevBtn) return;

    const slides = track.querySelectorAll('.review-slide');
    const totalSlides = slides.length;
    if (totalSlides === 0) return;

    let currentIndex = 0;
    function updateSlider() {
        const translateX = -(currentIndex * 100);
        track.style.transform = `translateX(${translateX}%)`;
    }

    nextBtn.addEventListener('click', () => {
        currentIndex = (currentIndex < totalSlides - 1) ? currentIndex + 1 : 0;
        updateSlider();
    });

    prevBtn.addEventListener('click', () => {
        currentIndex = (currentIndex > 0) ? currentIndex - 1 : totalSlides - 1;
        updateSlider();
    });
});

// Category Filter Tabs
document.addEventListener('DOMContentLoaded', function () {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const productGrid = document.getElementById('categoryProductsGrid');
    if (!productGrid) return;
    const productCards = productGrid.querySelectorAll('.category-product-card');

    const mobileFilterToggle = document.getElementById('mobileFilterToggle');
    const categoryFiltersContainer = document.getElementById('categoryFilters');

    if (mobileFilterToggle && categoryFiltersContainer) {
        mobileFilterToggle.addEventListener('click', () => categoryFiltersContainer.classList.toggle('expanded'));
    }

    filterButtons.forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const selectedCategory = this.getAttribute('data-category');
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            if (categoryFiltersContainer) categoryFiltersContainer.classList.remove('expanded');

            productCards.forEach(card => {
                if (card.getAttribute('data-category') === selectedCategory) {
                    card.style.display = 'block';
                    window.gbShowElement(card);
                } else {
                    card.style.display = 'none';
                }
            });

            productGrid.style.opacity = '0';
            setTimeout(() => { productGrid.style.opacity = '1'; }, 100);
        });
    });
});

// Smart Sticky Navbar
document.addEventListener('DOMContentLoaded', function () {
    const navbar = document.querySelector('.nav-bar-full');
    const navbarWrapper = document.querySelector('.nav-bar-wrapper');
    const mobileNavbar = document.querySelector('.mobile-nav-bar');
    const mobileNavWrapper = document.querySelector('.mobile-nav-wrapper');

    function handleScroll() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        if (navbar && navbarWrapper && window.innerWidth > 768) {
            if (scrollTop > navbarWrapper.offsetTop) {
                if (!navbar.classList.contains('is-stuck')) {
                    navbar.classList.add('is-stuck');
                    navbarWrapper.style.height = navbar.offsetHeight + 'px';
                }
            } else {
                navbar.classList.remove('is-stuck');
                navbarWrapper.style.height = 'auto';
            }
        }
        if (mobileNavbar && mobileNavWrapper && window.innerWidth <= 768) {
            if (scrollTop > mobileNavWrapper.offsetTop) {
                if (!mobileNavbar.classList.contains('is-stuck')) {
                    mobileNavbar.classList.add('is-stuck');
                    mobileNavWrapper.style.height = mobileNavbar.offsetHeight + 'px';
                }
            } else {
                mobileNavbar.classList.remove('is-stuck');
                mobileNavWrapper.style.height = 'auto';
            }
        }
    }
    window.addEventListener('scroll', handleScroll, { passive: true });
    handleScroll();
    window.addEventListener('resize', handleScroll);
});

// Advanced Lazy Loading
document.addEventListener('DOMContentLoaded', function () {
    const productCards = document.querySelectorAll('.category-product-card, .bestseller-card, .latest-product-card');
    productCards.forEach(card => {
        if (!card.classList.contains('lazy-load')) card.classList.add('lazy-load');
    });

    if ('IntersectionObserver' in window) {
        window.gbElementObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    window.gbShowElement(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, { root: null, rootMargin: '50px', threshold: 0.1 });

        document.querySelectorAll('.lazy-load').forEach(el => window.gbElementObserver.observe(el));
    } else {
        document.querySelectorAll('.lazy-load').forEach(el => window.gbShowElement(el));
    }

    setTimeout(() => {
        document.querySelectorAll('.lazy-load:not(.is-visible)').forEach(el => window.gbShowElement(el));
    }, 2000);
});

// ============================================================================
// EPO (Extra Product Options) Conditional Add-to-Cart
//
// Three cases handled:
//   1. Products WITH required EPO options  → redirect cleanly to product page.
//   2. Products WITHOUT required options   → direct AJAX add-to-cart + modal.
//   3. "Shop Now" / browse buttons         → always simple redirect, no cart.
//
// Case 2 uses its own fetch() AJAX instead of relying on WooCommerce's
// wc-add-to-cart.js, which may fail to initialise if wc_add_to_cart_params
// is not defined on the page. If the server rejects the add (EPO required
// fields not met), the JSON response contains {error, product_url} and we
// redirect to the product page instead.
// ============================================================================
document.addEventListener('DOMContentLoaded', function () {

    // --- Helper: clean URL (strip ?add-to-cart= from any href) ---------------
    function cleanProductUrl(url) {
        if (!url) return url;
        try {
            var u = new URL(url, window.location.origin);
            u.searchParams.delete('add-to-cart');
            return u.toString();
        } catch (e) {
            return url.split('?')[0];
        }
    }

    // --- Helper: direct AJAX add-to-cart ------------------------------------
    function gbDoAjaxAddToCart(btn, productId, fallbackUrl) {
        if (!productId) {
            if (fallbackUrl) window.location.href = fallbackUrl;
            return;
        }

        // Determine WooCommerce AJAX endpoint
        var wcAjaxUrl = '/?wc-ajax=add_to_cart';
        if (typeof gb_ajax_params !== 'undefined' && gb_ajax_params.wc_ajax_url) {
            wcAjaxUrl = gb_ajax_params.wc_ajax_url.replace('%%endpoint%%', 'add_to_cart');
        } else if (typeof wc_add_to_cart_params !== 'undefined' && wc_add_to_cart_params.wc_ajax_url) {
            wcAjaxUrl = wc_add_to_cart_params.wc_ajax_url.replace('%%endpoint%%', 'add_to_cart');
        }

        var qty = btn.getAttribute('data-quantity') || '1';
        var sku = btn.getAttribute('data-product_sku') || '';

        btn.classList.add('loading');
        btn.classList.remove('added');

        var body = 'product_id=' + encodeURIComponent(productId)
                 + '&quantity=' + encodeURIComponent(qty)
                 + '&tcaddtocart=' + encodeURIComponent(productId); // bypass EPO loop-page block, keep required-field validation
        if (sku) body += '&product_sku=' + encodeURIComponent(sku);

        fetch(wcAjaxUrl, {
            method: 'POST',
            credentials: 'same-origin',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
            body: body
        })
        .then(function (r) { return r.json(); })
        .then(function (data) {
            btn.classList.remove('loading');

            if (data && data.error && data.product_url) {
                // Server rejected add-to-cart (e.g. EPO required options) → go to product page
                window.location.href = cleanProductUrl(data.product_url);
                return;
            }

            if (data && data.fragments) {
                // Success — product added
                btn.classList.add('added');
                // Trigger WooCommerce + our modal via jQuery
                if (typeof jQuery !== 'undefined') {
                    jQuery(document.body).trigger('added_to_cart', [data.fragments, data.cart_hash, jQuery(btn)]);
                }
            } else {
                // Unexpected response — fall back to URL navigation
                if (fallbackUrl && fallbackUrl !== '#') {
                    window.location.href = fallbackUrl;
                }
            }
        })
        .catch(function () {
            btn.classList.remove('loading');
            if (fallbackUrl && fallbackUrl !== '#') {
                window.location.href = fallbackUrl;
            }
        });
    }

    // --- 3. Shop Now buttons must NEVER trigger any cart logic ---------------
    document.querySelectorAll(
        '.btn-category-shop, .btn-bestseller-shop, .btn-latest-shop'
    ).forEach(function (btn) {
        btn.classList.remove('ajax_add_to_cart', 'add_to_cart_button');
        btn.removeAttribute('data-product_id');
        btn.removeAttribute('data-quantity');
    });

    // --- 1 & 2. Intercept cart icon button clicks ----------------------------
    document.addEventListener('click', function (e) {
        var btn = e.target.closest('.btn-category-add-to-cart');
        if (!btn) return;

        var hasRequired = btn.getAttribute('data-has-required-options');
        var productId = btn.getAttribute('data-product_id') || btn.getAttribute('data-product-id');
        var productUrl = btn.getAttribute('data-product-permalink')
            || cleanProductUrl(btn.getAttribute('href'));

        // ── CASE 1: Has required EPO options → redirect to product page ──────
        if (hasRequired === '1' || btn.classList.contains('gb-epo-redirect')) {
            e.preventDefault();
            e.stopImmediatePropagation();
            if (productUrl && productUrl !== '#') {
                window.location.href = cleanProductUrl(productUrl);
            }
            return;
        }

        // ── CASE 2: No required EPO → direct AJAX add-to-cart ────────────────
        // We take full ownership of this click so we don't depend on
        // wc-add-to-cart.js being present and correctly initialised.
        e.preventDefault();
        e.stopImmediatePropagation();
        gbDoAjaxAddToCart(btn, productId, btn.getAttribute('href'));

    }, true); // capture phase — fires before any bubble-phase handlers

}); // end DOMContentLoaded

// ============================================================================
// Cart Modal & AJAX
// ============================================================================
jQuery(function ($) {
    const $modal = $('#gb-cart-modal');
    if (!$modal.length) return;

    $(document.body).on('added_to_cart', function (event, fragments, cart_hash, $button) {
        const productId = $button.data('product_id');
        if (!productId) return;
        $.ajax({
            url: gb_ajax_params.ajax_url,
            type: 'POST',
            data: { action: 'gb_get_cart_info', product_id: productId },
            success: function (response) {
                if (response.success) {
                    const data = response.data;
                    $modal.find('.gb-modal-product-image').html(`<img src="${data.image}" alt="${data.name}">`);
                    $modal.find('.gb-modal-product-name').text(data.name);
                    $modal.find('.gb-modal-product-price-qty').html(`1 x ${data.price}`);
                    $modal.find('.subtotal-value').html(data.subtotal);
                    $modal.find('.cart-count-text').text(`Your cart contains ${data.count} items`);
                    $modal.fadeIn(300);
                }
            }
        });
    });

    $modal.find('.gb-modal-close, .btn-modal-continue').on('click', () => $modal.fadeOut(300));
    $(window).on('click', (e) => { if ($(e.target).is($modal)) $modal.fadeOut(300); });

    // Shop Sidebar
    const $toggleBtn = $('#toggle-filters');
    const $sidebar = $('#shop-sidebar');
    const $gridWrapper = $('#shop-grid-wrapper');
    if ($toggleBtn.length && $sidebar.length) {
        $toggleBtn.on('click', function () {
            $sidebar.toggleClass('active');
            $(this).find('.toggle-text').text($sidebar.hasClass('active') ? 'HIDE FILTERS' : 'SHOW FILTERS');
        });
    }

    // ── Toast Notification Helper ─────────────────────────────────────────────
    // Creates a slim, branded toast that auto-dismisses after 4 seconds.
    // type: 'success' | 'error' | 'info'
    function gbToast(message, type, loginUrl) {
        // Inject styles once
        if (!$('#gb-toast-styles').length) {
            $('head').append(`<style id="gb-toast-styles">
                #gb-toast-container {
                    position: fixed;
                    top: 24px;
                    right: 24px;
                    z-index: 99999;
                    display: flex;
                    flex-direction: column;
                    gap: 10px;
                    pointer-events: none;
                }
                .gb-toast {
                    min-width: 280px;
                    max-width: 380px;
                    background: #fff;
                    border-left: 4px solid #73884D;
                    border-radius: 8px;
                    padding: 14px 18px;
                    box-shadow: 0 8px 24px rgba(0,0,0,.12);
                    font-family: 'Times New Roman', Times, serif;
                    font-size: 0.95rem;
                    color: #333;
                    pointer-events: all;
                    opacity: 0;
                    transform: translateX(30px);
                    transition: opacity .3s ease, transform .3s ease;
                }
                .gb-toast.gb-toast--show {
                    opacity: 1;
                    transform: translateX(0);
                }
                .gb-toast.gb-toast--error  { border-left-color: #e74c3c; }
                .gb-toast.gb-toast--info   { border-left-color: #3498db; }
                .gb-toast .gb-toast-title  { font-weight: 700; margin-bottom: 4px; }
                .gb-toast .gb-toast-login  {
                    display: inline-block;
                    margin-top: 8px;
                    background: #73884D;
                    color: #fff !important;
                    padding: 6px 14px;
                    border-radius: 50px;
                    text-decoration: none;
                    font-size: 0.85rem;
                    font-weight: 600;
                    transition: background .2s;
                }
                .gb-toast .gb-toast-login:hover { background: #5A6D3A; }
                @media (max-width: 480px) {
                    #gb-toast-container {
                        top: auto;
                        bottom: 16px;
                        right: 12px;
                        left: 12px;
                    }
                    .gb-toast { max-width: 100%; }
                }
            </style>`);
        }

        if (!$('#gb-toast-container').length) {
            $('body').append('<div id="gb-toast-container"></div>');
        }

        const typeClass = type === 'error' ? 'gb-toast--error' : (type === 'info' ? 'gb-toast--info' : '');
        let loginLink = '';
        if (loginUrl) {
            loginLink = `<br><a href="${loginUrl}" class="gb-toast-login">Log In / Register</a>`;
        }

        const $toast = $(`<div class="gb-toast ${typeClass}"><div class="gb-toast-title">${message}</div>${loginLink}</div>`);
        $('#gb-toast-container').append($toast);

        // Trigger transition
        setTimeout(() => $toast.addClass('gb-toast--show'), 20);

        // Auto-dismiss
        setTimeout(() => {
            $toast.removeClass('gb-toast--show');
            setTimeout(() => $toast.remove(), 350);
        }, 4500);
    }

    // ── Wishlist & Compare — Add ──────────────────────────────────────────────
    $(document).on('click', '.gb-add-to-wishlist, .gb-add-to-compare', function (e) {
        e.preventDefault();
        const $btn = $(this);
        const productId = $btn.data('product-id');
        const isWishlist = $btn.hasClass('gb-add-to-wishlist');
        const action = isWishlist ? 'gb_add_to_wishlist' : 'gb_add_to_compare';

        if (!productId || $btn.hasClass('loading')) return;

        const ajaxUrl = (typeof gb_ajax_params !== 'undefined') ? gb_ajax_params.ajax_url : '/wp-admin/admin-ajax.php';

        $btn.addClass('loading');

        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            data: {
                action: action,
                product_id: productId,
                security: (typeof gb_ajax_params !== 'undefined') ? gb_ajax_params.nonce : ''
            },
            success: function (response) {
                $btn.removeClass('loading');

                if (response === -1 || response === '-1') {
                    gbToast('Security check failed. Please refresh the page and try again.', 'error');
                    return;
                }

                if (typeof response !== 'object') {
                    try { response = JSON.parse(response); }
                    catch (err) {
                        gbToast('Server returned an unexpected response.', 'error');
                        return;
                    }
                }

                if (response.success) {
                    gbToast(response.data.message, 'success');
                    $btn.addClass('active');
                    if (response.data && response.data.count !== undefined) {
                        const counterClass = isWishlist ? '.wishlist-count' : '.compare-count';
                        $(counterClass).text(response.data.count);
                    }
                } else {
                    // Check for "not logged in" error — show login prompt
                    const errData = response.data || {};
                    if (errData.code === 'not_logged_in') {
                        const loginUrl = (typeof gb_ajax_params !== 'undefined' && gb_ajax_params.login_url)
                            ? gb_ajax_params.login_url
                            : '/my-account';
                        gbToast(errData.message || 'You must log in to add items to your wishlist.', 'error', loginUrl);
                    } else {
                        const msg = errData.message || (typeof errData === 'string' ? errData : 'An error occurred. Please try again.');
                        gbToast(msg, 'error');
                    }
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', status, error, xhr.responseText);
                $btn.removeClass('loading');
                gbToast('Could not process the request. Please try again later.', 'error');
            }
        });
    });

    // ── Wishlist & Compare — Remove ───────────────────────────────────────────
    $(document).on('click', '.remove-from-wishlist, .remove-from-compare', function (e) {
        e.preventDefault();
        e.stopPropagation();

        const $btn = $(this);
        const productId = $btn.attr('data-product-id');
        const isWishlist = $btn.hasClass('remove-from-wishlist');
        const action = isWishlist ? 'gb_remove_from_wishlist' : 'gb_remove_from_compare';

        if (!productId || $btn.hasClass('loading')) return;

        $btn.addClass('loading');
        $btn.css('opacity', '0.5');

        const ajaxUrl = (typeof gb_ajax_params !== 'undefined') ? gb_ajax_params.ajax_url : '/wp-admin/admin-ajax.php';
        const nonce = (typeof gb_ajax_params !== 'undefined') ? gb_ajax_params.nonce : '';

        $.ajax({
            url: ajaxUrl,
            type: 'POST',
            dataType: 'json',
            data: {
                action: action,
                product_id: productId,
                security: nonce
            },
            success: function (response) {
                // Always remove the card from the DOM — success or logical error.
                const $card = $btn.closest(isWishlist ? '.wishlist-product-card' : '.compare-product-card');

                $card.fadeOut(300, function () {
                    $card.remove();

                    // If the grid is now empty, show the empty-state UI.
                    const $grid = isWishlist ? $('.wishlist-products-grid') : $('.compare-products-grid');
                    if ($grid.length && $grid.children('.wishlist-product-card, .compare-product-card').length === 0) {
                        const shopUrl = (typeof gb_ajax_params !== 'undefined' && gb_ajax_params.shop_url)
                            ? gb_ajax_params.shop_url
                            : '/shop';
                        const emptyHtml = isWishlist
                            ? `<div class="empty-wishlist"><svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="#ccc" stroke-width="1.5"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg><p>Your wishlist is currently empty.</p><a href="${shopUrl}" class="btn-go-shopping">Go Shopping</a></div>`
                            : `<div class="empty-compare"><p>Your comparison list is empty.</p></div>`;
                        $grid.replaceWith(emptyHtml);
                    }
                });

                // Update header counter badge
                if (response && response.success) {
                    const counterClass = isWishlist ? '.wishlist-count' : '.compare-count';
                    const newCount = (response.data && response.data.count !== undefined) ? response.data.count : 0;
                    if (newCount === 0) {
                        $(counterClass).text('0').hide();
                    } else {
                        $(counterClass).text(newCount).show();
                    }
                    gbToast('Item removed from ' + (isWishlist ? 'wishlist' : 'compare list') + '.', 'info');
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX Removal Error:', status, error);
                $btn.removeClass('loading').css('opacity', '1');
                gbToast('Could not remove item. Please try again.', 'error');
            }
        });
    });
});