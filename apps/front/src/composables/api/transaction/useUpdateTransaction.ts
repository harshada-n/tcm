import { PUT } from "~/constants/http";
import type { Transaction, TransactionId } from "~/types/TransactionInput";
import useBasicError from "~/composables/useBasicError";

type TransactionInput = Omit<Transaction, "id"> & {
  localization: string;
};
export default function useUpdateTransaction() {
  const { $appFetch } = useNuxtApp();
  const { setError, resetError, errorMessage, violations } = useBasicError();
  return {
    errorMessage,
    violations,
    async updateTransaction(transactionId: TransactionId, transaction: TransactionInput) {
      try {
        resetError();
        const response = await $appFetch<Transaction>("/transactions/" + transactionId, {
          method: PUT,
          body: transaction,
        });
        if (!response) {
          throw createError("Error while updating transaction");
        }
        return response;
      } catch (e: any) {
        setError(e);
        throw e;
      }
    },
  };
}
