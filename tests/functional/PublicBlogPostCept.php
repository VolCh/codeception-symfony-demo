<?php use App\Tests\FunctionalTester;
$I = new FunctionalTester($scenario);
$I->am('Anonymous');
$I->wantTo('open blog post 1 by slug and see title');

/** @var \App\Entity\Post $blogPost */
$blogPost = $I->grabEntityFromRepository(\App\Entity\Post::class, ['id' => 1]);
$url = sprintf('/en/blog/posts/%s', $blogPost->getSlug());

$I->amOnPage($url);
$I->seeResponseCodeIs(200);
$I->seeCurrentUrlEquals($url);
$I->see($blogPost->getTitle());
