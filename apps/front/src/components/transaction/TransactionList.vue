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
<div v-show="isOpen">{{locations}}</div>
   
  </div>
</template>

<script setup lang="ts">
import type { TransactionInput } from "~/types/TransactionInput";
import useAuthUser from "~/store/auth";
import useListtransactions from "~/composables/api/transaction/useListtransactions";
import useListLocations from "~/composables/api/transaction/useListLocations";

const authStore = useAuthUser();
const isOpen = false;
const location_selected = null;
const transaction_selected = null;
const { updateTransaction } = useListtransactions();

const {
  data: transactions,
  error,
  pending: transactionsPending,
  refresh: transactionsRefresh,
} = await useListtransactions();

const locations = useListLocations();

function setData(id) {
  this.isOpen = !isOpen;
  this.transaction_selected = id;
}

const submit = async (state: TransactionInput) => {
  try {
    await updateTransaction(transaction_selected, state);
    await navigateTo("/transactions");
  } catch (e) {
    logger.info(e);
  }
};
</script>

<style scoped lang="scss"></style>