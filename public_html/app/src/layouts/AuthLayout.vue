<template>
  <q-layout view="lhr lpr lfr">

    <q-page-container>
      <router-view />
    </q-page-container>
    <q-footer class="text-center text-white authentication-bg">
      <div class="row q-mt-lg">
        <div class="col">
          <p> {{date}} Eje Satelital © Todos los derechos Reservados
          </p>
        </div>
      </div>
    </q-footer>
  </q-layout>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue'

export default defineComponent({
  name: 'AuthLayout',
  setup () {
    const date = ref(new Date().getFullYear())
    return { date }
  }
})
</script>
