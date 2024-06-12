
# Calcul'UT

## Contexte

Le BDE-UTC, fédération des associations UTCéennes a émis une demande quant à la réalisation d'un outil permettant d'estimer le bilan carbonne des activités de ses associations.

Un sujet de TX a été créé afin de développer la solution demandée par le BDE lors du semestre P24.

Lors du semestre P24, une étude du besoin, de conception et un MVP ont été réalisés. Calcul'UT reste pour le moment un outil expérimental et nous encourageons le BDE à poursuivre la TX afin de de le rendre plus consistant et déployable. Cependant, l'outil peut être testable par différentes utilisations afin d'avoir de premier feed-backs dans le but d'instaurer une logique d'amélioration continue.

## L'application

Calcul'UT est une application de formulaire dynamique et modulable, elle permet au BDE-UTC de créer des formulaires liés à des pôles d'émissions carbonnes qui pourront ensuite être complétés par les différentes associations UTCéennes.

### Partie Administrateur

La patie Administrateur permet au BDE-UTC de créer des formulaires, des données, et de visualiser les différents bilans d'émissions carbonnes de ses associations.

Une donnée est une valeur numérique avec unitée entrée par le BDE lié à une émission. Chaque donnée est accompagnée d'une source afin d'être transparent et rigoureux dans les chiffres utilisés.

_Exemple de donnée:_ La donnée d'émission d'un BUS en kgCO2/p/km, la source d'information étant la base carbonne de l'Ademe.

Un formulaire comprend un intitulé, un secteur, une description, une formule et une liste N de questions. Chaque question créée et rattachée à un formulaire est soit:
- Une saisie numérique de l'utilisateur.
- Une question à choix uniques, chaque choix unique est rattachée à une donnée créée préalablement par le BDE.

La formule du formulaire permet de créer le lien entre les différentes questions afin de calculer l'émission liée au sujet du formulaire.

_Exemple: Un formulaire a été créé pour estimer l'émission carbonne lié au transport des participants. Celui-ci est rattaché au secteur "Transport" et comprend 3 questions:_
- _"Quel type de transport a été utilisé ? Choix unique parmis: [Navette, Avion, Train,...]"_
