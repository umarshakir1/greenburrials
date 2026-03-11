<?php
/**
 * The template for displaying 404 pages (not found)
 */

get_header();
?>

<div class="container page-main-container">
    <section class="error-404 not-found">
        <header class="page-header">
            <h1 class="page-title">404</h1>
            <h2 class="error-subtitle">Oops! That page can&rsquo;t be found.</h2>
            <div class="title-divider"></div>
        </header>

        <div class="page-content text-center">
            <p>It looks like nothing was found at this location. Maybe try a search?</p>
            <div class="error-search-form">
                <?php get_search_form(); ?>
            </div>
            <div class="error-actions" style="margin-top: 2rem;">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-hero" style="display: inline-block;">Back to Home</a>
            </div>
        </div>
    </section>
</div>

<style>
.error-404 {
    text-align: center;
    padding: 5rem 0;
}
.error-404 .page-title {
    font-size: 10rem !important;
    line-height: 1;
    margin-bottom: 0 !important;
    color: #f5f5f5 !important;
    font-weight: 800;
}
.error-subtitle {
    font-size: 2.5rem;
    color: #73884D;
    margin-top: -3rem;
    position: relative;
    z-index: 1;
    font-family: 'Times New Roman', Times, serif;
}
.title-divider {
    width: 60px;
    height: 3px;
    background: #C4B768;
    margin: 1.5rem auto 2.5rem;
}
.error-search-form {
    max-width: 500px;
    margin: 2rem auto;
}
.error-search-form .search-form {
    display: flex;
    align-items: stretch;
}
.error-search-form .search-form label {
    flex: 1;
    margin-bottom: 0;
    display: block;
}
.error-search-form .search-field {
    width: 100%;
    height: 50px;
    padding: 10px 20px;
    border: 1px solid #ddd;
    border-radius: 30px 0 0 30px;
    font-size: 1rem;
    outline: none;
    box-sizing: border-box;
}
.error-search-form .search-submit {
    height: 50px;
    padding: 0 30px;
    background-color: #73884D !important;
    color: #fff !important;
    border: none;
    border-radius: 0 30px 30px 0;
    font-weight: 700;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-left: -1px;
}
.error-search-form .search-submit:hover {
    background-color: #5a6b3d !important;
}

.screen-reader-text {
    border: 0;
    clip: rect(1px, 1px, 1px, 1px);
    clip-path: inset(50%);
    height: 1px;
    margin: -1px;
    overflow: hidden;
    padding: 0;
    position: absolute;
    width: 1px;
    word-wrap: normal !important;
}

.btn-hero {
    background: #73884D;
    color: #fff !important;
    padding: 12px 35px;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 700;
    transition: all 0.3s ease;
    text-transform: uppercase;
    font-family: 'Times New Roman', Times, serif;
    font-size: 0.9rem;
    letter-spacing: 1px;
}
.btn-hero:hover {
    background: #5a6b3d;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

@media (max-width: 768px) {
    .error-404 {
        padding: 3rem 1rem;
    }
    .error-404 .page-title {
        font-size: 6rem !important;
    }
    .error-subtitle {
        font-size: 1.8rem;
        margin-top: -1.5rem;
    }
    .error-search-form .search-submit {
        padding: 0 20px;
    }
}
</style>

<?php
get_footer();
