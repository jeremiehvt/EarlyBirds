<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 07/05/2018
 * Time: 17:34
 */

namespace App\Tests\UI\Action\Security;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class UserActionTest extends WebTestCase
{
    /**
     * @test
     */
    public function testUserAction()
    {
        $client = static::createClient();

        $client->request('GET', '/se-connecter');

        static::assertSame(
            Response::HTTP_OK,
            $client->getResponse()->getStatusCode()
        );
    }
}
