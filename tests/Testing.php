<?php


use App\Entity\User\User;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

class Testing extends TestCase
{

    /** @test */

    public function user_methods()
    {
        $user = new App\Entity\User\User();
        $user -> setDisplayName("Antonio");
        $user -> setDiscord("zoom");
        $user -> setDescription("admin");
        $user -> setEmail("admin@sadasdsad.com");
        $user -> setFirstName("Antonio");
        $user -> setLastName("Antonio");

        $this->assertEquals("Antonio", $user->getDisplayName());
        $this->assertEquals("zoom", $user->getDiscord());
        $this->assertEquals("admin", $user->getDescription());
        $this->assertEquals("admin@sadasdsad.com", $user->getEmail());
        $this->assertEquals("Antonio", $user->getFirstName());
        $this->assertEquals("Antonio", $user->getLastName());
    }

		public function testWiring()
	{
		$mock = new MockHandler([
			new Response(200, ['Test' => 'testik'], 'Len tak '),
			new RequestException('Error ', new Request('GET', 'https://127.0.0.1:8001'))
		]);

		$handlerStack = HandlerStack::create($mock);
		$client = new Client(['handler' => $handlerStack]);

			$response = $client->request('GET', '/');
			echo $response->getStatusCode();
			echo $response->getBody();

		$this->assertEquals(200, $response->getStatusCode());
	}

	public function testPostMethods(){
		$post = new \App\Entity\Blog\Post();
		$comment = new \App\Entity\Blog\Comment();
		$post -> addComment($comment);
		$post -> setContent("admin");
		$post -> setTitle("Antonio");

	$this->assertCount(1, $post->getComments());
		$this->assertEquals("admin", $post->getContent());
		$this->assertEquals("Antonio", $post->getTitle());
	}

	public function testTagMethods(){
    	$tag = new \App\Entity\Blog\Tag();
		$tag -> setName('tag');
		$this->assertEquals('tag', $tag ->getName());
    }

    public function  testRoles(){
    $user = new App\Entity\User\User();
    $user->setRoles([]);
    $this->assertSame([User::ROLE_DEFAULT], $user->getRoles());

	}
	public function testSetAdmin(){
    	$user = new App\Entity\User\User();
    	$user->setRoles([User::ROLE_ADMIN]);
    	$this->assertSame([User::ROLE_ADMIN, User::ROLE_DEFAULT] , $user->getRoles());
	}

	public function testRoleCategory(){
    	$role = new \App\Entity\Team\Role();

    	$role->setName('name');
    	$role->setCategory($role::CATEGORY_ADMINISTRATION);
    	$role->setMembers(App\Entity\User\User::class);

    	$this ->assertEquals('name' , $role->getName());
    	$this ->assertSame($role::CATEGORY_ADMINISTRATION, $role->getCategory());
    	$this-> assertSame(User::class, $role->getMembers());
	}

	public function testPartnerEntity(){
    	$partner = new \App\Entity\Partner();

    	$partner->setName('meno');
    	$partner->setDescription('description');
    	$partner->setFacebook('id55797');
    	$partner->setInstagram('id56478');
    	$partner->setLogo('null');
    	$partner->setWebsite(null);

		$this ->assertEquals('meno' , $partner->getName());
		$this ->assertEquals('description' , $partner->getDescription());
		$this ->assertEquals('id55797' , $partner->getFacebook());
		$this ->assertEquals('id56478' , $partner->getInstagram());
		$this ->assertEquals('null' , $partner->getLogo());
		$this ->assertEquals(null, $partner->getWebsite());
	}





}
