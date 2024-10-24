<?php 
namespace App\Templates;
use App\Exceptions\NotFoundException;
use App\Modles\Post;

class SearchPage extends Temlate{
    private $posts;
    private $topPosts;
    private $lastPosts;

    public function __construct(){
        parent::__construct();

        if(!$this->request->has('word'))
            throw new NotFoundException('Page not found!');

        $word = $this->request->word;
        $this->title = $this->setting->getTitle().' - result for: '.$word;
        $postModle =new Post();

        $this->posts = $postModle->filterData(function($item) use($word){
            return str_contains($item->getTitle(),$word )or str_contains($item->getContent(),$word)?true:false;
        });

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
                                <?php foreach($this->posts as $post): ?>
                                    <article>
                                        <div class="caption">
                                            <h3><?=$post->getTitle() ?></h3>
                                            <ul>
                                                <li>date:<span><?=$post->getDate() ?></span></li>
                                                <li>views:<span><?= $post->getView() ?> view</span></li>
                                            </ul>
                                            <p>
                                                <?= $post->getExcerpt() ?>
                                            </p>
                                            <a href="<?= url('index.php',['action' =>'single','id' =>$post->getId()]) ?>">more ...</a>
                                        </div>
                                        <div class="image">
                                            <img src="<?=asset($post->getImage()) ?>" alt="<?=$post->getTitle() ?>">
                                        </div>
                                        <div class="clear-fix"></div>
                                    </article>
                                <?php endforeach ?>
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