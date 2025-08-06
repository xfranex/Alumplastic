import { useState, useEffect } from "react"
import { getCarpinterias } from "../servicios/getCarpinterias"

const useCarpinterias = () => {
    const [buscando, setBuscando] = useState(false)
    const [carpinterias, setCarpinterias] = useState([])

    function rellenarCarpinterias() {
        setBuscando(true)
        getCarpinterias().then(carpinterias => {
            setCarpinterias(carpinterias)
            setBuscando(false)
        })
    }

    useEffect(rellenarCarpinterias, [])
    return {buscando, carpinterias}
}
export default useCarpinterias