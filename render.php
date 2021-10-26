<?php

class rendering
{
    private $__letterArr = array("A","B","C","D","E","F","G","H","I","J",
        "K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z",
        "А","Б","В","Г","Д","Е","Ж","З","И","К","Л","М","Н","О","П","Р",
        "С","Т","У","Ф","Х","Ц","Ч","Ш","Щ","Э","Ю","Я");
   
    
    
    public function main_rendering($activeLetter,$contactLetterArr)
    {
        $html = $this->header_output();
        $html .= $this->logo_output();
        $html .= $this->letter_output($activeLetter);
        $html .= $this->contacts_output($contactLetterArr);
        $html .= $this->addContacts_output();
        return $html;
    }
    
    public function __construct()
    {
        ob_start();
        session_start();
        $this->__hendlerPost = new handler();
    }
    
    public function login($flag = true)
    {
        $html = $this->header_output();
        $html .= '<div class="parent d-flex align-items-center justify-content-center bg-light">
        <div class="child col-md-4 bg-white shadow p-3 mb-5 rounded">
            <form method="post">
                <div class="col">
                    <div class="mb-2">
                        <label for="InputEmail" class="form-label">Email</label>
                        <input name="LoginEmail" type="email" class="form-control" id="InputEmail" aria-describedby="emailHelp" >
                    </div>
                    <div class="mb-3">
                        <label for="InputPassword" class="form-label">Пароль</label>
                        <input name="LoginPassword" type="password" class="form-control" id="InputPassword">
                    </div>
                    <div class="mb-2">';
        if (!$flag)
        {
            $html .= '<p class="form-label text-danger"> Указан неверный email или пароль</p>';
        }
        $html .= '<button type="submit" class="btn btn-success" name="LoginButton">Войти</button>
                        <button type="submit" class="btn btn-primary" name="ToSigninButton"> Зарегистрироваться </button>
                    </div>
                    </div>
                </form>
            </div>
        </div>';
        return $html;
    }
    
    public function registration($flag)
    {
        $html = $this->header_output();
        $html .= ' <div class="parent bg-light d-flex align-items-center justify-content-center align-content-center">
        <div class="child col-md-5 bg-white shadow p-3 mb-5 rounded">
            <form method="post">
                <div class="col">
                    <div class="mb-2">
                        <label for="nickName" class="form-label">Имя</label>
                        <input name="regName" class="form-control" id="nickName" required>
                    </div>
                    <div class="mb-2"
                        <label for="InputEmail1" class="form-label">Email</label> ';
        if(!$flag)
            $html .=  '<label for="InputEmail1" class="form-label text-danger">Указанный email уже зарегестрирован</label>';
        $html .=  '<input name="regEmail" type="email" class="form-control" id="InputEmail" aria-describedby="emailHelp"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="InputPassword" class="form-label">Пароль</label>
                        <input name="regPassword" type="password" class="form-control" id="InputPassword" required>
                    </div>
                    <div class="mb-2">
                        <button name="SigninButton "type="submit" class="btn btn-success">Зарегистрироваться</button>
                    </div>
                </div>
            </form>
        </div>
    </div>';
        return $html;
    }

    public function header_output() 
    {
        return "  <!DOCTYPE html>
                <html lang=\"en\">

                <head>
                    <meta charset=\"UTF-8\">
                    <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
                    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
                    <script src=\"vendor/js/jquery-3.3.1.slim.min.js\" defer></script>
                    <script src=\"vendor/js/popper.min.js\" async></script>
                    <link rel=\"stylesheet\" href=\"vendor/css/bootstrap.min.css\">
                    <script src=\"vendor/js/bootstrap.min.js\" defer></script>
                    <link rel=\"stylesheet\" href=\"style.css\">
                    <!-- JavaScript Bundle with Popper -->
                    <script src=\"https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js\"
                    integrity=\"sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ\"
                    crossorigin=\"anonymous\"></script>
                    <title>Document</title>
                </head>";
    }
    
