<template>
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
</template>
<script setup lang="ts">
import type { Transaction } from "~/types/Transaction";

interface State extends Omit<Transaction, "id"> {}
interface Props {
  defaultValue?: State;
  violations?: {
    [K in keyof State]?: string;
  } & {
    password?: string;
  };
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

const isPasswordEmpty = computed(() => !localization.value);
const isValid = isPasswordEmpty;

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
