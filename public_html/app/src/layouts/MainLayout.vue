<template>
  <q-layout view="lHr lpR lfr">
    <q-header class="bg-primary text-white">
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          icon="menu"
          aria-label="Menu"
          @click="miniState = !miniState"
        />
        <q-toolbar-title>
          PAES - Eje Satelital
        </q-toolbar-title>
        <q-space />
<!--        <widget-notification-component/>-->
        <dropdown-user-component/>
      </q-toolbar>
    </q-header>

    <q-drawer show-if-above
              :mini="miniState"
              :mini-to-overlay="miniState"
              bordered
              :width="200"
              :mini-width="85"
              :breakpoint="500"
    >
      <q-list class="q-mx-md text-grey-6">
        <q-item class="q-mb-lg q-mt-sm">
          <q-item-section
            avatar v-if="miniState"
          >
            <q-avatar >
              <img class="q-my-sm" src="~assets/images/logo/favicon.png" alt=""/>
            </q-avatar>
          </q-item-section>
          <q-item-section  v-else>
            <img class="q-my-sm" src="~assets/images/logo/logo.png"  style="max-width: 150px" alt=""/>
          </q-item-section>
        </q-item>
        <EssentialLink
          v-for="link in essentialLinks"
          :key="link.title"
          v-bind="link"
        />
      </q-list>
    </q-drawer>
    <q-page-container>
      <router-view/>
    </q-page-container>
  </q-layout>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue'
import EssentialLink from 'components/sidebar/EssentialLink.vue'
import { sidebar } from 'src/services/sidebar'
import DropdownUserComponent from 'components/user/DropdownUserComponent.vue'
// import WidgetNotificationComponent from 'components/notifications/WidgetNotificationComponent.vue'

export default defineComponent({
  name: 'MainLayout',

  components: {
    EssentialLink,
    DropdownUserComponent
    // WidgetNotificationComponent
  },

  setup () {
    const miniState = ref(false)

    return {
      essentialLinks: sidebar,
      miniState
    }
  }
})
</script>