    public function logo_output()
    {     
        return "<body>
                <nav class=\"header\">
                    <div class=\"row\">
                        <div class=\"logo col-md-2\">Адресная книга</div>
                            <div class=\"search col-md-8 \"> 
                                <ul class=\"nav justify-content-end\">
                                    <form method=\"post\">
                                        <li class=\"nav-item\">
                                            <div class=\"input-group\">
                                                <div class=\"input-group-prepend\">
                                                    <span class=\"input-group-text\">
                                                        <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\"
                                                            fill=\"currentColor\" class=\"bi bi-search\" viewBox=\"0 0 16 16\">
                                                            <path
                                                                d=\"M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z\" />
                                                        </svg>
                                                    </span>
                                                </div>
                                                <input type=\"text\" name=\"find\" class=\"form-control\"
                                                aria-label=\"Text input with segmented dropdown button\">
                                                <div class=\"input-group-append\">
                                                    <button type=\"button\" class=\"btn btn-primary\" type=\"submit\" disabled>Поиск
                                                        по...</button>
                                                    <button type=\"button\"
                                                        class=\"btn btn-outline-secondary dropdown-toggle dropdown-toggle-split\"
                                                        data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                                                        <span class=\"sr-only\">Toggle Dropdown</span>
                                                    </button>
                                                    <div class=\"dropdown-menu\">
                                                        <button class=\"dropdown-item\" name=\"fio\" href=\"#\">ФИО</button>
                                                        <button class=\"dropdown-item\" name=\"place_of_work\" href=\"#\">Организация</button>
                                                        <button class=\"dropdown-item\" name=\"email\" href=\"#\">Электронная почта</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </form>
                                </ul>
                            </div>
                            <div class=\"profile col-md-1\">
                                <button type=\"button\" class=\"profileButton btn btn-outline-primary\" data-bs-toggle=\"modal\" data-bs-target=\"#exampleModal1\">".
                                    $_SESSION['name'].
                                "</button>
                            </div>
                            <div class=\"profile col-md-1\">
                                <form method=\"post\">
                                    <button name=\"exitButton\" type=\"submit\" class=\"exitButton btn btn-danger\">
                                        Выйти
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </nav>";
    }
    
    public function letter_output($activeLetter)
    {
        $html = "<form method=\"post\">
                <div class=\"letters btn-group\">";
        
        foreach($this->__letterArr as $letter)
        {   
            if ($activeLetter === $letter)
            {
                $html .= "<button type=\"submit\" name=\"letter\" value = \"".$letter."\" class=\"btn btn-success \">"
                .$letter."</button>";
            }
            else
            {
                $html .= "<button type=\"submit\" name=\"letter\" value = \"".$letter."\" class=\"btn btn-primary\">"
                .$letter."</button>";
            }
        }
        return $html. "</div> </form>";
    } 
    
