import { useState, useEffect } from "react"
import { getProductos } from "../servicios/getProductos"

const useProductos = (carpinteria) => {
    const [buscando, setBuscando] = useState(false)
    const [productos, setProductos] = useState([])

    function rellenarProductos() {
        setBuscando(true)
        getProductos(carpinteria).then(productos => {
            setProductos(productos)
            setBuscando(false)
        })
    }

    useEffect(rellenarProductos, [carpinteria])
    return {buscando, productos}
}
export default useProductos