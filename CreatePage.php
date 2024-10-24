<?php
namespace App\Templates;

use App\Classes\Session;
use App\Entities\PostEntity;
use App\Modles\Post;

class CreatePage extends Temlate{


    private $errors =[];
    public function __construct()
    {
        parent::__construct();
        $this->title = $this->setting->getTitle().' - Admin panel - Creat post';

        if($this->request->isPostMethod())
        {
            $data = $this->validator->validate([
                'title'=>['required','min:3','max:100'],
                'category' =>['required','in:sport,political,social'],
                'content' => ['required','min:3','max:5000'],
                'image' => ['required','file','type:jpg,png,jfif','size:2048']
            ]);
            if(!$data ->hasError())
            {
                $this->createPost();
            }else
            {
                $this->errors = $data -> getErrors();
            }
        }
    }

    private function createPost()
    {
        $postModle = new Post();

        $post = new PostEntity([
            'id' =>$postModle->getLastData()->getId() + 1,
            'title' => $this->request->title,
            'content' => $this->request->content,
            'category' => $this->request->category,
            'view' => 0,
            'image' => $this->request->image->upload(),
            'date' => date('Y-m-d H:i:s')
        ]);

        $postModle->createData($post);
        Session::flush('message','new post was created.');

        redirect('panel.php',['action'=>'posts']);
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

    public function reanderPage()
    {
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
                                <input type="text" name="title" id="title" value="<?= $this->request->has('title')?$this->request->title:'' ?>">
                            </div>
                            <div>
                                <label for="category">Category</label>
                                <select name="category" id="category">
                                    <option value="political"<?= ($this->request->has('category') and $this->request->category == 'political')?'selected':'' ?>>Political</option>
                                    <option value="sport"<?= ($this->request->has('category') and $this->request->category == 'sport')?'selected':'' ?>>Sport</option>
                                    <option value="social"<?= ($this->request->has('category') and $this->request->category == 'social')?'selected':'' ?>>Social</option>
                                </select>
                            </div>
                            <div>
                                <label for="content">Content</label>
                                <textarea name="content" id="content" cols="30" rows="10"><?=$this->request->has('content')?$this->request->content :'' ?></textarea>
                            </div>
                            <div>
                                <label for="image">Image</label>
                                <input type="file" name="image" id="image">
                            </div>
                            <div>
                                <input type="submit" value="Create post">
                            </div>
                        </form>
                    </section>
                </main>
            </body>
        </html>
        <?php
    }
}