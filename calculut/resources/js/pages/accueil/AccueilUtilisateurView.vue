<script setup>
    import Card from 'primevue/card';
    import Button from "primevue/button";
    import CreateBilanModalView from "../bilans/utilisateur/CreateBilanModalView.vue";

    function ouvrirCreateBilan() {
        dialog.open(CreateBilanModalView, {
            props: { header: 'Créer un bilan', modal: true},
            onClose: () => {}
        });
    }

</script>

<template>
    <div class="p-8 bg-stone-100 h-full">
        <div class="grid gap-8 grid-cols-7">
            <Card class="col-span-2">
                <template #title>Les raccourcis</template>
                <template #content>
                    <Button label="Créer un bilan" severity="primary" @click="ouvrirCreateBilan"/>
                </template>
            </Card>
            <Card class="col-span-5">
                <template #title>Bienvenue Léo</template>
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
        </div>

    </div>
</template>
