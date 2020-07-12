<?php
if ($_POST) {
    // In your "php.ini" file, search for the file_uploads directive, and set it to On
    define('ETUDIANT', 'Etudiant');


    // include database connection
    include 'config/database.php';

    try {

        // insert query
        $query =
            "INSERT INTO adherent  (Id, Prenom, Nom, Mail, MotdePasse, Status, Annee, Photo, Hobbies, Languages, Pseudo)
            Values(null, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // prepare query for execution
        $stmt = $con->prepare($query);

        // posted values
        $prenom = htmlspecialchars(strip_tags($_POST['prenom']));
        $nom = htmlspecialchars(strip_tags($_POST['nom']));
        $mail = htmlspecialchars(strip_tags($_POST['email']));
        $pseudo = htmlspecialchars(strip_tags($_POST['pseudo']));
        $motdepasse = htmlspecialchars(strip_tags($_POST['password']));
        $status = strip_tags($_POST['status']);
        $annee =  $status == ETUDIANT ?  htmlspecialchars(strip_tags($_POST['etudiantAnnee'])) : null;

        // Photo
        $target_dir = "C:/Users/user/Desktop/monsite/img/"; // dir should created and has chmod 777 permessions
        // $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file); // move it to the file target
        $photo = $_FILES["photo"]["name"];

        $hobbiesAsArray = array(
            isset($_POST['informatique']) ? strip_tags($_POST['informatique']) : '',
            isset($_POST['sport']) ? strip_tags($_POST['sport']) : '',
            isset($_POST['voyages']) ? strip_tags($_POST['voyages']) : '',
            isset($_POST['musique']) ? strip_tags($_POST['musique']) : ''
        );
        $hobbiesFiltered = array_filter($hobbiesAsArray); // removing blank, null, false, 0 (zero) values
        $hobbies = implode(",", $hobbiesFiltered);

        $languagesAsArray = array(
            isset($_POST['arabe']) ? strip_tags($_POST['arabe']) : '',
            isset($_POST['francais']) ? strip_tags($_POST['francais']) : '',
            isset($_POST['espagnol']) ? strip_tags($_POST['espagnol']) : '',
            isset($_POST['englais']) ? strip_tags($_POST['englais']) : ''
        );
        $languagesFiltered = array_filter($languagesAsArray); // removing blank, null, false, 0 (zero) values
        $languages = implode(",", $languagesFiltered);

        // Execute the query
        $values = array(
            $prenom, 
            $nom, 
            $mail, 
            $motdepasse, 
            $status, 
            $annee, 
            $photo, 
            $hobbies, 
            $languages, 
            $pseudo
        );

        if ($stmt->execute($values)) {
            echo "<div style='padding:5px; background-color:green; color: #fff'>Record was saved.</div>";
        } else {
            echo "<div style='padding:5px; background-color:red; color: #fff'>Unable to save record.</div>";
        }
    }

    // show error
    catch (PDOException $exception) {
        die('ERROR: ' . $exception->getMessage());
    }
}
