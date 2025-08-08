import React from "react"
import useSerieProducto from "../hooks/useSerieProducto"
import { useParams } from "react-router-dom"
import Retroceso from "../componentes/Retroceso"
import Ajax from "../componentes/Ajax"
import Detalle from "../componentes/Detalle"

const Virsualizar = () => {
    let { carpinteria } = useParams()
    let { producto } = useParams()
    let { serie } = useParams()
    const {buscando, productoSerie} = useSerieProducto(producto, serie)
    
    return (
        <>
            <Retroceso ruta={`/productos/carpinterias/${carpinteria}/productos/${producto}/series`}/>
            <div className="row justify-content-center">
                {buscando ? <Ajax/> : productoSerie?.descripcion && productoSerie?.imagen ? <Detalle descripcion={productoSerie.descripcion} imagen={`/storage/${productoSerie.imagen}`}/> : ""}
            </div>
        </>
    )
}
export default Virsualizar