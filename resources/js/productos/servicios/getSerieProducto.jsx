import { token } from './token'

export function getSerieProducto(producto, serie) {
    return fetch(`/api/v1/productos/${producto}/series/${serie}`, {
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