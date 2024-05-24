const donnees = [
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
]

const questions = [
    {
        id: 1,
        intitule: 'Question 1',
        nomVariable: 'varA',
        type: 'unique',
        donnees,
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

const formule = {
    operator: '*',
    var1: {
        operator: '+',
        var1: "varA",
        var2: {
            operator: '+',
            var1: "varA",
            var2: "varC"
        }
    },
    var2: "varC"
}

function operation(a, b, op) {
    switch(op) {
        case '+':
            return a+b
        case '*':
            return a*b
    }
}

function calcul_formulaire(qs, f) {
    if(typeof f.var1 === "string" && typeof f.var2 === "string") {
        q1 = qs.find(q => q.nomVariable === f.var1)
        q2 = qs.find(q => q.nomVariable === f.var2)
        return operation(q1.reponse, q2.reponse, f.operator)
    } else if(typeof f.var1 !== "string") {
        let raw = calcul_formulaire(qs, f.var1)
        q2 = qs.find(q => q.nomVariable === f.var2)
        return operation(raw, q2.reponse, f.operator)
    } else {
        let raw = calcul_formulaire(qs, f.var2)
        q1 = qs.find(q => q.nomVariable === f.var1)
        return operation(raw, q1.reponse, f.operator)
    }
}

console.log(calcul_formulaire(questions, formule));