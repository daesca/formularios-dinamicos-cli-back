<?php 
declare(strict_types = 1);

namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use Slim\Routing\RouteContext;

use App\Models\Campaign;

class CampaignController extends Controller{

    public function home(Request $request, Response $response){

        $campaigns = Campaign::all();

        // $createdCampaigns = [{
        //     code: '25896',
        //     name: 'Campaña creada 1',
        //     category: '1',
        //     dateInit: '2020-01-01',
        //     dateFinal: '2020-12-01',
        //     totalAspirants: '100',
        // }];

        $createdCampaigns = array();

        foreach($campaigns as $campaign){

            $array = array(
                'id' => $campaign->id,
                'code'=> $campaign->code, 
                'name' => $campaign->name, 
                'category' => $campaign->category, 
                'startDate' => $campaign->startDate, 
                'finalDate' => $campaign->finalDate, 
                'totalAspirants' => $campaign->totalAspirants
            );

            array_push($createdCampaigns, $array);

        }

        $createdCampaigns = json_encode($createdCampaigns);

        $response->getBody()->write($createdCampaigns);
        return $response->withHeader('Content-Type', 'application/json');

    }

    public function store(Request $request, Response $response){

        $this->container->get(LoggerInterface::class)->debug(CampaignController::class, ['message' => "Agregando una nueva campaña"]);
        $newCampaignInfo = $request->getParsedBody();

        // print_r($newCampaignInfo);
        // die();
        $newCampaign = new Campaign;

        $newCampaign->code = rand(0, 99999);
        $newCampaign->name = $newCampaignInfo['name'];
        $newCampaign->category = $newCampaignInfo['category'];
        $newCampaign->startDate = $newCampaignInfo['startDate'];
        $newCampaign->finalDate = $newCampaignInfo['finalDate'];
        $newCampaign->totalAspirants = $newCampaignInfo['totalAspirants'];

        if($newCampaign->save()){

            $result = array('code' => 200, 'status' => true, 'message' => 'Campaign created succefully');

        }else{

            $result = array('code' => 500, 'status' => false, 'message' => 'The campaign does not created');

        }

        $result = json_encode($result);

        $response->getBody()->write($result);

        return $response->withHeader('Content-Type', 'application/json');
    }

    public function edit(Request $request, Response $response, $args){

        $this->container->get(LoggerInterface::class)->debug(CampaignController::class, ['message' => "Recuperando campaña con id: ". $args["id"] ." para edicion"]);

        if($campaign = Campaign::findOrFail($args["id"])){

            $array = array(
                'id' => $campaign->id,
                'name' => $campaign->name, 
                'category' => $campaign->category, 
                'startDate' => $campaign->startDate, 
                'finalDate' => $campaign->finalDate, 
                'totalAspirants' => $campaign->totalAspirants
            );


            $result = array('code' => 200, 'status' => true, 'message' => 'Campaign copy saved succefully', 'data' => $array);


        }else{

            $result = array('code' => 404, 'status' => false, 'message' => 'this register does not exist');

        }

        $result = json_encode($result);

        $response->getBody()->write($result);

        return $response->withHeader('Content-Type', 'application/json');

    }

    public function update(Request $request, Response $response){
        
        $updatedInfo = $request->getParsedBody();

        // print_r($updatedInfo["id"]);

        // die();

        $this->container->get(LoggerInterface::class)->debug(CampaignController::class, ['message' => "Editando campaña con id: ". $updatedInfo["id"]]);

        if($campaign = Campaign::findOrFail($updatedInfo["id"])){

            $campaign->name = $updatedInfo['name'];
            $campaign->category = $updatedInfo['category'];
            $campaign->startDate = $updatedInfo['startDate'];
            $campaign->finalDate = $updatedInfo['finalDate'];
            $campaign->totalAspirants = $updatedInfo['totalAspirants'];

            if($campaign->save()){

                $result = array('code' => 200, 'status' => true, 'message' => 'Campaign edited succefully');
    
            }else{
    
                $result = array('code' => 500, 'status' => false, 'message' => 'The campaign does not edited');
    
            }

        }else{

            $result = array('code' => 404, 'status' => false, 'message' => 'this register does not exist');

        }

        $result = json_encode($result);

        $response->getBody()->write($result);

        return $response->withHeader('Content-Type', 'application/json');

    }

    public function copy(Request $request, Response $response, $args){

        $this->container->get(LoggerInterface::class)->debug(CampaignController::class, ['message' => "Copiando campaña con id: ". $args["id"]]);


        if($campaign = Campaign::findOrFail($args["id"])){

            $newCampaign = new Campaign;

            $newCampaign->code = rand(0, 99999);
            $newCampaign->name = $campaign->name;
            $newCampaign->category = $campaign->category;
            $newCampaign->startDate = $campaign->startDate;
            $newCampaign->finalDate = $campaign->finalDate;
            $newCampaign->totalAspirants = $campaign->totalAspirants;

            if($newCampaign->save()){

                $result = array('code' => 200, 'status' => true, 'message' => 'Campaign copy saved succefully');

            }else{

                $result = array('code' => 408, 'status' => false, 'message' => 'Error to save the campaign copy');

            }
            

        }else{

            $result = array('code' => 404, 'status' => false, 'message' => 'this register does not exist');

        }

        $result = json_encode($result);

        $response->getBody()->write($result);
        return $response->withHeader('Content-Type', 'application/json');

    }

    public function remove(Request $request, Response $response, $args){

        $this->container->get(LoggerInterface::class)->debug(CampaignController::class, ['message' => "Removiendo campaña con id: ". $args["id"]]);


        if($deletedRows = Campaign::where('id', $args["id"])->delete()){

            $result = array('code' => 200, 'status' => true);

        }else{

            $result = array('code' => 500, 'status' => false);

        }  
        
        $result = json_encode($result);

        $response->getBody()->write($result);
        return $response->withHeader('Content-Type', 'application/json');

    }


}