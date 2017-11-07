<?php
/**
 * Created by PhpStorm.
 * User: quentin
 * Date: 11/7/17
 * Time: 8:44 AM
 */

namespace App\Controller;

use Respect\Validation\Rules\Date;
use Slim\Http\Request;
use App\Model\Giftlist;
use Slim\Http\Response;

class ListController extends Controller
{
    public function myLists(Request $request, Response $response){
        $lists = Giftlist::where('user_id', $this->auth->getUser()->id)->get();

        $currentDate = strtotime(date_format(new \DateTime(), 'Y-m-d'));
        $data = [
                'lists' => $lists,
                'current' => $currentDate
            ];

        return $this->view->render($response, 'App/mylists.twig', $data);

    }

    public function addList(Request $request, Response $response){
        return $this->view->render($response, 'App/addlist.twig');
    }

}