<template>

  <div class="row">
    <q-dialog v-model="prompt" persistent>
      <q-card style="min-width: 350px">
        <q-card-section>
          <div class="text-h6">Subir Imagen</div>
        </q-card-section>

        <q-card-section class="q-pt-none">
          <q-uploader
            v-model="image"
            label="Subir Imagen"
            accept=".jpg, image/*"
            :factory="UploadFn"
            auto-upload
            @uploaded="Uploaded"
          />
        </q-card-section>

        <q-card-actions align="right" class="text-primary">
          <q-btn flat label="Cancel" @click="closeModal"/>
        </q-card-actions>
      </q-card>
    </q-dialog>

    <div class="col" v-if="field.type === 0">
      <q-input v-model="value"   @keyup="emite" :label="field.label"/>
    </div>
    <div class="col" v-if="field.type === 1">
      <q-input filled v-model="value" @keyup="emite" type="textarea" :label="field.label"/>
    </div>
    <div class="col" v-if="field.type === 2">
      <q-input filled v-model="value" @keyup="emite" type="number" :label="field.label"/>
    </div>
    <div class="col" v-if="field.type === 3">
      <q-input filled v-model="value"  @keyup="emite" type="tel" :label="field.label"/>
    </div>
    <div class="col" v-if="field.type === 4">
    <q-input filled v-model="value"  @keyup="emite" type="email" :label="field.label"/>
   </div>
    <div class="col" v-else-if="field.type === 5">
      <div class="row">
        <div class="q-mb-md  col-12 col-md-6 col-lg-4">
          <label>{{ field.label }}</label>
        </div>
        <div class="q-mb-md  col-12 col-md-6 col-lg-4">
          <q-btn-toggle
            v-model="value"
            class="toggle-q"
            @click="emite"
            toggle-color="primary"
            :options="[
          {label: 'Si', value: 1, slot: 'one'},
          {label: 'No', value: 0, slot: 'two'},
          {label: 'N/A', value: 2, slot: 'three'}
        ]"
          />
        </div>
        <div class="q-mb-md  col-12 col-lg-4">
          <q-input
            v-model="comment"
            filled
            autogrow
            @keyup="emite"
          />
        </div>
      </div>
    </div>
    <div class="col" v-if="field.type === 6">
      <q-select filled v-model="value"  :options="field.options" label="field.label" />
    </div>
    <div class="col" v-if="field.type === 7">
    <q-select filled v-model="value"  multiple :options="field.options" label="field.label" />
    </div>
    <div class="col" v-if="field.type === 8">
      <label>{{field.label}}</label>
      <q-uploader
        v-model="value"
        label="Subir Imagen"
        accept=".jpg, image/*"
        :factory="UploadFn"
        auto-upload
        @uploaded="UploadedField"
      />
    </div>
    <div class="col" v-else-if="field.type === 9">
      <label>{{field.label}}</label>
     <vue3-signature ref="signature" :w="'350px'" :h="'250px'" :disabled="state.disabled" style="border: dotted 1px #cccc"/>
      <q-btn class="q-ma-md" color="secondary" label="Guardar" @click="save('image/jpeg')"></q-btn>
      <q-btn class="q-ma-md" color="red" label="limpiar" @click="clear"></q-btn>
    </div>

  </div>
</template>

<script lang="ts">
import {
  defineComponent, reactive, ref
} from 'vue'

import { useUserStore } from 'stores/user-store'
import Vue3Signature from 'vue3-signature'
import { useQuasar } from 'quasar'
import { server } from 'boot/axios'
export default defineComponent({
  name: 'FieldsComponent',
  components: { Vue3Signature },
  props: {
    field: {
      type: Object,
      required: true
    }
  },
  emits: ['updateAnswer'],
  setup (props, ctx) {
    const $q = useQuasar()
    const value = ref()
    const comment = ref()
    const image = ref()
    const prompt = ref(false)
    const state = reactive({
      count: 0,
      option: {
        penColor: "rgb(0, 0, 0)",
        backgroundColor: "rgb(255,255,255)"
      },
      disabled: false
    })
    const signature = ref(null)
    const save = async (t) => {
      const signatureData = signature.value.save(t)
      const signatureFile = dataURLtoFile(signatureData, 'signature.png' + props.field.label)
      const formData = new FormData()
      formData.append('file', signatureFile)
      await server.post('/dynamicform/v1/formresponses/upload-image', formData, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      }).then(response => {
        $q.notify({
          position: 'top',
          type: 'positive',
          message: 'Firma Guardada correctamente'
        })
        value.value = response.data.data.url
        emite()
      })
    }
    const undo = () => {
      signature.value.undo()
    }
    const clear = () => {
      signature.value.clear()
    }
    const UploadFn = (file) => {
      return new Promise((resolve, reject) => {
        // Retrieve JWT token from your store.
        const token = useUserStore().token
        const csrfToken = useUserStore().csrfToken
        resolve({
          url: 'https://paes-v2.ejesatelital.com/api/dynamicform/v1/formresponses/upload-image',
          method: 'POST',
          headers: [
            { name: 'Authorization', value: `Bearer ${token}` },
            { name: 'X-CSRF-TOKEN', value: `${csrfToken}` }
          ],
          fieldName: 'file'
        })
      })
    }

    const Uploaded = (info) => {
      const upload = JSON.parse(info.xhr.response)
      image.value = upload.data.url
      emite()
      closeModal()
    }
    const UploadedField = (info) => {
      const upload = JSON.parse(info.xhr.response)
      value.value = upload.data.url
      emite()
    }
    const closeModal = () => {
      console.log(value.value, props.field.type, image.value)
      if (props.field.type === 5 && value.value === 0 && image.value === undefined) {
        value.value = null
      }
      prompt.value = false
    }
    const emite = () => {
      if (props.field.type === 5 && value.value === 0 && !image.value) {
        prompt.value = true
      } else {
        ctx.emit('updateAnswer', { fiel_id: props.field.id, label: props.field.label, type: props.field.type, value: value.value, comment: comment.value, image: image.value })
      }
    }
    return {
      value,
      comment,
      prompt,
      image,
      signature,
      state,
      emite,
      UploadFn,
      Uploaded,
      UploadedField,
      closeModal,
      save,
      clear
    }
  }
})
function dataURLtoFile (dataurl, filename) {
  var arr = dataurl.split(','),
    mime = arr[0].match(/:(.*?);/)[1],
    bstr = atob(arr[arr.length - 1]),
    n = bstr.length,
    u8arr = new Uint8Array(n)
  while (n--) {
    u8arr[n] = bstr.charCodeAt(n)
  }
  return new File([u8arr], filename, { type: mime })
}
</script>
<style lang="sass" scoped>
.toggle-q
  border: 1px solid #027be3
</style>
