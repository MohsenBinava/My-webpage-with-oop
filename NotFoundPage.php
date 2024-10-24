<?php
namespace App\Templates;
use App\Templates\Temlate;

class NotFoundPage extends Temlate{

    private $message;

    public function __construct($message){
        parent::__construct();
        $this->message = $message;
        $this->title = $message;
    }

    public function reanderPage(){
        ?>
            <!DOCTYPE html>
            <html lang="en">
            <?php $this->getHead() ?>
            <body>
                <main>
                    <section id="content">
                        <div>
                            <?= $this->message ?>
                            <br>
                            <a href="<?= url('index.php') ?>">Go to home page</a>
                        </div>
                    </section>
                </main>
            </body>
            </html>
        <?php
    }
}