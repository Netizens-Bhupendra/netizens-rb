<?php

// use VendorName\Skeleton\Tests\TestCase;
// uses(TestCase::class)->in(__DIR__);

use Netizens\RB\Tests\RBTestCase;
uses(RBTestCase::class)->in(__DIR__);                                   // scan tests folder with its recursive subfolders
uses(RBTestCase::class)->in(__DIR__ . '/NT_RB_Testing/Routes');
uses(RBTestCase::class)->in(__DIR__ . '/NT_RB_Testing/Models');
