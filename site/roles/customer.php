<?php

return [
  'name' => 'Customer',
  'default' => true,
  'permissions' => [
    '*' => false,
    'panel.access' => true,
    'panel.access.users' => function() { return strstr(kirby()->path(), 'users/'.$this->user()->username().'/') ? true : false; },
    'panel.user.delete' => function() { return $this->user()->is($this->target()->user()) ? true : false; },
    'panel.user.read' => function() { return $this->user()->is($this->target()->user()) ? true : false; },
    'panel.user.update' => function() { return $this->user()->is($this->target()->user()) ? true : false; },
  ]
];