<?php

namespace Potherca\Katwizy\Example\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class RandomNumberController extends AbstractController
{
    /**
     * @Route("/random/")
     */
    final public function randomAction(Request $request)
    {
        return $this->randomLimitAction($request, 100000) ;
    }

    /**
     * @Route("/random/{limit}")
     */
    final public function randomLimitAction(Request $request, $limit)
    {
        $statusCode = Response::HTTP_OK;

        $response = [
            'status' => 'success',
            'code' => $statusCode,
            'message' => 'OK',
            'data' => [
                'number' => mt_rand(0, $limit)
            ],
        ];

        return $this->createJsonResponse($request, $response);
    }

    /**
     * @Route("/random/{limit}")
     */
    public function randomActionHtml(Request $request, $limit)
    {
        $number = rand(0, $limit);

        return $this->render('micro/random.html.twig', array(
            'number' => $number
        ));
    }
}

/*EOF*/
