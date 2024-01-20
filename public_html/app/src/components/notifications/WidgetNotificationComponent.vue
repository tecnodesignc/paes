<template>
  <q-btn-dropdown stretch flat dropdown-icon="notifications_active" transition-hide="true">
    <q-list>
      <q-item-label header class="text-h6 ">Notificaciones</q-item-label>
      <q-scroll-area style="height: 180px; width: 360px;">
        <q-item v-for="notification in notifications" :key="notification.id" clickable tabindex="0">
          <q-item-section avatar>
          </q-item-section>
          <q-item-section>
            <q-item-label>{{ notification.title }}</q-item-label>
            <q-item-label lines="1" caption>{{ notification.message }}</q-item-label>
          </q-item-section>
          <q-item-section side top clikeable @click="makeRead(notification.id)">
            <q-icon name="close" size="xs"/>
          </q-item-section>
        </q-item>
      </q-scroll-area>
      <q-separator inset/>
      <q-item :to="{name:'notification'}" class="text-center" clickable>
        <q-item-section>
          <q-item-label>
            Ver Todas
          </q-item-label>
        </q-item-section>
      </q-item>
    </q-list>
  </q-btn-dropdown>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted } from 'vue'
import { useNotificationStore } from 'stores/notification-store'
import { useQuasar } from 'quasar'
import { echo } from 'src/boot/echo'
import { useUserStore } from 'stores/user-store'
import { Notification } from 'src/types/interfases'
import { useRouter } from 'vue-router'

export default defineComponent({
  name: 'WidgetNotificationComponent',

  setup: function () {
    const $q = useQuasar()
    const router = useRouter()
    const notificationStore = useNotificationStore()
    const notifications = ref()
    const toolbar = ref(false)
    const notificationConfig = ref(false)
    const lengthNotification = ref('0')
    onMounted(async () => {
      await notificationStore.loadNotifications()
      getNotification()
      echo.channel('encorecms.notifications.' + useUserStore().id)
        .listen('Modules\\Notification\\Events\\BroadcastNotification', (response: never) => {
          console.log(response)
        })
    })
    const getNotification = async () => {
      notifications.value = notificationStore.getNotifications
      const noRead = notifications.value.filter((item: Notification) => {
        return !item.is_read
      })
      if (noRead.length > 9) {
        lengthNotification.value = 9 + '+'
      } else {
        lengthNotification.value = noRead.length
      }
    }
    const makeRead = async (notification: Notification) => {
      $q.loading.show()
      notificationStore.makeRead(notification.id).then(() => {
        $q.loading.hide()
      }).catch(e => {
        $q.notify({
          position: 'top',
          type: 'negative',
          message: e.message
        })
        $q.loading.hide()
      })
      router.push({ name: notification.link })
      $q.loading.hide()
    }
    return {
      notifications,
      makeRead,
      lengthNotification
    }
  }
})
</script>
