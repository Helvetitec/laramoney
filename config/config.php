<?php

return [
    'model_currency_field' => 'currency',
    'default_currency' => 'BRL',
    'values_in_cents' => true, //If set to false, values will be saved with * 100
    'casts_null' => false //If true, the LaraMoneyCast can return NULL, if not it will return 0 with default_currency
];