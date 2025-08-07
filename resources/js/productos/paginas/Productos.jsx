import React from 'react'
import Ajax from '../componentes/Ajax'
import Cuadrado from '../componentes/Cuadrado'
import Retroceso from '../componentes/Retroceso'
import useProductos from '../hooks/useProductos'
import { useParams } from 'react-router-dom'

const Productos = () => {
    let { carpinteria } = useParams()
    const {buscando, productos} = useProductos(carpinteria)

    function pintarCuadrados(elemento, index) {
        return <Cuadrado key={index} nombre={elemento.nombre} ruta={`/productos/carpinterias/${carpinteria}/productos/${elemento.id}/series`}/>
    }

    return (
        <>
            <Retroceso ruta={`/`}/>
            <div className="row justify-content-center">
                {buscando ? <Ajax/> : productos.map(pintarCuadrados)}
            </div>
        </>
    )    
}
export default Productos