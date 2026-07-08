#  Application de Gestion de Bibliothèque en Ligne

Bienvenue sur le dépôt de l'application de gestion de bibliothèque. Ce projet est une application web dynamique, fluide et entièrement adaptative (Responsive Design) qui permet aux utilisateurs de consulter un catalogue de livres et aux administrateurs de piloter le stock grâce à un système CRUD complet.

##  Fonctionnalités

### Éspace Public (Lecteur)
* **Recherche interactive :** Recherche d'ouvrages par titre ou auteur avec une validation de sécurité en JavaScript (minimum 2 caractères requis).
* **Affichage moderne :** Présentation des livres sous forme de cartes élégantes grâce à une grille **CSS Grid** adaptative.
* **Fiche détaillée :** Consultation complète des informations d'un livre (Description, Éditeur, exemplaires restants).
* **Liste de lecture (Wishlist) :** Ajout en un clic à une liste personnelle (gérée en **CSS Flexbox**) avec contrôle des doublons.

### Éspace Administration (Gestionnaire)
* **Create (Ajouter) :** Formulaire d'insertion de nouveaux ouvrages avec vérification des champs obligatoires côté PHP (`trim()`, `!empty()`).
* **Read (Lister) :** Visualisation globale de la collection sous forme de tableau responsive.
* **Update (Modifier) :** Interface dédiée (`edit.php`) avec formulaire pré-rempli pour mettre à jour les informations en base de données.
* **Delete (Supprimer) :** Retrait sécurisé d'un livre de la collection avec boîte de dialogue de confirmation JavaScript (`confirm`).

---

##  Technologies utilisées

* **Frontend :** HTML5, CSS3 Avancé (Variables, Grid, Flexbox, Media Queries), Vanilla JavaScript.
* **Backend :** PHP 8 (Architecture PDO fluide, compatible tout hébergeur).
* **Base de données :** MySQL.

---

##  Installation et Configuration Locale

Pour faire fonctionner ce projet sur votre machine avec **Laragon** :

1. **Cloner ou télécharger le projet :**
   Placez le dossier du projet dans votre répertoire racine : `C:\laragon\www\bibliotheque\`.

2. **Démarrer les services :**
   Ouvrez Laragon et cliquez sur **"Tout démarrer"** pour lancer Apache et MySQL.

3. **Importer la base de données :**
   * Accédez à votre interface de gestion de base de données (PhpMyAdmin ou l'outil intégré de Laragon).
   * Créez une base de données nommée exactement `bibliotheque`.
   * Allez dans l'onglet **Importer**, sélectionnez le fichier `bibliotheque.sql` situé à la racine du projet, puis validez.

4. **Accéder au site :**
   Rendez-vous sur votre navigateur à l'adresse suivante : [http://localhost/bibliotheque/](http://localhost/bibliotheque/)

>  **Note de développement :** Le fichier de connexion `db.php` intègre un système de détection d'hôte intelligent. Il bascule automatiquement entre les identifiants locaux de Laragon et les variables d'environnement sécurisées en cas de déploiement en ligne (Render, InfinityFree...).

---

##  Structure du Code Source

```text
├── index.html         # Page d'accueil et barre de recherche principale
├── db.php             # Connexion PDO hybride (Local vs Cloud)
├── results.php        # Traitement et affichage des résultats (CSS Grid)
├── details.php        # Fiche d'information détaillée d'un livre par ID
├── wishlist.php       # Liste de lecture de l'utilisateur (Flexbox)
├── admin.php          # Tableau de bord : Formulaire d'ajout et Tableau CRUD
├── edit.php           # Formulaire de modification d'un ouvrage
├── style.css          # Feuille de style globale et responsive
└── database.sql       # Script de structure et données de la base de données