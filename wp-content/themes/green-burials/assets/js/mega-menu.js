(function () {
    'use strict';

    /**
     * Initialize the mega menu functionality
     */
    function initMegaMenu() {
        const trigger = document.querySelector('.all-categories-trigger');
        const dropdown = document.getElementById('allCategoriesDropdown');
        const catItems = document.querySelectorAll('.mega-cat-item');
        const contents = document.querySelectorAll('.mega-menu-content');

        // Check if required elements exist
        if (!trigger || !dropdown) {
            return;
        }

        // Toggle mega menu on trigger click
        trigger.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            dropdown.classList.toggle('active');
        });

        // Handle category item hover to switch content
        catItems.forEach(function (item) {
            item.addEventListener('mouseenter', function () {
                const catId = this.getAttribute('data-category-id');

                // Remove active class from all category items
                catItems.forEach(function (i) {
                    i.classList.remove('active');
                });

                // Add active class to current item
                this.classList.add('active');

                // Hide all content panels
                contents.forEach(function (c) {
                    c.style.display = 'none';
                });

                // Show the target content panel
                const targetContent = document.getElementById('mega-content-' + catId);
                if (targetContent) {
                    targetContent.style.display = 'flex';
                }
            });
        });

        // Close mega menu when clicking outside
        document.addEventListener('click', function (e) {
            if (!dropdown.contains(e.target) && !trigger.contains(e.target)) {
                dropdown.classList.remove('active');
            }
        });

        // Prevent clicks inside the dropdown from closing it
        dropdown.addEventListener('click', function (e) {
            e.stopPropagation();
        });
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initMegaMenu);
    } else {
        initMegaMenu();
    }
})();
