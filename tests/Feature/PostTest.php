<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PostTest extends TestCase
{
    use RefreshDatabase;
    /**
     * test DB Connection
     *
     * @return void
     */
    // public function testNoBlogPostsWhenNothingInDatabase()
    // {
    //     $response = $this->get('/posts');

    //     $response->assertSeeText('No blog posts yet!');
    // }

    public function testSee1BlogPostWhenThereIs1WithNoComments()
    {
        // Arrange
        $post = $this->createDummyBlogPost();

        // Act
        $response = $this->get('/posts');
            
        // Assert
        $response->assertSeeText('I am changed!');
        $response->assertSeeText('No comments yet!');

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'I am changed!',
            'content' => 'I am the content'
        ]);
    }

    public function testSee1BlogPostWithComments()
    {
        // Arrange
        $post = $this->createDummyBlogPost();
        Comment::factory(4)->create([
            'blog_post_id' => $post->id
        ]);

        // Act
        $response = $this->get('/posts');

        // Assert
        $response->assertSeeText('4 comments');
    }

    public function testStoreValid()
    {
        $params = [
            'title' => 'Valid title',
            'content' => 'At least 10 characters'
        ];

        $this->actingAs($this->user())
             ->post('/posts', $params)
             ->assertStatus(302)
             ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'The blog post was created!');
    }

    public function testStoreFail()
    {
        $params = [
            'title' => 'x',
            'content' => 'x'
        ];

        $this->actingAs($this->user())
             ->post('/posts', $params)
             ->assertStatus(302)
             ->assertSessionHas('errors');

        $messages = session('errors')->getMessages();
        
        $this->assertEquals($messages['title'][0], 'The title must be at least 5  characters.');
        $this->assertEquals($messages['content'][0], 'The content must be at least 10 characters.');
    }

    public function testUpdateValid()
    {
        $post = $this->createDummyBlogPost();

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'I am changed!',
            'content' => 'I am the content'
        ]);
        
        $params = [
            'title' => 'A new named title',
            'content' => 'Content was changed'
        ];

        $this->actingAs($this->user())
             ->put("/posts/{$post->id}", $params)
             ->assertStatus(302)
             ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Blog post was updated!');
        $this->assertDatabaseMissing('blog_posts', [
            'title' => 'I am changed!',
            'content' => 'I am the content'
        ]);
        $this->assertDatabaseHas('blog_posts', [
            'title' => 'A new named title',
            'content' => 'Content was changed'
        ]);
    }

    public function testDelete()
    {
        $post = $this->createDummyBlogPost();
        $this->assertDatabaseHas('blog_posts', [
            'title' => 'I am changed!',
            'content' => 'I am the content'
        ]);

        $this->actingAs($this->user())
             ->delete("/posts/{$post->id}")
             ->assertStatus(302)
             ->assertSessionHas('status');
        
        $this->assertEquals(session('status'), 'Blog post was deleted!');
        $this->assertDatabaseMissing('blog_posts', [
            'title' => 'I am changed!',
            'content' => 'I am the content'
        ]);
    }

    private function createDummyBlogPost(): BlogPost
    {
        // $post
        return \App\Models\BlogPost::factory()->newTitle()->create();
    }
}
