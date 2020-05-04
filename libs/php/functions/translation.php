<?php
// INDEX.PHP
$aLecoute = array("Un service à l'écoute", "A service that listens");
$quiSommeNous = array("Qui sommes nous ?", "Who are we?");
$quiSommeNoustexte = array("NSA Services est un service de conciergerie privée à destination d’une clientèle haut de gamme, exigeante, pressée, à qui nous offrons l’excellence, la perfection et le sur-mesure.
", "NSA Services is a private concierge service for an upscale, demanding, hurried clientele to whom we offer excellence, perfection and customization.");
$aboIndiv = array("Abonnement individuels", "Individual Subscriptions");
$open = array("Ouvert", "Open");
$from = array("de", "from");
$to = array("a", "to");

//SIGNUP.PHP
$inscription = array("Inscription", "Registration");
$passerror = array("Vos mot de passe ne correspondent pas !", "Your passwords don't match!");
$pseudolength = array("Votre pseudo ne peut pas dépasser 15 caracteres !", "Your nickname cannot exceed 15 characters!");
$lastnameLength = array("Votre nom ne peut pas dépasser 15 caracteres !", "Your name cannot be longer than 15 characters!");
$field_blank = array("Tout les champs doivent être compléter !", "All fields must be completed!");
$name_length = array("Votre prénom ne peut pas dépasser 15 caracteres !", "Your first name cannot exceed 15 characters!");
$invalid_email = array("Votre adresse mail n\'est pas valide !", "Your email address is not valid!");
$email_exist = array("Email déja existant", "Email already existing");
$Nom = array('Nom', 'Lastame');
$Prenom = array('Prenom', 'Firstname');
$address = array('Adresse Postal', 'Postal Address');
$Ville = array('Ville', 'City');
$telNumber = array('Numéro de telephone', 'Phone number');
$passwd = array('Mot de passe', 'Password');
$confimPasswd = array('confirmer le mot de passe', 'Confirm your Password');
$seConnecter = array('Se connecter', 'Login');
$sInscrire = array('S\'inscire', 'Login');
$saisir = array('Saisir', 'Enter');
$reSaisir = array('Retappez', 'Re-type');

//LOGIN.PHP
$connexion = array('Connexion', 'Login');
$wrongpass = array('Mauvais mot de passe' ,'Wrong password');
$rediInscri = array('Vous pouvez désormais vous connecter', 'You can now log in');
$pasEncoreInscrit = array('Pas encore inscrit ? Rejoingnez-nous !', 'Not registered yet? Join us!');

//Dashboard
$decouvrirAbon = array('Découvrez nos abonnements', 'Discover our subscriptions');
$resiliationOk = array('Résiliation effectuée avec succès', 'Termination successfully completed.');
$heureMois = array('heures de services par mois', 'hours of service per month');
$disponibilite = array('Disponibilité', 'Availability');
$engagement = array('(Sans)/(Avec) Engagement', '(Without)/(With) Commitment');
$sabonnerA = array('S\'abonner à :', 'Subscribe to :');
$attendPlus = array('<p>N\'attendez plus pour profiter de tous nos services !</p> <p>Vous serez redirigé vers la page de paiement.</p>', '<p>	Don\'t wait any longer to take advantage of all our services!</p><p>You will be redirected to the payment page.</p>');
$close = array('Fermer', 'Close');
$passerPaiement = array('Passer au paiement', 'Proceed to payment');

//userheader
$mesServices = array('Mes services', 'My services');
$chercherServices = array('Chercher un service', 'Search for a service');
$obtenirDevis = array('Obtenir un devis', 'Provide quote');
$commande = array('Commande', 'Order');
$headerDevis = ["Mes devis", "My quotes"];


//mes_services.php
$demandeOk = array('Votre demande a bien été prise en compte', 'Your request has been taken into account');
$servicePrevu = array('Services prévus', 'Planned Services');
$lieu = array('Lieu', 'Location');
$prix = array('Prix', 'price');
$prestataire = array('Prestataire', 'Provider');

//service.php
$chercherService = array('Rechercher des services', 'Search for services');
$exPlacehorder = array('Garde d\'enfants, plomberie, réparation informatique', 'Childcare, plumbing, computer repairs');
$nosServices = array('Nos services', 'Our services');
$serviceInconnu = array('Besoin d\'un devis ?', 'Need an unlisted service ? Make your quote');
$reseigneInfo = array('Renseignez les informations concernant votre service et nous reviendrons vers vous le plus vite possible', 'Fill in the information about your service and we will get back to you as soon as possible.');
$titre = array('Titre', 'Title');
$dateEtHeure = array('Date et Heure', 'Date and hours');
$lieuIntervention = array('Lieu de l\'intervention', 'Location of the intervention');
$envoyerDemande = array('Envoyer ma demande', 'Send my request');

//Orders.php
$mesCommandes= array('Mes Commandes', 'My Orders');
$historiqueCommande = array('Historique des commandes', 'Orders History');
$quantite = array('Quantite', 'Quantity');
$etatPaiement = array('État des paiements', 'Payment Status');
$dateReservation = array('Date de réservation', 'Reservation Date');
$etatCommande = array('État de la commande', 'Order Status');
$panier = array('Mon panier de services', 'My basket of services');

//mainHeader
$deconnexion = array('Deconnexion', 'Log Out');
$langues = array('Langues','Languages');

//admin/HeaderNavigation
$settings = array('Parametres', 'Settings');
// admin/sidebar
$utilisateurs = array('Utilisateurs','Customers');
$abonnement = array('Abonnements','Subscriptions');
$partenaires = array('Partenaires','Partners');
$report = array('Rapports','Saved reports');
$cemois = array('Mois en cours',"Current month");
$trimeste = array('Dernier trimestre','Last quarter');
$cetteAnnee = array('Cette années','Year-end sale');

// admin/displayUsers
$gestionUser = array('Gestions des utilisateurs','Users Management');
$listeUser = array('Liste des utilisateurs', 'Users List');

// admin/subscriptions
$gestionAbonnement = array('Gestion des abonnements','subscriptions managements');
$duree = array('Duree (en mois)','Duration (month)');
$nbHeureCompris = array('Nb d\'heure compris', 'nb of hours included');
$nbJourCompris = array('Nb de jours compris', 'nb of days included');
$heureOuvertFermer = array('Heure Ouvert/Fermer', 'Hour open/close');
$heureOuverture = array('Heure ouverture', 'Opening time');
$heureFermeture = array('Heure Fermeture','Time Closing');
$creeAbonnement = array('Creer abonnement','Create subcription');

// admin/partner_management
$gestionPartner = array('Gestion des partenaires', 'Partners Management');
$entreprise = array('Entreprise','Corporation');
$listPartner = array('Liste des partenaires','Partners List');
$disponibleDebut = array('Disponibilite debut', 'Disponibility Begin');
$disponibleFin = array('Disponibilite fin', 'Disponibility end');


// admin/services_management
$GestionService = array('Gestion des services', 'Services Management');
$listeService = array('Liste des services','Services List');
$prixReduit = array('Prix réduit','Discount Price');
$categorie = array('Catégorie','Category');
$nomService = array('Nom du service','Service name');
$name = array('Nom', 'Name');
//newCategoriesModal
$nvlleCategorie = array('Nouvelle catégorie', 'New category');
$creenvlleCategorie = array('Creer une nouvelle catégorie', 'Create a new category');
$nbAvantReduc = array('Nb avant réduction', 'Nb before discount');

// admin/order_management
$gestionCommande = array('Gestion des commandes','Orders Management');
$dateCommande = array('Date commande','Order Date');
 ?>
