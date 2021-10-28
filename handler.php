<?php
include 'users.php';
class handler
{
    private $__DB;
    
    public function __construct()
    {
        $this->__DB = new userDB();
      
    }
    
    public function handler_login($email, $password): bool //ok
    {
        $id = $this->__DB->getIdUser($email, $password);
        if ($id !== NULL)
        {
            $_SESSION["name"] = $this->__DB->_nameUser;
            $_SESSION["id"] = $id;
            return true;
        }
        else
        {
            return false;
        }
    }
    public function handler_registration($email, $name, $password)  //ok
    {
            if($this->__DB->registration($email, $name, $password))
            {
                $_SESSION["name"] = $this->__DB->_nameUser;
                $_SESSION["id"] = $this->__DB->_idUser;
                return true;
            }
            return false;
    }
    
    public function handler_tab($letter)
    {
            return $this->__DB->getContacts($letter, $_SESSION['id']);          
    }      
    
    public function handler_exit()
    {
            session_destroy();
            $_SESSION = [];
    }
    
    public function handler_add_contact()
    {
           $contactArr = $this->inArr();
           $this->__DB->addContact($contactArr);
           return mb_strtoupper(mb_substr($contactArr['surname'], 0, 1));
    }
    
    public function inArr()
    {
        $contactArr = array();
        isset($_POST['addname']) ? $contactArr['name'] = $_POST['addname'] : $contactArr['name'] = "";
        isset($_POST['addsurname']) ? $contactArr['surname'] = $_POST['addsurname'] : $contactArr['surname'] = "";
        isset($_POST['addpatronymic']) ? $contactArr['patronymic'] = $_POST['addpatronymic'] : $contactArr['patronymic'] = "";
        isset($_POST['addplace_of_work']) ? $contactArr['place_of_work'] = $_POST['addplace_of_work'] : $contactArr['place_of_work'] = "";
        isset($_POST['addpost']) ? $contactArr['post'] = $_POST['addpost'] : $contactArr['post'] = "";
        isset($_POST['addemail']) ? $contactArr['email'] = $_POST['addemail'] : $contactArr['email'] = "";
        isset($_POST['addnumber0']) ? $contactArr['phone_numbers'][] = $_POST['addnumber0'] : $contactArr['phone_numbers'] = array() ;
        for($i = 1; $i < 5; $i++)
        {
            if(isset($_POST['addnumber'.$i]))
            {
                $contactArr['phone_numbers'][] = $_POST['addnumber'.$i];
            }
        }
        $contactArr['id_user'] = $_POST['addContact'];
        return $contactArr;
        
    }
    
    public function handler_delete($contact)
    {
            $this->__DB->deleteContact($contact);
    }
    
    public function handler_find_on_fio()
    {
        return $this->__DB->getContactOnFio($_POST['find']);
    }   
           
    public function handler_find_on_work()
    { 
        return $this->__DB->getContactOnWork($_POST['find']);
    }
           
    public function handler_find_on_email()
    {
        return $this->__DB->getContactOnEmail($_POST['find']);
    }
    
    public function handler_find_on_number()
    {
        return $this->__DB->getContactOnNumber($_POST['find']);
    }
    
    public function hendler_edit_contact()
    {
           $contactArr = $this->inArrCorect();
           $this->__DB->corectContact($contactArr);
           return mb_strtoupper(mb_substr($contactArr['surname'], 0, 1));
    }
    
    public function inArrCorect()
    {
        $contactArr = array();
        $contactArr['id'] = $_POST['corectContact'];
        isset($_POST['corectname']) ? $contactArr['name'] = $_POST['corectname'] : $contactArr['name'] = "";
        isset($_POST['corectsurname']) ? $contactArr['surname'] = $_POST['corectsurname'] : $contactArr['surname'] = "";
        isset($_POST['corectpatronymic']) ? $contactArr['patronymic'] = $_POST['corectpatronymic'] : $contactArr['patronymic'] = "";
        isset($_POST['corectplace_of_work']) ? $contactArr['place_of_work'] = $_POST['corectplace_of_work'] : $contactArr['place_of_work'] = "";
        isset($_POST['corectpost']) ? $contactArr['post'] = $_POST['corectpost'] : $contactArr['post'] = "";
        isset($_POST['corectemail']) ? $contactArr['email'] = $_POST['corectemail'] : $contactArr['email'] = "";
        isset($_POST['corectnumber0']) ? $contactArr['phone_numbers'][] = $_POST['corectnumber0'] : $contactArr['phone_numbers'] = array() ;
        for($i = 1; $i <= 5; $i++)
        {
            if(isset($_POST['corectnumber'.$i]) && $i != 5)
            {
                $contactArr['phone_numbers'][] = $_POST['corectnumber'.$i];
            }
            
            if(isset($_POST['corectnumberDop']) && $i == 5)
            {
                $contactArr['phone_numbers'][] = $_POST['corectnumberDop'];
            }
        }
     
        $contactArr['id_user'] = $_SESSION['id'];
        return $contactArr;
    }
   
}