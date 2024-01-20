<template>
  <q-page class="row authentication-bg authentication-bg-pattern q-pt-xl">
    <div class="col">
      <div class="row items-center justify-evenly">
        <q-card class="bg-pattern q-pa-lg q-mt-xl" style="max-width: 420px">
          <q-card-section class="q-mx-xl text-center">
            <q-img
              class="q-mb-lg"
              src="~assets/images/logo/logo.png"
              style="max-width: 180px"
            />
            <p class="text-grey-6 text-bold">Ingrese su correo electrónico y contraseña para acceder al panel.</p>
          </q-card-section>
          <q-card-section class="q-pa-lg q-gutter-lg">
            <q-input v-model="email" label="Correo Electrónico" type="email"/>
            <q-input v-model="password" label="Contraseña" type="password"/>
            <q-btn
              color="primary"
              label="Entrar"
              @click="login"
              style="width: 94%"
            />
          </q-card-section>
<!--          <q-card-section class="text-center">
            <p class="text-bold text-grey-8">Inicia sesión con </p>
            <q-btn size="10px" flat round color="blue-10" icon="fab fa-facebook-f" />
            <q-btn size="10px" flat round color="red-8" icon="fab fa-google" />
          </q-card-section>-->
        </q-card>
      </div>
      <div class="row items-center justify-evenly text-center q-mt-lg text-white">
        <div class="col">
          <p><router-link to="/auth/forget-password" class="text-white" style="text-decoration: none;">¿Olvidaste tu contraseña?</router-link></p>
<!--          <p>¿No tienes una cuenta? <router-link to="/auth/register" class="text-white text-bold" style="text-decoration: none;">Inscribirse</router-link></p>
      -->  </div>
      </div>
    </div>
  </q-page>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue'
import { useUserStore } from 'stores/user-store'
import { useQuasar } from 'quasar'
import { useRouter } from 'vue-router'
import { useVehicleStore } from 'stores/Vehicle-store'

const userStore = useUserStore()
const VehicleStore = useVehicleStore()
export default defineComponent({
  name: 'LoginPage',
  components: {},
  setup () {
    const $q = useQuasar()
    const router = useRouter()
    const email = ref('')
    const password = ref('')
    const login = async () => {
      $q.loading.show()
      await userStore.login(email.value, password.value).then(() => {
        router.push('/dashboard')
        $q.loading.hide()
      }).catch(e => {
        $q.notify({
          position: 'top',
          type: 'negative',
          message: e.message
        })
        $q.loading.hide()
      })
    }

    return { email, password, login }
  }
})
</script>

<style>
.authentication-bg {
  background-color: #00acc1;
  background-position: 50%;
  background-size: cover;
}
.authentication-bg-pattern {
  background-image: url("assets/images/bg/bg-pattern.png");
}
.bg-pattern {
  background-image: url("assets/images/bg/bg-pattern-2.png");
  background-size: cover;
}
</style>
