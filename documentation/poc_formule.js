const eqparser = require('./node_modules/equation-parser');
const util = require('util')

const questions = [
    {
        id: 1,
        intitule: 'Question 1',
        nomVariable: 'varA',
        type: 'unique',
        donnees: [
            {
                id: 1,
                intitule: 'Avion',
                valeur: 2
            },
            {
                id: 2,
                intitule: 'Navette',
                valeur: 3
            },
            {
                id: 3,
                intitule: 'Voiture',
                valeur: 4
            },
        ],
        reponse: 30 // Valeur dans la donnée
    },
    {
        id: 2,
        intitule: 'Question 2',
        nomVariable: 'varB',
        type: 'saisie',
        reponse: 10 // Saisie utilisateur
    },
    {
        id: 3,
        intitule: 'Question 3',
        nomVariable: 'varC',
        type: 'unique',
        reponse: 14 // Valeur dans la donnée
    },
]

function new_operation(a, b, op) {
    switch(op) {
        case 'plus':
            return a+b
        case 'multiply-dot':
            return a*b
    }
}

function new_calcul_formulaire(qs, f) {
    if(f.type === "block") return new_calcul_formulaire(qs, f.child)
    if(f.a.type === "variable" && f.b.type === "variable") {
        q1 = qs.find(q => q.nomVariable === f.a.name)
        q2 = qs.find(q => q.nomVariable === f.b.name)
        return new_operation(q1.reponse, q2.reponse, f.type)
    } else if(f.a.type !== "variable") {
        let raw = new_calcul_formulaire(qs, f.a)
        q2 = qs.find(q => q.nomVariable === f.b.name)
        return new_operation(raw, q2.reponse, f.type)
    } else {
        let raw = new_calcul_formulaire(qs, f.b)
        q1 = qs.find(q => q.nomVariable === f.a.name)
        return new_operation(raw, q1.reponse, f.type)
    }
}

function parse_and_eval(f) {
    const pf = eqparser.parse(f)
    return new_calcul_formulaire(questions, pf)
}

/*
 * varA: 30
 * varB: 10
 * varC: 14
 */

const FORMULE_TEST = "varA+varB*varC"
const PARSED_FORMULA = eqparser.parse(FORMULE_TEST)
console.log(util.inspect(PARSED_FORMULA, false, null, true))
console.log('----------------------------------------------------')
console.log(parse_and_eval(FORMULE_TEST))