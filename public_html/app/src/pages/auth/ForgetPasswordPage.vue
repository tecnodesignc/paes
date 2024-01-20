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
            <p class="text-grey-6 text-bold">Ingrese su  correo electrónico y le enviaremos un correo electrónico con instrucciones para restablecer su contraseña.</p>
          </q-card-section>
          <q-card-section class="q-pa-lg q-gutter-lg">
            <q-input v-model="email" label="Correo Electrónico" type="email"/>
            <q-btn
              color="primary"
              label="Reiniciar Contraseña"
              style="width: 94%"
            />
          </q-card-section>
        </q-card>
      </div>
      <div class="row items-center justify-evenly text-center q-mt-lg text-white">
        <div class="col">
          <p>Volver a <router-link to="/auth/login" class="text-white text-bold" style="text-decoration: none;">Iniciar sesión</router-link></p>
        </div>
      </div>
    </div>
  </q-page>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue'

export default defineComponent({
  name: 'LoginPage',
  components: {},
  setup () {
    const email = ref('')
    return { email }
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
