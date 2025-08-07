import React from "react"
import { Link } from "react-router-dom"

const Retroceso = (props) => {
    return (
        <div className="row">
            <div className="col-12 text-center mb-5">
                <Link to={`${props.ruta}`} className='w-50'>
                    <div className="service-box text-center p-5 shadow rounded d-flex align-items-center justify-content-center animacionProductos">
                        <h4>Volver</h4>
                    </div>
                </Link>
            </div>
        </div>
    )
}
export default Retroceso