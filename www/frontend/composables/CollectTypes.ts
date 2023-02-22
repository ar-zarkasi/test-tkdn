export interface detailResource {
    id: string
    name: string
    email: string
    gender: string | null
    married: string | null
    address?: string | null
    created_at: string
    updated_at: string
}

type responseType = 'success' | 'error'

interface responseStatus {
    code: number,
    response: responseType
    message: string
}

export interface responseServer {
    status: responseStatus
    result: Array<any> | Array<detailResource> | detailResource
}

export type methodhttp = 'get' | 'post' | 'put' | 'delete'
export type statusalert = 'success' | 'info' | 'warning' | 'error' | 'primary'

export interface notification {
    id: string | number
    tipe: statusalert
    message: string | undefined
}