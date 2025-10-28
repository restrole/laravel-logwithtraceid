<?php




return [
  'middleware_groups' => ['api', 'web'],

  'header_name' => 'X-Trace-Id',

  'log_context_key' => 'trace_id',
];
