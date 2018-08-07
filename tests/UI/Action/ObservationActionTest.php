<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 07/05/2018
 * Time: 17:33
 */

namespace App\Tests\UI\Action;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ObservationActionTest extends WebTestCase
{
    /**
     * @test
     */
    public function testObservationAction()
    {
        $client = static::createClient();

        $client->request('GET', '/saisir-observation');

        static::assertSame(
            Response::HTTP_FOUND,
            $client->getResponse()->getStatusCode()
        );
    }
}
