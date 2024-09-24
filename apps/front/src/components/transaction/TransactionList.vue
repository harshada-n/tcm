<template>
  <div>
    
    <table>
      <thead>
        <tr>
          <th>{{ $t("components.transaction.list.transactionDate") }}</th>
          <th>{{ $t("components.transaction.list.amount") }}</th>
          <th>{{ $t("components.transaction.list.paymentLabel") }}</th>
          <th>{{ $t("components.transaction.list.localization") }}</th>
          <th>{{ $t("components.transaction.list.actions") }}</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="transaction in transactions" :key="transaction.id">
          <td>{{ transaction.transaction_date }}</td>
          <td>{{ transaction.amount }}</td>
          <td>{{ transaction.payment_label }}</td>
          <td>{{ transaction.localization }}</td>
          <td v-if="transaction.localization"></td>              
          <td v-else>
            <Button @click="setData(transaction.id)"  severity="secondary">{{
                $t("components.transaction.list.identity")
              }}</Button>
          </td>
        </tr>
      </tbody>
    </table>
    <Dialog :visible="visible" modal header="Select Location" :style="{ width: '25rem' }" :closable="false">
      <form @submit.prevent.stop="submit">
        <div class="flex items-center gap-4 mb-4" v-for="location in locations" :key="location">
            <input 
            v-model="localization"
            id="{{key}}"
            :value="location"
            type="radio"/>
            <label>{{location}}</label>
        </div>
        <slot name="buttons" :is-valid="isValid">
            <Button
              type="button"
              severity="danger"
              class="mr-2 mb-2"
              @click="visible = false"
            >
              {{ $t("components.user.form.buttonCancel") }}
            </Button>
            <Button type="submit" :disabled="!isValid" class="mr-2 mb-2">
              {{ $t("components.user.form.ok") }}
            </Button>
          </slot>
      </form>
    </Dialog>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import type { TransactionInput } from "~/types/TransactionInput";
import useListtransactions from "~/composables/api/transaction/useListtransactions";
import useListLocations from "~/composables/api/transaction/useListLocations";
import useUpdateTransaction from "~/composables/api/transaction/useUpdateTransaction";

const visible = ref(false);
const transactionId = ref(null);
const localization = ref(null);
const locations = useListLocations();
const { violations, updateTransaction: updateTransactionApi } = useUpdateTransaction();



const isValid = localization ? true : false;
const {
  data: transactions,
  refresh: transactionsRefresh,
  error,
} = await useListtransactions();

function setData(id) {
  transactionId.value = id;
  visible.value = true;
}

const submit = async (TransactionInput) => {
  try {
    await updateTransactionApi({ id: transactionId.value, localization: localization.value });
    transactionsRefresh();
    visible.value = false;
  } catch (e) {
    logger.info(e);
  }
};

</script>

<style scoped lang="scss"></style>