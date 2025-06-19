<?php
	if (function_exists('icl_get_languages')) {
		$languages = icl_get_languages('skip_missing=0');
		if (!empty($languages)) {
			echo '<div class="lang-switcher">';
			foreach ($languages as $lang) {
				if ($lang['active']) {
					echo '<div class="lang-active">';
					echo '<a>' . esc_html(strtoupper($lang['code'])) . '</a>';
					echo '</div>';
				}
			}
			echo '<div class="lang-dropdown">';
			foreach ($languages as $lang) {
				if (!$lang['active']) {
					echo '<a href="' . esc_url($lang['url']) . '">' . esc_html(strtoupper($lang['code'])) . '</a>';
				}
			}
			echo '</div>';
			echo '</div>';
		}
	}

