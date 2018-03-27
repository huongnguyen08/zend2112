<?php
namespace User\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use User\Entity\User;
use Zend\View\Model\ViewModel;
use User\Form\UserForm;


class UserController extends AbstractActionController{

    private $entityManager;
    private $userManager ;
    function __construct($entityManager, $userManager ){
        $this->entityManager = $entityManager;
        $this->userManager = $userManager;
    }
    
    function indexAction(){
        
        //$users = $this->entityManager->find(User::class, 10);
        //$users = $this->entityManager->getRepository(User::class)->find(10);

        //$users = $this->entityManager->getRepository(User::class)->findBy([]);
        $users = $this->entityManager->getRepository(User::class)->findAll();

        //$users = $this->entityManager->getRepository(User::class)->findOneByFullname('huong01@gmail.com');
        //print_r($users);
        
        return new ViewModel(['users'=>$users]);
    }

    function addAction(){
        $form = new UserForm('add');

        $request = $this->getRequest();
        if($request->isPost()){
            $data = $this->params()->fromPost();
            $form->setData($data);
            if($form->isValid()){
                $data = $form->getData();
                
                // echo "<pre>";
                // print_r($data);
                // echo "</pre>";
                // return false;

                // validate pw vs confirm pw
                //check Email Exist

                $user = $this->userManager->insertUser($data);
                $this->flashMessenger()->addSuccessMessage('Đăng kí thành công');
                return $this->redirect()->toRoute('user',[
                    'controller'=>'user',
                    'action'=>'index'
                ]);

            }
        }
        return new ViewModel(['form'=>$form]);
    }
}
?>