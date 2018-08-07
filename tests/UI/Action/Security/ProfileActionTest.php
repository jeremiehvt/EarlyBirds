<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 10/05/2018
 * Time: 08:06
 */

namespace App\Tests\UI\Action\Security;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ProfileActionTest extends WebTestCase
{
    /**
     * @test
     */
    public function testProfileAction()
    {
        $client = static::createClient();

        $client->request('GET', '/profil');

        static::assertSame(
            Response::HTTP_FOUND,
            $client->getResponse()->getStatusCode()
        );
    }
}
