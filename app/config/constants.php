<?php

define('SESSION_ADMIN', 'session_admin');

/**
 * UNIT constants
 */
define ('MINUTE',       60 );
define ('HOUR',         3600 );
define ('DAY',          3600 * 24 );
define ('WEEK',         3600 * 24 * 7 );
define ('MONTH',        3600 * 24 * 30 );
define ('YEAR',         3600 * 24 * 365 );

define ('KILO',         1024 );
define ('MEGA',         1024 * 1024 );
define ('GIGA',         1024 * 1024 * 1024 );
define ('TERA',         1024 * 1024 * 1024 * 1024 );


define('STATUS_NEW',                    'New');
define('STATUS_IMPROVING',              'Improving');
define('STATUS_WAITING_APPROVAL',       'Waiting Approval');
define('STATUS_APPROVED',               'Approved');
define('STATUS_PUBLISHED',              'Published');
define('STATUS_PROCESSING',             'Processing');
define('STATUS_PENDING',                'PENDING');
define('STATUS_SENDING',                'SENDING');
define('STATUS_SENT',                   'SENT');
define('STATUS_CONFIRMED',              'Confirmed');
define('STATUS_COMPLETED',              'COMPLETED');
define('STATUS_FAILED',                 'FAILED');
define('STATUS_EXISTED',                'Existed');
define('STATUS_NOT_EXISTED',            'Not Existed');
define('STATUS_ERROR',                  'ERROR');
define('STATUS_CANCELLED',              'Cancelled');
define('STATUS_YES',                    'Yes');
define('STATUS_NO',                     'No');


define('PAYMENT_STATUS_PENDING',        'PENDING');
define('PAYMENT_STATUS_PREAUTH',        'PREAUTH');
define('PAYMENT_STATUS_COMPLETED',      'COMPLETED');
define('PAYMENT_STATUS_ERROR',          'ERROR');
define('PAYMENT_STATUS_CANCELLED',      'CANCELLED');

define('PAYMENT_CARD_TYPE_VISA',        'VISA');
define('PAYMENT_CARD_TYPE_MASTER',      'MASTER');


define('ORDER_CHANNEL_WEBSITE',         'Website');
define('ORDER_CHANNEL_MOBILE',          'Mobile');
define('ORDER_CHANNEL_IHONE_APP',       'iPhone App');
define('ORDER_CHANNEL_ANDROID_APP',     'Android App');
define('ORDER_CHANNEL_WINDOW_APP',      'Window App');


define('OPENID_PROVIDER_DIRECT',        'Direct');
define('OPENID_PROVIDER_FACEBOOK',      'Facebook');
define('OPENID_PROVIDER_TWITTER',       'Twitter');
define('OPENID_PROVIDER_GOOGLE',        'Google');
define('OPENID_PROVIDER_YAHOO',         'Yahoo');
define('OPENID_PROVIDER_HOTMAIL',       'Hotmail');


define('GENDER_MALE',                   'Male');
define('GENDER_FEMALE',                 'Female');
define('GENDER_OTHER',                  'Other');


define('OPERATION_CREDIT',              'Credit');
define('OPERATION_BUY',                 'Buy');


define('APP_IS_DEBUGING',                1);
define('APP_TOKEN_LIFETIME',             60*20);
