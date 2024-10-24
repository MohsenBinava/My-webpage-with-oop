<?php
namespace App\Templates;
use App\Modles\User;
use App\Classes\Auth;

class LoginPage extends Temlate
{
    private $errors = [];
    public function __construct(){
        parent::__construct();

        if(Auth::isAuthenticated())
            redirect('panel.php',['action' =>'posts']);

        $this->title = $this->setting->getTitle().' - Login to system';

        if($this->request->isPostMethod()){
            $data = $this->validator->validate([
                'email' =>['required','email'],
                'password' =>['required','min:6'],
            ]);

            if(!$data->hasError()){
                $userModle = new User();
                $user =$userModle->authenticatUser($this->request->email, $this->request->password);
                   if($user){
                        Auth::loginUser($user);
                        redirect('panel.php',['action' =>'posts']);
                   }else{
                        $this->errors[] = 'Invalid credential';
                   }
            }else{
                $this->errors = $data->getErrors();
            }
        }
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
            <html lang="en">
            <?php $this->getAdminHead() ?>
            <body>
                <main>
                    <form method="POST" action="<?= url('index.php',['action'=>'login']) ?>">
                        <div class="login">
                            <h1>Login to system</h1>
                                <?php $this->showErrors() ?>
                            <div>
                                <label for="email">Email:</label>
                                <input type="text" name="email" id="email">
                            </div>
                            <div>
                                <label for="password">Password:</label>
                                <input type="password" name="password" id="password">
                            </div>
                            <div>
                                <input type="submit" value="Login">
                            </div>
                        </div>
                    </form>
                </main>
            </body>
            </html>
        <?php
    }
}