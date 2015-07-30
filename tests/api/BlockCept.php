<?php

$I = new ApiTester($scenario);

$I->wantToTest('Blocks');

require(__DIR__.'/../../components/BlockControllerTrait.php');
$urlAnchor=\app\components\BlockControllerTrait::$blockUrlAnchor;


$I->amGoingTo("Load outerBlock's controller in module");
$I->sendGET("/test/{$urlAnchor}/outer/test-view");
$I->seeResponseCodeIs(200);
$I->seeResponseContains("Outer block controller (in module) is running!");


$I->amGoingTo("Load innerBlock's controller in module");
$I->sendGET("/test/{$urlAnchor}/outer/inner/test-view");
$I->seeResponseCodeIs(200);
$I->seeResponseContains("Inner block controller (in module) is running!");


$I->amGoingTo("Load innerBlock's controller (in module) in module");
$I->sendGET("/{$urlAnchor}/test/test-view");
$I->seeResponseCodeIs(200);
$I->seeResponseContains("Block controller is running!");