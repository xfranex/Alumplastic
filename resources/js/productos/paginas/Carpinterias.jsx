import React from 'react';
import Ajax from '../componentes/Ajax';
import useCarpinterias from '../hooks/useCarpinterias';
import Cuadrado from '../componentes/Cuadrado';

const Carpinterias = () => {
    const  {buscando, carpinterias} = useCarpinterias()

    function pintarCuadrados(elemento, index) {
        return <Cuadrado key={index} id={elemento.id} nombre={elemento.nombre}/>
    }

    return (
        <>
            {buscando ? <Ajax/> : carpinterias.map(pintarCuadrados)}
        </>
    )
}
export default Carpinterias;