<?php
/**
 * Created by PhpStorm.
 * User: Neok
 * Date: 05/05/2018
 * Time: 18:02
 */

namespace App\UI\Responder\Interfaces;

use App\Domain\Models\Post;

interface HomeResponderInterface
{
    /**
     * @param array     $observes
     * @param Post|null $post
     *
     * @return mixed
     */
    public function __invoke(array $observes, ?Post $post);
}
