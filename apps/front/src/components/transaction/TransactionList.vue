<template>
  <div>
    <div v-show="error">{{ error }}}</div>
    {{ errorDelete }}
    <table>
      <thead>
        <tr>
          <th>{{ $t("components.transaction.list.title") }}</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="transaction in transactions" :key="transaction.id">
          <td>{{ transaction.transaction_date }}</td>
          <td>{{ transaction.amount }}</td>
          <td>{{ transaction.payment_label }}</td>
          <td>{{ transaction.localization }}</td>
          <td>
            <NuxtLink
              v-if="!authStore.isAuthUser(transaction)"
              :to="`/transactions/${transaction.id}`"
            >
              <Button @click="isOpen = true"  severity="secondary">{{
                $t("components.transaction.list.identity")
              }}</Button>
            </NuxtLink>
          </td>
        </tr>
      </tbody>
    </table>
    <UModal v-model="isOpen">
      <div class="p-4">
        <Placeholder class="h-48" />
      </div>
    </UModal>
  </div>
</template>

<script setup lang="ts">
import type { Transaction } from "~/types/Transaction";
import useAuthUser from "~/store/auth";
import useListtransactions from "~/composables/api/transaction/useListtransactions";

const authStore = useAuthUser();
const isOpen = ref(false);

const {
  data: transactions,
  error,
  pending: transactionsPending,
  refresh: transactionsRefresh,
} = await useListtransactions();
</script>

<style scoped lang="scss"></style>
