<?php

        add_shortcode('woocommerce_my_waitlist', array( WooCommerce_Waitlist_Plugin::$Pie_WCWL_Frontend_UI, 'current_user_waitlist' ) );