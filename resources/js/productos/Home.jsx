import React from 'react';
import { Routes, Route } from 'react-router-dom';
import Carpinterias from './paginas/Carpinterias';

const Home = () => {
    return (
        <div className="services section-padding bg-grey">
            <div className="container">
                <div className="row justify-content-center">
                    <Routes>
                        <Route path='/' element={<Carpinterias/>}/>
                    </Routes>
                </div>
            </div>
        </div>
    );
}
export default Home;