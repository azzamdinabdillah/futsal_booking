import { Field } from "./field";

export interface Booking {
    id: number;
    booking_code: string;
    field_id: number;
    customer_name: string;
    customer_whatsapp: string;
    customer_email: string;
    play_date: string;
    start_time: string;
    end_time: string;
    duration_hours: string | number;
    price_per_hour_snapshot: string | number;
    total_price: string | number;
    payment_method: string;
    dp_percentage_snapshot: string | number;
    dp_amount: string | number;
    remaining_amount: string | number;
    status: "pending" | "confirmed" | "completed" | "cancelled";
    policy_agreed: boolean;
    admin_note: string | null;
    rating_token: string | null;
    confirmed_at: string | null;
    confirmed_by: number | null;
    completed_at: string | null;
    cancelled_at: string | null;
    cancelled_by: number | null;
    dp_refunded: boolean;
    field?: Field;
    created_at: string;
    updated_at: string;
}
