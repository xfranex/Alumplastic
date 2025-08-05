import { useState, useEffect } from "react";
import { getProductos } from "../servicios/getProductos";

const useProductos = (id) => {
    const [buscando, setBuscando] = useState(false)
    const [productos, setProductos] = useState([])

    function rellenarProductos() {
        setBuscando(true)
        getProductos(id).then(productos => {
            setProductos(productos)
            setBuscando(false)
        })
    }

    useEffect(rellenarProductos, [id])
    return {buscando, productos}
}
export default useProductos;