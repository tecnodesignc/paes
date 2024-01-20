<template>
  <q-page class="row items-center justify-evenly">
    <q-card class="my-card" flat bordered v-for="form in forms" :key="form.id"  :style="'color:' + form.color">
    <q-item :to="{name:'form', params:{ id: form.id }}">
        <q-item-section avatar>
          <q-avatar size="100px">
            <q-icon :name="form.icon" font-size="52px"/>
          </q-avatar>
        </q-item-section>
        <q-item-section >
          <q-item-label>{{ form.caption }}</q-item-label>
        </q-item-section>
      </q-item>
    </q-card>
  </q-page>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted } from 'vue'
import { server } from 'boot/axios'
import { useUserStore } from 'stores/user-store'
export default defineComponent({
  name: 'IndexFormPage',
  setup () {
    const forms = ref([])
    const getForms = async () => {
      try {
        await server.get('/dynamicform/v1/forms?companies=' + useUserStore().company.id + '&include=companies&take=20&page=1').then(response => {
          forms.value = response.data.data
        })
      } catch (e) {
        console.log(e)
      }
    }
    onMounted(async () => {
      await getForms()
    })
    return {
      forms
    }
  }
})
</script>
