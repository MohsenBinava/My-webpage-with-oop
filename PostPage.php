<?php
namespace App\Templates;

use App\Classes\Session;
use App\Modles\Post;

class PostPage extends Temlate{

    private $posts;

    public function __construct(){
        parent::__construct();

        $this->title = $this->setting->getTitle().' - Admin panel - all posts';
        $postModle = new Post();
        $this->posts = $postModle->getAllData();
    }

    private function showMessage()
    {
        if(Session::get('message')):
            ?>
                <div class="message">
                    <?= Session::flush('message'); ?>
                </div>
            <?php
            endif;
    }

    public function reanderPage(){
        ?>
            <html>
                <?php $this->getAdminHead() ?>
                <body>
                    <main>
                        <?php $this->getAdminNavbar() ?>
                        <section class="content">
                            <?php $this->showMessage() ?>
                            <?php if(count($this->posts)): ?>
                            <table>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>View</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach( $this->posts as $post ): ?>
                                    <tr>
                                        <td><?=$post->getId() ?></td>
                                        <td><?= $post->getTitle() ?></td>
                                        <td><?= $post->getCategory() ?></td>
                                        <td><?= $post->getView() ?> View</td>
                                        <td><?= $post->getDate() ?></td>
                                        <td>
                                            <a href="<?= url('panel.php',['action' => 'edit','id'=> $post->getId()]) ?>">Edit</a>
                                            <a href="<?= url('panel.php',['action' => 'delete','id'=> $post->getId()]) ?>">Delete</a>
                                        </td>
                                    </tr>
                                    <?php endforeach ?>
                                </tbody>
                            </table>
                            <?php endif ?>
                        </section>
                    </main>
                </body>
        <?php
    }
}