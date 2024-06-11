<script setup>
    import InputText from "primevue/inputtext";
    import Button from "primevue/button";
    import {inject} from "vue";
    import {useToast} from "primevue/usetoast";
    import { BilanService} from "../../../services/BilanService.ts";
    import {useRouter} from "vue-router";
    import Calendar from "primevue/calendar";
    import {date, object, string} from "yup";
    import {useForm} from "vee-validate";

    const toast = useToast();
    const router = useRouter();
    const dialogRef = inject('dialogRef');

    const bilanService = new BilanService();

    const asso = router.currentRoute.value.path.split("/")[2]

    const validationSchema = object({
        intitule: string().required(),
        debut: date().required(),
        fin: date().required().test('finApresDebut', (fin, testContext) => {
            return fin > testContext.parent.debut;
        })
    });

    const initialValues = {
        intitule: "",
        debut: new Date(),
        fin: new Date(),
    }

    const { handleSubmit, defineField, errors } = useForm({
        validationSchema, initialValues
    });

    const [intitule, intituleAttrs] = defineField('intitule', {
        validateOnModelUpdate: false,
    });
    const [debut, debutAttrs] = defineField('debut', {
        validateOnModelUpdate: false,
    });
    const [fin, finAttrs] = defineField('fin', {
        validateOnModelUpdate: false,
    });

    const onSubmit = handleSubmit(values => {
        console.log()
        bilanService.createBilan(values, asso).then(bilan => {
            toast.add({ severity: 'success', summary: 'Création effectuée !', detail: 'Le bilan a bien été créée', life: 5000 });
            router.push(`/assos/${bilan.asso}/bilans/${bilan.id}/edit`);
        });

    });

    function cancel() {
        dialogRef.value.close();
    }
</script>

<template>
    <form @submit="onSubmit">
        <div class="flex flex-col gap-3 mb-3">
            <label for="intitule" class="font-semibold w-6rem">Titre du bilan</label>
            <InputText id="intitule" v-model="intitule" v-bind="intituleAttrs" class="flex-auto" :invalid="errors.intitule != null"/>
        </div>
        <div class="flex flex-col gap-3 mb-3">
            <label for="dateDebut" class="font-bold block mb-2">Date de début</label>
            <Calendar v-model="debut" v-bind="debutAttrs" showIcon iconDisplay="input" inputId="dateDebut" dateFormat="dd/mm/yy" :invalid="errors.debut != null"/>
        </div>
        <div class="flex flex-col gap-3 mb-3">
            <label for="dateDebut" class="font-bold block mb-2">Date de début</label>
            <Calendar v-model="fin" v-bind="finAttrs" showIcon iconDisplay="input" inputId="dateDebut" dateFormat="dd/mm/yy" :invalid="errors.fin != null"/>
        </div>
        <div class="flex justify-content-end gap-2">
            <Button type="button" label="Annuler" severity="danger" @click="cancel"></Button>
            <Button type="submit" label="Créer" severity="success"></Button>
        </div>
    </form>
</template>
