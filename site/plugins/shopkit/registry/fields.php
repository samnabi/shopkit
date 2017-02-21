<?php

// Register path for snippetfield
c::set('snippetfield.path', kirby()->roots()->plugins().DS.'shopkit'.DS.'snippets'.DS.'panel');

// Register fields
$kirby->set('field', 'snippetfield', __DIR__.DS.'..'.DS.'fields'.DS.'snippetfield');
$kirby->set('field', 'color',        __DIR__.DS.'..'.DS.'fields'.DS.'color');
$kirby->set('field', 'markdown',     __DIR__.DS.'..'.DS.'fields'.DS.'markdown');
$kirby->set('field', 'tabs',         __DIR__.DS.'..'.DS.'fields'.DS.'tabs');
$kirby->set('field', 'tiers',        __DIR__.DS.'..'.DS.'fields'.DS.'tiers');