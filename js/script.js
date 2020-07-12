function validate() {
  var validationMessage;
  // Le prénom et le nom est une chaine de caractère
  var regexChaine = /^[a-zA-Z]+$/;
  var prenom = document.getElementById("prenomId").value;
  if (regexChaine.test(prenom) !== true) {
    validationMessage = validationMessage
      ? validationMessage + "\nprenom doit etre une chaine de caractère."
      : "\nprenom doit etre une chaine de caractère.";
  }
  var nom = document.getElementById("nomId").value;
  if (regexChaine.test(nom) !== true) {
    validationMessage = validationMessage
      ? validationMessage + "\nnom doit etre une chaine de caractère."
      : "\nnom doit etre une chaine de caractère.";
  }

  // La forme de l’émail est correcte
  var regixEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
  var email = document.getElementById("emailId").value;
  if (regixEmail.test(email) !== true) {
    validationMessage = validationMessage
      ? validationMessage + "\nemail est invalide."
      : "\nemail est invalide.";
  }

  // Le pseudo est une chaine composée au moins de 5 caractères.
  var pseudo = document.getElementById("pseudoId").value;
  if (regexChaine.test(pseudo) !== true || pseudo.length < 5) {
    validationMessage = validationMessage
      ? validationMessage +
        "\npseudo doit etre une chaine composée au moins de 5 caractères."
      : "\npseudo doit etre une chaine composée au moins de 5 caractères.";
  }

  // Le mot de passe est composé de au moins 8 caractères.
  var motdepasse = document.getElementById("passwordId").value;
  if (motdepasse.length < 8) {
    validationMessage = validationMessage
      ? validationMessage +
        "\nmot de passe est composé de au moins 8 caractères."
      : "\nmot de passe est composé de au moins 8 caractères.";
  }

  // Le choix de statut est obligatoire.
  var isEnseignant = document.getElementById("enseignantStatusId").checked;
  var isEtudiant = document.getElementById("etudiantStatusId").checked;

  if (!isEnseignant && !isEtudiant) {
    validationMessage = validationMessage
      ? validationMessage + "\nchoix de statut est obligatoire."
      : "\nchoix de statut est obligatoire.";
  }

  // check result
  if (validationMessage) {
    alert(validationMessage);
    return false;
  }

  // by default return true
  return true;
}
