import { useState, useEffect } from "react"
import { getSerieProducto } from "../servicios/getSerieProducto"

const useSerieProducto = (producto, serie) => {
    const [buscando, setBuscando] = useState(false)
    const [productoSerie, setProductoSerie] = useState({})

    function rellenarProductoSerie() {
        setBuscando(true)
        getSerieProducto(producto, serie).then(productoSerieConcreto => {
            setProductoSerie(productoSerieConcreto)
            setBuscando(false)
        })
    }

    useEffect(rellenarProductoSerie, [producto, serie])
    return {buscando, productoSerie}
}
export default useSerieProducto