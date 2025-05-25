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
                       
                    },
                    
                    
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
