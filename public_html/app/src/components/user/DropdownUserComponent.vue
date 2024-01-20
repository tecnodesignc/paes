<template>
  <q-btn-dropdown stretch flat>
    <template v-slot:label>
      <q-item clickable v-ripple>
        <q-item-section avatar>
          <q-avatar color="white">
            <q-img :src="user.avatar"/>
          </q-avatar>
        </q-item-section>
        <q-item-section class="text-bold">{{ user.name }}</q-item-section>
      </q-item>
    </template>
    <q-list>
      <q-item clickable v-close-popup :to="{name:'account'}">
        <q-item-section avatar>
          <q-icon name="person" size="xs"/>
        </q-item-section>
        <q-item-section>
          <q-item-label>Cuenta</q-item-label>
        </q-item-section>
      </q-item>
      <q-item clickable v-close-popup :to="{name:'settings'}">
        <q-item-section avatar>
          <q-icon name="settings" size="xs"/>
        </q-item-section>
        <q-item-section>
          <q-item-label>Configuración</q-item-label>
        </q-item-section>
      </q-item>
      <q-item clickable v-close-popup :to="{name:'lock-screen', query:$router.to}">
        <q-item-section avatar>
          <q-icon name="lock" size="xs"/>
        </q-item-section>
        <q-item-section>
          <q-item-label>Bloquear Pantalla</q-item-label>
        </q-item-section>
      </q-item>
      <q-separator inset spaced/>
      <q-item clickable v-close-popup @click="logout">
        <q-item-section avatar>
          <q-icon name="person" size="xs"/>
        </q-item-section>
        <q-item-section>
          <q-item-label>Cerrar Sesión</q-item-label>
        </q-item-section>
      </q-item>
    </q-list>
  </q-btn-dropdown>

</template>

<script lang="ts">
import { defineComponent, ref } from 'vue'
import { useUserStore } from 'stores/user-store'
import { useQuasar } from 'quasar'
import { useRouter } from 'vue-router'

export default defineComponent({
  name: 'DropdownUserComponent',

  setup () {
    const $q = useQuasar()
    const router = useRouter()
    const userStore = useUserStore()
    const user = {
      avatar: userStore.getAvatar,
      name: userStore.firstName
    }
    const logout = async () => {
      $q.dialog({
        title: 'Cerrar Sesión',
        message: 'Esta seguro que desea cerrar Sesión?',
        cancel: true,
        persistent: true
      }).onOk(() => {
        $q.loading.show()
        userStore.logout().then(() => {
          $q.loading.hide()
          router.push({ name: 'login' })
        }).catch(e => {
          $q.notify({
            position: 'top',
            type: 'negative',
            message: e.message
          })
          $q.loading.hide()
        })
      })
    }
    return {
      user,
      logout
    }
  }
})
</script>
