<?php

namespace frontend\tests\functional;

use frontend\tests\FunctionalTester;

class HomeCest
{
    public function checkOpen(FunctionalTester $I)
    {
        $I->amOnRoute(\Yii::$app->homeUrl);
        $I->seeInTitle('Starter Page');
        //$I->seeLink('Manicure');
        //$I->click('Manicure');
       // $I->see('How to cut the cuticle 132');
    }
}