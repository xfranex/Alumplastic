import React from 'react';
import Cuadrado from './componentes/Cuadrado';

export default function Home() {
    return (
        <div className="services section-padding bg-grey" data-scroll-index="2">
            <div className="container">
                <div className="row justify-content-center">
                    <Cuadrado />
                </div>
            </div>
        </div>
    );
}