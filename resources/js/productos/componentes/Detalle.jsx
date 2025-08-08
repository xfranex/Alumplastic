import React from "react"

const Detalle = (props) => {
    return (
        <div className="w-90 mx-auto">
            <div className="mb-4 rounded shadow overflow-hidden">
                <img src={props.imagen} className="img-fluid w-100"/>
            </div>
            <div className="text-center">
                <p className="fs-5 fw-medium">{props.descripcion}</p>
            </div>
        </div>
    )
}
export default Detalle