# Authentification

-   GET: /api/me
	-   Prénom et Nom de l’utilisateur + les associations dont il est membre sur l’outil.
```json
{
	"prenom": "Léo",
	"nom": "Péron",
	"is_bde": False,
	"associations": [
		{
			"name": "FSC",
			"id": "12121",
		}
	]
}
```
# Accueil

-   GET: /api/dashboard
	-   Les informations nécessaires pour l’affichage de la page d’accueil
```json
{
	"synthese": [
		{
			"date": "01/01/2020",
			"valeur": "30.0",
			"secteur": "transport"
		}
	]
}
```
-   GET: /api/admin/dashboard
	-   Les informations nécessaires pour l’affichage de la page d’accueil version Admin
```json
{
	"synthese": [
		{
			"date": "01/01/2020",
			"valeur": "30.0",
			"secteur": "transport"
		}
	],
	"dernier_bilans_valides": [
		{
			"nom": "Activité du semestre",
			"id": "2323232232",
			"association": {
				"nom": "CET",
				"id": "1212121"
			}
		}
	]
}
```
# Bilans

-   GET: /api/assos/:assoId/bilans
	-   Renvoi tous les bilans d’une association
```json
{
	"bilans": [
		{
			"nom": "Fresque du Climat",
			"type": "Event",
			"date_debut": "01/01/2019",
			"date_fin": "01/01/2020",
			"statut": "Edition",
		}
	],
}
```
-   POST: /api/assos/:assoId/bilans
	-   Créé un bilan pour une association
```json
{
	"nom": "Mon nouveau bilan": STRING,
	"date_debut": 2323232323: TIMESTAMP,
	"date_fin": 3323232323232: TIMESTAMP,
	"secteurs": [3,5,8,10,12]: LIST[Formulaire_id]
}
```
-   POST: /api/assos/:assoId/bilans/:bilanId/enregistrement
	-   Créé un enregistrement de l'état du bilan pour une association
```json
{
	"nom": "Mon nouveau bilan": STRING,
	"date_debut": 2323232323: TIMESTAMP,
	"date_fin": 3323232323232: TIMESTAMP,
	"secteurs": [3,5,8,10,12]: LIST[Formulaire_id]
}
```
