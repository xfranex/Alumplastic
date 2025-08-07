import React from 'react'
import Ajax from '../componentes/Ajax'
import Cuadrado from '../componentes/Cuadrado'
import Retroceso from '../componentes/Retroceso'
import useSeries from '../hooks/useSeries'
import { useParams } from 'react-router-dom'

const Series = () => {
    let { carpinteria } = useParams()
    let { producto } = useParams()
    const {buscando, series} = useSeries(producto)

    function pintarCuadrados(elemento, index) {
        return <Cuadrado key={index} nombre={elemento.nombre} ruta={`/productos/carpinterias/${carpinteria}/productos/${producto}/series/${elemento.id}`}/>
    }

    return (
        <>
            <Retroceso ruta={`/productos/carpinterias/${carpinteria}/productos`}/>
            <div className="row justify-content-center">
                {buscando ? <Ajax/> : series.map(pintarCuadrados)}
            </div>
        </>
    )    
}
export default Series