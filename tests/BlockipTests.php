<?php namespace Olssonm\Blockip;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use Olssonm\Blockip\Http\Middleware\BlockipMiddleware;

class BlockipTests extends \Orchestra\Testbench\TestCase {

	protected $middleware;

	public function setUp()
    {
        parent::setUp();
        $this->middleware = new BlockipMiddleware;
    }

    /**
     * Load the package
     * @return array the packages
     */
    protected function getPackageProviders($app)
    {
        return [
            'Olssonm\Blockip\BlockipServiceProvider'
        ];
    }

	/** @test */
	public function test_route_filter_is_set()
	{
		$middlewares = $this->app->router->getMiddleware();
		$this->assertTrue(in_array('Olssonm\Blockip\Http\Middleware\BlockipMiddleware', $middlewares));
		$this->assertTrue(array_key_exists('blockip', $middlewares));
	}

	/** @test */
	public function test_valid_request()
	{
		$request = new Request();
        $response = new JsonResponse();

        $next = function($request) use ($response) {
            return $response;
        };

        $result = $this->middleware->handle($request, $next);

		$this->assertEquals(200, $result->getStatusCode());
	}

	/** @test */
	public function test_unvalid_request_message()
	{
		// Overload config
		config()->set('blockip.ips', ['127.0.0.1']);

		$request = new Request();
        $response = new JsonResponse();

        $next = function($request) use ($response) {
            return $response;
        };

        $result = $this->middleware->handle($request, $next);

		$this->assertEquals(401, $result->getStatusCode());
		$this->assertEquals(config('blockip.error_message'), $result->getContent());
	}

	/** @test */
	public function test_unvalid_request_view()
	{
		// Overload config
		config()->set('blockip.ips', ['127.0.0.1']);
		config()->set('blockip.error_view', 'blockip::default');

		$request = new Request();
        $response = new JsonResponse();

        $next = function($request) use ($response) {
            return $response;
        };

        $result = $this->middleware->handle($request, $next);

		$this->assertEquals(401, $result->getStatusCode());
		$this->assertContains('This is the default view for the blockip-package', $result->getContent());
	}

	/** @test */
	public function test_unvalid_request_message_cidr()
	{
		// Overload config
		config()->set('blockip.ips', ['127.0.0.1/24']);

		$request = new Request();
        $response = new JsonResponse();

        $next = function($request) use ($response) {
            return $response;
        };

        $result = $this->middleware->handle($request, $next);

		$this->assertEquals(401, $result->getStatusCode());
		$this->assertEquals(config('blockip.error_message'), $result->getContent());
	}
}
