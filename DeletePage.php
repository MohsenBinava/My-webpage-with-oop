<?php

namespace App\Templates;

use App\Classes\Session;
use App\Modles\Post;

class DeletePage extends Temlate{


    public function __construct()
    {
        parent::__construct();

        if(! $this->request->has('id'))
            redirect('panel.php',['action' => 'posts']);

        $id = $this->request->get('id');

        $postModle = new Post();
        $post = $postModle->getDataById($id);

        $postModle->deleteData($post->getId());
        deleteFile($post->getImage());

        Session::flush('message','Post was deleted.');
        redirect('panel.php',['action' => 'posts']);

    }

    public function reanderPage(){
        echo "delete page";
    }
}