<?php

namespace App\Templates;

use App\Classes\Session;
use App\Modles\Post;

class EditPage extends Temlate{
    private $errors = [];
    private $post;

    public function __construct()
    {
        parent::__construct();

        if(! $this->request->has('id'))
            redirect('panel.php',['action'=>'posts']);
        

        $id = $this->request->id;
        $postModle = new Post();
        $this->post =$postModle->getDataById($id);
        $this->title = $this->setting->getTitle().' - Admin panel - Edit post: '. $this->post->getTitle();

        if($this->request->isPostMethod())
        {
            $data = $this->validator->validate([
                'title' =>['required','min:3','max:100'],
                'content' => ['required','min:3','max:5000'],
                'category' => ['required','in:sport,political,social'],
                'image' =>['nullable','file','type:jpg,png,jfif','size:2048']
            ]);

            if(!$data->hasError())
            {
                $this->updatePost($postModle);
            }else{
                $this->errors = $data->getErrors();
            }
        }
    }
    private function updatePost($postModle)
    {
        $this->post->setTitle($this->request->title);
        $this->post->setContent($this->request->content);
        $this->post->setCategory($this->request->category);

        if($this->request->image->isFile())
        {
            deleteFile($this->post->getImage());
            $image = $this->request->image->upload();
            $this->post->setImage($image);
        }

        $postModle->editData($this->post);
        Session::flush('message','Post was updated.');

        redirect('panel.php',['action'=>'posts']);
        
    }

    public function reanderPage(){
        ?>
            <html>
            <?php $this->getAdminHead() ?>
            <body>
                <main>
                    <?php $this->getAdminNavbar() ?>
                    <section class="content">
                        <?php $this->showErrors() ?>
                        <form method="POST" enctype="multipart/form-data">
                            <div>
                                <label for="title">Title</label>
                                <input type="text" name="title" id="title" value="<?= $this->post->getTitle() ?>">
                            </div>
                            <div>
                                <label for="category">Category</label>
                                <select name="category" id="category">
                                    <option value="political"<?= ($this->post->getCategory() == 'political')?'selected':'' ?>>Political</option>
                                    <option value="sport"<?= ($this->post->getCategory() == 'sport')?'selected':'' ?>>Sport</option>
                                    <option value="social"<?= ($this->post->getCategory() == 'social')?'selected':'' ?>>Social</option>
                                </select>
                            </div>
                            <div>
                                <label for="content">Content</label>
                                <textarea name="content" id="content" cols="30" rows="10"><?=$this->post->getContent() ?></textarea>
                            </div>
                            <div>
                                <label for="image">Image</label>
                                <input type="file" name="image" id="image">
                                <img src="<?= asset($this->post->getImage()) ?>" >
                            </div>
                            <div>
                                <input type="submit" value="Update post">
                            </div>
                        </form>
                    </section>
                </main>
            </body>
        </html>
        <?php
    }
    private function showErrors()
    {
        if(count($this->errors))
        {
            ?>
                <div class="errors">
                    <ul>
                        <?php foreach($this->errors as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach ?>
                    </ul>
                </div>
            <?php
        }
    }

}