import { token } from './token'

export function getSeries(producto) {
    return fetch(`/api/v1/productos/${producto}/series`, {
        headers: {
            'Content-Type': 'application/json',
            'token-alumplastic': token
        }
    }).then(response => response.json()).then(response => {
        return response
    }).catch(error => {
        throw error
    })
}