<?php

namespace tests\unit\helpers;

use app\helpers\IpHelper;
use Codeception\Test\Unit;

class IpHelperTest extends Unit
{
    /**
     * @dataProvider ipv4DataProvider
     */
    public function testMaskIpWithIpv4(string $input, string $expected)
    {
        $this->assertEquals($expected, IpHelper::maskIp($input));
    }

    public function ipv4DataProvider(): array
    {
        return [
            ['192.168.1.1', '192.168.**.**'],
            ['10.0.0.1', '10.0.**.**'],
            ['172.16.254.1', '172.16.**.**'],
            ['255.255.255.255', '255.255.**.**'],
            ['0.0.0.0', '0.0.**.**'],
            ['127.0.0.1', '127.0.**.**'],
            ['208.67.222.222', '208.67.**.**'],
            ['8.8.8.8', '8.8.**.**'],
            ['93.184.216.34', '93.184.**.**'],
            ['142.250.185.206', '142.250.**.**'],
            ['192.168.0.1', '192.168.**.**'],
            ['10.1.1.1', '10.1.**.**'],
            ['172.31.255.255', '172.31.**.**'],
        ];
    }

    /**
     * @dataProvider ipv6DataProvider
     */
    public function testMaskIpWithIpv6(string $input, string $expected)
    {
        $this->assertEquals($expected, IpHelper::maskIp($input));
    }

    public function ipv6DataProvider(): array
    {
        return [
            ['2001:0db8:85a3:0000:0000:8a2e:0370:7334', '2001:0db8:85a3:0000:****:****:****:****'],
            ['FE80:0000:0000:0000:0202:B3FF:FE1E:8329', 'FE80:0000:0000:0000:****:****:****:****'],
            ['2001:0db8:0000:0000:0000:ff00:0042:8329', '2001:0db8:0000:0000:****:****:****:****'],
            ['2001:0db8:0000:0000:0000', '2001:****:****:****:****']
        ];
    }
}
