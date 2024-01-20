<template>
        <q-item v-if="hasAccess(authorize)"
                clickable
                :to="{name:link}"
                :dense="true"
        >
          <q-item-section>
            <q-item-label>{{title }}</q-item-label>
          </q-item-section>
        </q-item>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import { hasAccess } from 'boot/hasAccess'
export default defineComponent({
  name: 'SubItem',
  methods: { hasAccess },
  props: {
    title: {
      type: String,
      required: true
    },
    link: {
      type: String,
      default: '#'
    },
    authorize: {
      type: String,
      default: ''
    }
  }
})
</script>
