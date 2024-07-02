<script setup>
    import {onMounted, ref} from "vue";
    import {forOwn} from "lodash";
    import { useRoute } from 'vue-router';

    import Card from 'primevue/card';
    import Button from "primevue/button";
    import Chart from 'primevue/chart';
    import Calendar from 'primevue/calendar';

    import CreateBilanModalView from "../bilans/utilisateur/CreateBilanModalView.vue";

    import {TypeFormulaire} from "../../services/FormulaireService.ts";
    import {BilanService} from "../../services/BilanService.ts";
    import {HeaderService} from "../../services/HeaderService.ts";

    const route = useRoute();
    const asso = route.params.asso;

    const bilanService = new BilanService();
    const headerService = new HeaderService();

    const emissionChart = ref();
    const chartData = ref();
    const chartOptions = ref();
    const startDate = ref();
    const endDate = ref();
    const bilans = ref();
    const total = ref(0);
    const enregistrementsFinalises = ref();
    const user = ref();

    async function getUser(){
        headerService.getIdentity().then((identity) => {
            user.value = identity.fullName;
        });
    }

    /* Actions boutons */
    function ouvrirCreateBilan() {
        dialog.open(CreateBilanModalView, {
            props: { header: 'Créer un bilan', modal: true},
            onClose: () => {}
        });
    }

    /* Graphiques */

    async function getBilans() {
        try {
            let data;

            if (asso){
                data = await bilanService.getBilansByAsso(asso);
            } else {
                data = await bilanService.getBilans();
            }

            enregistrementsFinalises.value = data
                .filter(bilan => bilan.enregistrement_finalises && bilan.enregistrement_finalises.length > 0)
                .map(bilan => {
                    const sortedEnregistrements = bilan.enregistrement_finalises
                        .sort((a, b) => new Date(b.updated_at) - new Date(a.updated_at));
                    const dernierEnregistrementFinalise = sortedEnregistrements[0];
                    const evenement = data.find(item => item.id === dernierEnregistrementFinalise.bilan_id)?.evenement;

                    return {
                        dernier_finalise: dernierEnregistrementFinalise,
                        evenement: evenement
                    };
                });
            bilans.value = data;
        } catch (error) {
            console.error('Erreur lors de la récupération des enregistrements finalisés :', error);
        }
    }

    function setChartData() {
        const emissions = {}
        const stringLabel = "Du " + startDate.value.toLocaleDateString("fr") + " au " + endDate.value.toLocaleDateString("fr");
        const labels = [stringLabel]
        const data = []
        total.value = 0;

        const filteredEnregistrements = enregistrementsFinalises.value.filter(enregistrement => {
            const dateDebut = new Date(enregistrement.evenement.debut * 1000);
            const dateFin = new Date(enregistrement.evenement.fin * 1000);
            return (!startDate.value || dateDebut >= startDate.value) && (!endDate.value || dateFin <= endDate.value);
        });

        for(const enregistrement of filteredEnregistrements){
            for(const formulaire of enregistrement.dernier_finalise.enregistrement.formulaires) {
                if(formulaire.secteur in emissions)
                    emissions[formulaire.secteur] += formulaire.evaluation;
                else emissions[formulaire.secteur] = formulaire.evaluation;
            }
        }

        forOwn(emissions, function (valeur, secteur) {
            data.push({
                label: TypeFormulaire[secteur],
                borderWidth: 1,
                data: [valeur]
            });

            total.value += valeur;
        });

        chartData.value =  {
            labels,
            datasets: data
        };
    }

    const setChartOptions = () => {
        const documentStyle = getComputedStyle(document.documentElement);
        const textColor = documentStyle.getPropertyValue('--p-text-color');
        const textColorSecondary = documentStyle.getPropertyValue('--p-text-muted-color');
        const surfaceBorder = documentStyle.getPropertyValue('--p-content-border-color');

        return {
            plugins: {
                legend: {
                    labels: {
                        color: textColor
                    }
                }
            },
            scales: {
                x: {
                    ticks: {
                        color: textColorSecondary
                    },
                    grid: {
                        color: surfaceBorder
                    }
                },
                y: {
                    beginAtZero: true,
                    ticks: {
                        color: textColorSecondary
                    },
                    grid: {
                        color: surfaceBorder
                    }
                }
            }
        };
    }

    /* Au chargement de la vue */
    onMounted(async () => {
        await getUser();

        const today = new Date();
        const defaultStartDate = new Date(today.getFullYear(), 0, 1);

        startDate.value = defaultStartDate;
        endDate.value = today;

        await getBilans();
        setChartData();
        chartOptions.value = setChartOptions();
    });
</script>

<template>
    <div class="p-8 bg-stone-100">
        <div class="grid gap-8 grid-cols-7">

            <Card class="col-span-2">
                <template #title>Les raccourcis</template>
                <template #content>
                    <Button label="Créer un bilan" severity="primary" @click="ouvrirCreateBilan"/>
                </template>
            </Card>

            <Card class="col-span-5">
                <template #title>Bienvenue {{ user }} !</template>
                <template #content>
                    <div class="flex flex-col gap-6">
                        <p class="m-0">
                            Cette application est une version BETA d'un estimateur d'emission carbonnes des associations UTCéennes. Il a été réalisé dans le cadre d'une TX pour le bde.
                        </p>
                        <div class="flex flex-col gap-2">
                            <p class="m-0">
                                Voici quelques-liens qui te seront utiles pour te familiariser avec les concepts de cette application:
                            </p>
                            <div class="flex flex-row gap-2">
                                <Button label="Charte RSE du BDE" link />
                                <Button label="Sources de données" link />
                                <Button label="Engagements DD de l'UTC" link />
                            </div>
                            <p class="m-0">
                                Prendre contact avec le bde: bde@assos.utc.fr
                            </p>
                        </div>
                    </div>
                </template>
            </Card>

            <Card class="col-span-4">
                <template v-if="asso" #title>Somme des enregistrements finalisés du {{ asso }}</template>
                <template v-else #title>Somme des enregistrements finalisés de toutes les associations</template>
                <template #content>
                    <div class="flex flex-row gap-4" style="align-items: baseline;">
                        <span>Du</span>
                        <Calendar v-model="startDate" placeholder="Date de début" />
                        <span>au</span>
                        <Calendar v-model="endDate" placeholder="Date de fin" />
                        <Button label="Appliquer les filtres" @click="setChartData" />
                    </div>
                    <Chart type="bar" :data="chartData" :options="chartOptions" ref="emissionChart"/>
                </template>
            </Card>

            <Card class="col-span-3" style="height:5rem; text-align: center;">
                <template #title>{{ total }} kg Eq. CO2</template>
            </Card>
        </div>

    </div>
</template>
