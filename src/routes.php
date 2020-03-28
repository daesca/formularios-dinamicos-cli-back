<?php
declare(strict_types=1);

use Slim\App;

return function (App $app) {
    $container = $app->getContainer();


    $app->get('/', 'HomeController:home')->setName("home");
    $app->get('/campaign/home', 'CampaignController:home')->setName("home");
    $app->post('/campaign/store', 'CampaignController:store')->setName("store");
    $app->post('/campaign/update', 'CampaignController:update')->setName("update");
    $app->get('/campaign/edit/{id}', 'CampaignController:edit')->setName("edit");
    $app->get('/campaign/remove/{id}', 'CampaignController:remove')->setName("remove");
    $app->get('/campaign/copy/{id}', 'CampaignController:copy')->setName("copy");
    
       
};