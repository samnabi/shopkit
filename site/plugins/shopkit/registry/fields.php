<?php

// Register path for snippetfield
c::set('snippetfield.path', kirby()->roots()->plugins().DS.'shopkit'.DS.'snippets'.DS.'panel');

// Register fields
$kirby->set('field', 'tabs',         __DIR__.DS.'..'.DS.'fields'.DS.'tabs');
$kirby->set('field', 'tiers',        __DIR__.DS.'..'.DS.'fields'.DS.'tiers');