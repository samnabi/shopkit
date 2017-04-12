<?php

/*
---------------------------------------
License Setup
---------------------------------------

Please add your license keys here.

You should have received your Kirby key via email after purchasing Kirby on http://getkirby.com/buy

It is not permitted to run a public website without valid license keys. Please read the End User License Agreement for more information: http://getkirby.com/license

You can retrieve your Shopkit license key from http://shopkit.samnabi.com. Log in or create an account with the email address you used to buy the license. Then click on "View Orders"

*/

c::set('license', '');         // put your Kirby license key here
c::set('license-shopkit', ''); // put your Shopkit license key here


/* 
---------------------------------------
Debugging
---------------------------------------

Show detailed error messages by switching this to 'true'

*/

c::set('debug', false);


/* 
---------------------------------------
Mail Logging
---------------------------------------
Log a copy of all emails sent by Shopkit.
Useful for debugging, but don't enable this on a live site!
The log saves all email content, including one-time access tokens and transaction details.
*/

c::set('mail.log', false);


/* 
---------------------------------------
Timezone
---------------------------------------

A list of supported timezones can be found at http://php.net/manual/en/timezones.php.

*/

c::set('timezone', 'UTC');


/* 
---------------------------------------
Panel install
---------------------------------------

Allow the panel installer to be run from the browser

*/

c::set('panel.install', true);


/* 
---------------------------------------
Homepage
---------------------------------------

If you don't want the shop to be your homepage, you can change this.

*/

c::set('home', 'shop');


/* 
---------------------------------------
Smartypants Setup 
---------------------------------------

Smartypants is a typography plugin, which
helps to improve things like quotes and ellipsises
and all those nifty little typography details. 

You can read more about it here: 
http://michelf.com/projects/php-smartypants/typographer/

*/

c::set('smartypants', true);
c::set('smartypants.attr', 1);
c::set('smartypants.doublequote.open', '&#8220;');
c::set('smartypants.doublequote.close', '&#8221;');
c::set('smartypants.space.emdash', ' ');
c::set('smartypants.space.endash', ' ');
c::set('smartypants.space.colon', '&#160;');
c::set('smartypants.space.semicolon', '&#160;');
c::set('smartypants.space.marks', '&#160;');
c::set('smartypants.space.frenchquote', '&#160;');
c::set('smartypants.space.thousand', '&#160;');
c::set('smartypants.space.unit', '&#160;');
c::set('smartypants.skip', 'pre|code|kbd|script|math');


/*
---------------------------------------
Languages
--------------------------------------

*/

c::set('language.detect', true);
c::set('languages', array(
  array(
    'code'    => 'en',
    'name'    => 'English',
    'default' => true,
    'locale'  => 'en_US',
    'url'     => '/',
  ),
  array(
    'code'    => 'fr',
    'name'    => 'Français',
    'locale'  => 'fr_FR',
    'url'     => '/fr',
  ),
  array(
    'code'    => 'de',
    'name'    => 'Deutsch',
    'locale'  => 'de_DE',
    'url'     => '/de',
  ),
  array(
    'code'    => 'es',
    'name'    => 'Español',
    'locale'  => 'es_ES',
    'url'     => '/es',
  ),
));




/* 
---------------------------------------
WYSIWYG
---------------------------------------

Enable drag-and-drop for WYSIWYG plugin

*/
c::set('field.wysiwyg.dragdrop.kirby', true);
c::set('field.wysiwyg.dragdrop.medium', true);
c::set('field.wysiwyg.double-returns', true);