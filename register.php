<?php
if ($_POST) {
    // In your "php.ini" file, search for the file_uploads directive, and set it to On
    $etudiant = 'Etudiant';

    // include database connection
    include 'config/database.php';

    try {

        // insert query
        $query =
            "INSERT INTO adherent SET Prenom=:prenom, Nom=:nom, Mail=:mail, MotdePasse=:motdepasse, 
            Status=:status, Annee=:annee, Photo=:photo, Hobbies=:hobbies, Languages=:languages, Pseudo=:pseudo";

        // prepare query for execution
        $stmt = $con->prepare($query);

        // posted values
        $prenom = htmlspecialchars(strip_tags($_POST['prenom']));
        $nom = htmlspecialchars(strip_tags($_POST['nom']));
        $mail = htmlspecialchars(strip_tags($_POST['email']));
        $motdepasse = htmlspecialchars(strip_tags($_POST['password']));
        $status = strip_tags($_POST['status']);
        $annee =  $status == $etudiant ?  htmlspecialchars(strip_tags($_POST['etudiantAnnee'])) : null;

        // Photo
        $target_dir = "C:/Users/user/Desktop/monsite/img/";
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file); // move it to the file target
        $photo = $_FILES["photo"]["name"];

        $hobbiesAsArray = array(
            strip_tags($_POST['informatique']),
            strip_tags($_POST['sport']),
            strip_tags($_POST['voyages']),
            strip_tags($_POST['musique'])
        );
        $hobbiesFiltered = array_filter($hobbiesAsArray); // removing blank, null, false, 0 (zero) values
        $hobbies = implode(",", $hobbiesFiltered);

        $languagesAsArray = array(
            strip_tags($_POST['arabe']),
            strip_tags($_POST['francais']),
            strip_tags($_POST['espagnol']),
            strip_tags($_POST['englais'])
        );
        $languagesFiltered = array_filter($languagesAsArray); // removing blank, null, false, 0 (zero) values
        $languages = implode(",", $languagesFiltered);

        // bind the parameters
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':mail', $mail);
        $stmt->bindParam(':motdepasse', $motdepasse);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':annee', $annee);
        $stmt->bindParam(':photo', $photo);
        $stmt->bindParam(':hobbies', $hobbies);
        $stmt->bindParam(':languages', $languages);
        $stmt->bindParam(':pseudo', $pseudo);

        // Execute the query
        if ($stmt->execute()) {
            echo "<div style='padding:5px; background-color:green;'>Record was saved.</div>";
        } else {
            echo "<div style='padding:5px; background-color:red;'>Unable to save record.</div>";
        }
    }

    // show error
    catch (PDOException $exception) {
        die('ERROR: ' . $exception->getMessage());
    }
}
