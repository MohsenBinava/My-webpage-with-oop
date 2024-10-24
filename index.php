<?php
session_start();

use App\Classes\Request;
use App\Exceptions\DoesNotExistsException;
use App\Exceptions\NotFoundException;
use App\Templates\CategoryPage;
use App\Templates\Errorpage;
use App\Templates\MainPage;
use App\Templates\NotFoundPage;
use App\Templates\SearchPage;
use App\Templates\SinglePage;
use App\Templates\LoginPage;


require './vendor/autoload.php';
try{
    $request = new Request();

    switch($request->get('action')){
        case 'single':
            $page = new SinglePage() ;
            break;
        case 'search':
            $page = new SearchPage() ;
            break;
        case 'category':
            $page = new CategoryPage() ;
            break;
        case null:
            $page = new MainPage();
            break;
        case 'login':
            $page = new LoginPage() ;
            break;
        default:
            throw new NotFoundException('Page not found!');
    }
    
}catch(DoesNotExistsException | NotFoundException $exception){
    $page = new NotFoundPage($exception->getMessage());
}catch(Exception $exception){
    $page = new Errorpage($exception->getMessage());
}finally{
    $page->reanderPage();
}

