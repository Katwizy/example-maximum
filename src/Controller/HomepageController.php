<?php

namespace Potherca\Katwizy\Example\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class HomepageController extends AbstractController
{
    /**
     * @Route("/")
     */
    final public function homeAction()
    {
        $html = <<<HTML
        <p>This is an example controller to demonstrate how to work with controllers.</p>
        <p>This controller has various example functions:</p>
        <ul>
            <li>
                <a href="./api/random/10000">Generate a random number</a>
            </li>
            <li>
            </li>
                <form action="./api/random" method="GET">
                    <input type="hidden" name="truncate" value="true" />
                    <button>Generate a random number</button>
                </form>
            <li>
                <form action="./api/coffee?pretty&debug" method="POST">
                    <button>Brew Some Coffee</button>
                </form>
            </li>
        </ul>
HTML;
        return new Response($html);
    }
}

/*EOF*/
