<?php

/*
* Title                   : Booking System PRO (WordPress Plugin)
* Version                 : 2.0
* File                    : includes/class-currencies.php
* File Version            : 1.0
* Created / Last Modified : 11 June 2014
* Author                  : Dot on Paper
* Copyright               : © 2012 Dot on Paper
* Website                 : http://www.dotonpaper.net
* Description             : Booking System PRO translation PHP class.
*/

    if (!class_exists('DOPBSPCurrencies')){
        class DOPBSPCurrencies{
            /*
             * Currencies list.
             */
            private $currencies = array();
            
            /*
             * Constructor
             */
            function DOPBSPCurrencies(){
                add_filter('dopbsp_filter_currencies', array(&$this, 'set'));
                
                $this->currencies = apply_filters('dopbsp_filter_currencies', $this->currencies);
            }
            
            /*
             * Get currency.
             * 
             * @param code (string): currency code
             * @param field (string): currency field
             * 
             * @return currency field value
             */
            function get($code = 'USD',
                         $field = 'sign'){
                $field_value = '&#36;';
                
                for ($i=0; $i<count($this->currencies); $i++){
                    if ($this->currencies[$i]['code'] == $code){
                        $field_value = $this->currencies[$i][$field];
                        break;
                    }
                }
                
                return $field_value;
            }
            
            /*
             * Get currencies list.
             * 
             * @return currencies array
             */
            function getList(){
                return $this->currencies;
            }
            
            /*
             * Set currencies.
             * 
             * @param currencies (array): initial currencies list 
             * 
             * @return currencies array
             */
            function set($currencies){
                array_push($currencies, array('name' => 'Afghanistan Afghani',
                                              'code' => 'AFN',
                                              'sign' => '&#1547;'));
                array_push($currencies, array('name' => 'Albania Lek',
                                              'code' => 'ALL',
                                              'sign' => '&#76;&#101;&#107;'));
                array_push($currencies, array('name' => 'Algeria Dinar',
                                              'code' => 'DZD',
                                              'sign' => 'دج'));
                array_push($currencies, array('name' => 'Argentina Peso',
                                              'code' => 'ARS',
                                              'sign' => '&#36;'));
                array_push($currencies, array('name' => 'Aruba Guilder',
                                              'code' => 'AWG',
                                              'sign' => '&#402;'));
                array_push($currencies, array('name' => 'Australia Dollar',
                                              'code' => 'AUD',
                                              'sign' => '&#36;'));
                array_push($currencies, array('name' => 'Azerbaijan New Manat',
                                              'code' => 'AZN',
                                              'sign' => '&#1084;&#1072;&#1085;'));
                array_push($currencies, array('name' => 'Bahamas Dollar',
                                              'code' => 'BSD',
                                              'sign' => '&#36;'));
                array_push($currencies, array('name' => 'Barbados Dollar',
                                              'code' => 'BBD',
                                              'sign' => '&#36;'));
                array_push($currencies, array('name' => 'Belarus Ruble',
                                              'code' => 'BYR',
                                              'sign' => '&#112;&#46;'));
                array_push($currencies, array('name' => 'Belize Dollar',
                                              'code' => 'BZD',
                                              'sign' => '&#66;&#90;&#36;'));
                array_push($currencies, array('name' => 'Bermuda Dollar',
                                              'code' => 'BMD',
                                              'sign' => '&#36;'));
                array_push($currencies, array('name' => 'Bolivia Boliviano',
                                              'code' => 'BOB',
                                              'sign' => '&#36;&#98;'));
                array_push($currencies, array('name' => 'Bosnia and Herzegovina Convertible Marka',
                                              'code' => 'BAM',
                                              'sign' => '&#75;&#77;'));
                array_push($currencies, array('name' => 'Botswana Pula',
                                              'code' => 'BWP',
                                              'sign' => '&#80;'));
                array_push($currencies, array('name' => 'Bulgaria Lev',
                                              'code' => 'BGN',
                                              'sign' => '&#1083;&#1074;'));
                array_push($currencies, array('name' => 'Brazil Real',
                                              'code' => 'BRL',
                                              'sign' => '&#82;&#36;'));
                array_push($currencies, array('name' => 'Brunei Darussalam Dollar',
                                              'code' => 'BND',
                                              'sign' => '&#36;'));
                array_push($currencies, array('name' => 'Cambodia Riel',
                                              'code' => 'KHR',
                                              'sign' => '&#6107;'));
                array_push($currencies, array('name' => 'Canada Dollar',
                                              'code' => 'CAD',
                                              'sign' => '&#36;'));
                array_push($currencies, array('name' => 'Cayman Islands Dollar',
                                              'code' => 'KYD',
                                              'sign' => '&#36;'));
                array_push($currencies, array('name' => 'Chile Peso',
                                              'code' => 'CLP',
                                              'sign' => '&#36;'));
                array_push($currencies, array('name' => 'China Yuan Renminbi',
                                              'code' => 'CNY',
                                              'sign' => '&#165;'));
                array_push($currencies, array('name' => 'Colombia Peso',
                                              'code' => 'COP',
                                              'sign' => '&#36;'));
                array_push($currencies, array('name' => 'Costa Rica Colon',
                                              'code' => 'CRC',
                                              'sign' => '&#8353;'));
                array_push($currencies, array('name' => 'Croatia Kuna',
                                              'code' => 'HRK',
                                              'sign' => '&#107;&#110;'));
                array_push($currencies, array('name' => 'Cuba Peso',
                                              'code' => 'CUP',
                                              'sign' => '&#8369;'));
                array_push($currencies, array('name' => 'Czech Republic Koruna',
                                              'code' => 'CZK',
                                              'sign' => '&#75;&#269;'));
                array_push($currencies, array('name' => 'Denmark Krone',
                                              'code' => 'DKK',
                                              'sign' => '&#107;&#114;'));
                array_push($currencies, array('name' => 'Dominican Republic Peso',
                                              'code' => 'DOP',
                                              'sign' => '&#82;&#68;&#36;'));
                array_push($currencies, array('name' => 'East Caribbean Dollar',
                                              'code' => 'XCD',
                                              'sign' => '&#36;'));
                array_push($currencies, array('name' => 'Egypt Pound',
                                              'code' => 'EGP',
                                              'sign' => '&#163;'));
                array_push($currencies, array('name' => 'El Salvador Colon',
                                              'code' => 'SVC',
                                              'sign' => '&#36;'));
                array_push($currencies, array('name' => 'Estonia Kroon',
                                              'code' => 'EEK',
                                              'sign' => '&#107;&#114;'));
                array_push($currencies, array('name' => 'Euro Member Countries',
                                              'code' => 'EUR',
                                              'sign' => '&#8364;'));
                array_push($currencies, array('name' => 'Falkland Islands (Malvinas) Pound',
                                              'code' => 'FKP',
                                              'sign' => '&#163;'));
                array_push($currencies, array('name' => 'Fiji Dollar',
                                              'code' => 'FJD',
                                              'sign' => '&#36;'));
                array_push($currencies, array('name' => 'Ghana Cedis',
                                              'code' => 'GHC',
                                              'sign' => '&#162;'));
                array_push($currencies, array('name' => 'Gibraltar Pound',
                                              'code' => 'GIP',
                                              'sign' => '&#163;'));
                array_push($currencies, array('name' => 'Guatemala Quetzal',
                                              'code' => 'GTQ',
                                              'sign' => '&#81;'));
                array_push($currencies, array('name' => 'Guernsey Pound',
                                              'code' => 'GGP',
                                              'sign' => '&#163;'));
                array_push($currencies, array('name' => 'Guyana Dollar',
                                              'code' => 'GYD',
                                              'sign' => '&#36;'));
                array_push($currencies, array('name' => 'Honduras Lempira',
                                              'code' => 'HNL',
                                              'sign' => '&#76;'));
                array_push($currencies, array('name' => 'Hong Kong Dollar',
                                              'code' => 'HKD',
                                              'sign' => '&#36;'));
                array_push($currencies, array('name' => 'Hungary Forint',
                                              'code' => 'HUF',
                                              'sign' => '&#70;&#116;'));
                array_push($currencies, array('name' => 'Iceland Krona',
                                              'code' => 'ISK',
                                              'sign' => '&#107;&#114;'));
                array_push($currencies, array('name' => 'India Rupee',
                                              'code' => 'INR',
                                              'sign' => 'INR'));
                array_push($currencies, array('name' => 'Indonesia Rupiah',
                                              'code' => 'IDR',
                                              'sign' => 'IDR'));
                array_push($currencies, array('name' => 'Iran Rial',
                                              'code' => 'IRR',
                                              'sign' => '&#65020;'));
                array_push($currencies, array('name' => 'Isle of Man Pound',
                                              'code' => 'IMP',
                                              'sign' => '&#163;'));
                array_push($currencies, array('name' => 'Israel Shekel',
                                              'code' => 'ILS',
                                              'sign' => '&#8362;'));
                array_push($currencies, array('name' => 'Jamaica Dollar',
                                              'code' => 'JMD',
                                              'sign' => '&#74;&#36;'));
                array_push($currencies, array('name' => 'Japan Yen',
                                              'code' => 'JPY',
                                              'sign' => '&#165;'));
                array_push($currencies, array('name' => 'Jersey Pound',
                                              'code' => 'JEP',
                                              'sign' => '&#163;'));
                array_push($currencies, array('name' => 'Kazakhstan Tenge',
                                              'code' => 'KZT',
                                              'sign' => '&#1083;&#1074;'));
                array_push($currencies, array('name' => 'Korea (North) Won',
                                              'code' => 'KPW',
                                              'sign' => '&#8361;'));
                array_push($currencies, array('name' => 'Korea (South) Won',
                                              'code' => 'KRW',
                                              'sign' => '&#8361;'));
                array_push($currencies, array('name' => 'Kyrgyzstan Som',
                                              'code' => 'KGS',
                                              'sign' => '&#1083;&#1074;'));
                array_push($currencies, array('name' => 'Laos Kip',
                                              'code' => 'LAK',
                                              'sign' => '&#8365;'));
                array_push($currencies, array('name' => 'Latvia Lat',
                                              'code' => 'LVL',
                                              'sign' => '&#76;&#115;'));
                array_push($currencies, array('name' => 'Lebanon Pound',
                                              'code' => 'LBP',
                                              'sign' => '&#163;'));
                array_push($currencies, array('name' => 'Liberia Dollar',
                                              'code' => 'LRD',
                                              'sign' => '&#36;'));
                array_push($currencies, array('name' => 'Lithuania Litas',
                                              'code' => 'LTL',
                                              'sign' => '&#76;&#116;'));
                array_push($currencies, array('name' => 'Macedonia Denar',
                                              'code' => 'MKD',
                                              'sign' => '&#1076;&#1077;&#1085;'));
                array_push($currencies, array('name' => 'Malaysia Ringgit',
                                              'code' => 'MYR',
                                              'sign' => '&#82;&#77;'));
                array_push($currencies, array('name' => 'Mauritius Rupee',
                                              'code' => 'MUR',
                                              'sign' => '&#8360;'));
                array_push($currencies, array('name' => 'Mexico Peso',
                                              'code' => 'MXN',
                                              'sign' => '&#36;'));
                array_push($currencies, array('name' => 'Mongolia Tughrik',
                                              'code' => 'MNT',
                                              'sign' => '&#8366;'));
                array_push($currencies, array('name' => 'Mozambique Metical',
                                              'code' => 'MZN',
                                              'sign' => '&#77;&#84;'));
                array_push($currencies, array('name' => 'Namibia Dollar',
                                              'code' => 'NAD',
                                              'sign' => '&#36;'));
                array_push($currencies, array('name' => 'Nepal Rupee',
                                              'code' => 'NPR',
                                              'sign' => '&#8360;'));
                array_push($currencies, array('name' => 'Netherlands Antilles Guilder',
                                              'code' => 'ANG',
                                              'sign' => '&#402;'));
                array_push($currencies, array('name' => 'New Zealand Dollar',
                                              'code' => 'NZD',
                                              'sign' => '&#36;'));
                array_push($currencies, array('name' => 'Nicaragua Cordoba',
                                              'code' => 'NIO',
                                              'sign' => '&#67;&#36;'));
                array_push($currencies, array('name' => 'Nigeria Naira',
                                              'code' => 'NGN',
                                              'sign' => '&#8358;'));
                array_push($currencies, array('name' => 'Korea (North) Won',
                                              'code' => 'KPW',
                                              'sign' => '&#8361;'));
                array_push($currencies, array('name' => 'Norway Krone',
                                              'code' => 'NOK',
                                              'sign' => '&#107;&#114;'));
                array_push($currencies, array('name' => 'Oman Rial',
                                              'code' => 'OMR',
                                              'sign' => '&#65020;'));
                array_push($currencies, array('name' => 'Pakistan Rupee',
                                              'code' => 'PKR',
                                              'sign' => '&#8360;'));
                array_push($currencies, array('name' => 'Panama Balboa',
                                              'code' => 'PAB',
                                              'sign' => '&#66;&#47;&#46;'));
                array_push($currencies, array('name' => 'Paraguay Guarani',
                                              'code' => 'PYG',
                                              'sign' => '&#71;&#115;'));
                array_push($currencies, array('name' => 'Peru Nuevo Sol',
                                              'code' => 'PEN',
                                              'sign' => '&#83;&#47;&#46;'));
                array_push($currencies, array('name' => 'Philippines Peso',
                                              'code' => 'PHP',
                                              'sign' => '&#8369;'));
                array_push($currencies, array('name' => 'Poland Zloty',
                                              'code' => 'PLN',
                                              'sign' => '&#122;&#322;'));
                array_push($currencies, array('name' => 'Qatar Riyal',
                                              'code' => 'QAR',
                                              'sign' => '&#65020;'));
                array_push($currencies, array('name' => 'Romania New Leu',
                                              'code' => 'RON',
                                              'sign' => '&#108;&#101;&#105;'));
                array_push($currencies, array('name' => 'Russia Ruble',
                                              'code' => 'RUB',
                                              'sign' => '&#1088;&#1091;&#1073;'));
                array_push($currencies, array('name' => 'Saint Helena Pound',
                                              'code' => 'SHP',
                                              'sign' => '&#163;'));
                array_push($currencies, array('name' => 'Saudi Arabia Riyal',
                                              'code' => 'SAR',
                                              'sign' => '&#65020;'));
                array_push($currencies, array('name' => 'Serbia Dinar',
                                              'code' => 'RSD',
                                              'sign' => '&#1044;&#1080;&#1085;&#46;'));
                array_push($currencies, array('name' => 'Seychelles Rupee',
                                              'code' => 'SCR',
                                              'sign' => '&#8360;'));
                array_push($currencies, array('name' => 'Singapore Dollar',
                                              'code' => 'SGD',
                                              'sign' => '&#36;'));
                array_push($currencies, array('name' => 'Solomon Islands Dollar',
                                              'code' => 'SBD',
                                              'sign' => '&#36;'));
                array_push($currencies, array('name' => 'Somalia Shilling',
                                              'code' => 'SOS',
                                              'sign' => '&#83;'));
                array_push($currencies, array('name' => 'South Africa Rand',
                                              'code' => 'ZAR',
                                              'sign' => '&#82;'));
                array_push($currencies, array('name' => 'Korea (South) Won',
                                              'code' => 'KRW',
                                              'sign' => '&#8361;'));
                array_push($currencies, array('name' => 'Sri Lanka Rupee',
                                              'code' => 'LKR',
                                              'sign' => '&#8360;'));
                array_push($currencies, array('name' => 'Sweden Krona',
                                              'code' => 'SEK',
                                              'sign' => '&#107;&#114;'));
                array_push($currencies, array('name' => 'Switzerland Franc',
                                              'code' => 'CHF',
                                              'sign' => '&#67;&#72;&#70;'));
                array_push($currencies, array('name' => 'Suriname Dollar',
                                              'code' => 'SRD',
                                              'sign' => '&#36;'));
                array_push($currencies, array('name' => 'Syria Pound',
                                              'code' => 'SYP',
                                              'sign' => '&#163;'));
                array_push($currencies, array('name' => 'Taiwan New Dollar',
                                              'code' => 'TWD',
                                              'sign' => '&#78;&#84;&#36;'));
                array_push($currencies, array('name' => 'Thailand Baht',
                                              'code' => 'THB',
                                              'sign' => '&#3647;'));
                array_push($currencies, array('name' => 'Trinidad and Tobago Dollar',
                                              'code' => 'TTD',
                                              'sign' => '&#84;&#84;&#36;'));
                array_push($currencies, array('name' => 'Turkey Lira',
                                              'code' => 'TRL',
                                              'sign' => '&#8356;'));
                array_push($currencies, array('name' => 'Tuvalu Dollar',
                                              'code' => 'TVD',
                                              'sign' => '&#36;'));
                array_push($currencies, array('name' => 'UAE Dirham',
                                              'code' => 'AED',
                                              'sign' => 'د.إ'));
                array_push($currencies, array('name' => 'Ukraine Hryvna',
                                              'code' => 'UAH',
                                              'sign' => '&#8372;'));
                array_push($currencies, array('name' => 'United Kingdom Pound',
                                              'code' => 'GBP',
                                              'sign' => '&#163;'));
                array_push($currencies, array('name' => 'United States Dollar',
                                              'code' => 'USD',
                                              'sign' => '&#36;'));
                array_push($currencies, array('name' => 'Uruguay Peso',
                                              'code' => 'UYU',
                                              'sign' => '&#36;&#85;'));
                array_push($currencies, array('name' => 'Uzbekistan Som',
                                              'code' => 'UZS',
                                              'sign' => '&#1083;&#1074;'));
                array_push($currencies, array('name' => 'Venezuela Bolivar Fuerte',
                                              'code' => 'VEF',
                                              'sign' => '&#66;&#115;'));
                array_push($currencies, array('name' => 'Viet Nam Dong',
                                              'code' => 'VND',
                                              'sign' => '&#8363;'));
                array_push($currencies, array('name' => 'Yemen Rial',
                                              'code' => 'YER',
                                              'sign' => '&#65020;'));
                array_push($currencies, array('name' => 'Zimbabwe Dollar',
                                              'code' => 'ZWD',
                                              'sign' => '&#90;&#36;'));
                
                return $currencies;
            }
        }
    }