<script setup>
    import Card from "primevue/card";
    import Calendar from "primevue/calendar";
    import Tree from "primevue/tree";
    import { ref, onMounted } from 'vue';
    import InputText from "primevue/inputtext";
    import {FormulaireService, TypeFormulaire} from "../../../services/FormulaireService.ts";
    import { map } from "lodash";
    import Button from "primevue/button";
    import QuestionUtilisateurCardComponent from "../../../components/bilans/utilisateur/FormulaireCardComponent.vue";
    import {useRoute} from "vue-router";
    import {BilanService} from "../../../services/BilanService.ts";
    import {useToast} from "primevue/usetoast";

    const formulaireService = new FormulaireService();
    const bilanService = new BilanService();
    const routes = useRoute();
    const toast = useToast();


    const formulaires = ref();
    const selectedFormulaires = ref([]);
    const answeredFormulaires = ref({});
    const nodes = ref(map(TypeFormulaire, (label, key) => {
        return { key, label, children: [] };
    }));

    const titre_bilan = ref("");
    const debut_event = ref();
    const fin_event = ref();

    async function recupererFormulaires() {
        await formulaireService.getFormulaires().then(data => {
            formulaires.value = data;
        });
    }

    onMounted(async() => {
        await recupererFormulaires();

        await bilanService.getBilan(routes.params.id).then(bilan => {
            titre_bilan.value = bilan.intitule

            if(bilan.enregistrement) {
                for(const formulaire of bilan.enregistrement.formulaires) {
                    answeredFormulaires.value[formulaire.id] = formulaire.reponses
                    selectedFormulaires.value.push(formulaire)
                }
            }
        })

        for(const formulaire of formulaires.value) {
            const node_index = nodes.value.findIndex(n => n.key === formulaire.secteur)
            nodes.value[node_index].children.push({ key: formulaire.id, label: formulaire.intitule, type: 'formulaire' })
        }
    });

    async function selectionerFormulaire(id) {
        await formulaireService.getFormulaire(id).then(formulaire => {
            selectedFormulaires.value.push(formulaire)
        });
    }

    function onNodeSelect(node) {
        if(node.type === 'formulaire') {
            selectionerFormulaire(node.key)
        }
    }

    function removeFormulaire(id) {
        selectedFormulaires.value = selectedFormulaires.value.filter(f => f.id !== id)
        delete answeredFormulaires.value[id]
    }

    function saveFormulaire(id, reponses) {
        console.log(reponses)
        answeredFormulaires.value[id] = reponses
    }

    async function saveBilan() {
        const formulairesEnregistrement = map(answeredFormulaires.value, (questions, id) => {
            const formulaire = selectedFormulaires.value.find(f => f.id === id)
            formulaire.reponses = questions
            return formulaire;
        })

        await bilanService.updateBilan(routes.params.id, titre_bilan.value, {
            date: new Date(),
            auteur: 'auteur',
            formulaires: formulairesEnregistrement
        }).then(() => {
            toast.add({ severity: 'success', summary: 'Bilan sauvegardé !', detail: 'Le bilan a bien été sauvegardé', life: 5000 });
        });
    }

</script>

<template>
    <div class="flex flex-row h-full">
        <div class="w-1/4 p-4 border-0 border-r border-r-emerald-800 border-solid">
            <h1 class="text-xl font-bold my-2">Les secteurs d'émissions</h1>
            <div class="flex justify-content-center overflow-y-scroll">
                <Tree :value="nodes" class="w-full md:w-30rem" selectionMode="single" @node-select="onNodeSelect" >
                    <template #default="slotProps">
                        <span class="font-semibold">{{ slotProps.node.label }}</span>
                    </template>
                    <template #formulaire="slotProps">
                        <span class="font-normal hover:text-emerald-600">{{ slotProps.node.label }}</span>
                    </template>
                </Tree>
            </div>
        </div>
        <div class="p-6 overflow-y-scroll bg-stone-100">
            <div class="flex flex-col gap-4">
                <Card id="bilan_creation_form">
                    <template #title>
                        <div class="flex flex-row items-center justify-between">
                            <h1 class="text-xl font-bold my-2">Création d'un Bilan</h1>
                            <div class="flex flex-row gap-2">
                                <Button label="Sauvegarder" severity="primary" @click="saveBilan"/>
                                <Button label="Finaliser" severity="secondary"/>
                                <Button label="Supprimer" severity="danger" outlined />
                            </div>
                        </div>
                    </template>
                    <template #content>
                        <div class="flex flex-row mt-2 items-center gap-16 m-0">
                            <div class="flex flex-col">
                                <label for="titreBilan" class="font-bold block mb-2">Titre du bilan</label>
                                <InputText v-model="titre_bilan" placeholder="Création d'un bilan, ex: SDF P24" id="titreBilan" class="w-96"/>
                            </div>
                            <div class="flex flex-col">
                                <label for="dateDebut" class="font-bold block mb-2">Date de début</label>
                                <Calendar v-model="debut_event" showIcon iconDisplay="input" inputId="dateDebut" />
                            </div>
                            <div class="flex flex-col">
                                <label for="dateFin" class="font-bold block mb-2">Date de fin</label>
                                <Calendar v-model="fin_event" showIcon iconDisplay="input" inputId="dateFin" />
                            </div>
                        </div>
                    </template>
                </Card>
                <div v-for="formulaire in selectedFormulaires">
                    <QuestionUtilisateurCardComponent :key="formulaire.id" :formulaire="formulaire" @removeFormulaire="removeFormulaire" @saveFormulaire="saveFormulaire"/>
                </div>
            </div>
        </div>
    </div>
</template>

