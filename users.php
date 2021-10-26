<?php
    class userDB
{
    public $_idUser;             // уникальный индентификатор пользовател
    public $_nameUser;
    protected $_dB;              //база данных
    protected $_dBUsers;         //
    protected $_dBContacts;      //таблица с контактами пользователей
    protected $_dBPhoneNumber;   //
        
    public function __construct() 
    {
        $this->_dB = new mysqli(
                "localhost",
                "root",
                "",
                "ddz_example"
            );
    }
    
    public function __destruct() 
    {
       $this->_dB->close();
    }
    
    public function registration($email, $name, $password)
    {
        if ($this->uniqueEmail($email))
        {
            $this->_dB->query("INSERT INTO `users_example` "
                    . "(`id`, `email`, `name`,"
                    . "`password`, `data_reg`) "
                    . "VALUES (NULL,"
                    . " '".$email."',"
                    . " '".$name."',"
                    . " '".$this->password100Md5($password)."',"
                    . " current_timestamp()); ");
            $this->_idUser = $this->getIdUser($email, $password);
            $this->_nameUser = $name;
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function uniqueEmail($email)
    {
        $this->_dBUsers = $this->_dB->query("SELECT * FROM `users_example` WHERE email IN ('".$email."')");
        if($this->_dBUsers->num_rows === 0)
            return true;
        return false;
    }
    
    public function getIdUser($email, $password)
    {
        $password = $this->password100Md5($password);
        $this->_dBUsers = $this->_dB->query("SELECT * FROM `users_example` WHERE email IN ('".$email."')");
        foreach($this->_dBUsers as $alpha)
        {
            if($alpha['email'] === $email && $alpha['password'] === $password)
            {
                $this->_idUser = $alpha['id'];
                $this->_nameUser = $alpha['name'];
                return $alpha['id'];
            }
        }
        
        return NULL;
    }
    
    public function getIdContact($contactArr)
    {
        $this->_dBContacts = $this->_dB->query("SELECT * FROM `all_contact` WHERE id_user IN ('".$this->_idUser."')");
        foreach($this->_dBContacts as $alpha)
        {
            if($contactArr['name'] === $alpha['name'] 
                    && $contactArr['surname'] === $alpha['surname']
                    && $contactArr['patronymic'] === $alpha['patronymic']
                    && $contactArr['place_of_work'] === $alpha['place_of_work']
                    && $contactArr['post'] === $alpha['post']
                    && $contactArr['id_user'] === $alpha['id_user'])
            {
                return $alpha['id'];
            }
        }
        return NULL;
    }
    
    
    public function addContact($contactArr)
    {       
        $str = "";
        $this->_dB->query("INSERT INTO `all_contact` "
                . "(`id`, `name`, `surname`, `patronymic`, `email`,"
                . " `place_of_work`, `post`, `id_user`) "
                . "VALUES (NULL,"
                . "'".$contactArr['name']."',"
                . "'".$contactArr['surname']."',"
                . "'".$contactArr['patronymic']."',"
                . "'".$contactArr['email']."',"
                . "'".$contactArr['place_of_work']."',"
                . "'".$contactArr['post']."',"
                . "'".$contactArr['id_user']."');");
        
        $idMessage = $this->getIdContact($contactArr);
       
        foreach($contactArr['phone_numbers'] as $number)
        {
            if($number !== "")
            {
                $this->_dB->query("INSERT INTO `phone_number` (`id`, `number`, `id_contact`) VALUES (NULL, '".$number."', '".$idMessage."') ");
            }
        }
         
    }
    
    public function getContacts($firstLetterWord)
    {
        $contactArr = array();
        $this->_dBContacts = $this->_dB->query("SELECT * FROM `all_contact` WHERE id_user IN ('".$_SESSION['id']."')");
        foreach($this->_dBContacts as $contact)
        {
            if(mb_strtoupper(mb_substr($contact['surname'], 0, 1)) === $firstLetterWord)
            {
                $contact['phone_numbers'] = $this->getPhone($contact['id']);
                $contactArr[] = $contact;
            }
        }
        return $contactArr;
        
    }
    
    public function deleteCOntact($idContact)
    {
        $this->_dB->query("DELETE FROM `all_contact` WHERE `id` =".$idContact);
        $this->_dB->query("DELETE FROM `phone_number` WHERE `id_contact` =".$idContact);
     
    }
    
    public function getPhone($idContact)
    {
        $numberArr = array();
        $this->_dBPhoneNumber = $this->_dB->query("SELECT * FROM `phone_number` WHERE id_contact IN ('".$idContact."')");
        foreach($this->_dBPhoneNumber as $number)
        {
                $numberArr[] = $number['number'];
        }
        return $numberArr;
    }

    private function password100Md5($password)
    {
        for($i = 0; $i <= 100; $i++)
        {
            $password = md5($password);
        }
        return $password;
    }
    
    public function getContactOnFio($fio)
    {
        $contactArr = array();
        $this->_dBContacts = $this->_dB->query("SELECT * FROM `all_contact` WHERE id_user IN ('".$_SESSION['id']."')");
        foreach($this->_dBContacts as $contact)
        {
         
            if(
                    (
                        (mb_strpos($fio, $contact['surname']) !== false && $contact['surname'] !== "") 
                        && (mb_strpos($fio, $contact['name']) !== false && $contact['name'] !== "")
                        && (mb_strpos($fio, $contact['patronymic']) !== false && $contact['patronymic'] !== "")
                    )
                    || (mb_strpos($contact['surname'], $fio) !== false && $contact['surname'] !== "") 
                    || (mb_strpos($contact['name'], $fio) !== false && $contact['name'] !== "")
                    || (mb_strpos($contact['patronymic'], $fio) !== false && $contact['patronymic'] !== "")
               )
            {
                $contact['phone_numbers'] = $this->getPhone($contact['id']);
                $contactArr[] = $contact;
            }
        }
        return $contactArr;
    }
    
    public function getContactOnWork($work)
    {
        $contactArr = array();
        $this->_dBContacts = $this->_dB->query("SELECT * FROM `all_contact` WHERE place_of_work IN ('".$work."')");
        foreach($this->_dBContacts as $contact)
        {
            if($_SESSION['id'] == $contact['id_user'])
            {
                $contact['phone_numbers'] = $this->getPhone($contact['id']);
                $contactArr[] = $contact;
            }
        }
        return $contactArr;   
    }
    
    public function getContactOnEmail($email)
    {
        $contactArr = array();
        $this->_dBContacts = $this->_dB->query("SELECT * FROM `all_contact` WHERE email IN ('".$email."')");
        foreach($this->_dBContacts as $contact)
        {
            if($_SESSION['id'] == $contact['id_user'])
            {
                $contact['phone_numbers'] = $this->getPhone($contact['id']);
                $contactArr[] = $contact;
            }
        }
        return $contactArr;   
    }
    
//    public function getUserIdContact($idContact) 
//    {
//        $this->_dBContacts = $this->_dB->query("SELECT * FROM `all_contact`");
//        foreach($this->_dBContacts as $alpha)
//        {
//            if($idContact === $alpha['id'])
//            {
//                return $alpha;
//            }
//        }
//        return false;
//    } 
//    
//    public function getContactOnNumber()
//    {
//        $numberArr = array();
//        $this->_dBPhoneNumber = $this->_dB->query("SELECT * FROM `phone_number`");
//        foreach($this->_dBPhoneNumber as $number)
//        {
//            if($idContact == $number['id_contact'])
//            {
//                $numberArr[] = $number['number'];
//            }
//        }
//        return $numberArr;
//    }
    
    public function corectContact($contactArr)
    {
        $this->_dB->query("UPDATE `all_contact` SET "
                . "`name` = '".$contactArr['name']."', "
                . "`surname` = '".$contactArr['surname']."', "
                . "`patronymic` = '".$contactArr['patronymic']."', "
                . "`email` = '".$contactArr['email']."', "
                . "`place_of_work` = '".$contactArr['place_of_work']."', "
                . "`post` = '".$contactArr['post']."' "
                . "WHERE `all_contact`.`id` =".$contactArr['id']."; ");
        $this->corectPhoneOnContact($contactArr['id'], $contactArr['phone_numbers']);
    }
    
    public function corectPhoneOnContact($idContact, $numberArr)
    {
        $this->_dB->query("DELETE FROM `phone_number` WHERE `id_contact` =".$idContact);      
        foreach ($numberArr as $number)
        { 
            if($number !== "")
            $this->_dB->query("INSERT INTO `phone_number` (`id`, `number`, `id_contact`) VALUES (NULL, '".$number."', '".$idContact."') ");
        }
        
    }
}