    public function contacts_output($contactLetterArr)
    {
        $html = "";
        
        if(isset($contactLetterArr))
        {
            $html = "<div class=\"main\">
                    <div class=\"row\">";
            foreach ($contactLetterArr as $key=>$contact)
            {
                $html .=  " <div class=\"contact col-md-3\">
                    <div class=\"card text-center\">
                        <div class=\"card-header\">
                            <form method=\"post\">
                            <ul class=\"nav justify-content-center card-header-pills\"> 
                                <li class=\"name nav-item\">
                                    <h5>".$contact['surname']." ".$contact['name']." ".$contact['patronymic']."</h5>
                                </li>
                                <li class=\"edit nav-item\">
                                    
                                    <button type=\"button\" data-bs-toggle=\"modal\" data-bs-target=\"#Modal".$key."\" >
                                        <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"green\" class=\"bi bi-pencil\" viewBox=\"0 0 16 16\">
                                            <path d=\"M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z\" />
                                        </svg>
                                    </button>
                                </li>
                                <li class=\"edit nav-item\">
                                <form method=\"post\">
                                    <button type=\"submit\" name=\"deleteContact\" value=\"".$contact['id']."\"><svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\"
                                            fill=\"red\" class=\"bi bi-trash\" viewBox=\"0 0 16 16\">
                                            <path
                                                d=\"M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z\" />
                                            <path fill-rule=\"evenodd\"
                                                d=\"M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z\" />
                                        </svg></button>
                                </form>
                                </li>
                            </ul>
                        </div>
                        <div class=\"card-body\">
                            <ul class=\"list-group list-group-flush\">
                                <li class=\"corporation list-group-item\">".$contact['place_of_work']."</li>
                                <li class=\"post list-group-item\">".$contact['post']."</li>
                                <li class=\"email list-group-item\">".$contact['email']."</li>

                                <li class=\"phone1 list-group-item  dropright\">Телефоны
                                    <button type=\"button\"
                                        class=\"morePhone btn btn-sm btn-light dropdown-toggle dropdown-toggle-split\"
                                        data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                                        <span class=\"sr-only\">Toggle Dropdown</span>
                                    </button>
                                    <div class=\"dropdown-menu\">";
            foreach($contact['phone_numbers'] as $number)
            {
                $html .="<p class=\"phone2 list-group-item\">".$number."</p>";    
            }

        $html .=                      "</div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <div class=\"modal fade\" id=\"Modal".$key."\" tabindex=\"-1\" aria-labelledby=\"ModalLabel\"aria-hidden=\"true\">
                                        <div class=\"modal-dialog\">
                                            <div class=\"modal-content\">
                                                <div class=\"modal-header\">
                                                    <h5 class=\"modal-title\" id=\"ModalLabel\">Изменение контакта</h5>
                                                    <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>
                                                </div>
                                                <div class=\"modal-body\">
                                                    <form method=\"post\" class=\"row\">
                                                        <div class=\"col-md-4\">
                                                            <label for=\"firstName\" class=\"form-label\">Имя</label>
                                                            <input type=\"text\" name=\"corectname\" value =\"".$contact['name']."\" class=\"form-control\" id=\"firstName\">
                                                        </div>
                                                        <div class=\"col-md-4\">
                                                            <label for=\"secondName\" class=\"form-label\">Фамилия</label>
                                                            <input type=\"text\" name=\"corectsurname\" value =\"".$contact['surname']."\" class=\"form-control\" id=\"secondName\">
                                                        </div>
                                                        <div class=\"col-md-4\">
                                                            <label for=\"firdName\" class=\"form-label\">Отчество</label>
                                                            <input type=\"text\" name=\"corectpatronymic\" value ='".$contact['patronymic']."' class=\"form-control\" id=\"firdName\">
                                                        </div>
                                                        <div class=\"col-md-6\">
                                                            <label for=\"corporationName\" class=\"form-label\">Нименование организации</label>
                                                            <input type=\"text\" name=\"corectplace_of_work\" value ='".$contact['place_of_work']."'class=\"form-control\" id=\"corporationName\">
                                                        </div>
                                                        <div class=\"col-md-6\">
                                                            <label for=\"corporationName\" class=\"form-label\">Должность</label>
                                                            <input type=\"text\" name=\"corectpost\" value =\"".$contact['post']."\" class=\"form-control\" id=\"corporationName\">
                                                        </div>
                                                        <div class=\"col-md-6\">
                                                            <label for=\"exampleInputEmail1\" class=\"form-label\">Email</label>
                                                            <input type=\"email\" name=\"corectemail\" value =\"".$contact['email']."\" class=\"form-control\" id=\"exampleInputEmail1\"
                                                                aria-describedby=\"emailHelp\">
                                                        </div>";
                                                                                  
               if(isset($contact['phone_numbers'][0]))
               {
                 $html .= "                                     <div class=\"col-md-12\">
                                                            <label for=\"phoneNumber\" class=\"form-label\">Телефон</label>
                                                            <input type=\"tel\" name=\"corectnumber0\" value =\"".$contact['phone_numbers'][0]."\" class=\"form-control\" id=\"corporationName\">
                                                        </div>";
               }

        $html .="                                       <div class=\"col-md-12\">
                                                            <button type=\"button\" class=\"btn dropdown-toggle dropdown-toggle-split\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">
                                                                <span>Дополнительные телефоны</span>
                                                              </button>
                                                        <div class=\"dropdown-menu\">";
        for($i=1; $i<5; $i++)
        {
            if(isset($contact['phone_numbers'][$i]))
            {
                $pok = 1;
                $html .="<input name=\"corectnumber".$i."\" value = \"".$contact['phone_numbers'][$i]."\" type=\"tel\" class=\"form-control\" id=\"phone".$i."\">";
            }
        }
      
            $html .="                                               <input name=\"corectnumberDop\" type=\"tel\" class=\"form-control\" id=\"phone\">                                           
                                                            </div>
                                                            <div class=\"addButton col-md-12\">
                                                                <button type=\"submit\" class=\"btn btn-primary\">Изменить</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                      ";
            }
        }
        return $html;   
    }
    
