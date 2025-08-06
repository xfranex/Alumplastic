import { token } from './token'

export function getCarpinterias() {
    return fetch(`/api/v1/carpinterias`, {
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