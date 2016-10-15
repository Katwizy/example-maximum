<?php

namespace Potherca\Katwizy\Example\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ExampleController extends Controller
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

    /**
     * The responding entity MAY be short and stout
     *
     * @Route("/api/coffee")
     * @Method({"BREW", "POST"})
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


    /**
     * @Route("/api/random/")
     */
    final public function randomAction(Request $request)
    {
        return $this->randomLimitAction($request, 100000) ;
    }

    /**
     * @Route("/api/random/{limit}")
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

    private function createJsonResponse(Request $request, array $response)
    {
        $code = $response['code'];

        if ($request->query->get('truncate') !== null) {
            $response = $response['data'];
        } else {
            /*/ HAL /*/
            $response['_links']['self'] = ['href' => $request->getUri()];
            /*/JSON-API /*/
            $response['links']['self'] = $request->getUri();
        }

        /* @TODO: Only enable in DEV environment */
        if ($request->query->get('debug') !== null) {
            $trace = debug_backtrace();
            /* Remove self from stack */
            array_shift($trace);
            $response['debug']['trace'] =  $trace;
        }

        $jsonResponse = new JsonResponse($response, $code);

        if ($request->query->get('pretty') !== null) {
            $jsonResponse->setEncodingOptions(
                $jsonResponse->getEncodingOptions() | JSON_PRETTY_PRINT
            );
        }

        return $jsonResponse;
    }
}
/*EOF*/