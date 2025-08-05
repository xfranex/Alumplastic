import React from 'react';
import ReactDOM from 'react-dom/client';
import { BrowserRouter } from 'react-router-dom';
import Home from './Home';

const elemento = document.getElementById('productos-react');

if (elemento) {
    const root = ReactDOM.createRoot(elemento);
    root.render(
        <BrowserRouter>
            <Home/>
        </BrowserRouter>
    );
}
