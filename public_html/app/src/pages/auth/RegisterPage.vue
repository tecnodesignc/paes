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
            <p class="text-grey-6 text-bold">¿No tienes una cuenta? Crea tu cuenta, te llevará menos de un minuto.</p>
          </q-card-section>
          <q-card-section class="q-pa-lg q-gutter-lg">
            <q-input v-model="firstName" label="Nombre" type="text"/>
            <q-input v-model="lastName" label="Apellido" type="text"/>
            <q-input v-model="email" label="Correo Electrónico" type="email"/>
            <q-input v-model="password" label="Contraseña" type="password"/>
            <q-input v-model="passwordConfirmation" label="Confirmar Contraseña" type="password"/>
            <q-checkbox v-model="terms" label="Acepto los términos y condiciones" class="text-grey-7" :true-value="true"/>
            <q-btn
              color="primary"
              label="Registrarse"
              style="width: 94%"
            />
          </q-card-section>
          <q-card-section class="text-center">
            <p class="text-bold text-grey-8">Regístrese usando </p>
            <q-btn size="10px" flat round color="blue-10" icon="fab fa-facebook-f"/>
            <q-btn size="10px" flat round color="red-8" icon="fab fa-google"/>
          </q-card-section>
        </q-card>
      </div>
      <div class="row items-center justify-evenly text-center q-mt-lg text-white">
        <div class="col">
          <p>¿Ya tienes cuenta?  <router-link to="/auth/login" class="text-white text-bold" style="text-decoration: none;">Iniciar sesión</router-link></p>
        </div>
      </div>
    </div>
  </q-page>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue'
import { useUserStore } from 'stores/user-store'
const userStore = useUserStore()
export default defineComponent({
  name: 'LoginPage',
  components: {},
  setup () {
    const firstName = ref('')
    const lastName = ref('')
    const email = ref('')
    const password = ref('')
    const passwordConfirmation = ref('')
    const terms = ref(false)
    const register = async () => {
      const data = {
        email: email.value,
        password: password.value,
        password_confirmation: passwordConfirmation.value,
        first_name: firstName.value,
        last_name: lastName.value
      }
      await userStore.register(data)
    }
    return { firstName, lastName, email, password, passwordConfirmation, terms, register }
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
