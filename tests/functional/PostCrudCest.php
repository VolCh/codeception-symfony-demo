<?php
class PostCrudCest
{
    const POST_ENTITY = 'AppBundle\Entity\Post';
    private $postId;

    protected function createPostInRepository(FunctionalTester $I)
    {
        // creating new record for test purposes
        // will be cleaned up in the end of a test
        $this->postId = $I->haveInRepository(self::POST_ENTITY, [
            'title' => 'Test Post',
            'slug' => 'test-post',
            'content' => 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor.',
            'summary' => 'Lorem ipsum text',
            'authorEmail' => 'anna_admin@symfony.com'
        ]);
    }

    protected function loginAsAdmin(FunctionalTester $I)
    {
        // logging in to site, this could also be done by fillField, click "sign in",
        // as it is in AuthCest
        $I->amGoingTo('log in to site');
        $I->amOnPage('/login');
        $I->submitForm('#main form', ['_username' => 'anna_admin', '_password' => 'kitten']);
    }

    /**
     * @before createPostInRepository
     * @param FunctionalTester $I
     */
    public function viewPostInFrontend(FunctionalTester $I)
    {
        $I->amOnPage('/blog/posts/test-post');
        $I->see('Test Post');
        $I->see('Lorem Ipsum dolor');
    }

    /**
     * @before loginAsAdmin
     */
    public function createPost(FunctionalTester $I)
    {
        $I->amOnPage('/admin/post/');
        $I->click('Create a new post');
        $I->seeCurrentUrlEquals('/admin/post/new');
        $I->fillField('Title', 'Sponsored post');
        $I->fillField('Summary', 'This post is sponsored, move along');
        $I->fillField('Content', 'Please read, this is very important');
        $I->click('Create post');
        $I->see('Post List', 'h1');
        $I->see('Sponsored post', 'table');
        $I->seeInRepository(self::POST_ENTITY, ['title' => 'Sponsored post']);
    }

    /**
     * @before loginAsAdmin
     * @before createPostInRepository
     * @param FunctionalTester $I
     */
    public function viewPostInBackend(FunctionalTester $I)
    {
        $I->amOnPage('/admin/post/');
        $I->see('Test Post', 'table');
        $I->amOnPage('/admin/post/'.$this->postId);
        $I->see('Test Post', 'h1');
        $I->see('Lorem ipsum text');
        $I->seeLink('Edit contents');
    }

    /**
     * @before loginAsAdmin
     * @before createPostInRepository
     * @param FunctionalTester $I
     */
    public function editPost(FunctionalTester $I)
    {
        $I->amOnPage("/admin/post/{$this->postId}/edit");
        $I->see("Edit post #".$this->postId);
        $I->fillField('Title', 'Improved post');
        $I->click('Save changes');
        $I->seeInRepository(self::POST_ENTITY, ['id' => $this->postId, 'title' => 'Improved post']);
        $I->dontSeeInRepository(self::POST_ENTITY, ['id' => $this->postId, 'title' => 'Test post']);
    }

    /**
     * @before loginAsAdmin
     * @before createPostInRepository
     * @param FunctionalTester $I
     */
    public function deletePost(FunctionalTester $I)
    {
        $I->amOnPage("/admin/post/{$this->postId}");
        $I->click('Delete post');
        $I->dontSee('Test post', 'table');
        $I->dontSeeInRepository(self::POST_ENTITY, ['id' => $this->postId]);
    }

}