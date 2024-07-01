# Étude du besoin

Ces documents ([note de clarification](#note-de-clarification) et [diagramme FAST](#diagramme-fast)) n'ont pas été finalisés mais sont une trace importante du travail effectué.

## Note de clarification

- [Contexte](#contexte)
- [PRC-NRC (Périmètre et niveau de remise en cause)](#prc-nrc-périmètre-et-niveau-de-remise-en-cause)
  - [PRC : Périmètre de remise en cause](#prc--périmètre-de-remise-en-cause)
  - [HPRC : Hors périmètre de remise en cause](#hprc--hors-périmètre-de-remise-en-cause)
  - [NRC : Niveau de remise en cause](#nrc--niveau-de-remise-en-cause)
- [Clarification du vocabulaire utilisé](#clarification-du-vocabulaire-utilisé)
  - [Événement](#événement)
  - [Empreinte liée à un événement](#empreinte-liée-à-un-événement)
  - [Secteur d’émission](#secteur-démission)
  - [Bilan](#bilan)
- [Périmètre](#périmètre)
- [Hors périmètre](#hors-périmètre)
- [Objectifs et livrables](#objectifs-et-livrables)
  - [Objectifs](#objectifs)
  - [Livrables](#livrables)
    - [Application web](#application-web)
- [Indications du bilan carbone au format PDF](#indications-du-bilan-carbone-au-format-pdf)
- [Organisation et planification](#organisation-et-planification)
  - [Début du projet](#début-du-projet)
  - [Fin du projet](#fin-du-projet)
  - [Rétroplanning](#rétroplanning)
- [Acteurs](#acteurs)
  - [Commanditaire](#commanditaire)
  - [Développeurs](#développeurs)
  - [Encadrants](#encadrants)
- [Conséquences attendues](#conséquences-attendues)
- [Difficultés prévisibles](#difficultés-prévisibles)
- [Budget](#budget)

### Contexte

Le BDE souhaite accompagner les associations de l'UTC dans une démarche responsable, dans l'adoption de la charte RSE et les pousser à s'engager plus activement sur les transformations qu'elles peuvent prendre pour améliorer leurs impacts environnementaux et sociaux. Il s'agit de permettre à ces associations de réaliser elles-mêmes et facilement les calculs d'impacts de leurs activités.

Léo Péron et Julie Chartier sont missionnés dans le cadre d’une TX encadrée par Benjamin Lussier et Valentin Le Gauche afin de réaliser un outil de calcul d’impact des associations UTCéennes.

Nous faisons le choix de nous concentrer sur l’impact carbone des associations.

### PRC-NRC (Périmètre et niveau de remise en cause)

#### PRC : Périmètre de remise en cause

Liste de ce qui peut être modifié.

- Source des données (BDD ou API)

#### HPRC : Hors périmètre de remise en cause

- Technologies de développement du SIMDE (React.js et Laravel)
- Accompagnement des associations par le BDE (échanges nécessaires) car l’outil ne cherche pas à “tout faire”. L'application ne remplace pas l'humain et n'est pas totalement autonome.

#### NRC : Niveau de remise en cause

### Clarification du vocabulaire utilisé

#### Événement

#### Empreinte liée à un événement

#### Secteur d'émission

#### Bilan

### Périmètre

Dans le contexte de cette TX concentrerons sur le calcul de l’empreinte carbone d’un événement et laisserons la possibilité de faire évoluer l’outil afin d’intégrer le calcul du fonctionnement courant d’une association lors d’une autre TX par exemple.
Dans cette version de l’outil, nous intégrerons :

- Calcul de l’empreinte carbone
- Bilan carbone d’un événement
- Un accès administrateur
- Un accès membre associatif
- Affichage de la source des données

### Hors périmètre

Cette partie permet de lister les fonctionnalités auxquelles nous avons pensé mais n’implémenterons pas dans cette version de l’outil. L’intérêt de les lister permet de connaître les limites du projet mais aussi de fournir les idées d’améliorations possibles pour de futurs projets. Enfin, la prise en compte de ces possibles futures améliorations permet de les prendre en compte dans la conception du produit de manière à ce que leur implémentation soit aisée.
Dans cette version de l’outil, nous n’intégrerons pas :

- Calcul d’impacts autres que l’empreinte carbone tels que O2, biodiversité, CH4, etc.
- Bilan carbone du fonctionnement courant d’une association
- Comparaison des bilans
- Recommandations

### Objectifs et livrables

#### Objectifs

Livrer une application web qui puisse être utilisée à la fin du semestre pour réaliser un bilan carbone exemple et obtenir des recommandations cohérentes.
Les associations pourront identifier facilement les transformations à entreprendre avec l’appui du BDE.

#### Livrables

##### Application web

Deux rôles permettants deux affichages distincts :

- membre associatif
- administrateur (BDE par exemple)
  Elle sera composée de la manière suivante.

Version membre associatif :

- d’une page d’accueil sous forme de dashboard
- d’une page permettant d’effectuer un bilan carbone en remplissant un formulaire. Lors de la finalisation/dépôt du bilan carbone, un e-mail est automatiquement envoyé au BDE.
- une page permettant de consulter les résultats d’un bilan carbone d’un événement présentés sous forme de graphique par secteur d’émission avec la liste des émissions par type d’émission ou activité et un bouton permettant d’exporter en PDF le bilan. Un bouton permettant de modifier le bilan même s’il est finalisé/déposé. Un bouton permettant de supprimer un bilan tant qu’il n’est pas finalisé/déposé et en demandant une confirmation à l’utilisateur. Un bouton permettant de finaliser/déposer le bilan et qui envoie un e-mail au BDE. + le comparer avec un autre bilan
- une page permettant de consulter la liste des bilans effectués des semestres et éditions précédentes. Actions sur chaque bilan : boutons modifier/supprimer/finaliser.
- une page permettant de visualiser le bilan total (cumulé) de l’association
- une section ou page permettant l’accès aux contacts du BDE, la charte RSE, guide de l’événement soutenable, ressources documentaires pour réduire son impact carbone (source ADEME ou labels).

Version administrateur :

- d’une page d’accueil sous forme de tableau de bord
- d’un outil permettant modifier/ajouter/archiver les données de consommation utilisées par l’application. De source ADEME ou ajoutées par le BDE.
- une page permettant l’édition et la création des formulaires / questions que les membres associatifs doivent compléter afin de faire un bilan carbone
- une page permettant de voir toutes les associations et leurs bilans carbone chiffrés en eq CO2. Les classer par pôles d’associations
- une page permettant de consulter un bilan carbone (et son historique de versions) d’un événement d’une association (avec les graphiques, bilan chiffré, PDF et réponses aux formulaires) et un bouton permettant de modifier le bilan de l’association (validation qui envoie un e-mail à l’association avec l’ancien et le nouveau bilan).

### Indications du bilan carbone au format PDF

L’objectif est de pouvoir soumettre un pdf à des labellisateurs donc le BDE nous a orientés vers le rendu de l'outils ADERE de l'ADEME (parcours confirmé) : https://evenementresponsable.ademe.fr.

### Organisation et planification

#### Début du projet

20 février 2024

#### Fin du projet

02 juillet 2024

#### Rétroplanning

- Définition du besoin :
- Validation diagramme FAST :
- Test utilisateurs :
- Maquette validée :
- Début du développement :
- Premiers tests utilisateur :

### Acteurs

#### Commanditaire

- pôle RSE du BDE UTC

#### Développeurs

- Léo PÉRON, GI05
- Julie Chartier, GI02

#### Encadrants

- enseignant-chercheur GI
- chargé de mission à la transition écologique et à l'engagement sociétal

### Conséquences attendues

### Difficultés prévisibles

- Pas de méthode universelle pour le calcul de l’empreinte carbone.
- Mise à disposition des données
- Gestion de connexion CAS et rôles

### Budget

Non concerné.

## Diagramme FAST

![](/resources/FASTdiagram.jpg)
