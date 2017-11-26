<?php use App\Tests\FunctionalTester;
$I = new FunctionalTester($scenario);
$I->am('Anonymous');

/** @var \Doctrine\ORM\EntityManager $em */
$em = $I->grabService('doctrine');
/** @var \App\Repository\PostRepository $repository */
$repository = $em->getRepository(\App\Entity\Post::class);
/** @var \App\Entity\Post $blogPost */
$blogPost = $repository->find(1);
$url = sprintf('/en/blog/posts/%s', $blogPost->getSlug());

$I->wantTo('open blog post by slug and see result');

$I->amOnPage($url);
$I->seeResponseCodeIs(200);
$I->seeCurrentUrlEquals($url);
$I->see($blogPost->getTitle());