    public function addContacts_output()
    {
        return " <div class=\"col-md-3\">
                <button type=\"button\" class=\"add btn btn-light shadow p-3 mb-5 rounded\" data-bs-toggle=\"modal\" data-bs-target=\"#exampleModal\">
                    <svg xmlns=\"http://www.w3.org/2000/svg\" width=\"50\" height=\"50\" fill=\"currentColor\"
                        class=\"bi bi-person-plus-fill\" viewBox=\"0 0 16 16\">
                        <path d=\"M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z\" />
                        <path fill-rule=\"evenodd\"
                            d=\"M13.5 5a.5.5 0 0 1 .5.5V7h1.5a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0V8h-1.5a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z\" />
                    </svg>
                </button>
            </div>
            <!-- Modal -->
            <div class=\"modal fade\" id=\"exampleModal\" tabindex=\"-1\" aria-labelledby=\"exampleModalLabel\"
                aria-hidden=\"true\">
                <div class=\"modal-dialog\">
                    <div class=\"modal-content\">
                        <div class=\"modal-header\">
                            <h5 class=\"modal-title\" id=\"exampleModalLabel\">Добавление контакта</h5>
                            <button type=\"button\" class=\"btn-close\" data-bs-dismiss=\"modal\" aria-label=\"Close\"></button>
                        </div>
                        <div class=\"modal-body\">
                            <form class=\"row\" method=\"post\">
                                <div class=\"col-md-4\">
                                    <label for=\"firstName\" class=\"form-label\">Имя</label>
                                    <input type=\"text\" name=\"addname\" class=\"form-control\" id=\"firstName\">
                                </div>
                                <div class=\"col-md-4\">
                                    <label for=\"secondName\" class=\"form-label\">Фамилия</label>
                                    <input type=\"text\" name=\"addsurname\" class=\"form-control\" id=\"secondName\">
                                </div>
                                <div class=\"col-md-4\">
                                    <label for=\"firdName\" class=\"form-label\">Отчество</label>
                                    <input type=\"text\" name=\"addpatronymic\" class=\"form-control\" id=\"firdName\">
                                </div>
                                <div class=\"col-md-6\">
                                    <label for=\"corporationName\" class=\"form-label\">Нименование организации</label>
                                    <input type=\"text\" name=\"addplace_of_work\" class=\"form-control\" id=\"corporationName\">
                                </div>
                                <div class=\"col-md-6\">
                                    <label for=\"corporationName\" class=\"form-label\">Должность</label>
                                    <input type=\"text\" name=\"addpost\" class=\"form-control\" id=\"corporationName\">
                                </div>
                                <div class=\"col-md-6\">
                                    <label for=\"exampleInputEmail1\" class=\"form-label\">Email</label>
                                    <input type=\"email\" name=\"addemail\" class=\"form-control\" id=\"exampleInputEmail1\"
                                        aria-describedby=\"emailHelp\">
                                </div>
                                <div class=\"col-md-12\">
                                    <label for=\"phoneNumber\" class=\"form-label\">Телефон</label>
                                    <input type=\"tel\" name=\"addnumber0\" class=\"form-control\" id=\"corporationName\">
                                </div>
                                <div class=\"addButton col-md-12\">
                                    <button type=\"submit\" name=\"addContact\" value=\"".$_SESSION['id']."\" class=\"btn btn-primary\">Добавить</button>
                                </div>
                                <div class=\"col-md-12\">
                                    <button type=\"button\" class=\"btn dropdown-toggle dropdown-toggle-split\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">
                                        <span>Дополнительные телефоны</span>
                                      </button>
                                      <div class=\"dropdown-menu\">
                                        <input name=\"addnumber1\" type=\"tel\" class=\"form-control\" id=\"phone2\">
                                        <input name=\"addnumber2\" type=\"tel\" class=\"form-control\" id=\"phone3\">
                                        <input name=\"addnumber3\" type=\"tel\" class=\"form-control\" id=\"phone4\">
                                        <input name=\"addnumber4\" type=\"tel\" class=\"form-control\" id=\"phone5\">
                                      </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>";
    }
}

