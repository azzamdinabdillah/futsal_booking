export interface FieldPhoto {
    id: number
    field_id: number
    photo_url: string
    sort_order: number
}

export interface Field {
    id: number
    name: string
    price_per_hour: number
    length_m: number
    width_m: number
    description: string
    status: string
    inactive_reason: string | null
    photos: FieldPhoto[]
}
