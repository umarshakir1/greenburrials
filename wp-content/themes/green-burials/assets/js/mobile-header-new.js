// New Mobile Header JavaScript
document.addEventListener('DOMContentLoaded', function () {
    const body = document.body;

    // ========================================
    // MOBILE SEARCH OVERLAY
    // ========================================
    const searchBtn = document.getElementById('mobileSearchBtn');
    const searchOverlay = document.getElementById('mobileSearchOverlay');
    const searchClose = document.getElementById('mobileSearchClose');

    if (searchBtn && searchOverlay && searchClose) {
        // Open search overlay
        searchBtn.addEventListener('click', function () {
            searchOverlay.classList.add('active');
            body.classList.add('mobile-nav-open');
            // Focus on input after animation
            setTimeout(() => {
                const input = searchOverlay.querySelector('.mobile-search-overlay-input');
                if (input) input.focus();
            }, 300);
        });

        // Close search overlay
        searchClose.addEventListener('click', function () {
            searchOverlay.classList.remove('active');
            body.classList.remove('mobile-nav-open');
        });

        // Close on backdrop click
        searchOverlay.addEventListener('click', function (e) {
            if (e.target === searchOverlay) {
                searchOverlay.classList.remove('active');
                body.classList.remove('mobile-nav-open');
            }
        });

        // Close on Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && searchOverlay.classList.contains('active')) {
                searchOverlay.classList.remove('active');
                body.classList.remove('mobile-nav-open');
            }
        });
    }

    // ========================================
    // MOBILE SIDE NAVIGATION
    // ========================================
    const hamburgerBtn = document.getElementById('mobileHamburgerBtn');
    const sideNav = document.getElementById('mobileSideNav');
    const sideNavClose = document.getElementById('mobileSideNavClose');


    if (hamburgerBtn && sideNav && sideNavClose) {

        // Open side navigation
        hamburgerBtn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            sideNav.classList.add('active');
            body.classList.add('mobile-nav-open');
        });

        // Close side navigation
        sideNavClose.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            sideNav.classList.remove('active');
            body.classList.remove('mobile-nav-open');
        });

        // Close on backdrop click
        document.addEventListener('click', function (e) {
            if (body.classList.contains('mobile-nav-open') &&
                !sideNav.contains(e.target) &&
                !hamburgerBtn.contains(e.target) &&
                !searchOverlay.contains(e.target) &&
                !searchBtn.contains(e.target)) {
                sideNav.classList.remove('active');
                searchOverlay.classList.remove('active');
                body.classList.remove('mobile-nav-open');
            }
        });

        // Close on Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && sideNav.classList.contains('active')) {
                sideNav.classList.remove('active');
                body.classList.remove('mobile-nav-open');
            }
        });
    }

    // ========================================
    // CATEGORIES ACCORDION IN SIDE NAV
    // ========================================
    const categoriesTrigger = document.getElementById('mobileCategoriesTrigger');
    const categoriesPanel = document.getElementById('mobileCategoriesPanel');

    if (categoriesTrigger && categoriesPanel) {
        categoriesTrigger.addEventListener('click', function () {
            this.classList.toggle('active');
            categoriesPanel.classList.toggle('active');

            if (categoriesPanel.classList.contains('active')) {
                categoriesPanel.style.maxHeight = categoriesPanel.scrollHeight + 'px';
            } else {
                categoriesPanel.style.maxHeight = '0';
            }
        });
    }

    // ========================================
    // ACCORDION ITEMS (Removed – Categories now direct links)
    // ========================================

    // ========================================
    // CLOSE MENUS ON WINDOW RESIZE
    // ========================================
    window.addEventListener('resize', function () {
        if (window.innerWidth > 768) {
            sideNav?.classList.remove('active');
            searchOverlay?.classList.remove('active');
            body.classList.remove('mobile-nav-open');
        }
    });

    // ========================================
    // UPDATE CART COUNT DYNAMICALLY (if using AJAX)
    // ========================================
    function updateMobileCartCount() {
        const cartCount = document.querySelector('.mobile-cart-count');
        if (cartCount && typeof wc_add_to_cart_params !== 'undefined') {
            // This would be updated via WooCommerce AJAX events
            // You can hook into WooCommerce's added_to_cart event
        }
    }

    // Listen for WooCommerce cart updates
    if (typeof jQuery !== 'undefined') {
        jQuery(document.body).on('added_to_cart removed_from_cart', function () {
            updateMobileCartCount();
        });
    }

    // ========================================
    // MOBILE PRIMARY MENU — SUBMENU ACCORDION
    // Finds every .menu-item-has-children in the
    // .mobile-side-nav-links nav, injects a caret
    // toggle button, and wires tap-to-expand.
    // ========================================
    function initMobileSubmenus() {
        const navLinks = document.querySelector('.mobile-side-nav-links');
        if (!navLinks) return;

        const parentItems = navLinks.querySelectorAll('li.menu-item-has-children');

        parentItems.forEach(function (item) {
            const subMenu = item.querySelector(':scope > .sub-menu');
            if (!subMenu) return;

            // Build caret toggle button
            const toggle = document.createElement('button');
            toggle.className = 'mobile-submenu-toggle';
            toggle.setAttribute('aria-expanded', 'false');
            toggle.setAttribute('aria-label', 'Expand submenu');
            toggle.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="6 9 12 15 18 9"></polyline></svg>';

            // Insert the button after the parent <a>
            const parentLink = item.querySelector(':scope > a');
            if (parentLink) {
                parentLink.insertAdjacentElement('afterend', toggle);
            }

            // Tap toggle
            toggle.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();

                const isOpen = subMenu.classList.contains('open');

                // Close all siblings first (accordion behaviour)
                const siblingItems = item.parentElement.querySelectorAll(':scope > li.menu-item-has-children');
                siblingItems.forEach(function (sibling) {
                    if (sibling !== item) {
                        const sibSubMenu = sibling.querySelector(':scope > .sub-menu');
                        const sibToggle = sibling.querySelector(':scope > .mobile-submenu-toggle');
                        if (sibSubMenu) sibSubMenu.classList.remove('open');
                        if (sibToggle) {
                            sibToggle.classList.remove('open');
                            sibToggle.setAttribute('aria-expanded', 'false');
                        }
                    }
                });

                // Toggle current
                if (isOpen) {
                    subMenu.classList.remove('open');
                    toggle.classList.remove('open');
                    toggle.setAttribute('aria-expanded', 'false');
                } else {
                    subMenu.classList.add('open');
                    toggle.classList.add('open');
                    toggle.setAttribute('aria-expanded', 'true');
                }
            });
        });
    }

    initMobileSubmenus();
});
