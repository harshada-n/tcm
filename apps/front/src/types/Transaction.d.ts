import { DateTimeFormat } from "~~/node_modules/@intlify/core-base/dist/core-base";

export type TransactionId = string;
export interface Transaction {
  payment_label: string;
  transaction_date: DateTimeFormat;
  localization: string;
  longitude: string;
  latitude: string;
  user_id: BigInteger;
  amount: string;
}
