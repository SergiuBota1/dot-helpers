<?php

declare(strict_types=1);

namespace DotTest\Helpers;

use Dot\Helpers\Factory\RouteHelperFactory;
use Dot\Helpers\Route\RouteHelper;
use Mezzio\Helper\ServerUrlHelper;
use Mezzio\Helper\UrlHelper;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use TypeError;

class RouteHelperFactoryTest extends TestCase
{
    private ContainerInterface|MockObject $containerInterface;

    /**
     * @throws Exception
     */
    public function setUp(): void
    {
        $this->routeHelperFactory = new RouteHelperFactory();
        $this->containerInterface = $this->createMock(ContainerInterface::class);
    }

    public function testWillNotCreateWithoutParams(): void
    {
        $this->containerInterface->method('get')->willReturnMap([
            [UrlHelper::class, null],
            [ServerUrlHelper::class, null],
        ]);

        $this->expectException(TypeError::class);

        (new RouteHelperFactory())($this->containerInterface);
    }


    /**
     * @throws Exception
     */
    public function testWillCreateWithParams(): void
    {
        $this->containerInterface->method('get')->willReturnMap([
            [UrlHelper::class, $this->createMock(UrlHelper::class)],
            [ServerUrlHelper::class, $this->createMock(ServerUrlHelper::class)],
        ]);

        $routeHelper = (new RouteHelperFactory())($this->containerInterface);

        $this->assertInstanceOf(RouteHelper::class, $routeHelper);
    }
}
