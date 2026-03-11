// Mobile Menu Toggle Functionality
document.addEventListener('DOMContentLoaded', function () {
    const menuToggle = document.querySelector('.mobile-menu-toggle-custom');
    const mobileMenu = document.querySelector('.mobile-nav-menu');
    const body = document.body;

    if (menuToggle && mobileMenu) {
        menuToggle.addEventListener('click', function () {
            // Toggle active class on button
            menuToggle.classList.toggle('active');

            // Toggle active class on menu
            mobileMenu.classList.toggle('active');

            // Toggle body scroll
            body.classList.toggle('mobile-menu-open');

            // Update aria-expanded attribute
            const isExpanded = menuToggle.classList.contains('active');
            menuToggle.setAttribute('aria-expanded', isExpanded);
        });

        // Close menu when clicking on a link
        const mobileLinks = mobileMenu.querySelectorAll('a');
        mobileLinks.forEach(link => {
            link.addEventListener('click', function () {
                menuToggle.classList.remove('active');
                mobileMenu.classList.remove('active');
                body.classList.remove('mobile-menu-open');
                menuToggle.setAttribute('aria-expanded', 'false');
            });
        });

        // Close menu when clicking outside
        document.addEventListener('click', function (event) {
            const isClickInsideMenu = mobileMenu.contains(event.target);
            const isClickOnToggle = menuToggle.contains(event.target);

            if (!isClickInsideMenu && !isClickOnToggle && mobileMenu.classList.contains('active')) {
                menuToggle.classList.remove('active');
                mobileMenu.classList.remove('active');
                body.classList.remove('mobile-menu-open');
                menuToggle.setAttribute('aria-expanded', 'false');
            }
        });

        // Close menu on window resize to desktop size
        window.addEventListener('resize', function () {
            if (window.innerWidth > 768 && mobileMenu.classList.contains('active')) {
                menuToggle.classList.remove('active');
                mobileMenu.classList.remove('active');
                body.classList.remove('mobile-menu-open');
                menuToggle.setAttribute('aria-expanded', 'false');
            }
        });
    }
});

// Mobile Mega Menu & Accordion Functionality
document.addEventListener('DOMContentLoaded', function () {
    // 1. Mega Menu Toggle
    const categoriesToggle = document.getElementById('mobileCategoriesToggle');
    const megaMenu = document.getElementById('mobileMegaMenu');
    const megaClose = document.getElementById('mobileMegaClose');
    const body = document.body;

    if (categoriesToggle && megaMenu && megaClose) {
        categoriesToggle.addEventListener('click', function () {
            megaMenu.classList.add('active');
            body.classList.add('mobile-menu-open'); // Reuse existing class to lock scroll
        });

        megaClose.addEventListener('click', function () {
            megaMenu.classList.remove('active');
            body.classList.remove('mobile-menu-open');
        });
    }

    // 2. Accordion Logic
    const accordionTriggers = document.querySelectorAll('.mobile-accordion-trigger');

    accordionTriggers.forEach(trigger => {
        trigger.addEventListener('click', function () {
            const panel = this.nextElementSibling;

            // Toggle current item
            this.classList.toggle('active');

            if (panel.style.maxHeight) {
                // Close
                panel.style.maxHeight = null;
            } else {
                // Open
                // Optional: Close others
                accordionTriggers.forEach(otherTrigger => {
                    if (otherTrigger !== this && otherTrigger.classList.contains('active')) {
                        otherTrigger.classList.remove('active');
                        otherTrigger.nextElementSibling.style.maxHeight = null;
                    }
                });

                panel.style.maxHeight = panel.scrollHeight + "px";
            }
        });
    });
});
