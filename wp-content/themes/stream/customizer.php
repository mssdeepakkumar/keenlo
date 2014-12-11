<?php
/*
* Theme Customizer Settings
*
*/
?>
<style type="text/css">
        .navbar-fixed-top { background-color:<?php echo get_theme_mod('main-menu-color'); ?>; }
        .post-views-counter-tag:before { border-color: transparent <?php echo get_theme_mod('primary-color'); ?>; transparent transparent;}
        #secondary {border-top: solid 3px <?php echo get_theme_mod('primary-color'); ?>; }
        a { color: <?php echo get_theme_mod('primary-color'); ?> }
        .tweetable-icon{ color: <?php echo get_theme_mod('primary-color'); ?> }
        .navbar-toggle .icon-bar { background-color: <?php echo get_theme_mod('primary-color'); ?>; } 
        .nav-previous a{background-color: <?php echo get_theme_mod('primary-color'); ?>; }       
        .nav-next a{background-color: <?php echo get_theme_mod('primary-color'); ?>; }  
        .nav .caret {border-top-color: <?php echo get_theme_mod('primary-color'); ?>;border-bottom-color: <?php echo get_theme_mod('primary-color'); ?>; }              
        .nav .open > a, .nav .open > a:hover, .nav .open > a:focus {border-bottom-color: <?php echo get_theme_mod('primary-color'); ?>; }
        #bar { background-color: <?php echo get_theme_mod('primary-color'); ?>; }    
        .cat-title-wrap p.small{ color: <?php echo get_theme_mod('primary-color'); ?>; }  
        .homeCta {     background-color: <?php echo get_theme_mod('primary-color'); ?>; }                   
        .moreCta {     background-color: <?php echo get_theme_mod('primary-color'); ?>; } 
        .tagcloud a {color: <?php echo get_theme_mod('primary-color'); ?>; }
        a:hover, a:focus {color: <?php echo get_theme_mod('primary-color'); ?>; }
        .form-submit #submit{background-color: <?php echo get_theme_mod('primary-color'); ?>; } 
        .nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus { color: <?php echo get_theme_mod('primary-color'); ?>;  } 
        li.cat-item:before { background-color: <?php echo get_theme_mod('primary-color'); ?>; } 
        .from-editor-title { background-color: <?php echo get_theme_mod('primary-color'); ?>; } 
        .popular-summary h4 a:hover { color: <?php echo get_theme_mod('primary-color'); ?>;  }
        #secondary-nav li a {border-top: solid 3px <?php echo get_theme_mod('primary-color'); ?>; }
        .nav > li > a:hover, .nav > li > a:focus { color: <?php echo get_theme_mod('primary-color'); ?>; }
        .navbar-default .navbar-nav > li > a:hover{ color: <?php echo get_theme_mod('primary-color'); ?>; }
        .rpwe-reply {
        border: 1px solid <?php echo get_theme_mod('primary-color'); ?>; 
        background-color: <?php echo get_theme_mod('primary-color'); ?>; 
        }                       
        a.rpwe-reply:hover {   color: <?php echo get_theme_mod('primary-color'); ?>; }
        .us_wrapper a{ color: <?php echo get_theme_mod('primary-color'); ?> !important; }
        .secondary-nav-wrap { background-color: <?php echo get_theme_mod('secondary-color'); ?> ; }           
        .marquee-wrap { background-color: <?php echo get_theme_mod('slider-bg-color'); ?> ; }         
        .footer-wrap { background-color: <?php echo get_theme_mod('footer-color'); ?> ; }  
        <?php if ('stroke-color' != ''){?>.article-wrap { border: solid 1px <?php echo get_theme_mod('stroke-color'); ?> ; }  <?php } ?>
        .social-count-plus ul.default li span.count {color: <?php echo get_theme_mod('primary-color'); ?>; }
        .tweetable a { border-bottom: 0px dotted <?php echo get_theme_mod('primary-color'); ?>;
              color: <?php echo get_theme_mod('primary-color'); ?>;}
        blockquote { border-left: solid 5px <?php echo get_theme_mod('primary-color'); ?>;}
        .review-final-score { background-color: <?php echo get_theme_mod('primary-color'); ?> !important; }
        .review-percentage .review-item span span { background-color: <?php echo get_theme_mod('primary-color'); ?> !important;}
        .auth-social a{ border: solid 1px <?php echo get_theme_mod('primary-color'); ?>;}
        .mag-line{ background-color: <?php echo get_theme_mod('primary-color'); ?>;}
        <?php if ('primary-color' != ''){?> .mag-circle{ border: <?php echo get_theme_mod('primary-color');  ?> solid 2px;}<?php } ?>
        .post-views-counter-tag{ background-color: <?php echo get_theme_mod('primary-color'); ?>;}
        .post-views-counter-tag{   border-color: transparent <?php echo get_theme_mod('primary-color'); ?> transparent transparent ;}   
        .widget > .review_wrap > .review-box > .review-summary > .review-final-score { background-color: <?php echo get_theme_mod('primary-color'); ?> !important;}             
        .archive-jt{ background-color: <?php echo get_theme_mod('primary-color'); ?>;}
        .sharebuttons a:hover { color: #fff; background: <?php echo get_theme_mod('primary-color'); ?>; border: 0; }    
        .tweetable a { text-decoration: none; border-bottom: 0px dotted #63b76c; color: <?php echo get_theme_mod('primary-color'); ?>; background: whitesmoke; }
        .arqam-widget-counter.arq-outer-frame.arq-dark li a i { color: #fff; background: <?php echo get_theme_mod('primary-color'); ?>; }
        .review-score-small-cric { background-color: <?php echo get_theme_mod('primary-color'); ?>; }
        <?php if ('primary-color' != ''){?>#social-icons a { border: 1px solid; <?php echo get_theme_mod('primary-color'); ?> }<?php } ?>
        .footer-wrap li.cat-item:before { background-color: <?php echo get_theme_mod('primary-color'); ?> }     
        .dropdown-menu > li > a:hover,
        .dropdown-menu > li > a:focus {
          color: <?php echo get_theme_mod('primary-color'); ?> ;
        }   

          .ms-view{
            min-height: <?php echo get_theme_mod('themeslug_maxheight'); ?> ;
          }

          .ms-slide{
            height: <?php echo get_theme_mod('themeslug_maxheight'); ?> !important;
          }

          @media(max-width: 600px ){
              .ms-thumb-list.ms-dir-v {
              display: none;
              }  
              .ms-view{
                min-height: <?php echo get_theme_mod('themeslug_minheight'); ?> ;
              }

              .ms-slide{
                height: <?php echo get_theme_mod('themeslug_minheight'); ?> !important;
              }
              .ms-tabs-vertical-template{
                padding-right: 0 !important;
              }
              #progress{
                height: 5px;
              }

          }



        <?php
        $toggle =  get_theme_mod('primary-menu'); 
        if($toggle != 'value1'){ 
        ?>

        @media (min-width: 768px) {
          #main-menu li{
            font-size: 14px;
          }
          #main-menu li:first-child{
            margin-left: 10px;
          }          
          .navbar-right .dropdown-menu {
            right: 0;
            left: auto;
          }
          .nav-tabs.nav-justified > li {
            display: table-cell;
            width: 1%;
          }
          .nav-justified > li {
            display: table-cell;
            width: 1%;
          }
          .navbar {
            border-radius: 4px;
          }
          .navbar-header {
            float: left;
          }
          .navbar-collapse {
            width: auto;
            border-top: 0;
            box-shadow: none;
          }
          .navbar-collapse.collapse {
            display: block !important;
            height: auto !important;
            padding-bottom: 0;
            overflow: visible !important;
          }
          .navbar-collapse.in {
            overflow-y: visible;
          }
          .navbar-collapse .navbar-nav.navbar-left:first-child {
            margin-left: -15px;
          }
          .navbar-collapse .navbar-nav.navbar-right:last-child {
            margin-right: -15px;
          }
          .navbar-collapse .navbar-text:last-child {
            margin-right: 0;
          }
          .container > .navbar-header,
          .container > .navbar-collapse {
            margin-right: 0;
            margin-left: 0;
          }
          .navbar-static-top {
            border-radius: 0;
          }
          .navbar-fixed-top,
          .navbar-fixed-bottom {
            border-radius: 0;
          }
          .navbar > .container .navbar-brand {
            margin-left: -15px;
          }
          .navbar-toggle {
            display: none;
            position: relative;
            float: right !important;
            margin-right: 15px;
            padding: 9px 10px;
            margin-top: 16.5px;
            margin-bottom: 16.5px;
            background-color: transparent;
            border: 1px solid transparent;
            border-radius: 4px;
          }    
          .navbar-nav {
            float: left;
            margin: 0;
          }
          .navbar-nav > li {
            float: left;
          }
          .navbar-nav > li > a {
            padding-top: 22px;
            padding-bottom: 22px;
            line-height: 1em;
            color: #545454;    
          }  
          .navbar-nav > li > a:hover {          
            border-bottom: solid 1px <?php echo get_theme_mod('primary-color'); ?>;
          }
          .navbar-left {
            float: left;
            float: left !important;
          }
          .navbar-right {
            float: right;
            float: right !important;
          } 
          .navbar-form .form-group {
            display: inline-block;
            margin-bottom: 0;
            vertical-align: middle;
          }
          .navbar-form .form-control {
            display: inline-block;
          }
          .navbar-form .radio,
          .navbar-form .checkbox {
            display: inline-block;
            margin-top: 0;
            margin-bottom: 0;
            padding-left: 0;
          }
          .navbar-form .radio input[type="radio"],
          .navbar-form .checkbox input[type="checkbox"] {
            float: none;
            margin-left: 0;
          }
          .navbar-form {
            width: auto;
            border: 0;
            margin-left: 0;
            margin-right: 0;
            padding-top: 0;
            padding-bottom: 0;
            -webkit-box-shadow: none;
            box-shadow: none;
          }  
          .navbar-text {
            margin-left: 15px;
            margin-right: 15px;
          }  
          .navbar-collapse {
            text-align:center;
            border-top: 1px solid transparent;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.1);
            -webkit-overflow-scrolling: touch;
            background-color: none;
          }
          .navbar-default .navbar-nav > .active > a{
            background: none;
            color: <?php echo get_theme_mod('primary-color'); ?>;
            border-bottom: solid 1px <?php echo get_theme_mod('primary-color'); ?>;            
          }
          .navbar-nav > li > .dropdown-menu li a {
            color: <?php echo get_theme_mod('primary-color'); ?>;  
          }
          .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1005;
            display: none;
            float: left;
            min-width: 160px;
            padding: 5px 0;
            margin: 2px 0 0;
            list-style: none;
            background-color: #fafafa;
            border: 1px solid #eee;
            border: 1px solid rgba(0, 0, 0, 0.15);
            border-radius: 0px;
            -webkit-box-shadow: 0 6px 6px rgba(0, 0, 0, 0.175);
            box-shadow: 0 6px 6px rgba(0, 0, 0, 0.175);
            background-clip: padding-box;
          } 
          #main-menu .dropdown-menu > li > a {
            display: block;
            padding: 3px 13px 0px 13px !important;
            clear: both;
            /* font-weight: 300; */
            font-size: 14px;
            font-weight: 700;
            line-height: 1.666;
            /* border: solid 2px transparent; */
            white-space: nowrap;
          }
          #main-menu .dropdown-menu > li:first-child{
            margin: 0;
          }
          .navbar-nav > li > .dropdown-menu:after {
            content: '';
            display: inline-block;
            border-left: 6px solid transparent;
            border-right: 6px solid transparent;
            border-top: 6px solid <?php echo get_theme_mod('primary-color'); ?>;  
            position: absolute;
            bottom: 50px;
            left: 10px;
          }
        }



        @media (max-width: 767px) {
        #main-menu li{
          font-size: 34px;
        }
        .navbar-nav{
          margin: 0;
          font-family: "Vollkorn", Georgia, serif;
          font-weight: 300;
          text-rendering: optimizeLegibility;
          padding: 30px 0;

        }                  
          .navbar-nav .open .dropdown-menu {
            position: static;
            float: none;
            width: auto;
            margin-top: 0;
            background-color: transparent;
            border: 0;
            box-shadow: none;
          }
          .navbar-nav .open .dropdown-menu > li > a,
          .navbar-nav .open .dropdown-menu .dropdown-header {
            padding: 5px 15px 5px 25px;
          }
          .navbar-nav .open .dropdown-menu > li > a {
            line-height: 23px;
          }
          .navbar-nav .open .dropdown-menu > li > a:hover,
          .navbar-nav .open .dropdown-menu > li > a:focus {
            background-image: none;
          }

          .navbar-default .navbar-nav > li > a:hover,
          .navbar-inverse .navbar-nav > li > a:hover,
          .navbar-default .navbar-nav > li > a:focus,
          .navbar-inverse .navbar-nav > li > a:focus {
            background-color: #fafafa;
          }          
          .navbar-form .form-group {
            margin-bottom: 5px;
          }  
          .navbar-collapse {
            text-align:center;
            border-top: 1px solid transparent;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.1);
            -webkit-overflow-scrolling: touch;
            background-color: <?php echo get_theme_mod('primary-color'); ?>;
          }  
          .navbar-default .navbar-nav > li > a, .navbar-inverse .navbar-nav > li > a {
            line-height: 1em;
            color: #fff;
          }
        }

        <?php }else{ ?>

        @media (max-width: 3767px) {
        .navbar-nav{
          margin: 0;
          font-family: "Vollkorn", Georgia, serif;
          font-weight: 300;
          text-rendering: optimizeLegibility;
          padding: 30px 0;
        }                  
          .navbar-nav .open .dropdown-menu {
            position: static;
            float: none;
            width: auto;
            margin-top: 0;
            background-color: transparent;
            border: 0;
            box-shadow: none;
          }
          .navbar-nav .open .dropdown-menu > li > a,
          .navbar-nav .open .dropdown-menu .dropdown-header {
            padding: 5px 15px 5px 25px;
          }
          .navbar-nav .open .dropdown-menu > li > a {
            line-height: 23px;
          }
          .navbar-nav .open .dropdown-menu > li > a:hover,
          .navbar-nav .open .dropdown-menu > li > a:focus {
            background-image: none;
          }
          .navbar-form .form-group {
            margin-bottom: 5px;
          }  
          .navbar-collapse {
            text-align:center;
            border-top: 1px solid transparent;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.1);
            -webkit-overflow-scrolling: touch;
            background-color: <?php echo get_theme_mod('primary-color'); ?>;  
          }  
          .navbar-default .navbar-nav > li > a, .navbar-inverse .navbar-nav > li > a {
            line-height: 1em;
            color: #fff;
            font-size: 32px;
          }
          .navbar-default .navbar-nav > li > a:hover,
          .navbar-inverse .navbar-nav > li > a:hover,
          .navbar-default .navbar-nav > li > a:focus,
          .navbar-inverse .navbar-nav > li > a:focus {
          background-color: #fafafa;
          }
          .navbar-default .navbar-nav > .active > a, .navbar-inverse .navbar-nav > .active > a, .navbar-default .navbar-nav > .active > a:hover, .navbar-inverse .navbar-nav > .active > a:hover, .navbar-default .navbar-nav > .active > a:focus, .navbar-inverse .navbar-nav > .active > a:focus{
            color: <?php echo get_theme_mod('primary-color'); ?>;  
            background-color: #fff;
          }
          .navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus{
            color: <?php echo get_theme_mod('primary-color'); ?>;  
          }
         
        }
        <?php } ?>




</style>
<?php
?>