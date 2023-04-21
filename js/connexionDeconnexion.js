let eMessageErreurConnexion = document.getElementById('messageErreurConnexion');
let eModaleConnexion = document.getElementById('modaleConnexion');
let eUsager = document.getElementById('usager');
let eConnecter = document.getElementById('connecter');
let eDeconnecter = document.getElementById('deconnecter');

eConnecter.onclick = afficherFenetreModale;
frmConnexion.onsubmit = traiterFormulaire;
eDeconnecter.onclick = deconnecter;

/**
 * Affichage de la fenêtre modale
 */
function afficherFenetreModale() {
  eMessageErreurConnexion.innerHTML = "&nbsp;";
  document.getElementById('modaleConnexion').showModal();
}

/**
 * Traitement du formulaire dans la fenêtre modale
 */
function traiterFormulaire(event) {
  event.preventDefault();
  let fd = new FormData(frmConnexion);
  fetch('connecter', { method: 'post', body: fd })
    .then(reponse => reponse.json())
    .then(usager => {
      if (!usager) {
        eMessageErreurConnexion.innerHTML = "Courriel ou mot de passe incorrect.";
      } else {
        eUsager.innerHTML = usager.prenom + " " + usager.nom;
        eConnecter.classList.add('invisible');
        eDeconnecter.classList.remove('invisible');
        eModaleConnexion.close();
      }
    })
    .catch(() => {
      eMessageErreurConnexion.innerHTML = "Problème technique sur le serveur.";
    });
}

/**
 * Déconnecter
 */
function deconnecter() {
  fetch('deconnecter')
    .then(reponse => reponse.json())
    .then(codeRetour => {
      if (codeRetour) {
        eUsager.innerHTML = "";
        eDeconnecter.classList.add('invisible');
        eConnecter.classList.remove('invisible');
      }
    });
}