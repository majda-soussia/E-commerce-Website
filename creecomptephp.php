<?php
    // Database configuration
    $servername = "localhost";
    $username = "root"; // Default XAMPP username
    $password = ""; // Default XAMPP password
    $dbname = "monsite"; // Correction ici : c'est "monsite" pas "utlisateur"
    $_SESSION['user_id'] = $stmt->insert_id;

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Process form data
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sanitize inputs
        $nom = mysqli_real_escape_string($conn, $_POST['nom']);
        $prenom = mysqli_real_escape_string($conn, $_POST['prenom']);
        $telephone = mysqli_real_escape_string($conn, $_POST['telephone']);
        $adresse = mysqli_real_escape_string($conn, $_POST['adresse']); // Correction : utiliser "adresse" pas "email"
        $motpasse = password_hash($_POST['password'], PASSWORD_DEFAULT); // Correction : stocker dans $motpasse
        $sexe = mysqli_real_escape_string($conn, $_POST['genre']);
        $datenaissance = mysqli_real_escape_string($conn, $_POST['date']);

        // Validate email
        if (!filter_var($adresse, FILTER_VALIDATE_EMAIL)) {
            die("Invalid email format");
        }

        // Check if email already exists
        $check_email = $conn->prepare("SELECT id FROM utilisateur WHERE email = ?");
        $check_email->bind_param("s", $adresse);
        $check_email->execute();
        $check_email->store_result();

        if ($check_email->num_rows > 0) {
            die("Email already exists");
        }
        $check_email->close();

        // Insert new user
        $stmt = $conn->prepare("INSERT INTO utilisateur
                          (nom, prenom, telephone, email, motpasse, sexe, datenaissance) 
                          VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $nom, $prenom, $telephone, $adresse, $motpasse, $sexe, $datenaissance);
        if ($stmt->execute()) {
            // Redirect to success page
            $_SESSION['user_id'] = $stmt->insert_id;
            $_SESSION['prenom'] = $prenom;
            $_SESSION['nom'] = $nom;
            header("Location: bienve.php");
            exit();
        } 

        $stmt->close();
    }

    $conn->close();
    

    ?>
