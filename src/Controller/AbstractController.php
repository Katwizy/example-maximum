<?php

namespace Potherca\Katwizy\Example\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

abstract class AbstractController extends Controller
{
    /**
     * Creates a JsonReponse based on given Request and Response
     *
     * @param Request $request
     * @param array $response
     *
     * @return JsonResponse
     */
    final public function createJsonResponse(Request $request, array $response)
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