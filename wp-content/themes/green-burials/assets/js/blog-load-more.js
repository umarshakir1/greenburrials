document.addEventListener('DOMContentLoaded', function () {
    const loadMoreBtn = document.getElementById('load-more-posts');
    const postsContainer = document.querySelector('.blog-grid');
    const spinner = document.querySelector('.load-more-container .loading-spinner-container');
    let isLoading = false;

    function loadMorePosts() {
        if (isLoading || !loadMoreBtn) return;

        const page = parseInt(loadMoreBtn.getAttribute('data-page'));
        const maxPages = parseInt(loadMoreBtn.getAttribute('data-max-pages'));
        const nextPage = page + 1;

        if (nextPage > maxPages) {
            loadMoreBtn.remove();
            return;
        }

        isLoading = true;
        loadMoreBtn.style.display = 'none';
        if (spinner) spinner.style.display = 'flex';

        const formData = new FormData();
        formData.append('action', 'green_burials_load_more_posts');
        formData.append('page', nextPage);

        fetch('/wp-admin/admin-ajax.php', {
            method: 'POST',
            body: formData
        })
            .then(response => response.text())
            .then(data => {
                if (data.trim().length > 0) {
                    postsContainer.insertAdjacentHTML('beforeend', data);
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
                console.error('Error loading more posts:', error);
                isLoading = false;
                loadMoreBtn.style.display = 'inline-block';
                if (spinner) spinner.style.display = 'none';
            });
    }

    if (loadMoreBtn && postsContainer) {
        loadMoreBtn.addEventListener('click', loadMorePosts);
    }
});
