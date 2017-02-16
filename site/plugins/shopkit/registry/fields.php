<?php

// Register snippets path for builder field
c::set('buildersnippets.path', kirby()->roots()->plugins().DS.'shopkit'.DS.'snippets'.DS.'builder');

// Register fields
$kirby->set('field', 'builder',      __DIR__.DS.'..'.DS.'fields'.DS.'builder');
$kirby->set('field', 'color',        __DIR__.DS.'..'.DS.'fields'.DS.'color');
$kirby->set('field', 'markdown',     __DIR__.DS.'..'.DS.'fields'.DS.'markdown');
$kirby->set('field', 'tabs',         __DIR__.DS.'..'.DS.'fields'.DS.'tabs');
$kirby->set('field', 'tiers',        __DIR__.DS.'..'.DS.'fields'.DS.'tiers');