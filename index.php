<?php 
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbName = "spotify";

    $conn = new mysqli($servername,$username,$password,$dbName);

    if($conn->connect_error){
        die("Errore nella connessione al database");
    }

    if($_SERVER['REQUEST_METHOD'] === 'GET'){
        echo "<html><body><h1>SPOTIFY FAMILY </h1>";
        echo "<h2> Partecipanti spotify family</h2>";
        $sql = "SELECT * FROM family";
        if($conn->query($sql)){
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()){
                echo $row['nome']. " <br>";
            }
        }
        echo "<h2>Pagamenti effettuati</h2>";
        $sql = "SELECT * FROM pagamenti";
        $result = $conn->query($sql);
        while($row = $result->fetch_assoc()){
            echo $row['nome']. " mese : ".$row['mese']. " quota pagata :".$row['quotaMensile']. "<br>"; 
        }

        echo "<h2>Inserisci pagamento fornendo nome mese e quotaMensile </h2>";
        echo "<form action = 'index.php' method = 'post'> 
                Nome Completo<input type = 'text' name = 'nome'>
                Mese <input type = 'text' name = 'mese'>
                Quota <input type = 'text' name = 'quotaMensile'>
                <input type = 'submit' name = 'pagare' value = 'paga'>
                </form>";

        echo "<h2> clicca questo tasto se vuoi eliminare un recordo dalla tabella </h2>";
        echo "<form actiom 'index.php' method = 'post'>
                Nome da eliminare <input type = 'text' name = 'nome'>
                <input type = 'submit' name = 'elimina' value = 'cancella'>
                </form>";

        echo "</body></html>";
    }else{
        if(isset($_POST['pagare'])){
            $nome = $_POST['nome'];
            $mese = $_POST['mese'];
            $quota = $_POST['quotaMensile'];
            $sql = "INSERT INTO pagamenti(nome,mese,quotaMensile) VALUES ('$nome','$mese','$quota')";
            $conn->query($sql);

            echo "<h2> lista aggiornata pagamenti </h2>";
            $sql = "SELECT * FROM pagamenti";
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()){
                echo $row['nome']. " mese : ".$row['mese']. " quota pagata :".$row['quotaMensile']. "<br>"; 
            }
            echo "<a href='index.php'> Torna alla home </a>";
        }else if(isset($_POST['elimina'])){
            $nome = $_POST['nome'];
            $sql = "DELETE FROM pagamenti where nome = '$nome'";
            $conn->query($sql);

            echo "<h2> lista aggiornata pagamenti </h2>";
            $sql = "SELECT * FROM pagamenti";
            $result = $conn->query($sql);
            while($row = $result->fetch_assoc()){
                echo $row['nome']. " mese : ".$row['mese']. " quota pagata :".$row['quotaMensile']. "<br>"; 
            }
            echo "<a href='index.php'> Torna alla home </a>";
            
        }
       
    }
    
?>