document.addEventListener('DOMContentLoaded', function () {
    // Sidebar Toggle (Hide Filters)
    const toggleBtn = document.getElementById('toggle-filters');
    const gridWrapper = document.getElementById('shop-grid-wrapper');
    const toggleText = toggleBtn ? toggleBtn.querySelector('.toggle-text') : null;

    if (toggleBtn && gridWrapper) {
        const applyInitialState = () => {
            const isMobile = window.innerWidth <= 768;

            if (isMobile) {
                gridWrapper.classList.add('sidebar-hidden');
                toggleBtn.classList.add('collapsed');
                if (toggleText) toggleText.textContent = 'SHOW FILTERS';
            } else {
                gridWrapper.classList.remove('sidebar-hidden');
                toggleBtn.classList.remove('collapsed');
                if (toggleText) toggleText.textContent = 'HIDE FILTERS';
            }
        };

        applyInitialState();

        toggleBtn.addEventListener('click', function () {
            gridWrapper.classList.toggle('sidebar-hidden');
            toggleBtn.classList.toggle('collapsed');

            if (gridWrapper.classList.contains('sidebar-hidden')) {
                toggleText.textContent = 'SHOW FILTERS';
            } else {
                toggleText.textContent = 'HIDE FILTERS';
            }
        });

        window.addEventListener('resize', applyInitialState);
    }

    // Accordion Toggles for Sidebar Sections
    const filterHeaders = document.querySelectorAll('.filter-section-header');

    filterHeaders.forEach(header => {
        const section = header.parentElement;
        const icon = header.querySelector('.filter-toggle-icon');

        if (icon) {
            icon.textContent = section.classList.contains('active') ? '×' : '+';
        }

        header.addEventListener('click', function () {
            const currentSection = this.parentElement;
            currentSection.classList.toggle('active');

            const currentIcon = this.querySelector('.filter-toggle-icon');
            if (currentIcon) {
                currentIcon.textContent = currentSection.classList.contains('active') ? '×' : '+';
            }
        });
    });

    // Load More Products
    const loadMoreBtn = document.getElementById('load-more-products');
    const productsContainer = document.querySelector('.shop-content .products');
    const spinner = document.querySelector('.load-more-container .loading-spinner-container');
    let isLoading = false;

    function loadMoreProducts() {
        if (isLoading || !loadMoreBtn) return;

        const page = parseInt(loadMoreBtn.getAttribute('data-page'));
        const maxPages = parseInt(loadMoreBtn.getAttribute('data-max-pages'));
        const category = loadMoreBtn.getAttribute('data-category');
        const nextPage = page + 1;

        if (nextPage > maxPages) {
            loadMoreBtn.remove();
            return;
        }

        isLoading = true;
        loadMoreBtn.style.display = 'none';
        if (spinner) spinner.style.display = 'flex';

        const formData = new FormData();
        formData.append('action', 'green_burials_load_more');
        formData.append('page', nextPage);
        if (category) {
            formData.append('category', category);
        }

        // Get current size filter from URL
        const urlParams = new URLSearchParams(window.location.search);
        const sizeFilter = urlParams.get('filter_size');
        if (sizeFilter) {
            formData.append('filter_size', sizeFilter);
        }

        console.log('Loading page ' + nextPage + ' for category: ' + category);

        // Get all current product IDs to skip them in the next query
        const currentProducts = productsContainer.querySelectorAll('.product');
        const existingIds = [];
        currentProducts.forEach(product => {
            const classes = product.className.split(' ');
            classes.forEach(cls => {
                if (cls.startsWith('post-')) {
                    existingIds.push(cls.replace('post-', ''));
                }
            });
        });

        if (existingIds.length > 0) {
            formData.append('existing_ids', existingIds.join(','));
        }

        // Get current sorting if available
        const sortingSelect = document.querySelector('.woocommerce-ordering select.orderby');
        if (sortingSelect) {
            formData.append('orderby', sortingSelect.value);
        }

        fetch('/wp-admin/admin-ajax.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(data => {
                if (data.trim().length > 0) {
                    productsContainer.insertAdjacentHTML('beforeend', data);
                    loadMoreBtn.setAttribute('data-page', nextPage);

                    if (nextPage >= maxPages) {
                        loadMoreBtn.remove();
                    } else {
                        loadMoreBtn.style.display = 'inline-block';
                    }
                } else {
                    loadMoreBtn.remove();
                }
                isLoading = false;
                if (spinner) spinner.style.display = 'none';
            })
            .catch(error => {
                console.error('Error loading more products:', error);
                isLoading = false;
                loadMoreBtn.style.display = 'inline-block';
                if (spinner) spinner.style.display = 'none';
            });
    }

    if (loadMoreBtn && productsContainer) {
        loadMoreBtn.addEventListener('click', loadMoreProducts);

        // Infinite Scroll
        window.addEventListener('scroll', function () {
            if (loadMoreBtn && loadMoreBtn.parentElement) {
                const rect = loadMoreBtn.getBoundingClientRect();
                if (rect.top < window.innerHeight + 100 && !isLoading) {
                    loadMoreProducts();
                }
            }
        });
    }

    // Grid Layout Switcher Logic
    const gridSwitcher = document.querySelector('.grid-layout-switcher');
    const gridBtns = document.querySelectorAll('.grid-btn');

    if (gridSwitcher && gridBtns.length > 0) {
        const STORAGE_KEY = 'gb_shop_grid_columns';

        const setGridLayout = (cols) => {
            const currentShopContent = document.querySelector('.shop-content');
            if (!currentShopContent) return;

            // Remove existing column classes
            currentShopContent.classList.remove('columns-1', 'columns-2', 'columns-3', 'columns-4');
            // Add new column class
            currentShopContent.classList.add(`columns-${cols}`);

            // Update button active state
            gridBtns.forEach(btn => {
                if (btn.getAttribute('data-columns') === cols.toString()) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });

            // Save to LocalStorage
            localStorage.setItem(STORAGE_KEY, cols);

            // Trigger a resize event to layout any scripts that might depend on column width
            window.dispatchEvent(new Event('resize'));
        };

        // Initialize from LocalStorage
        const initLayout = () => {
            const savedLayout = localStorage.getItem(STORAGE_KEY);
            if (savedLayout && ['1', '2', '3', '4'].includes(savedLayout)) {
                setGridLayout(savedLayout);
            } else {
                // Default 3 columns for desktop (as seen in CSS)
                setGridLayout(3);
            }
        };

        // Initial run
        initLayout();

        // Re-run after a short delay to catch any late-loading content or AJAX replacements
        setTimeout(initLayout, 500);

        // Add Click Events
        gridBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                const cols = this.getAttribute('data-columns');
                setGridLayout(cols);
            });
        });

        // Listen for AJAX completion (common Woo events)
        document.body.addEventListener('post-load', initLayout);
        document.body.addEventListener('updated_wc_div', initLayout);
    }
});
