<?php

namespace Potherca\Katwizy\Example\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class CoffeePotController extends AbstractController
{
    /**
     * The responding entity MAY be short and stout
     *
     * @Route("/api/coffee")
     * @Method({"BREW", "POST"})
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    final public function makeCoffee(Request $request)
    {
        $statusCode = Response::HTTP_I_AM_A_TEAPOT;

        $response = [
            'status' => 'error',
            'code' => $statusCode,
            'message' => 'The HTCPCP Server is a teapot.',
            'error' => [
                'code' => 'HTCPCP-001',
                'information' => 'The request to brew coffee could not be honoured as the server can only pour tea.',
                'documentation' => 'https://en.wikipedia.org/wiki/Hyper_Text_Coffee_Pot_Control_Protocol',
            ],
        ];

        return $this->createJsonResponse($request, $response);
    }
}

/*EOF*/
