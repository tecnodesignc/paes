import { boot } from 'quasar/wrappers'
import { useUserStore } from 'stores/user-store'

const hasAccess = (permission: string) => {
  const userStore = useUserStore()
  if (!permission) return true
  return Object.hasOwn(userStore.permissions, permission)
}

export default boot(({ app }) => {
  app.config.globalProperties.$hasAccess = hasAccess
})

export { hasAccess }
