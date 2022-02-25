<?php
require __DIR__ . '/Config.php';
require __DIR__ . '/DB_Connect.php';
/**
 * 1. Commencez par importer le script SQL disponible dans le dossier SQL.
 * 2. Connectez vous à la base de données blog.
 */

/**
 * 3. Sans utiliser les alias, effectuez une jointure de type INNER JOIN de manière à récupérer :
 *   - Les articles :
 *     * id
 *     * titre
 *     * contenu
 *     * le nom de la catégorie ( pas l'id, le nom en provenance de la table Categorie ).
 *
 * A l'aide d'une boucle, affichez chaque ligne du tableau de résultat.
 */

// TODO Votre code ici.
$stmt = DB_Connect::dbConnect()->prepare("
    SELECT article.id, article.title, article.content, categorie.name
    FROM article
    INNER JOIN categorie ON article.category_fk = categorie.id
");

if ($stmt->execute()) {
    foreach ($stmt->fetchAll() as $value) {
        foreach ($value as $key => $article) {
            echo $key . " --> " . $article . "<br>";
        }
        echo "<br>";
    }
    echo "<br><br>";
}

/**
 * 4. Réalisez la même chose que le point 3 en utilisant un maximum d'alias.
 */

$stmt = DB_Connect::dbConnect()->prepare("
    SELECT ar.id, ar.title, ar.content, cate.name
    FROM article AS ar
    INNER JOIN categorie AS cate ON ar.category_fk = cate.id
");

if ($stmt->execute()) {
    foreach ($stmt->fetchAll() as $value) {
        foreach ($value as $key => $article) {
            echo $key . " --> " . $article . "<br>";
        }
        echo "<br>";
    }
}


/**
 * 5. Ajoutez un utilisateur dans la table utilisateur.
 *    Ajoutez des commentaires et liez un utilisateur au commentaire.
 *    Avec un LEFT JOIN, affichez tous les commentaires et liez le nom et le prénom de l'utilisateur ayant écrit le commentaire.
 */

// TODO Votre code ici.

$firstname = "Noah";
$lastname = "Decroix";
$mail = "noah.decroix3@gmail?com";
$password = password_hash("Edvijn221102*", PASSWORD_ARGON2I);
$stmt = DB_Connect::dbConnect()->prepare("
    INSERT INTO utilisateur(firstName, lastName, mail, password)
    VALUES (:firstName, :lastName, :mail, :password)
");

$stmt->bindParam(':firstName', $firstname);
$stmt->bindParam(':lastName', $lastname);
$stmt->bindParam(':mail', $mail);
$stmt->bindParam(':password', $password);

$stmt->execute();

$stmt = DB_Connect::dbConnect()->prepare("
    SELECT com.content, us.firstName, us.lastName 
    FROM commentaire AS com
    LEFT JOIN utilisateur AS us ON com.user_fk = us.id
");

if ($stmt->execute()) {
    foreach ($stmt->fetchAll() as $value) {
        foreach ($value as $key => $item) {
            echo $key . ' --> ' . $item . "<br>";
        }
        echo "<br>";
    }
}