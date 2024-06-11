<script setup>

    import {EnregistrementFinaliseService} from "../../services/EnregistrementFinaliseService.ts";
    import {onMounted, ref} from "vue";
    import {useRoute} from "vue-router";
    import RecapitulatifCardComponent from "../../components/recapitulatif/RecapitulatifCardComponent.vue";
    import Chart from "primevue/chart";
    import {forOwn} from "lodash";
    import {TypeFormulaire} from "../../services/FormulaireService.ts";
    import Dropdown from "primevue/dropdown";

    const routes = useRoute();
    const bilanId = routes.params.id;

    const enregistrementFinaliseService = new EnregistrementFinaliseService();

    const emissionChart = ref();
    const chartData = ref();

    const enregistrementFinalises = ref([]);

    const optionsEnregistrement = ref([]);
    const selectEnregistrementId = ref("");

    const enregistrement = ref({
        auteur:"",
        commentaire: "",
        bilan: {
            intitule: ""
        },
        enregistrement: {
            formulaires: []
        }
    });

    onMounted(async () => {
        await enregistrementFinaliseService.getEnregistrementFinalises(bilanId).then(data => {
            enregistrementFinalises.value = data;

            // On prend le premier
            enregistrement.value = data[0];
            setChartData();
            selectEnregistrementId.value = data[0].id;

            for(const enregistrement of data) {
                optionsEnregistrement.value.push({
                    label: new Date(enregistrement.created_at).toLocaleDateString("fr") + " - " + enregistrement.auteur,
                    id: enregistrement.id
                })
            }
        });
    });

    function setChartData() {
        const emissions = {}
        const labels = []
        const data = []

        for(const formulaire of enregistrement.value.enregistrement.formulaires) {
            if(formulaire.secteur in emissions)
                emissions[formulaire.secteur] += formulaire.evaluation;
            else emissions[formulaire.secteur] = formulaire.evaluation;
        }

        forOwn(emissions, function(valeur, secteur) {
            labels.push(TypeFormulaire[secteur])
            data.push(valeur)
        });

        chartData.value =  {
            labels,
            datasets: [
                {
                    data,
                }
            ]
        };
    }

    function fetchNewEnregistrement() {
        enregistrement.value = enregistrementFinalises.value.find(e => e.id === selectEnregistrementId.value);
        setChartData();
    }
</script>


<template>
    <div class="m-4">
        <div class="m-6 flex flex-row justify-around">
            <div class="flex flex-col">
                <div class="p-8 shadow border border-emerald-800 border-solid rounded-2xl">
                    <div>
                        <label for="enregistrement">Choisir un bilan à visualiser</label>
                        <Dropdown v-model="selectEnregistrementId" :options="optionsEnregistrement" optionLabel="label" optionValue="id" placeholder="Bilan selectionné" class="w-full my-2" @update:modelValue="fetchNewEnregistrement" id="enregistrement"/>
                    </div>
                    <h1 class="my-2">{{ enregistrement.bilan.intitule }}</h1>
                    <p class="italic my-1">{{ enregistrement.commentaire }}</p>
                    <p class="my-1">{{ enregistrement.auteur }}</p>
                </div>
            </div>
            <div>
                <Chart type="doughnut" :data="chartData" ref="emissionChart"/>
                <p class="italic my-4">Graphique des différents pôles d'émissions.</p>
            </div>
        </div>
        <div class="flex flex-col">
            <RecapitulatifCardComponent :formulaire="formulaire" v-for="formulaire in enregistrement.enregistrement.formulaires" />
        </div>
    </div>
</template>


