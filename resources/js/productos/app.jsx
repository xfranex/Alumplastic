import React from 'react';
import ReactDOM from 'react-dom/client';
import Home from './Home';

const elemento = document.getElementById('productos-react');

if (elemento) {
    const root = ReactDOM.createRoot(elemento);
    root.render(<Home/>);
}
