import React from "react";
import img from "../marker.svg";
import '../styles/style.scss'

export const CheckBox = (props) => {

    const divStyle = {
        backgroundImage: props.checked ?  'url(' + img + ')' : ''
    };

    return (
        <div className="inlineBox">
            <div className="checkB" style={divStyle} onClick={props.checkChange} />
            <div className="checkBoxText">{props.children}</div>
        </div>
    );
};