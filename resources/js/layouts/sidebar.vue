<template>
  <SidebarLayout
    :links
    :links-bottom="linksBottom"
    default-sidebar="dashboard"
  >
    <!-- Propagating the context to the default slot -->
    <template #default="context">
      <slot v-bind="context" />
    </template>

    <!-- Expose the page-heading slot -->
    <template #page-heading="context">
      <slot name="page-heading" v-bind="context" />
    </template>

    <template #logo>
      <RouterLink to="/">
        <AnimatedLogo width="36px" />
      </RouterLink>
    </template>

    <template #subsidebar-title="{ activeSubsidebar }">
      <h3>{{ activeSubsidebar?.subsidebar.label }}</h3>
    </template>

    <template #toolbar>
      <!-- <ToolbarLanguage /> -->
      <ToolbarNotification />
      <ToolbarThemeToggle />
      <!-- <ToolbarActivity /> -->
    </template>

    <template #toolbar-mobile>
      <ToolbarNotificationMobile />
      <ToolbarUserProfile right />
    </template>

    <template #extra>
      <CircularMenu />

      <PanelLanguages />
      <PanelActivity />
      <PanelSearch />
      <PanelTask />

      <ClientOnly>
        <VReloadPrompt app-name="Vuero" />
      </ClientOnly>
    </template>
  </SidebarLayout>
</template>

<script setup lang="ts">
import { usePanels } from '@/stores/panels';
import type { SidebarItem } from '/@src/components/layouts/sidebar/sidebar.types'

import LayoutSwitcher from '/@src/components/partials/layout/LayoutSwitcher.vue'
import ToolbarUserProfile from '/@src/components/partials/layout/toolbar/ToolbarUserProfile.vue'
import { h, ref } from 'vue';

const panels = usePanels()

const links = ref<SidebarItem[]>([
  {
    id: 'dashboard',
    label: 'Cadastros',
    icon: 'lucide:notebook-tabs',

    type: 'subsidebar',
    subsidebar: {
      label: 'Cadastros',
      items: [
        {
          type: 'collapse',
          id: 'personal',
          label: 'Admin',
          children: [
            {
                label: 'Usuários',
                to: 'users.index',
                icon: 'lnil lnil-users',
            }
          ],
        },
        {
          type: 'divider',
        },
        {
            type: 'link',
            label: 'Automóveis',
            to: 'vehicles.index'
        },
        {
          type: 'link',
          label: 'Categorias',
          to: 'categories.index'
        },
        {
          type: 'link',
          label: 'Marcas',
          to: 'brands.index',
        },
        {
          type: 'link',
          label: 'Modelos',
          to: 'brandModels.index'
        },
        {
          type: 'link',
          label: 'Versões Modelos',
          to: 'modelVersions.index'
        },
        {
          type: 'link',
          label: 'Tipos',
          to: 'vehicleType.index'
        },
        {
          type: 'link',
          label: 'Tipo Combustível',
          to: 'vehicleFuelType.index'
        
        },
        {
          type: 'link',
          label: 'Acessórios',
          to: 'accessories.index'
        },
        {
          type: 'link',
          label: 'Cores Veículos',
          to: 'vehicleColors.index',
        },
        {
          type: 'link',
          label: 'Condições Veículos',
          to: 'vehicleConditions.index'
        },
        {
          type: 'link',
          label: 'Portas',
          to: 'vehicleDoors.index'
        },
        {
          type: 'link',
          label: 'Tipo de Transmissão',
          to: 'vehicleTransmissions.index'
        },
        {
          type: 'link',
          label: 'Status Veículos',
          to: 'vehicleStatus.index'
        }
      ],
    },
  },
  {
    id: 'layout',
    label: 'Menu',
    icon: 'lucide:grid',

    type: 'subsidebar',
    subsidebar: {
      label: 'Menu',
      items: []
    },
  },
])

const linksBottom = ref<SidebarItem[]>([
//   {
//     id: 'layout-switcher',
//     type: 'component',
//     label: 'Switch layout',
//     hideMobile: true,
//     component: markRaw(LayoutSwitcher),
//   },
//   {
//     id: 'search',
//     type: 'action',
//     label: 'Search',
//     icon: 'lucide:search',
//     onClick() {
//       panels.setActive('search')
//     },
//   },
  {
    id: 'user-profile-dropdown',
    type: 'component',
    hideMobile: true,
    component: () => h(ToolbarUserProfile, { end: true }),
  },
])
</script>
