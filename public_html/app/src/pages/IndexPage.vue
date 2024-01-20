<template>
  <q-page class="row items-center justify-evenly">
    <q-card class="bg-green-10 q-dark">
      <q-item :to="{name: 'forms'}">
        <q-card-section >
          <h2>Preopretativos</h2>
          <div class="q-my-sm">Lorem, ipsum dolor sit amet consectetur adipisicing elit.</div>
        </q-card-section>
      </q-item>
    </q-card>
  </q-page>
</template>

<script lang="ts">
import { defineComponent, ref } from 'vue'
export default defineComponent({
  name: 'IndexPage',
  components: {},
  setup () {
    return { }
  }
})
</script>
