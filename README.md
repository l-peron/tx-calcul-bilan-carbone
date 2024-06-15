# Calcul'UT

## Contexte

Le BDE-UTC, fédération des associations UTCéennes a émis une demande quant à la réalisation d'un outil permettant d'estimer le bilan carbonne des activités de ses associations.

Un sujet de TX a été créé afin de développer la solution demandée par le BDE lors du semestre P24.

Lors du semestre P24, une étude du besoin, de conception et un MVP ont été réalisés. Calcul'UT reste pour le moment un outil expérimental et nous encourageons le BDE à poursuivre la TX afin de le rendre plus consistant et déployable. Cependant, l'outil peut être tester pour différentes utilisations afin d'avoir des premiers feed-backs dans le but d'instaurer une logique d'amélioration continue.

## L'application

Calcul'UT est une application de formulaire dynamique et modulable, elle permet au BDE-UTC de créer des formulaires liés à des pôles d'émissions carbones qui pourront ensuite être complétés par les différentes associations UTCéennes.

### Partie Administrateur

La patie Administrateur permet au BDE-UTC de créer des formulaires, des données, et de visualiser les différents bilans d'émissions carbonnes de ses associations.

### Partie Association/Utilisateur

La patie Association/Utilisateur permet à un membre d'une association de créer un bilan carbone pour chaque événement qu'elle organise et de visualiser son impact carbone.

## Définitions des concepts de l'application

### Événement

Un événement représente un événement organisé par une association. Ses attributs sont l'intitulé de l'événement, une date de début et une date de fin.

### Bilan

Un bilan est relié à un événement. Il contient les réponses de l'association aux formulaires qu'elle a sélectionné. Une fois le bilan finalisé, la page de visualisation du bilan devient disponible. Un bilan peut avoir plusieurs versions et peut être modifié et vu par le BDE une fois finalisé.

### Formulaire

Un formulaire comprend un intitulé, un secteur, une description, une formule et une liste de N questions.

### Question

Une question comprend un intitulé, une description, un nom de variable, un type (_saisie utilisateur_ ou _choix unique_) et N données associées si le type est _choix unique_. Chaque question créée et rattachée à un formulaire est soit de type :

- _saisie utilisateur_ : Une saisie numérique de l'utilisateur.
- _choix unique_ : Une question à choix unique qui permet à l'utilisateur de choisir une réponse parmis plusieurs données préalablement sélectionnées par l'admin. Chaque réponse possible est rattachée à une donnée créée préalablement par le BDE.

Le nom de variable d'une question est unique, permettant d'en faire référence lors de la création de la formule.

### Réponse

Une réponse est une donnée qui est référencée dans les choix possibles d'une question.

### Donnée

Une donnée est une valeur numérique avec unitée entrée par le BDE liée à un type d'émission. Chaque donnée est accompagnée d'une source afin d'être transparent et rigoureux dans les chiffres utilisés.

_Exemple de donnée:_ La donnée d'émission d'un BUS en kgCO2/p/km, la source d'information étant la base carbonne de l'Ademe.

### Formule

La formule du formulaire permet de créer le lien entre les différentes questions afin de calculer l'émission liée au sujet du formulaire.

_Exemple: Un formulaire a été créé pour estimer l'émission carbonne lié au transport des participants. Celui-ci est rattaché au secteur "Transport" et comprend 3 questions:_

- _"Quel type de transport a été utilisé ? Choix unique parmis: [Navette, Avion, Train,...]"_
- _"Combien de participants ont été transporté ? Saisie numérique de l'utilisateur"_
- _"Combien de KMs a été réalisé ? Saisie numérique de l'utilisateur"_

_La formule étant "typeTransport * nbKm * nbpersonnes", il est possède de calculer l'émission lié au transport des participants._
