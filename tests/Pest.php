<?php

// use VendorName\Skeleton\Tests\TestCase;
// uses(TestCase::class)->in(__DIR__);

use Netizens\RB\Tests\RBTestCase;

uses(RBTestCase::class)->in(__DIR__);                           // scan tests/ folder
uses(RBTestCase::class)->in(__DIR__.'/NtRoleBase');           // scan tests/NtRoleBase folder
uses(RBTestCase::class)->in(__DIR__.'/Models');
