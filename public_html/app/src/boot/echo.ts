import Echo from 'laravel-echo'
import { boot } from 'quasar/wrappers'
import Pusher from 'pusher-js'

declare global {
  interface Window {
    Pusher: typeof Pusher
  }
}

window.Pusher = Pusher
const echo = new Echo({
  broadcaster: 'pusher',
  key: 'bbc441f6694ca34519eb',
  cluster: 'us2',
  forceTLS: true
})

export default boot(({ app }) => {
  app.config.globalProperties.$echo = echo
})

export { echo }
