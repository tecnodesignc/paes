<template>
  <q-expansion-item
    :icon="icon"
    size="xs"
    :label="title"
    v-if="items && hasAccess(authorize) "
  >
    <template v-slot:header>
      <q-item-section
        v-if="icon"
        avatar
      >
        <q-icon :name="icon" size="xs" />
      </q-item-section>

      <q-item-section>
        <q-item-label>{{ title }}</q-item-label>
      </q-item-section>
    </template>
    <SubItem class="q-ml-xl q-pl-lg"  v-for="link in items"
              :key="link.title"
              v-bind="link" />
  </q-expansion-item>
  <q-item v-else-if="hasAccess(authorize)"
    clickable
    :to="{name:link}"
  >
    <q-item-section
      v-if="icon"
      avatar
    >
      <q-icon :name="icon" size="xs" />
    </q-item-section>

    <q-item-section>
      <q-item-label>{{ title }}</q-item-label>
    </q-item-section>
  </q-item>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import SubItem from 'components/sidebar/SubItem.vue'
import { hasAccess } from 'boot/hasAccess'

export default defineComponent({
  name: 'EssentialLink',
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
    icon: {
      type: String,
      default: ''
    },
    authorize: {
      type: String,
      default: ''
    },
    items: {
      type: []
    }
  },
  components: {
    SubItem
  }
})
</script>
<style lang="scss">
.q-item__section--avatar {
  min-width: 40px;
}
body.desktop .q-focusable:focus > .q-focus-helper, body.desktop .q-manual-focusable--focused > .q-focus-helper, body.desktop .q-hoverable:hover > .q-focus-helper {
  background: $primary ;
}
body.desktop .q-hoverable:hover > .q-item__section {

  .q-icon{
    color: $primary !important;
  }
  .q-item__label{
    color: $primary !important;
  }
}
</style>
