import React from 'react'
import Ajax from '../componentes/Ajax'
import Cuadrado from '../componentes/Cuadrado'
import useSeries from '../hooks/useSeries'
import { useParams, Link } from 'react-router-dom'

const Series = () => {
    let { carpinteria } = useParams()
    let { producto } = useParams()
    const {buscando, series} = useSeries(producto)

    function pintarCuadrados(elemento, index) {
        return <Cuadrado key={index} nombre={elemento.nombre} ruta={`/productos/carpinterias/${carpinteria}/productos/${producto}/series/${elemento.id}`}/>
    }

    return (
        <>
            <div className="row">
                <div className="col-12 text-center mb-5">
                    <Link to={`/productos/carpinterias/${carpinteria}/productos`} className='w-50'>
                        <div className="service-box text-center p-5 shadow rounded d-flex align-items-center justify-content-center animacionProductos">
                            <h4>Volver</h4>
                        </div>
                    </Link>
                </div>
            </div>
            <div className="row justify-content-center">
                {buscando ? <Ajax/> : series.map(pintarCuadrados)}
            </div>
        </>
    )    
}
export default Series