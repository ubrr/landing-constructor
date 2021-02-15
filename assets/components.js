import React from 'react';
import ReactDOM from 'react-dom';
import { Calculator } from './modules/calculator-form/components/Calculator';

document.querySelectorAll('.calculator_form_container').forEach(el => {
    const creditTitle = el.getAttribute('creditTitle');
    ReactDOM.render(
        <React.StrictMode>
            <Calculator creditTitle={creditTitle}/>
        </React.StrictMode>,
        el
    );
});
