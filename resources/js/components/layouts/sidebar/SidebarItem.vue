<script setup lang="ts">
import type { SidebarItem, SidebarItemAction } from './sidebar.types'
import { useSidebarLayoutContext } from './sidebar.context'
import { Link, usePage, router } from "@inertiajs/vue3";
import { onMounted } from 'vue';

const props = defineProps<{
  link: SidebarItem
}>()

const {
  activeSubsidebarId,
  toggleSubsidebar,
} = useSidebarLayoutContext()

onMounted(() => {
  console.log(props.link)
})
</script>

<template>
  <a
    v-if="props.link.type === 'subsidebar'"
    :class="[activeSubsidebarId === props.link.id && 'is-active']"
    tabindex="0"
    role="button"
    :data-content="props.link.label"
    @keydown.enter.prevent="() => toggleSubsidebar(props.link.id)"
    @click.prevent="() => toggleSubsidebar(props.link.id)"
  >
    <VIcon
      class="sidebar-svg"
      :icon="props.link.icon"
    />
  </a>
  <component
    :is="props.link.component"
    v-else-if="props.link.type === 'component'"
    :title="props.link.label"
  />
  <Link
    v-else-if="props.link.type === 'link'"
    :title="props.link.label"
    :href="$route(props.link.to)"
    :data-content="props.link.label"
  >
    <VIcon
      class="sidebar-svg"
      :icon="props.link.icon"
    />
  </Link>
  <a
    v-else-if="props.link.type === 'action'"
    role="button"
    tabindex="0"
    :title="props.link.label"
    :data-content="props.link.label"
    @click="(props.link as SidebarItemAction).onClick"
    @keydown.enter="(props.link as SidebarItemAction).onClick"
  >
    <VIcon
      class="sidebar-svg"
      :icon="props.link.icon"
    />
  </a>
</template>
