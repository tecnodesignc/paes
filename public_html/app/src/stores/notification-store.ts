import { defineStore } from 'pinia'
import { server } from 'src/boot/axios'
import { Notification } from '../types/interfases'

export const useNotificationStore = defineStore('notifications', {
  state: () => ({
    notifications: []
  }),
  getters: {
    getNotifications: (state) => state.notifications
  },
  actions: {
    async loadNotifications () {
      try {
        await server.get('/notification').then(response => {
          const notifications = response.data
          console.log(notifications, 'actions')
          this.setNotifications(notifications)
        })
      } catch (e) {
        if (e) {
          throw e
        }
      }
    },
    async addToNotification (notification: never) {
      const notifications = this.getNotifications
      notifications.push(notification)
      this.setNotifications(notifications)
    },
    async makeRead (id: any) {
      try {
        await server.post('notification/mark-read', { id: id }).then((response) => {
          const notifications = this.getNotifications
          // eslint-disable-next-line array-callback-return
          notifications.map((item: Notification) => {
            if (item.id === id) {
              item.is_read = true
            }
            return item
          })
        })
      } catch (e) {
        if (e) throw e
      }
    },
    setNotifications (payload: any) {
      console.log(payload, 'payload')
      if (payload.data) this.notifications = payload.data
    },
    clearNotifications () {
      this.notifications = []
    }

  },
  persist: true
})
