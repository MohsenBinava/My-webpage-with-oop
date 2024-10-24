<?php

use App\Classes\Auth;
use App\Exceptions\NotFoundException;
use App\Templates\CreatePage;
use App\Templates\NotFoundPage;
use App\Templates\PostPage;

session_start();
use App\Classes\Request;
use App\Exceptions\DoesNotExistsException;
use App\Templates\DeletePage;
use App\Templates\EditPage;
use App\Templates\Errorpage;

require('./vendor/autoload.php');

try{
    Auth::checkAuthenticated();
    $request = new Request();
    switch($request->get('action')){
        case 'posts':
            $page =new PostPage();
            break;
        case 'logout':
            Auth::logoutUser();
            break;
        case 'create':
            $page = new CreatePage();
            break;
        case 'edit':
            $page = new EditPage();
            break;
        case 'delete':
            $page = new DeletePage();
            break;
        default:
            throw new NotFoundException('Not found page!');
    }
}catch(DoesNotExistsException | NotFoundException $exception){
    $page = new NotFoundPage($exception->getMessage());
}catch(Exception $exception) {
    $page = new Errorpage($exception->getMessage());
}finally{
    $page->reanderPage();
}