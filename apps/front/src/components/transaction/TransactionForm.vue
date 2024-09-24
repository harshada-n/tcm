<template>
<Dialog v-model:visible="visible" modal header="Select Location" :style="{ width: '25rem' }">
  <div class="grid">
    <div class="col-12">
      <form @submit.prevent.stop="submit">
        <div class="field col-12">
          <div v-for="location in locations" :key="location">
            <input v-model="localization"
            input-id="localization"
            :class="{
              'p-invalid': violations.localization,
            }" 
            type="radio"/>{{ location }}
          </div>          
          <small class="p-error">
            {{ violations.localization }}
          </small>
        </div>
        <div>
          <slot name="buttons" :is-valid="isValid" :cancel="cancel">
            <Button
              type="button"
              severity="danger"
              class="mr-2 mb-2"
              @click="cancel"
            >
              {{ $t("components.user.form.buttonCancel") }}
            </Button>
            <Button type="submit" :disabled="!isValid" class="mr-2 mb-2">
              {{ $t("components.user.form.ok") }}
            </Button>
          </slot>
        </div>
      </form>
    </div>
  </div>
  </Dialog>
</template>
<script setup lang="ts">
import { Transaction } from "~/types/Transaction";
import useListLocations from "~/composables/api/transaction/useListLocations";
import defaultVue from "../../layouts/default.vue";

interface State extends Omit<Transaction, "id"> {}
interface Props {
  defaultValue?: State;
}
const props = withDefaults(defineProps<Props>(), {
  defaultValue() {
    return {
      email: "",
    };
  },
  violations() {
    return {};
  },
});
const state = reactive({ ...props.defaultValue });
const localization = ref("");
const locations = useListLocations();
const results = locations.filter(object => Object.values(object).some(i => i.includes(defaultValue)));

const isValid = localization.value ? true : false;

interface EventEmitter {
  (
    e: "submit",
    value: Omit<Transaction, "id"> & {
      localization: string;
    },
  ): void;
  (e: "cancel"): void;
}

const emits = defineEmits<EventEmitter>();
const submit = () => {
  emits("submit", { ...state, localization: localization.value });
};
const cancel = () => {
  emits("cancel");
};
</script>

<style scoped lang="scss"></style>
