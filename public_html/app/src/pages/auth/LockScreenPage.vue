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
            <q-avatar size="88px" >
              <q-img
                class="q-mb-lg"
                src="https://www.tecnodesign.com.co/assets/media/oav90h1.png"
              />
            </q-avatar>
            <h6 class="text-h6 q-my-sm text-bold">Hola! Marcos</h6>
            <p class="text-grey-6 text-weight-bold">Ingrese su contraseña para acceder al administrador.</p>
          </q-card-section>
          <q-card-section class="q-pa-lg q-gutter-lg">
            <q-input v-model="password" label="Contraseña" type="password"/>
            <q-btn
              color="primary"
              label="Entrar"
              style="width: 94%"
            />
          </q-card-section>
        </q-card>
      </div>
      <div class="row items-center justify-evenly text-center q-mt-lg text-white">
        <div class="col">
          <p>¿No tú? volver a <router-link to="/auth/login" class="text-white text-bold" style="text-decoration: none;">Iniciar sesión</router-link></p>
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
    const password = ref('')
    return { password }
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
