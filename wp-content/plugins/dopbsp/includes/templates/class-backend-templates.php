<?php

/*
* Title                   : Booking System Pro (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/templates/class-backend-templates.php
* File Version            : 1.0
* Created / Last Modified : 28 May 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO back end templates PHP class.
*/

    if (!class_exists('DOPBSPBackEndTemplates')){
        class DOPBSPBackEndTemplates extends DOPBSPBackEnd{
            /*
             * Constructor
             */
            function DOPBSPBackEndTemplates(){
            }
        
            /*
             * Prints out the templates page.
             * 
             * @return HTML page
             */
            function view(){
                global $DOPBSP;
                
                $DOPBSP->views->templates->template();
            }
        }
    }