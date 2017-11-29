<?php

use App\Tests\FunctionalTester;
use Codeception\Util\HttpCode;

$I = new FunctionalTester($scenario);
$I->am('Regular user');
$I->wantTo('add new comment to post and see it');
$I->amOnPage('/en/login');
$I->seeResponseCodeIs(HttpCode::OK);
$I->fillField('_username', 'john_user');
$I->fillField('_password', 'kitten');
$I->submitForm('.well form', []);
$I->seeResponseCodeIs(HttpCode::OK);
$I->seeCurrentRouteIs('blog_index');
$I->click('article.post > h2 a');
$I->seeResponseCodeIs(HttpCode::OK);
$I->seeCurrentRouteIs('blog_post');
$I->dontSee('Hi, Symfony!');
$I->fillField('comment[content]', 'Hi, Symfony!');
$I->submitForm('#post-add-comment > form', []);
$I->seeCurrentRouteIs('blog_post');
$I->see('Hi, Symfony!');
$I->seeInRepository(\App\Entity\Comment::class, ['content' => 'Hi, Symfony!']);
