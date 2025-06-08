<?php
	if (function_exists('icl_get_languages')) {
		$languages = icl_get_languages('skip_missing=0');
		if (!empty($languages)) {
			// Always show FR first, then others
			$output = [];
			
			if (isset($languages['fr'])) {
				$fr = $languages['fr'];
				if ($fr['active']) {
					$output[] = '<span class="lang-active">' . esc_html(strtoupper($fr['code'])) . '</span>';
				} else {
					$output[] = '<a href="' . esc_url($fr['url']) . '">' . esc_html(strtoupper($fr['code'])) . '</a>';
				}
			}
			
			foreach ($languages as $lang) {
				if ($lang['code'] === 'fr') {
					continue; // Already handled FR
				}
				
				if ($lang['active']) {
					$output[] = '<span class="lang-active">' . esc_html(strtoupper($lang['code'])) . '</span>';
				} else {
					$output[] = '<a href="' . esc_url($lang['url']) . '">' . esc_html(strtoupper($lang['code'])) . '</a>';
				}
			}
			
			echo '<div class="lang-switcher">' . implode(' | ', $output) . '</div>';
		}
	}

