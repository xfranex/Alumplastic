import React from 'react';
import { Link } from 'react-router-dom';

const Cuadrado = (props) => {
    return (
        <div className="col-12 col-sm-10 col-md-6 col-lg-4 mb-4">
            <Link to={`/productos/carpinterias/${props.id}/productos`} className="w-100 h-100 d-block">
                <div className="service-box text-center p-5 shadow rounded d-flex align-items-center justify-content-center minimoAltura animacionProductos">
                    <h4 className="w-100 m-0">{props.nombre}</h4>
                </div>
            </Link>
        </div>
    );
}
export default Cuadrado;