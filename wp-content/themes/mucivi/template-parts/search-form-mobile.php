<div class="search-container search-container-mobile">
    <button id="search-icon-mobile"><i class="bi bi-search"></i></button>
    <div class="search-form-wrapper search-form-wrapper-mobile" id="search-form-wrapper-mobile">
        <form role="search" method="get" class="search-form-mobile" action="<?php echo home_url('/'); ?>">
            <button id="close-search-mobile" class="close-button-search">
                <i class="bi bi-x"></i>
            </button>
            <label>
                <input type="search" class="search-field-mobile" placeholder="<?php echo __('Search …', 'mucivi'); ?>" value="<?php echo get_search_query(); ?>" name="s" title="Search for:" autocomplete="off" />
            </label>
            <button type="submit" class="search-submit">
                <i class="bi bi-search"></i>
            </button>
        </form>
    </div>
</div>
