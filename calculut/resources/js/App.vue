<template>
    <HeaderComponent id="header"></HeaderComponent>
    <div id="root">
        <Toast />
        <ConfirmDialog />
        <DynamicDialog />
        <router-view v-slot="{ Component, route }">
            <div :key="route.name" class="h-full">
                <Component :is="Component" />
            </div>
        </router-view>
    </div>
</template>

<script setup lang="ts">
    import HeaderComponent from "./components/header/HeaderComponent.vue";
    import Toast from "primevue/toast";
    import ConfirmDialog from "primevue/confirmdialog";
    import DynamicDialog from "primevue/dynamicdialog";
</script>

<style>
    body {
        margin: 0;
        height: 100vh;
    }

    #root {
        top: 66px;
        position: fixed;
        overflow: scroll;
        height: calc(100% - 66px);
        width: 100%;
    }

    #header {
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 10;
    }
</style>
