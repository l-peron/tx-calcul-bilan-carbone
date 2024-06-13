<script setup>
    import Textarea from "primevue/textarea";
    import Button from "primevue/button";
    import {inject, onMounted, ref} from "vue";
    import {useToast} from "primevue/usetoast";
    import {EnregistrementFinaliseService} from "../../../services/EnregistrementFinaliseService.ts";

    const toast = useToast();
    const dialogRef = inject('dialogRef');

    const enregistrementFinaliseService = new EnregistrementFinaliseService();

    const enregistrement = ref({});
    const commentaire = ref("");

    onMounted(async() => {
        enregistrement.value = dialogRef.value.data.enregistrement;
    })

    async function confirm() {

        const enregistrementFinalise = {
            commentaire: commentaire.value,
            enregistrement: enregistrement.value,
        }

        await enregistrementFinaliseService.createEnregistrementFinalise(dialogRef.value.data.bilanId, enregistrementFinalise)

        dialogRef.value.close();

        toast.add({ severity: 'info', summary: 'Confirmation', detail: 'Le bilan a bien été finalisé', life: 3000 });
    }

    function cancel() {
        dialogRef.value.close();
    }

</script>

<template>
    <div class="flex flex-col gap-3 mb-5">
        <label for="description" class="font-semibold w-6rem">Commentaire</label>
        <Textarea id="description" v-model="commentaire" rows="3" cols="30" />
    </div>
    <div class="flex justify-content-end gap-2">
        <Button type="button" label="Finaliser" severity="primary" @click="confirm"/>
        <Button type="button" label="Annuler" severity="danger" outlined @click="cancel"/>
    </div>
</template>
