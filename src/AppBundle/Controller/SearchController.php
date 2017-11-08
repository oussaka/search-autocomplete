<?php

namespace AppBundle\Controller;

use Elastica\Query;
use Elastica\Suggest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * @Route("/search")
 */
class SearchController extends Controller
{
    /**
     * @Route("/accounts", name="search_accounts", options={"expose"=true})
     * @param Request $request
     * @return JsonResponse
     */
    public function getRestaurantsAction(Request $request)
    {
        if (!($text = $request->get('search'))) {
            throw new BadRequestHttpException('Missing "search" parameter.');
        }

        $suggestions = array();

        return new JsonResponse(array(
            'suggestions' => $suggestions,
        ));
    }
}
