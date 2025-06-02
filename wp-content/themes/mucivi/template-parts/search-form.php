<div class="search-container search-container-desktop">
    <button class="me-2" id="search-icon"><i class="bi bi-search"></i></button>
    <div class="search-form-wrapper search-form-wrapper-desktop" id="search-form-wrapper">
        <form role="search" method="get" class="search-form-desktop" action="<?php echo home_url('/'); ?>">
            <button id="close-search" class="close-button-search">
                <i class="bi bi-x"></i>
            </button>
            <label>
                <input type="search" class="search-field-desktop" placeholder="<?php echo __('Search …', 'mucivi'); ?>" value="<?php echo get_search_query(); ?>" name="s" title="Search for:" autocomplete="off" />
            </label>
            <button type="submit" class="search-submit">
                <i class="bi bi-search"></i>
            </button>
        </form>
    </div>
</div>


