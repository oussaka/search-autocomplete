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
        if (!($text = $request->get('q'))) {
            throw new BadRequestHttpException('Missing "q" parameter.');
        }

        $completion = new Suggest\Completion('search', 'name_suggest');
        $completion->setText($text);
        $completion->setFuzzy(array('fuzziness' => 2));
        $resultSet = $this->get('fos_elastica.index.app.accounts')->search(Query::create($completion));

        $suggestions = array();

        foreach ($resultSet->getSuggests() as $suggests) {
            foreach ($suggests as $suggest) {
                foreach ($suggest['options'] as $option) {
                    $suggestions[] = array(
                        'id' => $option['_source']['id'],
                        'text' => $option['_source']['givenname'],
                        'email' =>  $option['_source']['emailaddress'],
                        'givenname' =>  $option['_source']['givenname'],
                        'username' =>  $option['_source']['username'],
                    );
                }
            }
        }

        return new JsonResponse(array(
            'suggestions' => $suggestions,
        ));
    }
}
