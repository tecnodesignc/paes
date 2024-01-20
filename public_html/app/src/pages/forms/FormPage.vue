<template>
  <q-page class="row items-center justify-evenly q-ma-xl">
    <q-card class="col-12  q-mb-md">
      <h2 class="text-h4 text-center text-primary font-size-10 text-bold">{{form.caption}} - <span class="text-italic">{{company}}</span> </h2>
    </q-card>
    <q-card class="col-12 q-pa-lg">
      <q-card-section class="row">
        <div class="col col-md-6 q-pr-xs">
          <q-input
            filled
            v-model="fullName"
            label="Nombre Completo"
            hint="Name and surname"
            lazy-rules
            :rules="[ val => val && val.length > 0 || 'Please type something']"
          />
        </div>
        <div class="col col-md-6 q-pl-xs">
          <q-input
            filled
            v-model="identification"
            label="Identificación"
            lazy-rules
            :rules="[ val => val && val.length > 0 || 'Please type something']"
          />
        </div>
      </q-card-section>
      <q-card-section  class="row">
        <div class="col col-md-6 q-pr-xs">
          <q-select
            filled
            label="Vehiculo"
            v-model="plate"
            use-input
            stack-label
            hide-selected
            fill-input
            input-debounce="0"
            :options="vehicles"
            @filter="filterVehicleFn"
          >
            <template v-slot:no-option>
              <q-item>
                <q-item-section class="text-grey">
                  No results
                </q-item-section>
              </q-item>
            </template>
          </q-select>
        </div>
        <div class="col col-md-6 q-pr-ls">
          <q-input
            filled
            v-model="millage"
            label="Kilometraje"
            lazy-rules
            :rules="[ val => val && val.length > 0 || 'Por favor complete este campo']"
          />
        </div>
      </q-card-section>
    </q-card>
    <q-card class="col-12 q-pa-lg q-mt-md">
      <h4 class="text-h6">Preguntas </h4>
      <q-separator/>
      <q-card-section class="row">
        <fields-component v-for="question in questions"
                          :field="question"
                          :key="question.id"
                          class="col-12 q-mt-md"
                          @update-answer="setAnswer"/>
      </q-card-section>
    </q-card>
    <q-card class="col-12 q-mt-md">
      <q-card-section class="row">
        <div class="col-8">
          <q-btn label="Guardar" class="q-ma-md" @click="sendForm" color="green-10"/></div>
        <q-btn class="q-ma-md" color="red" label="Cancelar" @click="cancel"/>
      </q-card-section>
    </q-card>
  </q-page>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted } from 'vue'
import { useUserStore } from 'stores/user-store'
import { server } from 'boot/axios'
import { useRoute, useRouter } from 'vue-router'
import FieldsComponent from 'components/form/FieldsComponent.vue'
import { useQuasar } from 'quasar'
export default defineComponent({
  name: 'IndexPage',
  components: { FieldsComponent },
  setup: function () {
    const $q = useQuasar()
    const vehiclesOptions = ref([
      { value: 1, label: 'FPK669', millage: 23500 },
      { value: 2, label: 'FPK989', millage: 28500 }
    ])
    const userStore = useUserStore()
    const route = useRoute()
    const router = useRouter()
    const company = userStore.company.name
    const fullName = userStore.fullName
    const identification = userStore.identification
    const plate = ref()
    const millage = ref()
    const questions = ref([])
    const answers = ref([])
    const form = ref({ caption: '' })
    const vehicles = ref(vehiclesOptions)

    const getForm = async () => {
      try {
        await server.get('/dynamicform/v1/forms/' + route.params.id + '?include=companies').then(response => {
          form.value = response.data.data
          getQuestions()
        })
      } catch (e) {
        console.log(e)
      }
    }
    const getQuestions = async () => {
      try {
        await server.get('/dynamicform/v1/forms/' + route.params.id + '/fields?include=form&limit=100&page=1').then(response => {
          questions.value = response.data.data
        })
      } catch (e) {
        console.log(e)
      }
    }
    onMounted(async () => {
      await $q.loading.show()
      await getForm()
      await $q.loading.hide()
    })
    const setAnswer = (data) => {
      const index = findIndexByProperty(answers.value, 'fiel_id', data.fiel_id)

      if (index > -1) {
        console.log(data)
        answers.value[index] = data
      } else {
        answers.value.push(data)
      }
    }
    const filterVehicleFn = (val: any, update: any, abort: any) => {
      update(() => {
        const needle = val.toLowerCase()
        vehicles.value = vehiclesOptions.value.filter((v) => {
          return v.label.toLowerCase().indexOf(needle) > -1
        })
      })
    }

    const sendForm = async () => {
      $q.loading.show()
      try {
        const params = {
          company_id: userStore.company.id,
          form_id: form.value.id,
          user_id: userStore.id,
          data: {
            info: {
              fullName: userStore.fullName,
              identification: userStore.identification,
              vehicle: plate.value,
              millaje: millage.value
            },
            answers: answers.value
          }
        }
        await server.post('/dynamicform/v1/formresponses/', params).then(response => {
          $q.notify({
            position: 'top',
            type: 'positive',
            message: 'Información envidada correctamente'
          })
          router.push({ name: 'forms' })
        })
      } catch (e) {
        console.log(e)
        $q.notify({
          position: 'top',
          type: 'negative',
          message: 'Error al Enviar los datos'
        })
      }
      $q.loading.hide()
    }
    const findIndexByProperty = (data, key, value) => {
      for (var i = 0; i < data.length; i++) {
        if (data[i][key] === value) {
          return i
        }
      }
      return -1
    }

    const cancel = () => {
      router.push({ name: 'forms' })
    }
    return {
      fullName,
      identification,
      plate,
      millage,
      questions,
      answers,
      form,
      vehicles,
      company,
      filterVehicleFn,
      setAnswer,
      sendForm,
      cancel
    }
  }
})
</script>
