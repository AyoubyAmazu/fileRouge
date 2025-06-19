<script setup>
import { ref } from 'vue';

import AppMenuItem from './AppMenuItem.vue';

const model = ref([


    {
        label: 'Hierarchy',
        items: [
            {
                label: 'Entretien Individuel Module',
                icon: 'pi pi-fw pi-user',
                items: [
                    {
                        label: 'Dashboard',
                        icon: 'pi pi-fw pi-home',
                        to: '/',
                    },


                ]
            },
            {
                label: 'Evenement Module',
                icon: 'pi pi-fw pi-calendar',
                items: [
                    {
                        label: 'Dashboard',
                        icon: 'pi pi-fw pi-home',
                        to: '/evenements',

                    },
                    {
                        label: 'Liste des Événements',
                        icon: 'pi pi-fw pi-list',
                        to: '/evenements/liste',
                    },
                    {
                        label: 'Ajouter un Événement',
                        icon: 'pi pi-fw pi-plus',
                        to: '/evenements/creation',
                    },
                    {
                        label: 'list des communautés',
                        icon: 'pi pi-fw pi-globe',
                        to: '/communautes',
                    },
                    {
                        label: 'Ajouter une communauté',
                        icon: 'pi pi-fw pi-plus',
                        to: '/communautes/creation',
                    },
                    {
                        label: 'Liste des Membres',
                        icon: 'pi pi-fw pi-users',
                        to: '/members',
                    },
                    {
                        label: 'Ajouter un Membre',
                        icon: 'pi pi-fw pi-user-plus',
                        to: '/member/add',
                    }


                ]
            }

        ]
    },

]);
</script>

<template>
    <ul class="layout-menu">
        <template v-for="(item, i) in model" :key="item">
            <app-menu-item v-if="!item.separator" :item="item" :index="i"></app-menu-item>
            <li v-if="item.separator" class="menu-separator"></li>
        </template>
    </ul>
</template>

<style lang="scss" scoped></style>
