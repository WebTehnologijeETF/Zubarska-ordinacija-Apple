  <?php 
    
        if (isset($_REQUEST['reset'])) 
        {
            echo "reset"; // Saljemo email sa passwordom
        } 
        else if (isset($_REQUEST['skrivenilog'])) 
        { 
            $conn = new PDO("mysql:dbname=appleordinacija;host=localhost;charset=utf8", "apple", "apple");
            //$conn= new PDO("mysql:dbname=appleordinacija;host=127.2.117.130;charset=utf8", "adminSFSF3dw", "st6BsffknmC7");
            $ispisikorisnika = $conn->query("SELECT id, username, password, email, administrator FROM korisnik ORDER BY id");
            
            if (!$ispisikorisnika) 
             {
                  $greska = $conn->errorInfo();
                  print "SQL greška: " . $greska[2];
                  exit();
             }
            $korisnici = $ispisikorisnika->fetchAll();
            
            foreach($korisnici as $user)
            {
                if($username === $user['username'] && $password === $user['password'])
                {
                    $_SESSION['username'] = $username;
                    if($user['administrator'] == '1')
                        $_SESSION['admin'] = 'true';
                    else 
                        $_SESSION['admin'] = 'false';
                    return;
                }
             
                    
            }
            echo "Greska";  
        }
       
    ?>