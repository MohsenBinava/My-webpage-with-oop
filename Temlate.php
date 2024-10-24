<?php

namespace App\Templates;

use App\Classes\Auth;
use App\Classes\Request;
use App\Classes\Validator;
use App\Modles\Setting;

abstract class Temlate{

    protected $title;
    protected $setting;
    protected $request;
    protected $validator;

    public function __construct()
    {
        
        $this->request = new Request();
        $this->validator = new Validator($this->request);
        $settingModle = new Setting();
        $this->setting = $settingModle->getFirstData();
    }

    protected function getHead()
    {
        ?>
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <meta name="description" content="<?= $this->setting->getDescription() ?>">
                <meta name="keyword" content="<?=$this->setting->getKeywords() ?>">
                <meta name="auther" content="<?= $this->setting->getAuther() ?>">
                <title><?= $this->title ?></title>
                <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
            </head>
        <?php
    }

    protected function getNavbar()
    {
        ?>
            <nav>
                <ul>
                    <li><a href="<?= url('index.php') ?>">Home</a></li>
                    <li><a href="<?= url('index.php',['action'=>'category','category'=>'sport']) ?>">Sport</a></li>
                    <li><a href="<?= url('index.php',['action'=>'category','category'=>'social']) ?>">Social</a></li>
                    <li><a href="<?= url('index.php',['action'=>'category','category'=>'political']) ?>">Political</a></li>
                    <li><a href="<?= url('index.php',['action' => 'login']) ?>">Login</a></li>
                </ul>
                <form action="<?= url('index.php') ?>" method="GET">
                    <input type="hidden" name="action" value="search">
                    <input type="text" name="word" placeholder="search your word" value="<?= $this->request->has('word')?$this->request->word:''?>">
                    <input type="submit" value="Search">
                </form>
            </nav>
        <?php
    }

    protected function getHeader()
    {
        ?>
            <header>
                <h1><?= $this->setting->getTitle() ?></h1>
                <div id="logo">
                    <img src="<?= asset('images/logo.png') ?>" alt="<?= $this->setting->getTitle() ?>">
                </div>
            </header>
        <?php
    }

    protected function getFooter()
    {
        ?>
            <footer>
                <p><?= $this->setting->getFooter() ?>  <a href="#"><?= $this->setting->getAuther()?></a></p>
            </footer>
        <?php
    }

    protected function getSidebar($topPost,$lastPost)
    {
        ?>
            <aside>
                <?php if(count($topPost)):  ?>
                    <div class="aside-box">
                        <h2>Top posts</h2>
                        <ul>
                            <?php foreach($topPost as $item): ?>
                                <li>
                                    <a href="<?= url('index.php',['action' => 'single','id' => $item->getId()]) ?>">
                                        <?=$item->getTitle()?> <small><?=$item->getView()?></small>
                                    </a>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                <?php endif ?>
                <?php if(count($lastPost)): ?>
                    <div class="aside-box">
                        <h2>Last posts</h2>
                        <ul>
                            <?php foreach($lastPost as $item): ?>
                                <li>
                                    <a href="<?= url('index.php',['action' => 'single','id' => $item->getId()]) ?>">
                                        <?=$item->getTitle()?> <small><?=$item->getDate()?></small>
                                    </a>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </div>
                <?php endif ?>
            </aside>
        <?php
    }

    protected function getAdminHead(){
        ?>
            <head>
                <title><?= $this->title ?></title>

                <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
                <link rel="stylesheet" href="<?= asset('css/panel.css') ?>">
            </head>
        <?php
    }

    protected function getAdminNavbar()
    {
        $user = Auth::getLoggedinUser();
        ?>
            <nav>
                <ul>
                    <li><a href="<?= url('index.php') ?>">Website</a></li>
                    <li><a href="<?= url('panel.php',['action' => 'posts']) ?>">Panel</a></li>
                    <li><a href="<?= url('panel.php',['action' => 'create']) ?>">Creat posts</a></li>
                    <li><a href="<?= url('panel.php',['action' => 'logout']) ?>">Log out</a></li>
                </ul>
                <ul>
                    <li><?= $user->getFulName() ?></li>
                </ul>
            </nav>
        <?php
    }

    abstract public function reanderPage();

}