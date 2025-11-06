import React from 'react'
import { Routes, Route } from 'react-router-dom'
import Carpinterias from './paginas/Carpinterias'
import Productos from './paginas/Productos'
import Series from './paginas/Series'
import Virsualizar from './paginas/Virsualizar'

const Home = () => {
    return (
        <div className="services section-padding">
            <div className="container">
                <Routes>
                    <Route path='/' element={<Carpinterias/>}/>
                    <Route path='/productos/carpinterias/:carpinteria/productos' element={<Productos/>}/>
                    <Route path='/productos/carpinterias/:carpinteria/productos/:producto/series' element={<Series/>}/> 
                    <Route path='/productos/carpinterias/:carpinteria/productos/:producto/series/:serie' element={<Virsualizar/>}/> 
                </Routes>
            </div>
        </div>
    )
}
export default Home
