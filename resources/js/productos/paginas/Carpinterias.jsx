import React from 'react'
import Ajax from '../componentes/Ajax'
import useCarpinterias from '../hooks/useCarpinterias'
import Cuadrado from '../componentes/Cuadrado'

const Carpinterias = () => {
    const {buscando, carpinterias} = useCarpinterias()

    function pintarCuadrados(elemento, index) {
        return <Cuadrado key={index} nombre={elemento.nombre} ruta={`/productos/carpinterias/${elemento.id}/productos`}/>
    }

    return (
        <div className="row justify-content-center">
            {buscando ? <Ajax/> : carpinterias.map(pintarCuadrados)}
        </div>
    )
}
export default Carpinterias