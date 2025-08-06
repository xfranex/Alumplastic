import { token } from './token'

export function getProductos(id) {
    return fetch(`/api/v1/carpinterias/${id}/productos`, {
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