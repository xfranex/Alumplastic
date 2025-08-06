import React from 'react'
import Ajax from '../componentes/Ajax'
import Cuadrado from '../componentes/Cuadrado'
import useProductos from '../hooks/useProductos'
import { useParams } from 'react-router-dom'

const Productos = () => {
    let { id } = useParams()
    const {buscando, productos} = useProductos(id)

    function pintarCuadrados(elemento, index) {
        return <Cuadrado key={index} id={elemento.id} nombre={elemento.nombre}/>
    }

    return (
        <>
            {buscando ? <Ajax/> : productos.map(pintarCuadrados)}
        </>
    )    
}
export default Productos