<?php

namespace App\Templates;
use App\Exceptions\NotFoundException;
use App\Modles\Post;

class SinglePage extends Temlate{

    private $post;
    private $topPosts;
    private $lastPosts;

    public function __construct()
    {
        parent::__construct();
        if(!$this->request->has('id'))
            throw new NotFoundException('Page not found!');

        $id = $this->request->get('id');
        $postModle = new Post();
        $this->post = $postModle->getDataById($id);
        $this->title = $this->setting->getTitle().' - '.$this->post->getTitle();

        $this->topPosts = $postModle->sortData(function($first,$second) {
            return $first->getView() > $second->getView()? -1 : 1;
        });

        $this->lastPosts = $postModle->sortData(function($first,$second) {
            return $first->getTimestamp() > $second->getTimestamp() ? -1:1;
        });


    }

    public function reanderPage()
    {
        ?>
            <html lang="en">
                <?php $this->getHead() ?>
                <body>
                    <main>
                        <?php $this->getHeader() ?>
                        <?php $this->getNavbar()?>
                        <section id="content">
                            <?php $this->getSidebar($this->topPosts,$this->lastPosts) ?>
                            <div id="articles">
                                    <article>
                                        <div class="caption">
                                            <h3><?=$this->post->getTitle() ?></h3>
                                            <ul>
                                                <li>date:<span><?=$this->post->getDate() ?></span></li>
                                                <li>views:<span><?= $this->post->getView() ?> view</span></li>
                                            </ul>
                                            <p>
                                                <?= $this->post->getContent() ?>
                                            </p>
                                            
                                        </div>
                                        <div class="image">
                                            <img src="<?=asset($this->post->getImage()) ?>" alt="<?=$this->post->getTitle() ?>">
                                        </div>
                                        <div class="clear-fix"></div>
                                    </article>
                            </div>
                            <div class="clear-fix"></div>
                            
                        </section>
                        <?= $this->getFooter() ?>
                    </main>
                </body>
            </html>
        <?php
    }
}