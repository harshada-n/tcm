<template>
  <h1 v-t="{ path: 'components.transaction.updateForm.title', args: data }"></h1>
  <TransactionForm
    :default-value="data"
    :violations="violations"
    :transaction_selected="transaction_selected"
    @submit="submit"
    @cancel="navigateToList"
  >
  </TransactionForm>
  {{ error }}
</template>

<script setup lang="ts">
import useUpdateTransaction from "~/composables/api/transaction/useUpdateTransaction";
import type { TransactionInput } from "~/types/TransactionInput";
import TransactionForm from "~/components/transaction/TransactionForm";

interface Props {
  transaction_selected: integer;
}

const props = defineProps<Props>();

const { violations, updateTransaction: updateTransactionApi } = useUpdateTransaction();

const submit = async (value: TransactionInput) => {
  // If you need to copy the value, create a clone so it does not track reactivity
  //data.value = {...data.value, ...value};
  await updateTransactionApi(props.transaction_selected, value);
  return navigateTo("/transactions/");
};
const navigateToList = () => {
  return navigateTo("/transactions/");
};
</script>
<style scoped lang="scss"></style>
